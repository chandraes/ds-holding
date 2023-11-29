@extends('layouts.app')
@section('content')
<div class="container text-center">
    <h1>DATABASE</h1>
</div>
<div class="container mt-5">
    <div class="row justify-content-left">

        <div class="col-md-3 mt-3 text-center">
            <a href="{{route('db.divisi')}}" class="text-decoration-none">
                <img src="{{asset('images/divisi.svg')}}" alt="" width="100">
                <h2>DIVISI</h2>
            </a>
        </div>
        <div class="col-md-3 mt-3 text-center">
            <a href="{{route('komisaris')}}" class="text-decoration-none">
                <img src="{{asset('images/komisaris.svg')}}" alt="" width="100">
                <h2>KOMISARIS</h2>
            </a>
        </div>
    </div>
    <hr>
    <div class="row justify-content-left">
        <div class="col-md-3 mt-3 text-center">
            <a href="{{route('db.rekening')}}" class="text-decoration-none">
                <img src="{{asset('images/rekening.svg')}}" alt="" width="100">
                <h2>REKENING TRANSAKSI</h2>
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

