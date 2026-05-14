<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rm',
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'poli_tujuan',
        'tanggal_periksa',
        'status',
        'keluhan',
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_periksa' => 'date'
    ];

    public static function generateNoRM()
    {
        $year = date('Y');
        $month = date('m');
        $last = self::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();

        return 'RM-' . $year . $month . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }
}