@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Konfirmasi
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.bayar.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
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
                        <li class="breadcrumb-item" aria-current="page">Konfirmasi</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <h2>Informasi</h2>
            <hr>
            <p>Terdapat pembayaran yang belum dikonfirmasi. Harap bersabar.</p>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('#formSubmit').on('submit', function(e){
            e.preventDefault();

            var arr = $(this).serialize().toString();
            if(arr.indexOf("bulan") < 0){
                alert("Pilih bulan terlebih dahulu");
                return false;
            }

            $('#submit-btn').attr('disabled','true');
            $('#formSubmit').unbind('submit').submit();
        });
    </script>
@endsection
