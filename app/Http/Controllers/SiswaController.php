<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request): Response {

        $filterKelas = $request->input('kelas', 'semua');
        $siswa = null;

        if ($filterKelas === 'semua') {
            $siswa = Siswa::get();
        } else {
            $siswa = Siswa::where('kelas_id', '=', $filterKelas)->get();
        }

        $kelas = Kelas::get();

        return response()->view('siswa', ['kelas' => $kelas, 'siswa' => $siswa, 'filterKelas' => $filterKelas]);
    }

    public function store(CreateSiswaRequest $request): RedirectResponse {
        DB::table('siswas')->insert($request->validated());

        return redirect('/siswa');
    }
}
