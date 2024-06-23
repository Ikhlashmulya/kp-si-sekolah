<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MutasiKeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KelasController extends Controller
{
    public function index(): View
    {
        $kelas = Kelas::withCount([
            'siswa as laki_laki' => function ($query) {
                $query->where('jenis_kelamin', 'L');
            },
            'siswa as perempuan' => function ($query) {
                $query->where('jenis_kelamin', 'P');
            }
        ])->get();

        return view('kelas.index', compact('kelas'));
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
