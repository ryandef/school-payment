@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Data Bayar
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
                        <li class="breadcrumb-item" aria-current="page">Data Bayar</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    {{-- Tambah Data --}}
    <a href="{{ route('admin.bayar.create') }}" class="btn btn-primary btn-icon-split shadow">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Data</span>
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
                            <th>Invoice</th>
                            <th>Tanggal</th>
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
                                <td><small>{{ date('d M Y, H:i:s', strtotime($item->created_at)) }}</small></td>
                                <td>Rp{{ number_format($item->subtotal) }}</td>
                                <td>
                                    @if ($item->tunai == 1)
                                        Tunai
                                    @else
                                        Transfer
                                    @endif
                                </td>
                                <td>{!! $item->getStatus() !!}</td>
                                <td>

                                    <form id="formDelete-{{ $item->id }}"
                                        action="{{ route('admin.bayar.destroy', $item->uuid) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="{{ route('admin.bayar.show', $item->uuid) }}"
                                            class="btn btn-info btn-circle btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($item->status == 0 && $item->bukti == null)
                                            <button type="button" onclick="deleteData('#formDelete-{{ $item->id }}')"
                                                class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif

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
