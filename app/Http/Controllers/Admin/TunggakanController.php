<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PembayaranDetail;
use App\Siswa;
use App\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TunggakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = null;
        $ta = TahunAjaran::first();
        $diff = Carbon::parse($ta->mulai)->floatDiffInMonths($ta->selesai);
        for ($i = 0; $i < ceil($diff); $i++) {
            $month = DATE('Y-m-d', strtotime($ta->mulai . "+" . $i . " month"));
            $data['bulan']['label'] = date('M Y', strtotime($month));
            $data['bulan']['value'] = date('Y-m-', strtotime($month)).'01';

            $data['month'][] = $data['bulan'];
        }

        if($request->get('bulan') == null) {
            $date = date('Y-m-') . '01';
        } else {
            $date = $request->get('bulan');
        }


        $detail = PembayaranDetail::where('bulan', $date)->whereHas('pembayaran', function ($query) use ($date) {
            $query->where('status', 1);
        })->get();

        $sudah_bayar = [];
        foreach ($detail as $d) {
            $sudah_bayar[] = $d->pembayaran->siswa_id;
        }

        $models = Siswa::where('status', 1)->where('tahun_ajaran_id', 1)->whereNotIn('id', $sudah_bayar)->get();
        return view('admin.tunggakan.index', compact('models', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notif($id)
    {
        $siswa = Siswa::find($id);

        $item = $siswa;
        \Mail::send('email.pembayaran.reminder', ['item' => $item], function ($m) use ($item) {
            $m->to($item->user->email);
            $m->subject('[Pengingat Pembayaran SPP ' . $item->nama . ']');
        });

        $email_api = urlencode("ryanadhitama2@gmail.com");
        $passkey_api = urlencode("Hm1231236");
        $no_hp_tujuan = urlencode($item->telepon_orangtua);
        $isi_pesan = urlencode("Yth. Orang Tua/Wali Siswa. Jatuh tempo pembayaran SPP bulan ini adalah tanggal 10/" . date('m/Y') . " sebesar Rp" . number_format($item->tahun_ajaran->tagihan) . ". Terima kasih.");
        $url = "https://reguler.medansms.co.id/sms_api.php?action=kirim_sms&email=" . $email_api . "&passkey=" . $passkey_api . "&no_tujuan=" . $no_hp_tujuan . "&pesan=" . $isi_pesan;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return redirect()
            ->back()
            ->with('success', 'Berhasil mengirim notifikasi ke ' . $item->nama);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
