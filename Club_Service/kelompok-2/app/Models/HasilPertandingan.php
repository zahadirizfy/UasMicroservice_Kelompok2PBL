<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPertandingan extends Model
{
    use HasFactory;

    protected $fillable = ['pertandingan_id','user_id'];

    public function pertandingan()
    {
        return $this->belongsTo(Pertandingan::class);
    }

    public function detailHasil()
    {
        return $this->hasMany(DetailHasilPertandingan::class, 'hasil_pertandingan_id', 'id');
    }

    public function atlet()
    {
        return $this->belongsTo(Atlet::class);
    }
}

