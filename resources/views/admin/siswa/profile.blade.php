@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Siswa
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
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
                    <li class="breadcrumb-item" aria-current="page">Data Siswa</li>
                </ol>
            </nav>
        </small>
    </div>
</div>
    <div class="alert mb-4 alert-info">
        <b>Perhatian!</b> Untuk perubahan data, silahkan hubungi bagian tata usaha sekolah.
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header text-gray-800">
                    Data Kelas
                </div>
                <div class="card-body">
                    <table class="table text-gray-800">
                        <tbody>
                            <tr>
                                <th>Kelas</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->kelas->getNama() }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tahun Ajaran</th>
                                <td>
                                    :
                                </td>
                                <td>
                                    {{ $data->tahun_ajaran->nama }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header text-gray-800">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
