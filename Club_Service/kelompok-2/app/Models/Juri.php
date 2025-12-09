<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juri extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_juri',       // GANTI dari 'nama' ke 'nama_juri'
        'tanggal_lahir',
        'sertifikat',
        'user_id'
    ];
}
