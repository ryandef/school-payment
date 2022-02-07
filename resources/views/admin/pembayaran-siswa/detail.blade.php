@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Detail Bayar {{ $model->invoice }}
@endsection
@section('back_button')
    <a href="{{ route('admin.bayar.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
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
                        <hr>
                        <small>Pastikan transfer hingga digit terakhir.</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header text-gray-800">
                    Detail Bayar
                </div>
                <div class="card-body text-gray-800">
                    <strong>Tanggal  </strong> : {{date('d M Y, H:i:s', strtotime($model->created_at))}} <br>
                    <strong>Batas Bayar</strong> : {{date('d M Y, H:i:s', strtotime($model->batas_bayar))}} <br>
                    @if ($model->waktu_diterima != null)
                    <strong>Diterima pada</strong> : {{date('d M Y, H:i:s', strtotime($model->waktu_diterima))}} <br>
                    @endif
                    <strong>Status</strong> : {!!$model->getStatus()!!}
                    @if ($model->status == -1)
                        <hr>
                        <b>Catatan:</b> <br>
                        {{$model->catatan}} <br>
                    @endif
                    @if ($model->discount > 0)
                        <hr>
                        <b>Potongan Beasiswa: </b> Rp{{ number_format($model->discount) }} <br>
                        {{ $model->catatan_discount }}<br>
                    @endif
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
            @if ($model->status != 1 && $model->status != -1)
            <div class="card mb-4">
                <div class="card-header text-gray-800">
                    Upload Bukti
                </div>
                <div class="card-body">
                    @if($model->bukti == null)
                    <form id="formSubmit" enctype="multipart/form-data" action="{{route('admin.bayar.update', $model->uuid)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="file" name="bukti" class="form-control-file" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <button id="submit-btn" type="submit" class="btn btn-success btn-block">Upload</button>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-info">
                        Mohon menunggu proses verifikasi admin maksimal 2 x 24 jam
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#formSubmit').on('submit', function(e){
            e.preventDefault();

            $('#submit-btn').attr('disabled','true');
            $('#formSubmit').unbind('submit').submit();
        });
    </script>
@endsection
