<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Http\Controllers\Controller;
use App\Pembayaran;
use App\PembayaranDetail;
use App\Siswa;
use App\Kelas;
use App\TahunAjaran;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Uuid;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Pembayaran::orderBy('created_at', 'desc');
        if($request->tahun_ajaran != null) {
            $models = $models->where('tahun_ajaran_id', $request->tahun_ajaran);
        }
        if($request->kelas != null) {
            $models = $models->where('kelas_id', $request->kelas);
        }
        $models = $models->get();
        $tahun_ajaran = TahunAjaran::where('status', 1)->get();
        $kelas = Kelas::where('status', 1)->get();
        return view('admin.pembayaran-admin.index', compact('models', 'tahun_ajaran', 'kelas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Pembayaran::where('uuid', $id)->first();
        return view('admin.pembayaran-admin.detail', compact('model'));
    }

    function print($id) {
        $model = Pembayaran::where('uuid', $id)->first();
        return view('admin.pembayaran-admin.print', compact('model'));
    }

    public function create($id)
    {
        $data = Siswa::find($id);
        $tahun = $data->tahun_ajaran;
        $siswa_id = $data->id;

        $pending = Pembayaran::where('siswa_id', $siswa_id)->where('status', 0)->count();

        if($pending > 0) {
            return view('admin.pembayaran-admin.konfirmasi-pending', compact('data'));
        }

        $models = [];
        $diff = Carbon::parse($tahun->mulai)->floatDiffInMonths($tahun->selesai);

        for ($i = 0; $i < ceil($diff); $i++) {
            $month = DATE('Y-m-d', strtotime($tahun->mulai . "+" . $i . " month"));

            $bayar = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) use ($siswa_id) {
                $query->where(function ($q) {
                    $q->where('status', 1)->orWhere('status', 0);
                });
                $query->where('siswa_id', $siswa_id);
            })->count();

            if ($bayar < 1) {
                $data_row['name'] = date('M Y', strtotime($month));
                $data_row['value'] = $month;

                $models[] = $data_row;
            }

        }
        $bank = Bank::where('status', 1)->get();
        return view('admin.pembayaran-admin.create', compact('models', 'bank', 'tahun', 'data'));
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
        $model = Pembayaran::where('uuid', $id)->first();
        $model->status = $request->status;

        if ($model->status == 1) {
            $model->waktu_diterima = date('Y-m-d H:i:s');
            $model->approved_id = Auth::user()->id;
            $item = $model;
            \Mail::send('email.pembayaran.diterima', ['item' => $item], function ($m) use ($item) {
                $m->to($item->user->email);
                $m->subject('[Pembayaran SPP DITERIMA ' . $item->invoice . ']');
            });
        } else {
            $item = $model;
            \Mail::send('email.pembayaran.ditolak', ['item' => $item], function ($m) use ($item) {
                $m->to($item->user->email);
                $m->subject('[Pembayaran SPP DITOLAK ' . $item->invoice . ']');
            });
        }

        $model->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil konfirmasi pembayaran');
    }

    public function reject(Request $request, $id)
    {
        $model = Pembayaran::where('uuid', $id)->first();
        $model->status = -1;
        $model->catatan = $request->catatan;
        $model->save();

        $item = $model;
        \Mail::send('email.pembayaran.ditolak', ['item' => $item], function ($m) use ($item) {
            $m->to($item->user->email);
            $m->subject('[Pembayaran SPP DITOLAK ' . $item->invoice . ']');
        });

        return redirect()
            ->back()
            ->with('success', 'Berhasil menolak pembayaran');
    }

    public function store(Request $request, $id)
    {
        if ($request->bulan == "") {
            return redirect()
                ->back()
                ->with('error_msg', 'Pilih bulan terlebih dahulu');
        }
        $siswa = Siswa::find($id);

        $data = new Pembayaran;
        $data->user_id = $siswa->user_id;
        $data->kelas_id = $siswa->kelas_id;
        $data->siswa_id = $siswa->id;
        $data->tahun_ajaran_id = $siswa->tahun_ajaran_id;
        $data->subtotal = 0;
        $data->uuid = Uuid::generate();
        $data->tunai = 1;

        if($request->discount != null) {
            $data->discount = $request->discount;
            $data->catatan_discount = $request->catatan_discount;
        }

        $data->save();

        foreach ($request->bulan as $bulan) {
            $detail = new PembayaranDetail;
            $detail->pembayaran_id = $data->id;
            $detail->bulan = $bulan;
            $detail->total = $siswa->tahun_ajaran->tagihan;
            $detail->save();

            $data->subtotal += $detail->total;
        }

        $data->kode_unik = 0;
        $data->total = $data->subtotal - $data->discount;
        $data->batas_bayar = \Carbon\Carbon::now()->addDays(2)->format('Y-m-d H:i:s');
        $data->invoice = 'INV' . date('YmdHis');
        $data->waktu_diterima = date('Y-m-d H:i:s');
        $data->approved_id = Auth::user()->id;
        $data->status = 1;
        $data->save();

        $item = $data;
        \Mail::send('email.pembayaran.diterima', ['item' => $item], function ($m) use ($item) {
            $m->to($item->user->email);
            $m->subject('[Pembayaran SPP DITERIMA ' . $item->invoice . ']');
        });

        return redirect()
            ->route('admin.pembayaran.show', $data->uuid)
            ->with('success', 'Berhasil tambah pembayaran');
    }
}
