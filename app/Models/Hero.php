<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'subtitle',
        'image',
        'video_background',
        'cta_text',
        'cta_link',
        'secondary_cta_text',
        'secondary_cta_link',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Accessor untuk URL gambar (Cloudinary-aware via Media)
    public function getImageUrlAttribute()
    {
        return \App\Support\Media::url($this->image, 'images/default-hero.jpg');
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}
