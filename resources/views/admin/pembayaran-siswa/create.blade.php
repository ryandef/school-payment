@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Bayar SPP
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
                        <li class="breadcrumb-item" aria-current="page">Bayar SPP</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    @if (count($models) > 0)
    <form id="formSubmit" action="{{ route('admin.bayar.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header text-gray-800">
                        Pilih Bulan
                    </div>
                    <div class="card-body text-gray-800">
                        <strong>Biaya Per Bulan</strong> : {{number_format(Auth::user()->siswa->tahun_ajaran->tagihan)}}
                        <hr>
                        @foreach ($models as $i => $item)
                            <input type="checkbox" class="checkbox_bulan" data-id="{{$i}}" name="bulan[]" id="" value="{{ $item['value'] }}"> {{ $item['name'] }}
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header text-gray-800">
                        Pilih Tujuan Pembayaran
                    </div>
                    <div class="card-body text-gray-800">
                        <div class="form-group">
                            <label for="">Daftar Bank</label>
                            <select name="bank_id" class="form-control" id="">
                                @foreach ($bank as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="submit-btn" type="submit" class="btn btn-success btn-block">Lakukan Pembayaran</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif

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
            var bulan_index = [];
            $('.checkbox_bulan').each(function(){
                if($(this).is(':checked') == true) {
                    bulan_index.push($(this).attr('data-id'));
                }
            });

            for (var i = 0; i < bulan_index.length; i++) {
                if(bulan_index[i] != i) {
                    alert("Pilih bulan secara berurutan");
                    return false;
                }
            }

            $('#submit-btn').attr('disabled','true');
            $('#formSubmit').unbind('submit').submit();
        });
    </script>
@endsection
