<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kontaks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'pesan',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Scope untuk pesan yang belum dibaca
     */
    public function scopeBelumDibaca($query)
    {
        return $query->where('status', 'belum_dibaca');
    }

    /**
     * Scope untuk pesan yang sudah dibaca
     */
    public function scopeSudahDibaca($query)
    {
        return $query->where('status', 'sudah_dibaca');
    }
}
