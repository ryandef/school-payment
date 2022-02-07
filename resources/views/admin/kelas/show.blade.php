@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Detail Kelas {{$model->getNama()}}
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.kelas.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
            Kembali</small></a>
@endsection

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
                        <li class="breadcrumb-item" aria-current="page">Detail Kelas</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    {{-- Table --}}
    <div class="card shadow mb-4">

        <!-- Card Body -->
        <div class="card-body ">
            <form id="formTA" method="get">
                <label for="">Tahun Ajaran</label>
                <select name="tahun_ajaran" class="form-control" id="tahun_ajaran">
                    <option value="">Pilih Tahun Ajaran</option>
                    @foreach ($tahun_ajaran as $ta)
                        <option @if(\Request::get('tahun_ajaran') == $ta->id) selected @endif value="{{ $ta->id }}">{{$ta->nama}}</option>
                    @endforeach
                </select>
            </form>
            @if (\Request::get('tahun_ajaran') != null)
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kelas->getNama() }}</td>
                                <td>{{ $item->tahun_ajaran->nama }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('admin.siswa.show', $item->id) }}" class="btn btn-success btn-circle btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
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
