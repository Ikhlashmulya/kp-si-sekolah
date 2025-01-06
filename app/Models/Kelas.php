<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas'
    ];

    public function siswa(): HasMany {
        return $this->hasMany(Siswa::class, 'kelas_id', 'nama_kelas');
    }

    public function mutasiMasuk(): HasMany {
        return $this->hasMany(MutasiMasuk::class, 'kelas_id', 'nama_kelas');
    }

    public function mutasiKeluar(): HasMany {
        return $this->hasMany(MutasiKeluar::class, 'kelas_id', 'nama_kelas');
    }
}
