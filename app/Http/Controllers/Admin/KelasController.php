<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\Kelas;
use App\Siswa;
use App\TahunAjaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Menampilkan daftar kelas
    public function index()
    {
        $models = Kelas::where('status', '!=', -1)->get();
        $jurusan = Jurusan::where('status', '!=', -1)->get();
        return view('admin.kelas.index', compact('models', 'jurusan'));
    }

    // Menyimpan data kelas
    public function store(Request $request)
    {
        $data = new Kelas();
        $data->jurusan_id = $request->jurusan_id;
        $data->indeks = $request->indeks;
        $data->tingkat = $request->tingkat;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah data');
    }

    // Update data kelas
    public function update(Request $request, $id)
    {
        $data = Kelas::find($id);
        $data->jurusan_id = $request->jurusan_id;
        $data->indeks = $request->indeks;
        $data->tingkat = $request->tingkat;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil ubah data');
    }

    // Hapus data kelas
    public function destroy($id)
    {
        $data = Kelas::findOrFail($id);
        $data->status = -1;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }

    public function show(Request $request, $id)
    {
        $model = Kelas::findOrFail($id);
        $tahun_ajaran = TahunAjaran::where('status',1)->get();
        $models = [];

        if($request->tahun_ajaran != "") {
            $models = Siswa::whereHas('log_kelas', function($query) use ($id, $request){
                $query->where('kelas_id', $id)
                ->where('tahun_ajaran_id', $request->tahun_ajaran);
            })->get();
        }

        // return $models;
        return view('admin.kelas.show', compact('model', 'tahun_ajaran', 'models'));
    }
}
