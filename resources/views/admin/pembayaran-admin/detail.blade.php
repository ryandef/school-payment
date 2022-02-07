@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Detail Bayar {{ $model->invoice }}
@endsection
@section('back_button')
    <a href="{{ route('admin.pembayaran.index') }}" class="mb-2 d-block text-gray-800"><small><i
                class="fa fa-arrow-left"></i>
            Kembali</small></a>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <small>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-gray-800"
                                href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Detail Bayar</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header text-gray-800">
                    Rincian Pembayaran
                </div>
                <div class="card-body">
                    <style>
                        .payment-box {
                            border: 1px dashed #5a5c69;
                            padding: 20px;
                        }

                    </style>

                    <div class="payment-box text-center text-gray-800">
                        @if ($model->tunai == 0)
                            <img class="mb-2" src="{{ $model->bank->getImage() }}"
                                alt="{{ $model->bank->nama }}" width="100"> <br>
                            {{ $model->bank->nama }} (Kode : {{ $model->bank->kode }})
                            <h4 class="mt-1"><b>{{ $model->bank->ref_nomor }}</b></h4>
                            <p>a/n {{ $model->bank->ref_nama }}</p>
                            <hr>
                            <p>Jumlah Transfer
                            @else
                            <h4>Pembayaran Tunai</h4>
                            <hr>
                        @endif

                        <h3>
                            Rp {{ number_format($model->total) }}
                        </h3>
                        </p>
                    </div>
                    @if ($model->bukti != null)
                        <hr>
                        <a target="_blank" href="{{ $model->getFile() }}" class="btn btn-primary btn-block">Lihat Bukti
                            Transfer</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header text-gray-800">
                    <div class="row">
                        <div class="col-6">
                            Detail Siswa
                        </div>
                        <div class="col-6 text-right">
                            <a target="_blank" href="{{ route('admin.siswa.show', $model->siswa->id) }}"
                                class="btn btn-sm btn-primary">Lihat</a>
                            @if ($model->status == 1)
                                <a target="_blank" href="{{ route('admin.pembayaran.print', $model->uuid) }}"
                                    class="btn btn-sm btn-danger">Print</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-body  text-gray-800">
                    <strong>NIS</strong> : {{ $model->siswa->nis }} <br>
                    <strong>Nama</strong> : {{ $model->siswa->nama }}
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header text-gray-800">
                    Detail Bayar
                </div>
                <div class="card-body text-gray-800">
                    <strong>Tanggal </strong> : {{ date('d M Y, H:i:s', strtotime($model->created_at)) }} <br>
                    <strong>Batas Bayar</strong> : {{ date('d M Y, H:i:s', strtotime($model->batas_bayar)) }} <br>
                    @if ($model->waktu_diterima != null)
                        <strong>Diterima pada</strong> : {{ date('d M Y, H:i:s', strtotime($model->waktu_diterima)) }}
                        <br>
                    @endif
                    <strong>Status</strong> : {!! $model->getStatus() !!}
                    @if ($model->status == -1)
                        <hr>
                        <b>Catatan:</b> <br>
                        {{ $model->catatan }} <br>
                    @endif
                    @if ($model->discount > 0)
                        <hr>
                        <b>Potongan Beasiswa: </b> Rp{{ number_format($model->discount) }} <br>
                        {{ $model->catatan_discount }}<br>
                    @endif
                    <hr>
                    @foreach ($model->detail as $item)
                        <li>
                            <small>
                                <strong class="text-gray-800">{{ date('M Y', strtotime($item->bulan)) }}</strong>
                                (Rp{{ number_format($item->total) }})
                            </small>
                        </li>
                    @endforeach
                </div>
            </div>
            @if ($model->status == 0 && $model->bukti != null)
                <div class="card mb-4">
                    <div class="card-body text-gray-800">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0)"
                                    onclick="receive('{{ route('admin.pembayaran.update', $model->uuid) . '?status=1' }}')"
                                    class="btn btn-success btn-block">Terima</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#create"
                                    class="btn btn-danger btn-block">Tolak</a>
                            </div>

                            <div class="modal fade" id="create" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tolak Pembayaran</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.pembayaran.reject', $model->uuid) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="" class="label">Catatan</label>
                                                    <textarea name="catatan" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@section('script')
    <script>
        function decline(id) {
            swal({
                    title: "Yakin ingin menolak pembayaran?",
                    text: "Setelah ditolak, Anda tidak akan dapat memulihkan data tersebut",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = id;
                        //   $(id).unbind('submit').submit()

                    } else {
                        return false;
                    }
                });
        }

        function receive(id) {
            swal({
                    title: "Yakin ingin menerima pembayaran?",
                    text: "Setelah diterima, data penerimaan pembayaran akan diteruskan ke siswa",
                    icon: "info",
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = id;
                        //   $(id).unbind('submit').submit()

                    } else {
                        return false;
                    }
                });
        }
    </script>
@endsection
