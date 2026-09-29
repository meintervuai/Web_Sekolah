<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $connection = 'tenant';

    protected $table = 'media';

    protected $fillable = [
        'pengguna_id',
        'judul',
        'nama_file_asli',
        'nama_file_disimpan',
        'path',
        'url',
        'tipe_media',
        'mime_type',
        'ekstensi',
        'ukuran_bytes',
        'dimensi',
        'kategori',
        'alt_teks',
        'sumber',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'ukuran_bytes' => 'integer',
            'urutan' => 'integer',
        ];
    }

    /**
     * Relasi ke pengguna pengunggah/pengelola media.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    /**
     * Helper ukuran berkas dalam format ramah manusia (KB/MB).
     */
    public function getUkuranFormattedAttribute(): string
    {
        $bytes = $this->ukuran_bytes;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1).' KB';
        } elseif ($bytes > 0) {
            return $bytes.' B';
        }

        return '-';
    }

    /**
     * Helper apakah media ini adalah gambar.
     */
    public function getIsGambarAttribute(): bool
    {
        return $this->tipe_media === 'gambar';
    }

    /**
     * Helper apakah media ini adalah video / youtube.
     */
    public function getIsVideoAttribute(): bool
    {
        return in_array($this->tipe_media, ['video', 'youtube']);
    }

    /**
     * Helper URL embed YouTube jika tipe YouTube.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if ($this->tipe_media !== 'youtube') {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $this->url, $match)) {
            return 'https://www.youtube.com/embed/'.$match[1].'?rel=0';
        }

        return $this->url;
    }
}
