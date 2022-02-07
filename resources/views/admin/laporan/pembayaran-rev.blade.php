@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Laporan Pembayaran
@endsection

{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
            Kembali</small></a>
@endsection
{{-- Content --}}
@section('content')
    <style>
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc_disabled:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:after {
            display: none;
        }

    </style>
    {{-- Breadcrumbs --}}
    <div class="row">
        <div class="col-lg-12">
            <small>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-gray-800"
                                href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Laporan Pembayaran</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="GET" class="form-inline">
                {{-- <div class="form-group text-gray-800 mr-4">
                    <label for="">Tahun Ajaran</label>
                    <select class="form-control ml-2" name="tahun_ajaran_id" id="">
                        @foreach ($tahun as $item)
                            <option @if (\Request::get('tahun_ajaran_id') == $item->id) selected @endif value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-primary" name="submit" value="search"><i
                            class="fa fa-search"></i> Filter</button>
                </div> --}}
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-success" name="submit" value="report"><i
                            class="fa fa-file-excel"></i>
                        Export Excel</button>
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-danger" name="submit" value="pdf"><i class="fa fa-file"></i>
                        Export PDF</button>
                </div>
            </form>
        </div>
    </div>
    @if ($models != null)
        <div class="card shadow mb-4">
            <!-- Card Body -->
            <div class="card-body ">
                <div class="alert alert-info text-center">
                    <h5>
                        <strong>Laporan Pembayaran Sumbangan Pembinaan Pendidikan</strong>
                    </h5>
                    <h5>Tahun Ajaran {{ $ta->nama }}</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><small>No</small></th>
                                <th><small>Kelas</small></th>
                                @foreach ($bulan as $item)
                                    <th><small>{{ $item }}</small></th>
                                @endforeach
                                <th><small>Jumlah</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_bayar = 0;
                            @endphp
                            @php
                                $per_bulan = [];
                            @endphp
                            @forelse ($models as $i => $item)
                                @php
                                    $jumlah = 0;

                                @endphp
                                <tr>
                                    <td><small>{{ $i + 1 }}</small></td>
                                    <td><small>{{ $item['kelas'] }}</small></td>
                                    @foreach ($item['bayar'] as $j => $bayar)
                                        <td><small>{{ $bayar }}</small></td>
                                        @php
                                            $jumlah += $bayar;
                                            $per_bulan[$j][$i] = $bayar;
                                        @endphp
                                    @endforeach
                                    <td><small>{{ $jumlah }}</small></td>
                                    {{-- <td>Rp{{ number_format($item['total']) }}</td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Belum ada data</td>
                                </tr>
                            @endforelse

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" align="center">
                                    <small>Total</small>
                                </td>

                                @foreach ($per_bulan as $i => $per)
                                    @php
                                        $total_bayar += array_sum($per) * $ta->tagihan;
                                    @endphp
                                    <td>
                                        <small>{{ number_format(array_sum($per) * $ta->tagihan) }}</small>
                                    </td>
                                @endforeach
                                <td>
                                    <small>{{ number_format($total_bayar) }}</small>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
