<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapLatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'tanggal',
        'jarak',
        'lemparan1',
        'lemparan2',
        'lemparan3',
        'user_id'

    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
