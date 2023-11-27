@extends('layouts.doc-nologo-1')
@section('content')
<div class="container-fluid">
    <center>
        <h2>REKAP KAS BESAR</h2>
        <h2>{{$stringBulanNow}} {{$tahun}}</h2>
    </center>
</div>
<div class="container-fluid table-responsive ml-3 text-pdf">
    <div class="row mt-3">
        <table class="table table-hover table-bordered text-pdf table-pdf" id="rekapTable">
            <thead class=" table-success">
            <tr>
                <th class="text-center align-middle table-pdf text-pdf">Tanggal</th>
                <th class="text-center align-middle table-pdf text-pdf">Uraian</th>
                <th class="text-center align-middle table-pdf text-pdf">Kas Kecil</th>
                <th class="text-center align-middle table-pdf text-pdf">Masuk</th>
                <th class="text-center align-middle table-pdf text-pdf">Keluar</th>
                <th class="text-center align-middle table-pdf text-pdf">Saldo</th>
                <th class="text-center align-middle table-pdf text-pdf">Transfer Ke</th>
                <th class="text-center align-middle table-pdf text-pdf">Bank</th>

            </tr>
            <tr class="table-warning">
                <td colspan="4" class="text-center align-middle table-pdf text-pdf">Saldo Bulan
                    {{$stringBulan}} {{$tahunSebelumnya}}</td>
                <td class="text-center align-middle table-pdf text-pdf"></td>
                <td class="text-center align-middle table-pdf text-pdf">Rp. {{$dataSebelumnya ? number_format($dataSebelumnya->saldo,
                    0, ',','.') : ''}}</td>
                <td class="text-center align-middle table-pdf text-pdf"></td>
                <td class="text-center align-middle table-pdf text-pdf"></td>
            </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td class="text-center align-middle table-pdf text-pdf">{{$d->id_tanggal}}</td>
                    <td class="text-center align-middle table-pdf text-pdf">
                        {{$d->uraian}}
                    </td>
                    <td class="text-center align-middle table-pdf text-pdf">
                        {{$d->format_nomor_kas_kecil}}
                    </td>
                    <td class="text-center align-middle table-pdf text-pdf">
                        {{$d->nominal_transaksi_masuk}}
                    </td>
                    <td class="text-center align-middle text-danger text-pdf table-pdf">
                        {{$d->nominal_transaksi_keluar}}
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
                    <th class="text-center align-middle table-pdf text-pdf" colspan="3"><strong>GRAND TOTAL</strong></th>
                    <th class="text-center align-middle table-pdf text-pdf"><strong>{{number_format($data->where('jenis',
                            1)->sum('nominal_transaksi'), 0, ',', '.')}}</strong></th>
                    <th class="text-center align-middle text-danger text-pdf table-pdf"><strong>{{number_format($data->where('jenis',
                            0)->sum('nominal_transaksi'), 0, ',', '.')}}</strong></th>
                    {{-- latest saldo --}}
                    <th class="text-center align-middle table-pdf text-pdf">
                        <strong>
                            {{$data->last() ? number_format($data->last()->saldo, 0, ',', '.') : ''}}
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
