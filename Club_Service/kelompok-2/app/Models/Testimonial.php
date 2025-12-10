<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'profession',
        'quote',
        'image',
        
    ];

    /**
     * Mengambil URL gambar testimonial (foto orang).
     */
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('uploads/testimonials/' . $this->image))) {
            return asset('uploads/testimonials/' . $this->image);
        }
        return asset('frontend/assets/images/default-profile.png'); // fallback
    }


}
