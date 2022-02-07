@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Dashboard
@endsection
@section('content')
    {{-- Breadcrumbs --}}
    <div class="row">
        <div class="col-lg-12">
            <small>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-gray-800" href="{{ route('admin.index') }}">Dashboard
                                {{ \Auth::user()->getType() }}</a></li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Halo,</div>
                            <div class="mb-0 font-weight-bold text-gray-800">{{ \Auth::user()->name }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
<div class="row">
    <div class="col-xl-4 col-md-6 mb-2">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pembayaran hari ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($data['pembayaran']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-2">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pembayaran {{date('M Y')}}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($data['total_bayar']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-2">
        <div class="card border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Tunggakan {{date('M Y')}}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($data['total_tunggakan']) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
