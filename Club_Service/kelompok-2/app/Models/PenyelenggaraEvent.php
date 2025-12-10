<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyelenggaraEvent extends Model
{
    use HasFactory;

    protected $table = 'penyelenggara_events'; // ← ubah jadi plural

    protected $fillable = [
        'nama_penyelenggara_event',
        'kontak',
        'user_id'
    ];
}
