<?php

namespace App\Http\Controllers;
use App\Siswa;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $siswa = Siswa::where('status', 1)->get();

        foreach($siswa as $item) {
            if($item->id == 1) {

                \Mail::send('email.pembayaran.reminder', ['item' => $item], function ($m) use ($item) {
                    $m->to($item->user->email);
                    $m->subject('[Pengingat Pembayaran SPP ' . $item->nama . ']');
                });

                $email_api = urlencode("ryanadhitama2@gmail.com");
                $passkey_api = urlencode("Hm1231236");
                $no_hp_tujuan = urlencode($item->telepon_orangtua);
                $isi_pesan = urlencode("Yth. Orang Tua/Wali Siswa. Jatuh tempo pembayaran SPP bulan ini adalah tanggal 10/".date('m/Y')." sebesar Rp".number_format($item->tahun_ajaran->tagihan).". Terima kasih.");
                $url = "https://reguler.medansms.co.id/sms_api.php?action=kirim_sms&email=" . $email_api . "&passkey=" . $passkey_api . "&no_tujuan=" . $no_hp_tujuan . "&pesan=" . $isi_pesan;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
            }
        }
    }
}
