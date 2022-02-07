<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    // Menampilkan daftar jurusan
    public function index()
    {
        $models = Jurusan::where('status', '!=', -1)->get();
        return view('admin.jurusan.index', compact('models'));
    }

    // Menyimpan data jurusan
    public function store(Request $request)
    {
        $data = new Jurusan();
        $data->nama = $request->nama;
        $data->kode = $request->kode;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah data');
    }

    // Update data jurusan
    public function update(Request $request, $id)
    {
        $data = Jurusan::find($id);
        $data->nama = $request->nama;
        $data->kode = $request->kode;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil ubah data');
    }

    // Hapus data jurusan
    public function destroy($id)
    {
        $data = Jurusan::findOrFail($id);
        $data->status = -1;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }
}
