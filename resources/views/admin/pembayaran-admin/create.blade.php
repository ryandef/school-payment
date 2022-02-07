@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Bayar SPP
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.siswa.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
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
        <form id="formSubmit" action="{{ route('admin.pembayaran.store', $data->id) }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            Data Siswa
                        </div>
                        <div class="card-body">
                            <table class="table text-gray-800">
                                <tbody>
                                    <tr>
                                        <th>NIS</th>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $data->nis }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $data->nama }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $data->jenis_kelamin }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $data->telepon }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Telepon Orang Tua</th>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $data->telepon_orangtua }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $data->alamat }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            {{ $data->tgl_lahir }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header text-gray-800">
                            Pilih Bulan
                        </div>
                        <div class="card-body text-gray-800">
                            <strong>Biaya Per Bulan</strong> : {{ number_format($tahun->tagihan) }}
                            <hr>
                            @foreach ($models as $i => $item)
                                <input type="checkbox" class="checkbox_bulan" data-id="{{ $i }}" name="bulan[]"
                                    id="" value="{{ $item['value'] }}"> {{ $item['name'] }}
                                <hr>
                            @endforeach
                            <div class="form-group">
                                <label for=""><strong>Potongan Beasiswa</strong></label>
                                <input type="number" id="discount" name="discount" min="1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for=""><strong>Catatan Beasiswa</strong></label>
                                <input type="text" name="catatan_discount"  class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body text-gray-800">
                            <button id="submit-btn" type="submit" class="btn btn-success btn-block">Lakukan
                                Pembayaran</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

@endsection

@section('script')
    <script>
        $('#formSubmit').on('submit', function(e) {
            e.preventDefault();
            var discount = $('#discount').val();

            var arr = $(this).serialize().toString();
            if (arr.indexOf("bulan") < 0) {
                alert("Pilih bulan terlebih dahulu");
                return false;
            }
            var bulan_index = [];
            $('.checkbox_bulan').each(function() {
                if ($(this).is(':checked') == true) {
                    bulan_index.push($(this).attr('data-id'));
                }
            });

            for (var i = 0; i < bulan_index.length; i++) {
                if (bulan_index[i] != i) {
                    alert("Pilih bulan secara berurutan");
                    return false;
                }
            }

            var tagihan = {{$tahun->tagihan}};

            if(discount > tagihan) {
                alert('discount tidak boleh lebih dari nominal');
            }

            $('#submit-btn').attr('disabled', 'true');
            $('#formSubmit').unbind('submit').submit();
        });
    </script>
@endsection
