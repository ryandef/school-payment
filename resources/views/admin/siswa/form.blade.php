@extends('layouts.admin')
{{-- Title --}}
@section('title')
    @if ($model->exists) Edit @else Tambah @endif Siswa
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.siswa.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
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
                        <li class="breadcrumb-item"><a class="text-gray-800"
                                href="{{ route('admin.siswa.index') }}">Siswa</a></li>
                        <li class="breadcrumb-item" aria-current="page">@if ($model->exists) Edit @else Tambah @endif Siswa</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <form action="@if ($model->exists) {{ route('admin.siswa.update', $model->id) }} @else {{ route('admin.siswa.store') }} @endif" method="post">@csrf
        @if ($model->exists)
            @method("PUT")
        @else
            @method("POST")
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="text-gray-800">Data Siswa</span>
                    </div>
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">NIS <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nis" required id=""
                                        value="{{ $model->nis }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" required id=""
                                        value="{{ $model->nama }}">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tgl_lahir" required id=""
                                        value="{{ $model->tgl_lahir }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-control" id="" required>
                                        <option @if ($model->jenis_kelamin == 'L') selected @endif value="L">Laki-Laki</option>
                                        <option @if ($model->jenis_kelamin == 'P') selected @endif value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">No Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="telepon" required id=""
                                        value="{{ $model->telepon }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">No Telepon Orang Tua <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="telepon_orangtua" required id=""
                                        value="{{ $model->telepon_orangtua }}">
                                </div>
                            </div>

                        </div>
                        <div class="row">

                        </div>
                        <div class="form-group text-gray-800">
                            <label for="">Alamat <span class="text-danger">*</span></label>
                            <textarea required name="alamat" class="form-control">{{ $model->alamat }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="text-gray-800">Data User</span>
                    </div>
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required id=""
                                        value="{{ $model->user ? $model->user->email : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">Password @if (!$model->exists)<span class="text-danger">*</span>@endif</label>
                                    <input type="password" class="form-control" name="password" @if (!$model->exists) required @endif id="">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="text-gray-800">Data Kelas</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-control" name="kelas_id" required>
                                        @foreach ($kelas as $item)
                                            <option @if ($model->kelas_id == $item->id) selected @endif value="{{ $item->id }}">
                                                {{ $item->getNama() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-gray-800">
                                    <label for="">Tahun Ajaran <span class="text-danger">*</span></label>
                                    <select class="form-control" name="tahun_ajaran_id" required>
                                        @foreach ($tahun as $item)
                                            <option @if ($model->tahun_ajaran_id == $item->id) selected @endif value="{{ $item->id }}">
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block">Simpan Data</button>
        </div>
    </form>
@endsection
