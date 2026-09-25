<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Central\DomainSekolah;
use App\Models\Central\Sekolah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TenantController extends Controller
{
    /**
     * Tampilkan daftar seluruh tenant sekolah terdaftar dengan filter & pencarian.
     */
    public function index(Request $request): View
    {
        $query = Sekolah::with('domains');

        // Pencarian nama sekolah atau domain
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                    ->orWhereHas('domains', function ($dq) use ($search) {
                        $dq->where('domain', 'like', "%{$search}%");
                    });
            });
        }

        // Filter jenjang
        if ($jenjang = $request->input('jenjang')) {
            $query->where('jenjang', $jenjang);
        }

        // Filter status operasional
        if ($request->filled('status')) {
            $status = $request->input('status') === 'aktif';
            $query->where('status_aktif', $status);
        }

        $sekolahList = $query->latest()->paginate(10)->withQueryString();

        $daftarJenjang = ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'];

        return view('central.tenants.index', compact('sekolahList', 'daftarJenjang'));
    }

    /**
     * Tampilkan formulir pendaftaran tenant sekolah baru.
     */
    public function create(): View
    {
        $daftarJenjang = ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'];

        return view('central.tenants.create', compact('daftarJenjang'));
    }

    /**
     * Simpan pendaftaran tenant sekolah dan domain baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:200'],
            'jenjang' => ['required', Rule::in(['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'])],
            'domain' => ['required', 'string', 'max:255', 'unique:domain_sekolah,domain', 'regex:/^[a-zA-Z0-9.-]+$/'],
            'status_aktif' => ['nullable', 'boolean'],
            'tgl_berakhir' => ['nullable', 'date'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'alamat' => ['nullable', 'string'],
        ], [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
            'domain.required' => 'Subdomain/Domain sekolah wajib diisi.',
            'domain.unique' => 'Domain tersebut sudah terdaftar pada sistem.',
            'domain.regex' => 'Format domain tidak valid (gunakan huruf, angka, tanda titik atau strip).',
        ]);

        $sekolah = Sekolah::create([
            'id' => (string) Str::uuid(),
            'nama_sekolah' => $validated['nama_sekolah'],
            'jenjang' => $validated['jenjang'],
            'status_aktif' => $request->boolean('status_aktif', true),
            'tgl_berakhir' => $validated['tgl_berakhir'] ?? null,
            'data' => [
                'telepon' => $validated['telepon'] ?? '',
                'email' => $validated['email'] ?? '',
                'alamat' => $validated['alamat'] ?? '',
            ],
        ]);

        DomainSekolah::create([
            'sekolah_id' => $sekolah->id,
            'domain' => strtolower(trim($validated['domain'])),
        ]);

        return redirect()->route('superadmin.tenants.index')
            ->with('sukses', "Tenant sekolah '{$sekolah->nama_sekolah}' berhasil didaftarkan.");
    }

    /**
     * Tampilkan detail tenant sekolah beserta riwayat domain dan konfigurasi.
     */
    public function show(Sekolah $tenant): View
    {
        $tenant->load('domains');

        return view('central.tenants.show', compact('tenant'));
    }

    /**
     * Tampilkan formulir edit konfigurasi tenant sekolah.
     */
    public function edit(Sekolah $tenant): View
    {
        $tenant->load('domains');
        $daftarJenjang = ['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'];
        $primaryDomain = $tenant->domains->first()?->domain ?? '';

        return view('central.tenants.edit', compact('tenant', 'daftarJenjang', 'primaryDomain'));
    }

    /**
     * Perbarui data konfigurasi tenant sekolah dan domainnya.
     */
    public function update(Request $request, Sekolah $tenant): RedirectResponse
    {
        $primaryDomain = $tenant->domains()->first();

        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:200'],
            'jenjang' => ['required', Rule::in(['PAUD', 'TK', 'SD', 'MI', 'MTS', 'SMP', 'SMA', 'SMK', 'MAN'])],
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9.-]+$/',
                Rule::unique('domain_sekolah', 'domain')->ignore($primaryDomain?->id),
            ],
            'status_aktif' => ['nullable', 'boolean'],
            'tgl_berakhir' => ['nullable', 'date'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'alamat' => ['nullable', 'string'],
        ]);

        $tenant->update([
            'nama_sekolah' => $validated['nama_sekolah'],
            'jenjang' => $validated['jenjang'],
            'status_aktif' => $request->boolean('status_aktif'),
            'tgl_berakhir' => $validated['tgl_berakhir'] ?? null,
            'data' => [
                'telepon' => $validated['telepon'] ?? '',
                'email' => $validated['email'] ?? '',
                'alamat' => $validated['alamat'] ?? '',
            ],
        ]);

        $cleanDomain = strtolower(trim($validated['domain']));
        if ($primaryDomain) {
            $primaryDomain->update(['domain' => $cleanDomain]);
        } else {
            DomainSekolah::create([
                'sekolah_id' => $tenant->id,
                'domain' => $cleanDomain,
            ]);
        }

        return redirect()->route('superadmin.tenants.show', $tenant)
            ->with('sukses', "Data tenant '{$tenant->nama_sekolah}' berhasil diperbarui.");
    }

    /**
     * Toggle cepat status aktif/suspend tenant sekolah.
     */
    public function toggleStatus(Sekolah $tenant): RedirectResponse
    {
        $tenant->status_aktif = ! $tenant->status_aktif;
        $tenant->save();

        $statusText = $tenant->status_aktif ? 'diaktifkan kembali' : 'dinonaktifkan (suspend)';

        return back()->with('sukses', "Status tenant '{$tenant->nama_sekolah}' berhasil {$statusText}.");
    }

    /**
     * Hapus tenant sekolah beserta seluruh data domain terkait.
     */
    public function destroy(Sekolah $tenant): RedirectResponse
    {
        $nama = $tenant->nama_sekolah;
        $tenant->delete();

        return redirect()->route('superadmin.tenants.index')
            ->with('sukses', "Tenant sekolah '{$nama}' telah dihapus dari sistem.");
    }
}
