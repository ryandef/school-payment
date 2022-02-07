<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    // Menampilkan daftar tahun ajaran
    public function index()
    {
        $models = TahunAjaran::where('status', '!=', -1)->get();
        return view('admin.tahun-ajaran.index', compact('models'));
    }

    // Menyimpan data tahun ajaran
    public function store(Request $request)
    {
        $data = new TahunAjaran();
        $data->nama = $request->nama;
        $data->tagihan = $request->tagihan;
        $data->mulai = $request->mulai;
        $data->selesai = $request->selesai;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah data');
    }

    // Update data tahun ajaran
    public function update(Request $request, $id)
    {
        $data = TahunAjaran::find($id);
        $data->nama = $request->nama;
        $data->tagihan = $request->tagihan;
        $data->mulai = $request->mulai;
        $data->selesai = $request->selesai;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil ubah data');
    }

    // Hapus data tahun ajaran
    public function destroy($id)
    {
        $data = TahunAjaran::findOrFail($id);
        $data->status = -1;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }
}
