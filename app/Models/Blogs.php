<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'categories_id',
        'author',
        'image',
        'content',
        'status',
    ];
    protected function categories() {
        return $this->belongsTo(Blogs::class, 'blog_id');
    }
     
}
