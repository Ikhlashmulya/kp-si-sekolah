<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View {

        $filterKelas = $request->input('kelas', 'semua');
        $siswa = null;

        if ($filterKelas === 'semua') {
            $siswa = Siswa::get();
        } else {
            $siswa = Siswa::where('kelas_id', '=', $filterKelas)->get();
        }

        $kelas = Kelas::get();

        return view('siswa.index', compact('siswa', 'kelas', 'filterKelas'));
    }

    public function store(CreateSiswaRequest $request): RedirectResponse {
        DB::table('siswa')->insert($request->validated());

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

    public function delete(Siswa $siswa): RedirectResponse {
        $siswa->delete();
        return redirect('/siswa');
    }

}
