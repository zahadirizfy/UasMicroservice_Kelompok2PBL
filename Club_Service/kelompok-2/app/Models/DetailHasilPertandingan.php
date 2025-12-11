<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailHasilPertandingan extends Model
{
    use HasFactory;

    protected $fillable = [
        'hasil_pertandingan_id',
        'nama',
        'lemparan1',
        'lemparan2',
        'lemparan3',
        'lemparan4',
        'lemparan5',
        'skor',
        'rangking',
        'catatan_juri',
        'user_id'
    ];

    // Relasi ke tabel hasil_pertandingans
    public function hasilPertandingan()
    {
        return $this->belongsTo(HasilPertandingan::class);
    }

    public function atlet()
    {
        return $this->belongsTo(Atlet::class);
    }
}
