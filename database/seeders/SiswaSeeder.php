<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kelas = ['X.1', 'X.2', 'X.3', 'XI.1', 'XI.2', 'XII.IPA', 'XII-IPS'];

        $jk = ['L', 'P'];

        for ($i = 0; $i < 100; $i++) {
            $nisn = $faker->randomDigit();
            $noInduk = $faker->randomDigit();
            $id = DB::table('siswa')->insertGetId([
                'nisn' => "$nisn",
                'no_induk' => "$noInduk",
                'nama' => $faker->name(),
                'jenis_kelamin' => $jk[rand(0, 1)],
                'kelas_id' => $kelas[rand(0, 6)],
            ]);

            DB::table('mutasi_masuk')->insert([
                'siswa_id' => $id,
                'tgl_masuk' => date('Y-m-d'),
                'asal_sekolah' => "SMP Al-Azhary",
                'keterangan' => "siswa baru",
                'kelas_id' => $kelas[rand(0, 6)],
            ]);
        }
        // $data = [
        //     [
        //         'nama' => 'AKBAR',
        //         'no_induk' => '2324.10.001',
        //         'nisn' => '0074983176',
        //         'jenis_kelamin' => 'L',
        //         'kelas_id' => 'X.1'
        //     ],
        //     [
        //         'nama' => 'AMELIA SALWA',
        //         'no_induk' => '2324.10.003',
        //         'nisn' => '0082563105',
        //         'jenis_kelamin' => 'P',
        //         'kelas_id' => 'X.1'
        //     ],
        //     [
        //         'nama' => 'ARDIANA',
        //         'no_induk' => '2324.10.004',
        //         'nisn' => '0083772089',
        //         'jenis_kelamin' => 'L',
        //         'kelas_id' => 'X.1'
        //     ]
        // ];
    }
}
