<?php

namespace App\Http\Controllers\Admin;

use App\Bank;
use App\Http\Controllers\Controller;
use App\Pembayaran;
use App\PembayaranDetail;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Uuid;

class PembayaranSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pembayaran()
    {
        $siswa_id = Auth::user()->siswa->id;

        $data['tunggakan'] = 0;
        $data['bayar'] = 0;

        $tahun = Auth::user()->siswa->tahun_ajaran;

        $models = [];
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

        return view('admin.pembayaran-siswa.pembayaran', compact('data', 'models'));
    }

    public function index()
    {
        $models = Pembayaran::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('admin.pembayaran-siswa.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun = Auth::user()->siswa->tahun_ajaran;
        $siswa_id = Auth::user()->siswa->id;

        $pending = Pembayaran::where('siswa_id', $siswa_id)->where('status', 0)->count();

        if($pending > 0) {
            return view('admin.pembayaran-siswa.pending');
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
        return view('admin.pembayaran-siswa.create', compact('models', 'bank'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->bulan == "") {
            return redirect()
                ->back()
                ->with('error_msg', 'Pilih bulan terlebih dahulu');
        }

        $data = new Pembayaran;
        $data->user_id = Auth::user()->id;
        $data->siswa_id = Auth::user()->siswa->id;
        $data->kelas_id = Auth::user()->siswa->kelas_id;
        $data->bank_id = $request->bank_id;
        $data->tahun_ajaran_id = Auth::user()->siswa->tahun_ajaran->id;
        $data->subtotal = 0;
        $data->uuid = Uuid::generate();
        $data->save();

        foreach ($request->bulan as $bulan) {
            $detail = new PembayaranDetail;
            $detail->pembayaran_id = $data->id;
            $detail->bulan = $bulan;
            $detail->total = Auth::user()->siswa->tahun_ajaran->tagihan;
            $detail->save();

            $data->subtotal += $detail->total;
        }

        $data->kode_unik = rand(0, 500);
        $data->total = $data->subtotal + $data->kode_unik;
        $data->batas_bayar = \Carbon\Carbon::now()->addDays(2)->format('Y-m-d H:i:s');
        $data->invoice = 'INV' . date('YmdHis');
        $data->save();

        return redirect()
            ->route('admin.bayar.show', $data->uuid)
            ->with('success', 'Berhasil tambah pembayaran');
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
        return view('admin.pembayaran-siswa.detail', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $data = Pembayaran::where('uuid', $id)->first();
        $file = $request->file('bukti');

        $nama_file = date('YmdHis') . '.' . strtolower($file->getClientOriginalExtension());
        $lokasi = 'img/bukti/';

        $file->move($lokasi, $nama_file);

        $data->bukti = $nama_file;
        $data->save();

        $item = $data;

        \Mail::send('email.pembayaran.upload', ['item' => $item], function ($m) use ($item) {
            $m->to(env('EMAIL_ADMIN'));
            $m->subject('[Pembayaran SPP ' . $item->invoice . ']');
        });

        return redirect()
            ->back()
            ->with('success', 'Berhasil upload bukti bayar');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pembayaran::where('uuid', $id)->first();
        $data->status = -1;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }
}
