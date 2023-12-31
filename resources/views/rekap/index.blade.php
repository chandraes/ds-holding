@extends('layouts.app')
@section('content')

<div class="container text-center">
    <h1>REKAP</h1>
</div>
<div class="container mt-5">
    <div class="row justify-content-left">
        <div class="col-md-3 mt-3 text-center">
            <a href="{{route('rekap.kas-besar')}}" class="text-decoration-none">
                <img src="{{asset('images/kas-besar.svg')}}" alt="" width="100">
                <h2>KAS BESAR</h2>
            </a>
        </div>
        <div class="col-md-3 mt-3 text-center">
            <a href="{{route('rekap.kas-kecil')}}" class="text-decoration-none">
                <img src="{{asset('images/kas-kecil.svg')}}" alt="" width="100">
                <h2>KAS KECIL</h2>
            </a>
        </div>
        <div class="col-md-3 mt-3 text-center">
            <a href="{{route('rekap.kas-gaji-komisaris')}}" class="text-decoration-none">
                <img src="{{asset('images/kas-gaji-komisaris.svg')}}" alt="" width="100">
                <h2>REKAP GAJI KOMISARIS</h2>
            </a>
        </div>
        <div class="col-md-3 mt-3 text-center">
            <a href="{{route('home')}}" class="text-decoration-none">
                <img src="{{asset('images/dashboard.svg')}}" alt="" width="100">
                <h2>DASHBOARD</h2>
            </a>
        </div>

    </div>
</div>
@endsection
