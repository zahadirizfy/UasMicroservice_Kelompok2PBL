<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'judul',
    'deskripsi_singkat',
    'deskripsi_lengkap',
    'image',
    'second_image',
    'video_link',
    ];
}
