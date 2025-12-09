<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'prestasi',
        'club_id', // tambahkan ini
        'user_id'
    ];

    /**
     * Relasi many-to-many dengan pertandingan
     */
    public function pertandingans()
    {
        return $this->belongsToMany(Pertandingan::class, 'peserta_pertandingan');
    }

    /**
     * Relasi many-to-one ke Club
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
