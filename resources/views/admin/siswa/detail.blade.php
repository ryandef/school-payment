@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Detail Siswa {{ $data->nis }}
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.siswa.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
            Kembali</small></a>
@endsection
{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <small>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-gray-800"
                                href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Data Siswa {{ $data->nis }}</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Data Siswa
                </div>
                <div class="card-body">
                    <table class="table text-gray-800">
                        <tbody>
                            <tr>
                                <th>NIS</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->nis }}
                                </td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->nama }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->jenis_kelamin }}
                                </td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->telepon }}
                                </td>
                            </tr>
                            <tr>
                                <th>Telepon Orang Tua</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->telepon_orangtua }}
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->alamat }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->tgl_lahir }}
                                </td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->kelas->getNama() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Detail Bayar
                </div>
                <div class="card-body">
                    <table class="table text-gray-800">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <form id="formTA" method="get">
                                        <select name="tahun_ajaran" class="form-control" id="tahun_ajaran">
                                            @foreach ($tahun_ajaran as $ta)
                                                <option @if(\Request::get('tahun_ajaran') == $ta->id) selected @endif value="{{ $ta->id }}">{{$ta->nama}}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $tahun->nama }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bulan</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($models as $i => $item)
                                <tr>
                                    <td>{{$i + 1}}</td>
                                    <td>{{ $item['month'] }}</td>
                                    <td>Rp{{ number_format($item['tagihan']) }}</td>
                                    <td>{{ $item['status'] }}</td>
                                    <td>
                                        @if ($item['uuid'] != null)
                                            <a target="_blank" href="{{route('admin.pembayaran.show', $item['uuid'])}}" class="btn btn-sm btn-danger">Invoice</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#tahun_ajaran').change(function(){
                $('#formTA').unbind('submit').submit();
            });
        });
    </script>
@endsection
