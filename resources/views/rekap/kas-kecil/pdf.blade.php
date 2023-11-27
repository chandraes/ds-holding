@extends('layouts.doc-nologo-1')
@section('content')
<div class="container-fluid">
    <center>
        <h2>REKAP KAS KECIL</h2>
        <h2>{{$stringBulanNow}} {{$tahun}}</h2>
    </center>
</div>
<div class="container-fluid table-responsive ml-3 text-pdf">
    <div class="row mt-3">
        <table class="table table-hover table-bordered table-pdf text-pdf" id="rekapTable">
            <thead class=" table-success">
            <tr>
                <th class="text-center align-middle table-pdf text-pdf">Tanggal</th>
                <th class="text-center align-middle table-pdf text-pdf">Nota</th>
                <th class="text-center align-middle table-pdf text-pdf">Uraian</th>
                <th class="text-center align-middle table-pdf text-pdf">Masuk</th>
                <th class="text-center align-middle table-pdf text-pdf">Keluar</th>
                <th class="text-center align-middle table-pdf text-pdf">Saldo</th>
                <th class="text-center align-middle table-pdf text-pdf">Cash/Transfer</th>
                <th class="text-center align-middle table-pdf text-pdf">Bank</th>
            </tr>
            <tr class="table-warning">
                <td class="text-center align-middle table-pdf text-pdf" colspan="3">Saldo Bulan
                    {{$stringBulan}} {{$tahunSebelumnya}}</td>
                <td class="text-center align-middle table-pdf text-pdf"></td>
                <td class="text-center align-middle table-pdf text-pdf"></td>
                <td class="text-center align-middle table-pdf text-pdf">Rp. {{$dataSebelumnya ? $dataSebelumnya->nf_saldo : ''}}</td>
                <td class="text-center align-middle table-pdf text-pdf"></td>
                <td class="text-center align-middle table-pdf text-pdf"></td>
            </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->id_tanggal}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->nota }}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->uraian}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->nominal_transaksi_masuk}}
                    </td>
                    <td class="text-center align-middle text-danger text-pdf table-pdf">{{$d->nominal_transaksi_keluar}}
                    </td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->nf_saldo}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->nama_rek}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->bank}}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="text-center align-middle table-pdf text-pdf" style="height: 13px"></td>
                    <td class="text-center align-middle table-pdf text-pdf"></td>
                    <td class="text-center align-middle table-pdf text-pdf"></td>
                    <td class="text-center align-middle table-pdf text-pdf"></td>
                    <td class="text-center align-middle table-pdf text-pdf"></td>
                    <td class="text-center align-middle table-pdf text-pdf"></td>
                    <td class="text-center align-middle table-pdf text-pdf"></td>
                    <td class="text-center align-middle table-pdf text-pdf"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-center align-middle table-pdf text-pdf"><strong>GRAND TOTAL</strong></th>
                    <th class="text-center align-middle table-pdf text-pdf"><strong>{{$totalMasuk}}</strong></th>
                    <th class="text-center align-middle text-danger text-pdf table-pdf"><strong>{{$totalKeluar}}</strong></th>
                    <th class="text-center align-middle table-pdf text-pdf">
                        <strong>
                            {{$data->last() ? $data->last()->nf_saldo : ''}}
                        </strong>
                    </th>
                    <th class="text-center align-middle table-pdf text-pdf"></th>
                    <th class="text-center align-middle table-pdf text-pdf"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
