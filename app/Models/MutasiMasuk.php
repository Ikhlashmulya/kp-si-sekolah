<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MutasiMasuk extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'mutasi_masuk';

    protected $guarded = [];

    public function siswa(): BelongsTo {
        return $this->belongsTo(Siswa::class)->withTrashed();
    }

    public function kelas(): BelongsTo {
        return $this->belongsTo(Kelas::class);
    }
}
