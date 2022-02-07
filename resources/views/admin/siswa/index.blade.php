@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Data Siswa
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
                        <li class="breadcrumb-item"><a class="text-gray-800" href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Data Siswa</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    {{-- Tambah Data --}}
    <a href="{{route('admin.siswa.create')}}" class="btn btn-primary btn-icon-split shadow">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Data</span>
    </a>

    <a href="{{route('admin.siswa.update-all')}}" class="btn btn-warning btn-icon-split shadow">
        <span class="icon text-white-50">
            <i class="fas fa-edit"></i>
        </span>
        <span class="text">Edit Data Masal</span>
    </a>


    <br><br>
    {{-- Table --}}
    <div class="card shadow mb-4">

        <!-- Card Body -->
        <div class="card-body ">
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
                                    <form id="formDelete-{{ $item->id }}"
                                        action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('admin.pembayaran.create', $item->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-wallet"></i> Bayar
                                        </a>
                                        <a target="_blank" href="{{ route('admin.siswa.show', $item->id) }}" class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a target="_blank" href="{{ route('admin.siswa.edit', $item->id) }}" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button" onclick="deleteData('#formDelete-{{ $item->id }}')"
                                            class="btn btn-danger btn-circle btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

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
    </script>
@endsection
