<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPertandingan extends Model
{
    use HasFactory;

    protected $table = 'peserta_pertandingan'; // Nama tabel

    protected $fillable = ['pertandingan_id', 'atlet_id', 'user_id'];

    public function atlet()
    {
        return $this->belongsTo(Atlet::class);
    }

    public function pertandingan()
    {
        return $this->belongsTo(Pertandingan::class);
    }
}
