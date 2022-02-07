<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\Kelas;
use App\Siswa;
use App\Pembayaran;
use App\User;
use App\TahunAjaran;
use App\PembayaranDetail;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];

        $tahun = TahunAjaran::where('aktif', 1)->first();
        $diff = Carbon::parse($tahun->mulai)->floatDiffInMonths($tahun->selesai);

        for ($i = 0; $i < ceil($diff); $i++) {
            $month = DATE('Y-m-d', strtotime($tahun->mulai . "+" . $i . " month"));
            $data_row['month'] = date('M Y', strtotime($month));
        }
        $data['filter'] = $data_row;
        $data['pembayaran'] = Pembayaran::where('status', 1)->whereDate('created_at', date('Y-m-d'))->get()->sum('subtotal');
        $data['total_bayar'] = 0;
        $data['total_tunggakan'] = 0;
        for ($i = 0; $i < ceil($diff); $i++) {
                $month = DATE('Y-m-d', strtotime($tahun->mulai . "+" . $i . " month"));

                $data_row['month'] = date('M Y', strtotime($month));

                $jumlah = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) {
                    $query->where('status', 1);
                })->count();

                $total = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) {
                    $query->where('status', 1);
                })->sum('total');
                $siswa = Siswa::where('tahun_ajaran_id', $tahun->id)->where('status', 1)->count();

                if(date('Y-m') == DATE('Y-m', strtotime($tahun->mulai . "+" . $i . " month"))) {
                    $data['total_bayar'] = $total;
                    $data['total_tunggakan'] = ($siswa - $jumlah) * $tahun->tagihan;
                }


            }


        if (Auth::user()->type == 1) {
            return view('admin.dashboard.kepala-sekolah', compact('data'));
        } else if (Auth::user()->type == 2) {
            $data['jurusan'] = Jurusan::where('status', 1)->count();
            $data['kelas'] = Kelas::where('status', 1)->count();
            $data['siswa'] = Siswa::where('status', 1)->count();

            $data['data_jurusan'] = Jurusan::where('status', 1)->take(5)->get();
            $data['data_kelas'] = Kelas::where('status', 1)->take(5)->get();

            return view('admin.dashboard.tatausaha', compact('data'));
        } else if (Auth::user()->type == 3) {
            $data['user'] = User::where('status', 1)->count();
            return view('admin.dashboard.administrasi', compact('data'));
        } else if (Auth::user()->type == 4) {
            return view('admin.dashboard.siswa');
        }

    }
}
