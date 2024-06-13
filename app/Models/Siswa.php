<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_induk',
        'nisn',
        'nama',
        'jenis_kelamin'
    ];

    public function kelas(): BelongsTo {
        return $this->belongsTo(Kelas::class);
    }
}
