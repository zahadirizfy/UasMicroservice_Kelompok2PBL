<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_Pertandingan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pertandingans';

    protected $fillable = [
        'pertandingan_id',
        'tanggal',
        'waktu',
        'lokasi',
        'deskripsi',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu'   => 'datetime:H:i',
    ];

    public function pertandingan()
    {
        return $this->belongsTo(Pertandingan::class);
    }
}
