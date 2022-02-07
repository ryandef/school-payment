@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Data Tunggakan Siswa
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
                        <li class="breadcrumb-item" aria-current="page">Data Tunggakan Siswa</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    {{-- Table --}}
    <div class="card shadow mb-4">
        <!-- Card Body -->
        <div class="card-body ">
            {{-- <b>Bulan : </b> {{date('M Y')}} <br> --}}
            <form id="formBulan" method="get">
            <select name="bulan" class="form-control" id="bulan">
                <option value="">Pilih Bulan</option>
                @foreach ($data['month'] as $ta)
                    <option @if($ta['value'] == \Request::get('bulan')) selected="selected" @endif value="{{ $ta['value'] }}">{{$ta['label']}}</option>
                @endforeach
            </select>
            </form>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->kelas->getNama() }}</td>
                                <td>{{ $item->tahun_ajaran->nama }}</td>
                                <td>
                                    <a href="{{ route('admin.pembayaran.create', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-wallet"></i> Bayar
                                    </a>
                                    <a href="{{ route('admin.tunggakan.notif', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-bell"></i> Notifikasi
                                    </a>
                                    <a target="_blank" href="{{ route('admin.siswa.show', $item->id) }}" class="btn btn-success  btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

    </script>
    <script>
        $(document).ready(function(){
            $('#bulan').change(function(){
                $('#formBulan').unbind('submit').submit();
            });
        });
    </script>
@endsection
