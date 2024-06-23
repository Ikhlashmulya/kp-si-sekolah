<?php

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mutasi_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Siswa::class);
            $table->foreignIdFor(Kelas::class);
            $table->date('tgl_masuk');
            $table->string('asal_sekolah');
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_masuk');
    }
};
