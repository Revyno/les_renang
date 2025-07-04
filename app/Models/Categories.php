<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];

   public function blogs()
    {
        return $this->hasMany(Categories::class,'categories_id');
    }
}
