@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Update Semua Siswa
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
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
                        <li class="breadcrumb-item" aria-current="page">Update Semua Siswa</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <form action="" method="GET">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header text-gray-800">
                        Filter Data
                    </div>
                    <div class="card-body">

                        <div style="display: flex;">
                            @csrf
                            <div class="form-group text-gray-800 mr-2">
                                <select class="form-control" name="kelas_id">
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" @if (\Request::get('kelas_id') == $item->id) selected="selected" @endif>
                                            {{ $item->getNama() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group text-gray-800 mr-2">
                                <select class="form-control" name="tahun_ajaran_id">
                                    @foreach ($tahun as $item)
                                        <option value="{{ $item->id }}" @if (\Request::get('tahun_ajaran_id') == $item->id) selected="selected" @endif>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('admin.siswa.update-all-save') }}" method="POST">
        <div class="card shadow mb-4">
            <div class="card-header text-gray-800">
                Update Data
            </div>
            <div class="card-body">

                <div style="display: flex;">
                    @csrf
                    <div class="form-group text-gray-800 mr-2">
                        <select class="form-control" name="kelas_id" required>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->getNama() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group text-gray-800 mr-2">
                        <select class="form-control" name="tahun_ajaran_id" required>
                            @foreach ($tahun as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>

            </div>
        </div>
        {{-- Table --}}
        <div class="card shadow mb-4">

            <!-- Card Body -->
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Tahun Ajaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($models as $i => $item)
                                <tr>
                                    <td><input type="checkbox" name="siswa_id[]" value="{{ $item->id }}" id=""></td>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->kelas->getNama() }}</td>
                                    <td>{{ $item->tahun_ajaran->nama }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('script')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#dataTable').DataTable();
        // });

        function deleteData(id) {
            swal({
                    title: "Yakin ingin menghapus data?",
                    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data tersebut",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $(id).unbind('submit').submit()

                    } else {
                        return false;
                    }
                });
        }

        $('#checkAll').click(function() {
            $('input:checkbox').prop('checked', this.checked);
        });
    </script>
@endsection
