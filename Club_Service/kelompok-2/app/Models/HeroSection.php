<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $table = 'hero_sections'; // opsional jika nama tabel tidak standar

    protected $fillable = [
        'image',
        'judul',
        'deskripsi',
    ];
}
