<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'no_induk',
        'nisn',
        'nama',
        'jenis_kelamin'
    ];

    public function kelas(): BelongsTo {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'nama_kelas');
    }

    public function mutasiMasuk(): HasMany {
        return $this->hasMany(MutasiMasuk::class, 'siswa_id', 'id');
    }

    public function mutasiKeluar(): HasMany {
        return $this->hasMany(MutasiKeluar::class, 'siswa_id', 'id');
    }
}
