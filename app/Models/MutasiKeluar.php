<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MutasiKeluar extends Model
{
    use HasFactory;

    protected $table = 'mutasi_keluar';

    public function siswa(): HasMany {
        return $this->hasMany(Siswa::class);
    }
}
