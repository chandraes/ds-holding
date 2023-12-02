@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-12 text-center">
            <h1><u>FORM DIVIDEN DIVISI</u></h1>
        </div>
    </div>
    @include('swal')
    <form action="{{route('form-dividen-divisi.store')}}" method="post" id="masukForm">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="mb-3">
                    <label for="divisi_id" class="form-label">Divisi</label>
                    <select class="form-select" name="divisi_id" id="divisi_id" required>
                        <option value="">-- PILIH DIVISI --</option>
                        @foreach ($data as $item)
                        <option value="{{$item->id}}" @if (old('divisi_id') == $item->id)
                            selected
                        @endif>{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-8 mb-3">
                <label for="nominal_transaksi" class="form-label">Nominal</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rp</span>
                    <input type="text" class="form-control @if ($errors->has('nominal_transaksi'))
                    is-invalid
                @endif" name="nominal_transaksi" id="nominal_transaksi" required data-thousands=".">
                </div>
                @if ($errors->has('nominal_transaksi'))
                <div class="invalid-feedback">
                    {{$errors->first('nominal_transaksi')}}
                </div>
                @endif
            </div>
        </div>
        <div class="d-grid gap-3 mt-3">
            <button class="btn btn-success" type="submit">Simpan</button>
            <a href="{{route('billing')}}" class="btn btn-secondary" type="button">Batal</a>
        </div>
    </form>
</div>
@endsection
@push('js')
<script src="{{asset('assets/js/cleave.min.js')}}"></script>
<script>
   var nominal = new Cleave('#nominal_transaksi', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand',
        numeralDecimalMark: ',',
        delimiter: '.'
    });


    // masukForm on submit, sweetalert confirm
    $('#masukForm').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Apakah data sudah benar?',
            text: "Pastikan data sudah benar sebelum disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, simpan!'
            }).then((result) => {
            if (result.isConfirmed) {
                $('#spinner').show();
                this.submit();
            }
        })
    });
</script>
@endpush
