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
                <div class="form-group text-gray-800 mr-4">
                    <label for="">Tahun Ajaran</label>
                    <select class="form-control ml-2" name="tahun_ajaran_id" id="">
                        @foreach ($tahun as $item)
                            <option @if(\Request::get('tahun_ajaran_id') == $item->id) selected @endif value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-primary" name="submit" value="search"><i
                            class="fa fa-search"></i> Filter</button>
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-success" name="submit" value="report"><i class="fa fa-file-excel"></i>
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
                <h5>Tahun Ajaran {{$ta->nama}}</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bulan Pembayaran</th>
                            <th>Jumlah Pembayaran</th>
                            <th>Total Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['month'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>Rp{{ number_format($item['total']) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
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
