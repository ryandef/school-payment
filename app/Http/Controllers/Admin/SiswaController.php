<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kelas;
use App\PembayaranDetail;
use App\Siswa;
use App\TahunAjaran;
use App\User;
use App\LogKelas;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Siswa::where('status', '!=', -1)->get();
        return view('admin.siswa.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Siswa();
        $kelas = Kelas::where('status', '!=', -1)->get();
        $tahun = TahunAjaran::where('status', '!=', -1)->get();
        return view('admin.siswa.form', compact('model', 'kelas', 'tahun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->type = 4;
        $user->password = bcrypt($request->password);
        $user->save();

        $data = new Siswa();
        $data->nis = $request->nis;
        $data->nama = $request->nama;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->telepon = $request->telepon;
        $data->telepon_orangtua = $request->telepon_orangtua;
        $data->alamat = $request->alamat;
        $data->kelas_id = $request->kelas_id;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id;
        $data->user_id = $user->id;
        $data->save();

        $log = new LogKelas();
        $log->siswa_id = $data->id;
        $log->tahun_ajaran_id = $request->tahun_ajaran_id;
        $log->kelas_id =  $request->kelas_id;
        $log->save();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $data = Auth::user()->siswa;
        return view('admin.siswa.profile', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Siswa::find($id);
        $kelas = Kelas::where('status', '!=', -1)->get();
        $tahun = TahunAjaran::where('status', 1)->get();
        return view('admin.siswa.form', compact('model', 'kelas', 'tahun'));
    }

    public function show(Request $request, $id)
    {
        $data = Siswa::find($id);
        $tahun = TahunAjaran::where('status', 1)->get();
        $tahun_ajaran = TahunAjaran::where('status', 1)->get();

        $siswa_id = $data->id;

        $models = [];
        // dd($request->tahun_ajaran);
        if($request->tahun_ajaran != null) {
            $tahun = TahunAjaran::findOrFail($request->tahun_ajaran);
        } else {
            $tahun = $data->tahun_ajaran;
        }

        $diff = Carbon::parse($tahun->mulai)->floatDiffInMonths($tahun->selesai);

        for ($i = 0; $i < ceil($diff); $i++) {
            $month = DATE('Y-m-d', strtotime($tahun->mulai . "+" . $i . " month"));

            $data_row['month'] = date('M Y', strtotime($month));
            $data_row['tagihan'] = $tahun->tagihan;
            $data_row['status'] = 'Belum Lunas';
            $data_row['uuid'] = null;

            $bayar = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) use ($siswa_id) {
                $query->where('status', 1);
                $query->where('siswa_id', $siswa_id);
            })->first();

            if ($bayar) {
                $data['bayar'] += $bayar->total;
                $data_row['status'] = 'Lunas';
                $data_row['uuid'] = $bayar->pembayaran->uuid;
            } else {
                $data['tunggakan'] += $tahun->tagihan;
            }

            $models[] = $data_row;
        }

        return view('admin.siswa.detail', compact('data', 'tahun', 'tahun_ajaran', 'models'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Siswa::findOrFail($id);
        $data->nis = $request->nis;
        $data->nama = $request->nama;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->telepon = $request->telepon;
        $data->telepon_orangtua = $request->telepon_orangtua;
        $data->alamat = $request->alamat;
        $data->kelas_id = $request->kelas_id;
        $data->tahun_ajaran_id = $request->tahun_ajaran_id;
        $data->save();

        $user = User::find($data->user_id);
        $user->name = $request->nama;
        $user->email = $request->email;
        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $log = new LogKelas();
        $log->siswa_id = $data->id;
        $log->tahun_ajaran_id = $request->tahun_ajaran_id;
        $log->kelas_id =  $request->kelas_id;
        $log->save();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Berhasil ubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Siswa::findOrFail($id);
        $model->status = -1;
        $model->save();

        $user = $model->user_id;

        $model = User::findOrFail($user);
        $model->status = -1;
        $model->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }

    public function updateAll(Request $request) {
        $models = Siswa::where('status', '!=', -1);
        if($request->kelas_id) {
            $models = $models->where('kelas_id', $request->kelas_id);
        }
        if($request->tahun_ajaran_id) {
            $models = $models->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        $models = $models->get();
        $kelas = Kelas::where('status', '!=', -1)->get();
        $tahun = TahunAjaran::where('status', '!=', -1)->get();
        return view('admin.siswa.update-all', compact('models', 'kelas', 'tahun'));
    }

    public function updateAllSave(Request $request) {
        if($request->siswa_id == "") {
            return redirect()
                ->back()
                ->with('error_msg', 'Pilih siswa terlebih dahulu');
        } else {
            foreach($request->siswa_id as $item) {
                $siswa = Siswa::find($item);

                $siswa->tahun_ajaran_id = $request->tahun_ajaran_id;
                $siswa->kelas_id =  $request->kelas_id;
                $siswa->save();

                $log = new LogKelas();
                $log->siswa_id = $siswa->id;
                $log->tahun_ajaran_id = $request->tahun_ajaran_id;
                $log->kelas_id =  $request->kelas_id;
                $log->save();
            }

            return redirect()
                ->back()
                ->with('success', 'Berhasil update data');
        }
    }
}
