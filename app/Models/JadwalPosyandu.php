<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPosyandu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_posyandu',
        'lokasi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];
}
