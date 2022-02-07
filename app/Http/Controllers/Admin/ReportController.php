<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PembayaranExport;
use App\Exports\TunggakanExport;
use App\Http\Controllers\Controller;
use App\Kelas;
use App\Pembayaran;
use App\PembayaranDetail;
use App\Siswa;
use App\TahunAjaran;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pembayaran_old(Request $request)
    {
        $tahun = TahunAjaran::where('status', 1)->get();

        $models = null;
        $ta = null;

        if ($request->tahun_ajaran_id != null) {
            $ta = TahunAjaran::findOrFail($request->tahun_ajaran_id);

            $diff = Carbon::parse($ta->mulai)->floatDiffInMonths($ta->selesai);
            for ($i = 0; $i < ceil($diff); $i++) {
                $month = DATE('Y-m-d', strtotime($ta->mulai . "+" . $i . " month"));

                $data_row['month'] = date('M Y', strtotime($month));

                $jumlah = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) {
                    $query->where('status', 1);
                })->count();

                $total = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) {
                    $query->where('status', 1);
                })->sum('total');

                $data_row['jumlah'] = $jumlah;
                $data_row['total'] = $total;

                $models[] = $data_row;
            }

            if ($request->submit == 'report') {
                return Excel::download(new PembayaranExport($models), 'laporan_pembayaran_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.xlsx');
            }

            if ($request->submit == 'pdf') {
                $pdf = PDF::loadview('admin.laporan.pembayaran-pdf', ['models' => $models, 'tahun_ajaran' => $ta]);
                return $pdf->download('laporan_pembayaran_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.pdf');
            }
        }

        return view('admin.laporan.pembayaran', compact('ta', 'tahun', 'models'));
    }

    public function pembayaran(Request $request)
    {
        ini_set('max_execution_time', 0);
        $tahun = TahunAjaran::where('status', 1)->get();
        $kelas = Kelas::where('status', 1)->get();
        $models = null;
        $ta = null;
        $bulan = null;
        $ta = TahunAjaran::where('aktif', 1)->first();

        foreach ($kelas as $k) {
            $data = null;
            $data_row = null;
            $data['kelas'] = $k->getNama();

            $bayar = null;
            $diff = Carbon::parse($ta->mulai)->floatDiffInMonths($ta->selesai);
            for ($i = 0; $i < ceil($diff); $i++) {
                $month = DATE('Y-m-d', strtotime($ta->mulai . "+" . $i . " month"));

                $jumlah = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) use ($k) {
                    $query->where('status', 1)->whereHas('siswa', function ($q) use ($k) {
                        $q->where('kelas_id', $k->id);
                    });
                })->count();

                $bayar[] = $jumlah;

            }
            $data['bayar'] = $bayar;
            $data_row = $data;

            $models[] = $data_row;
        }

        $ta = TahunAjaran::where('aktif', 1)->first();
        $diff = Carbon::parse($ta->mulai)->floatDiffInMonths($ta->selesai);
        for ($i = 0; $i < ceil($diff); $i++) {
            $month = DATE('Y-m-d', strtotime($ta->mulai . "+" . $i . " month"));
            $bulan[] = date('M Y', strtotime($month));
        }

        if ($request->submit == 'report') {
            return Excel::download(new PembayaranExport($models, $bulan, $ta), 'laporan_pembayaran_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.xlsx');
        }

        if ($request->submit == 'pdf') {
            $pdf = PDF::loadview('admin.laporan.pembayaran-rev-pdf', ['models' => $models, 'bulan' => $bulan, 'ta' => $ta, 'tahun_ajaran' => $ta])->setPaper('a4', 'landscape')->setWarnings(false);
            return $pdf->download('laporan_pembayaran_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.pdf');
        }

        return view('admin.laporan.pembayaran-rev', compact('ta', 'tahun', 'models', 'bulan', 'kelas'));
    }

    // public function tunggakan(Request $request)
    // {
    //     $tahun = TahunAjaran::where('status', 1)->get();

    //     $models = null;
    //     $ta = null;

    //     if ($request->tahun_ajaran_id != null) {
    //         $ta = TahunAjaran::findOrFail($request->tahun_ajaran_id);

    //         $diff = Carbon::parse($ta->mulai)->floatDiffInMonths($ta->selesai);
    //         for ($i = 0; $i < ceil($diff); $i++) {
    //             $month = DATE('Y-m-d', strtotime($ta->mulai . "+" . $i . " month"));

    //             $data_row['month'] = date('M Y', strtotime($month));

    //             $jumlah = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) {
    //                 $query->where('status', 1);
    //             })->count();

    //             $total = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) {
    //                 $query->where('status', 1);
    //             })->sum('total');

    //             $siswa = Siswa::where('tahun_ajaran_id', $ta->id)->where('status', 1)->count();

    //             $data_row['jumlah'] = $siswa - $jumlah;
    //             $data_row['total'] = $data_row['jumlah'] * $ta->tagihan;

    //             $models[] = $data_row;
    //         }

    //         if ($request->submit == 'report') {
    //             return Excel::download(new TunggakanExport($models), 'laporan_tunggakan_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.xlsx');
    //         }

    //         if ($request->submit == 'pdf') {
    //             $pdf = PDF::loadview('admin.laporan.tunggakan-pdf', ['models' => $models, 'tahun_ajaran' => $ta]);
    //             return $pdf->download('laporan_tunggakan_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.pdf');
    //         }
    //     }

    //     return view('admin.laporan.tunggakan', compact('ta', 'tahun', 'models'));
    // }

    public function tunggakan(Request $request)
    {
        ini_set('max_execution_time', 0);
        $tahun = TahunAjaran::where('status', 1)->get();
        $kelas = Kelas::where('status', 1)->get();
        $models = null;
        $ta = null;
        $bulan = null;
        $ta = TahunAjaran::where('aktif', 1)->first();

        foreach ($kelas as $k) {
            $data = null;
            $data_row = null;
            $data['kelas'] = $k->getNama();

            $bayar = null;
            $diff = Carbon::parse($ta->mulai)->floatDiffInMonths($ta->selesai);
            for ($i = 0; $i < ceil($diff); $i++) {
                $month = DATE('Y-m-d', strtotime($ta->mulai . "+" . $i . " month"));

                $jumlah = PembayaranDetail::where('bulan', $month)->whereHas('pembayaran', function ($query) use ($k) {
                    $query->where('status', 1)->whereHas('siswa', function ($q) use ($k) {
                        $q->where('kelas_id', $k->id);
                    });
                })->count();

                $siswa = Siswa::where('tahun_ajaran_id', $ta->id)->where('kelas_id', $k->id)->where('status', 1)->count();

                $bayar[] = $siswa - $jumlah;

            }
            $data['bayar'] = $bayar;
            $data_row = $data;

            $models[] = $data_row;
        }

        $ta = TahunAjaran::where('aktif', 1)->first();
        $diff = Carbon::parse($ta->mulai)->floatDiffInMonths($ta->selesai);
        for ($i = 0; $i < ceil($diff); $i++) {
            $month = DATE('Y-m-d', strtotime($ta->mulai . "+" . $i . " month"));
            $bulan[] = date('M Y', strtotime($month));
        }

        if ($request->submit == 'pdf') {
            $pdf = PDF::loadview('admin.laporan.tunggakan-rev-pdf', ['models' => $models, 'bulan' => $bulan, 'ta' => $ta, 'tahun_ajaran' => $ta])->setPaper('a4', 'landscape')->setWarnings(false);
            return $pdf->download('laporan_tunggakan_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.pdf');
        }

        if ($request->submit == 'report') {
            return Excel::download(new TunggakanExport($models, $bulan, $ta), 'laporan_tunggakan_' . Str::slug($ta->nama) . '_' . date('d_m_Y_H_i_s') . '.xlsx');
        }

        return view('admin.laporan.tunggakan-rev', compact('ta', 'tahun', 'models', 'bulan', 'kelas'));
    }
}
