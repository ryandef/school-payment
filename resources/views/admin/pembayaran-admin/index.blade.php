@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Data Pembayaran
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
                        <li class="breadcrumb-item" aria-current="page">Data Pembayaran</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Body -->
        <div class="card-body ">
            {{-- <form id="formTA" method="get">
                <label for=""><strong>Tahun Ajaran</strong></label>
                <select name="tahun_ajaran" class="form-control" id="tahun_ajaran">
                    <option value="">Semua</option>
                    @foreach ($tahun_ajaran as $ta)
                        <option @if(\Request::get('tahun_ajaran') == $ta->id) selected @endif value="{{ $ta->id }}">{{$ta->nama}}</option>
                    @endforeach
                </select>
            </form> --}}
            <form action="" method="GET" class="form-inline">
                <div class="form-group text-gray-800 mr-4">
                    <label for="">Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="form-control mx-2" id="tahun_ajaran">
                    <option value="">Semua</option>
                    @foreach ($tahun_ajaran as $ta)
                        <option @if(\Request::get('tahun_ajaran') == $ta->id) selected @endif value="{{ $ta->id }}">{{$ta->nama}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group text-gray-800 mr-4">
                    <label for="">Kelas</label>
                    <select name="kelas" class="form-control mx-2" id="tahun_ajaran">
                    <option value="">Semua</option>
                    @foreach ($kelas as $k)
                        <option @if(\Request::get('kelas') == $k->id) selected @endif value="{{ $k->id }}">{{$k->getNama()}}</option>
                    @endforeach
                </select>
                </div>

                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-success" name="submit" value="search"><i
                            class="fa fa-search"></i> Filter</button>
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <a href="{{route('admin.pembayaran.index')}}" class="btn btn-danger"><i class="fa fa-file"></i>
                        Reset</a>
                </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Nama</th>
                            <th>Kelas / Tahun Ajaran</th>
                            <th>Tanggal</th>
                            <th>Potongan Beasiswa</th>
                            <th>Total</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><small>{{ $item->invoice }}</small></td>
                                <td><small>{{ $item->siswa->nama }}</small></td>
                                <td><small>{{ $item->kelas->getNama() }} / {{ $item->tahun_ajaran->nama }}</small></td>
                                <td><small>{{ $item->created_at }}</small></td>
                                <td><small>Rp{{ number_format($item->discount) }}</small></td>
                                <td><small>Rp{{ number_format($item->total - $item->kode_unik) }}</small></td>
                                <td>
                                    @if ($item->tunai == 1)
                                        Tunai
                                    @else
                                        Transfer
                                    @endif
                                </td>
                                <td>
                                    {!! $item->getStatus() !!}
                                </td>
                                <td>
                                    <a href="{{ route('admin.pembayaran.show', $item->uuid) }}"
                                        class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-eye"></i></a>
                                    @if ($item->status == 1)
                                        <a target="_blank" href="{{ route('admin.pembayaran.print', $item->uuid) }}"
                                            class="btn btn-danger btn-sm btn-rounded"><i class="fa fa-print"></i></a>
                                    @endif
                                </td>
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
            $('#tahun_ajaran').change(function(){
                $('#formTA').unbind('submit').submit();
            });
        });
    </script>
@endsection
