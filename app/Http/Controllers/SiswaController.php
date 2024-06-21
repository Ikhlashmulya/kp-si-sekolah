<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View {

        $filterKelas = $request->input('kelas', 'semua');
        $siswa = null;

        if ($filterKelas === 'semua') {
            $siswa = Siswa::doesntHave('mutasiKeluar')->get();
        } else {
            $siswa = Siswa::doesntHave('mutasiKeluar')->where('kelas_id', '=', $filterKelas)->get();
        }

        $kelas = Kelas::get();

        return view('siswa.index', compact('siswa', 'kelas', 'filterKelas'));
    }

    public function store(CreateSiswaRequest $request): RedirectResponse {
        $siswa = $request->only(['no_induk', 'nisn', 'nama', 'jenis_kelamin', 'kelas_id']);
        $mutasiMasuk = $request->only(['tgl_masuk', 'asal_sekolah']);

        $lastId = DB::table('siswa')->insertGetId($siswa);
        DB::table('mutasi_masuk')->insert([
            'siswa_id' => $lastId,
            'tgl_masuk' => $mutasiMasuk['tgl_masuk'],
            'asal_sekolah' => $mutasiMasuk['asal_sekolah']
        ]);

        return redirect('/siswa');
    }

    public function edit(Siswa $siswa): View {
        $kelas = Kelas::get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse {
        $validated = $request->validated();

        $siswa->fill($validated);
        $siswa->kelas_id = $validated['kelas_id'];
        $siswa->save();

        return redirect('/siswa');
    }

}
