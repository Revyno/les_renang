<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{

    protected $fillable = ['address', 'phone', 'email', 'social', 'whatsapp_number', 'whatsapp_message'];
    protected $casts = ['social' => 'array'];
    use HasFactory;
}
