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
        'crop_settings',
        'kategori',
        'alt_teks',
        'sumber',
        'urutan',
    ];

    protected $appends = [
        'focal_position_css',
        'smart_crop_style',
    ];

    protected function casts(): array
    {
        return [
            'ukuran_bytes' => 'integer',
            'urutan' => 'integer',
            'crop_settings' => 'array',
        ];
    }

    /**
     * Helper CSS object-position dari crop_settings / focal point.
     * Contoh: '50% 30%' atau 'center center'.
     */
    public function getFocalPositionCssAttribute(): string
    {
        if (! empty($this->crop_settings['focal_x']) && ! empty($this->crop_settings['focal_y'])) {
            return "{$this->crop_settings['focal_x']}% {$this->crop_settings['focal_y']}%";
        }

        if (isset($this->crop_settings['x_percent']) && isset($this->crop_settings['y_percent'])) {
            return "{$this->crop_settings['x_percent']}% {$this->crop_settings['y_percent']}%";
        }

        return 'center center';
    }

    /**
     * Helper CSS Style lengkap untuk Smart Box Cropping (Zoom & Clip).
     * Memastikan hanya area potongan (misal 20% atas) yang tampil di container tanpa meluber.
     */
    public function getSmartCropStyleAttribute(): string
    {
        $settings = $this->crop_settings;
        if (empty($settings) || empty($settings['box_w']) || empty($settings['box_h'])) {
            return "object-position: {$this->focal_position_css}; object-fit: cover;";
        }

        $boxW = max(1, (float) $settings['box_w']);
        $boxH = max(1, (float) $settings['box_h']);
        $focalX = isset($settings['focal_x']) ? (float) $settings['focal_x'] : 50;
        $focalY = isset($settings['focal_y']) ? (float) $settings['focal_y'] : 50;

        // Jika box mencakup hampir 100% (tidak di-crop ketat), cukup gunakan object-position
        if ($boxW >= 98 && $boxH >= 98) {
            return "object-position: {$focalX}% {$focalY}%; object-fit: cover;";
        }

        // Jika di-crop spesifik (misal hanya 20% tinggi), terapkan zoom transform & focal center
        $scale = max(100 / $boxW, 100 / $boxH);
        $scaleFormatted = number_format($scale, 3, '.', '');

        return "object-position: {$focalX}% {$focalY}%; object-fit: cover; transform: scale({$scaleFormatted}); transform-origin: {$focalX}% {$focalY}%;";
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
