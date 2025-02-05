<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;
use App\Models\MutasiMasuk;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View
    {

        $filterKelas = $request->input('kelas', 'semua');
        $siswa = null;

        if ($filterKelas === 'semua') {
            $siswa = Siswa::all();
        } else {
            $siswa = Siswa::where('kelas_id', '=', $filterKelas)->get();
        }

        $kelas = Kelas::get();

        return view('siswa.index', compact('siswa', 'kelas', 'filterKelas'));
    }

    public function store(CreateSiswaRequest $request): RedirectResponse
    {
        $siswaRequest = $request->only(['no_induk', 'nisn', 'nama', 'jenis_kelamin', 'kelas_id']);
        $mutasiMasuk = $request->only(['tgl_masuk', 'asal_sekolah', 'keterangan']);

        $siswa = Siswa::create($siswaRequest);
        $siswa->created_at = $mutasiMasuk['tgl_masuk'];
        $siswa->save();
        DB::table('mutasi_masuk')->insert([
            'siswa_id' => $siswa->id,
            'tgl_masuk' => $mutasiMasuk['tgl_masuk'],
            'asal_sekolah' => $mutasiMasuk['asal_sekolah'],
            'keterangan' => $mutasiMasuk['keterangan'],
            'kelas_id' => $siswaRequest['kelas_id']
        ]);

        return redirect('/siswa');
    }

    public function edit(Siswa $siswa): View
    {
        $kelas = Kelas::get();
        $mutasiMasuk = MutasiMasuk::where('siswa_id', $siswa->id)->first();
        return view('siswa.edit', compact('siswa', 'kelas', 'mutasiMasuk'));
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $validated = $request->validated();
        $updateMutasiMasuk = $request->only(['asal_sekolah', 'keterangan', 'tgl_masuk', 'kelas_id']);

        $siswa->fill($validated);
        $siswa->kelas_id = $validated['kelas_id'];
        $siswa->mutasiMasuk()->update($updateMutasiMasuk);
        $siswa->save();

        return redirect('/siswa');
    }
}
