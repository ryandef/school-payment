<?php

use Illuminate\Database\Seeder;
use App\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Kelas;
        $model->jurusan_id = 1;
        $model->tingkat = 10;
        $model->indeks = '1';
        $model->save();

        $model = new Kelas;
        $model->jurusan_id = 1;
        $model->tingkat = 10;
        $model->indeks = '2';
        $model->save();

        $model = new Kelas;
        $model->jurusan_id = 2;
        $model->tingkat = 10;
        $model->indeks = '1';
        $model->save();

        $model = new Kelas;
        $model->jurusan_id = 2;
        $model->tingkat = 10;
        $model->indeks = '2';
        $model->save();

        $model = new Kelas;
        $model->jurusan_id = 3;
        $model->tingkat = 10;
        $model->indeks = '1';
        $model->save();

        $model = new Kelas;
        $model->jurusan_id = 3;
        $model->tingkat = 10;
        $model->indeks = '2';
        $model->save();
    }
}
