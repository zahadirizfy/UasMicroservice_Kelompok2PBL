<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLogo extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sudah sesuai konvensi Laravel)
    protected $table = 'client_logos';

    // Kolom yang dapat diisi
    protected $fillable = ['logo'];
}
