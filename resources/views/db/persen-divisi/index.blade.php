@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h1><u>PERSEN GAJI KOMISARIS PER DIVISI</u></h1>
        </div>
    </div>
    <div class="row justify-content-between mt-3">
        <div class="col-md-6">
            <table class="table" id="data-table">
                <tr>
                    <td><a href="{{route('home')}}"><img src="{{asset('images/dashboard.svg')}}" alt="dashboard"
                                width="30"> Dashboard</a></td>
                    <td><a href="{{route('db')}}"><img src="{{asset('images/database.svg')}}" alt="dokumen" width="30">
                            Database</a></td>
                    {{-- <td><a href="#" data-bs-toggle="modal" data-bs-target="#createInvestor"><img
                                src="{{asset('images/persen-divisi.svg')}}" width="30"> Tambah Persentase</a>

                    </td> --}}
                </tr>
            </table>
        </div>
    </div>
</div>
{{-- @include('db.persen-divisi.create') --}}
@include('db.persen-divisi.edit')
<div class="container mt-5 table-responsive">
    @foreach ($divisi as $d)
    <div class="row mb-3">
        <div class="col-md-12">
            <h3>{{$d->nama}}</h3>
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th class="text-center align-middle">No</th>
                    <th class="text-center align-middle">Komisaris</th>
                    <th class="text-center align-middle">Persentase</th>
                    <th class="text-center align-middle">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalPersentase = 0;
                @endphp
                @foreach ($komisaris as $k)
                @php
                $persentase = $k->persentaseDivisi($d->id);
                $totalPersentase += $persentase;
                @endphp
                <tr>
                    <td class="text-center align-middle">{{$loop->iteration}}</td>
                    <td class="text-center align-middle">{{$k->nama}}</td>
                    <td class="text-center align-middle">{{$persentase}}%</td>
                    <td class="text-center align-middle">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editInvestor" onclick="editInvestor({{$d}}, {{$k}}, {{$persentase}})"><i
                                class="fa fa-edit"></i> Edit</button>

                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-end">Total Persentase:</th>
                    <th class="text-center">{{$totalPersentase}}%</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <hr>
    @endforeach
</div>

@endsection
@push('css')
<link href="{{asset('assets/css/dt.min.css')}}" rel="stylesheet">
<style>
    .hide-footer {
        display: none;
    }
</style>
@endpush
@push('js')

<script src="{{asset('assets/js/cleave.min.js')}}"></script>

<script src="{{asset('assets/js/dt5.min.js')}}"></script>
<script>
    function editInvestor(divisi, komisaris, persen) {
        console.log(divisi, komisaris.id, persen);
        document.getElementById('divisi').value = divisi.nama;
        document.getElementById('divisi_id').value = divisi.id;
        document.getElementById('komisaris').value = komisaris.nama;
        document.getElementById('komisaris_id').value = komisaris.id;
        document.getElementById('edit_persen').value = persen;
        // Populate other fields...
        document.getElementById('editForm').action = '/db/persen-divisi/store';
    }



    var table = $('#data').DataTable({
        paging: false,
        scrollCollapse: true,
        scrollY: "550px",
        drawCallback: function (settings) {
            var api = this.api();
            var startIndex = api.context[0]._iDisplayStart;//gets rows displayed startIndex
            api.column(0, {page: 'current'}).nodes().each(function (cell, i) {
                cell.innerHTML = startIndex + i + 1;
            });
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
            var total = api
                .column(3, { page: 'current'} )
                .data()
                .reduce(function (a, b) {
                    return parseInt(a) + parseInt(b);
                }, 0);
            $(api.column(3).footer()).html(total+"%");
        }
    });

    $('#divisiFilter').on('change', function () {
        if (this.value == "") {
            $('#totalPersen').addClass('hide-footer');
        } else {
            $('#totalPersen').removeClass('hide-footer');
        }

        table.column(2) // change this to the index of the 'Divisi' column
            .search(this.value)
            .draw();

        // show totalPersen

    });

    $('#createForm').submit(function(e){
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


    $('#editForm').submit(function(e){
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
