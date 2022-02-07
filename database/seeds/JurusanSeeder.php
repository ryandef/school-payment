<?php

use Illuminate\Database\Seeder;
use App\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Jurusan;
        $model->kode = "TKJ";
        $model->nama = "Teknik Komputer dan Jaringan";
        $model->save();

        $model = new Jurusan;
        $model->kode = "RPL";
        $model->nama = "Rekayasa Perangkat Lunak";
        $model->save();

        $model = new Jurusan;
        $model->kode = "MM";
        $model->nama = "Multimedia";
        $model->save();

    }
}
