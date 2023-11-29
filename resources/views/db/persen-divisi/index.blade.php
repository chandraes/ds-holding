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
                    <td><a href="#" data-bs-toggle="modal" data-bs-target="#createInvestor"><img
                                src="{{asset('images/persen-divisi.svg')}}" width="30"> Tambah Persentase</a>

                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-3 mt-2">
                    <label for="divisiFilter" class="form-label">Filter by Divisi:</label>
                </div>
                <div class="col-md-9">

                <select id="divisiFilter" class="form-control">
                    <option value="">All</option>
                    @foreach ($divisi as $k)
                    <option value="{{$k->nama}}">{{$k->nama}}</option>
                    @endforeach
                </select>
                </div>
            </div>

        </div>
    </div>
</div>
@include('db.persen-divisi.create')
@include('db.persen-divisi.edit')
<div class="container mt-5 table-responsive">

    <table class="table table-bordered table-hover" id="data">
        <thead class="table-warning bg-gradient">
            <tr>
                <th class="text-center align-middle" style="width: 5%">NO</th>
                <th class="text-center align-middle">KOMISARIS</th>
                <th class="text-center align-middle">DIVISI</th>
                <th class="text-center align-middle">PERSENTASE</th>
                <th class="text-center align-middle">ACT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td class="text-center align-middle">{{$loop->iteration}}</td>
                <td class="text-center align-middle">{{$d->komisaris->nama}}</td>
                <td class="text-center align-middle">{{$d->divisi->nama}}</td>
                <td class="text-center align-middle">{{$d->persen}}%</td>
                <td class="text-center align-middle">
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal"
                            data-bs-target="#editInvestor" onclick="editInvestor({{$d}}, {{$d->id}})"><i
                                class="fa fa-edit"></i></button>
                        <form action="{{route('komisaris.delete', $d)}}" method="post" id="deleteForm-{{$d->id}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger m-2"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>

                </td>
            </tr>
            <script>
                $('#deleteForm-{{$d->id}}').submit(function(e){
                       e.preventDefault();
                       Swal.fire({
                           title: 'Apakah data yakin untuk menghapus data ini?',
                           icon: 'warning',
                           showCancelButton: true,
                           confirmButtonColor: '#3085d6',
                           cancelButtonColor: '#6c757d',
                           confirmButtonText: 'Ya, hapus!'
                           }).then((result) => {
                           if (result.isConfirmed) {
                            $('#spinner').show();
                               this.submit();
                           }
                       })
                   });
            </script>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@push('css')
<link href="{{asset('assets/css/dt.min.css')}}" rel="stylesheet">
@endpush
@push('js')

<script src="{{asset('assets/js/cleave.min.js')}}"></script>

<script src="{{asset('assets/js/dt5.min.js')}}"></script>
<script>
    function editInvestor(data, id) {
        document.getElementById('edit_komisaris_id').value = data.komisaris_id;
        document.getElementById('edit_divisi_id').value = data.divisi_id;
        document.getElementById('edit_persen').value = data.persen;
        // Populate other fields...
        document.getElementById('editForm').action = '/db/persen-divisi/' + id + '/update';
    }



    $('#divisiFilter').on('change', function () {
        table.column(2) // change this to the index of the 'Divisi' column
            .search(this.value)
            .draw();
    });

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
        }
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
