<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPemeriksaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'poli',
        'dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'kuota' => 'integer',
    ];

    /**
     * Accessor untuk memastikan format hari konsisten (huruf kapital di awal)
     * Saat mengambil data dari database
     */
    public function getHariAttribute($value)
    {
        return ucfirst(strtolower(trim($value))); // "senin" -> "Senin", "SENIN" -> "Senin"
    }

    /**
     * Mutator untuk menyimpan hari dengan format konsisten
     * Saat menyimpan data ke database
     */
    public function setHariAttribute($value)
    {
        $this->attributes['hari'] = ucfirst(strtolower(trim($value))); // Simpan sebagai "Senin", "Selasa", dll
    }

    /**
     * Accessor untuk format jam_mulai (H:i)
     */
    public function getJamMulaiFormattedAttribute()
    {
        return $this->jam_mulai ? substr($this->jam_mulai, 0, 5) : '-';
    }

    /**
     * Accessor untuk format jam_selesai (H:i)
     */
    public function getJamSelesaiFormattedAttribute()
    {
        return $this->jam_selesai ? substr($this->jam_selesai, 0, 5) : '-';
    }

    /**
     * Accessor untuk range jam lengkap
     */
    public function getJamRangeAttribute()
    {
        return $this->jam_mulai_formatted . ' - ' . $this->jam_selesai_formatted;
    }

    /**
     * Scope untuk mencari berdasarkan hari (case insensitive)
     */
    public function scopeHari($query, $hari)
    {
        return $query->whereRaw('LOWER(TRIM(hari)) = ?', [strtolower(trim($hari))]);
    }

    /**
     * Scope untuk mencari berdasarkan poli
     */
    public function scopePoli($query, $poli)
    {
        return $query->where('poli', 'LIKE', "%{$poli}%");
    }

    /**
     * Scope untuk jadwal yang masih aktif (kuota > 0)
     */
    public function scopeTersedia($query)
    {
        return $query->where('kuota', '>', 0);
    }

    /**
     * Cek apakah jadwal tersedia pada hari tertentu
     */
    public function isAvailableOn($hari)
    {
        return strtolower(trim($this->hari)) === strtolower(trim($hari));
    }

    /**
     * Mendapatkan daftar hari yang tersedia untuk poli tertentu
     */
    public static function getHariTersedia($poli)
    {
        return self::where('poli', $poli)
            ->pluck('hari')
            ->map(function($hari) {
                return $hari; // Sudah diformat oleh accessor
            })
            ->toArray();
    }

    /**
     * Mendapatkan semua poli unik
     */
    public static function getUniquePoli()
    {
        return self::select('poli')
            ->distinct()
            ->orderBy('poli')
            ->pluck('poli')
            ->toArray();
    }

    /**
     * Relasi dengan Pelayanan (untuk menghitung pendaftar)
     */
    public function pelayanans()
    {
        return $this->hasMany(Pelayanan::class, 'poli_tujuan', 'poli');
    }

    /**
     * Hitung jumlah pendaftar untuk tanggal tertentu
     */
    public function countPendaftar($tanggal)
    {
        return $this->pelayanans()
            ->whereDate('tanggal_periksa', $tanggal)
            ->whereIn('status', ['pending', 'diproses'])
            ->count();
    }

    /**
     * Hitung sisa kuota untuk tanggal tertentu
     */
    public function sisaKuota($tanggal)
    {
        $terdaftar = $this->countPendaftar($tanggal);
        return max(0, $this->kuota - $terdaftar);
    }

    /**
     * Cek apakah masih ada kuota untuk tanggal tertentu
     */
    public function hasKuota($tanggal)
    {
        return $this->sisaKuota($tanggal) > 0;
    }
}