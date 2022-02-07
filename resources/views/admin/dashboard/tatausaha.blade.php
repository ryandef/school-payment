@extends('layouts.admin')
{{-- Title --}}
@section('title')
Dashboard
@endsection
@section('content')
{{-- Breadcrumbs --}}
<div class="row">
    <div class="col-lg-12">
        <small>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-gray-800" href="{{route('admin.index')}}">Dashboard {{\Auth::user()->getType()}}</a></li>
                </ol>
              </nav>
        </small>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Halo,</div>
                        <div class="mb-0 font-weight-bold text-gray-800">{{ \Auth::user()->name }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jurusan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['jurusan'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-table fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Kelas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['kelas'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['siswa'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-xl-4 col-md-6 mb-2">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pembayaran hari ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($data['pembayaran']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-2">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pembayaran {{date('M Y')}}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($data['total_bayar']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-2">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Tunggakan {{date('M Y')}}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($data['total_tunggakan']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-6">
        <div class="card mb-2">
            <div class="card-header bg-primary text-white">
                Daftar Kelas
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah Siswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['data_kelas'] as $i => $item)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td>{{$item->getNama()}}</td>
                            <td>{{$item->siswa->where('status', 1)->count()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-2">
            <div class="card-header bg-primary text-white">
                Daftar Jurusan
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['data_jurusan'] as $i => $item)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td>{{$item->kode}}</td>
                            <td>{{$item->kelas->where('status', 1)->count()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</div>


@endsection
