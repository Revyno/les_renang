<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramController extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'tingkat_kesulitan',
        'durasi',
        'harga',
        'instruktur_id',
    ];

    // Relasi ke instruktur
    public function instruktur()
    {
        return $this->belongsTo(Instructor::class);
    }

    //methodn siswa
    public function student()
    {
        return $this->belongsToMany(User::class, 'pendaftaran_program');
    }
}
