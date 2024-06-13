<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index(): Response
    {
        $kelas = Kelas::withCount([
            'siswa as laki_laki' => function ($query) {
                $query->where('jenis_kelamin', 'L');
            },
            'siswa as perempuan' => function ($query) {
                $query->where('jenis_kelamin', 'P');
            }
        ])->get();

        return response()->view('kelas', ['kelas' => $kelas]);
    }

    public function store(Request $request): RedirectResponse
    {
        $nama = $request->input('nama-kelas');

        DB::table('kelas')->insert(['nama_kelas' => $nama]);

        return redirect('/kelas');
    }

    public function delete(Request $request): RedirectResponse
    {
        $kelas = $request->query('nama-kelas');
        DB::table('kelas')->where('nama_kelas', '=', $kelas)->delete();

        return redirect('/kelas');
    }
}
