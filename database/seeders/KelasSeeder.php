<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['X.1', 'X.2', 'X.3', 'XI.1', 'XI.2', 'XII.IPA', 'XII-IPS'];

        foreach ($data as $kelas) {
            DB::table('kelas')->insert([
                'nama_kelas' => $kelas
            ]);
        }
    }
}
