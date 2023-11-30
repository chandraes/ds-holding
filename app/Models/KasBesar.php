<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasBesar extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getIdTanggalAttribute()
    {
        return date('d-m-Y', strtotime($this->tanggal));
    }

    public function lastKasBesar()
    {
        return $this->latest()->orderBy('id', 'desc')->first();
    }

    public function getNfNominalTransaksiAttribute()
    {
        return number_format($this->nominal_transaksi, 0, ',', '.');
    }

    public function getNfModalInvestorAttribute()
    {
        return number_format($this->modal_investor, 0, ',', '.');
    }

    public function getNfSaldoAttribute()
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    public function getNominalTransaksiMasukAttribute()
    {
        if ($this->jenis == 1) {
            return number_format($this->nominal_transaksi, 0, ',', '.');
        }
    }

    public function getNominalTransaksiKeluarAttribute()
    {
        if ($this->jenis == 0) {
            return number_format($this->nominal_transaksi, 0, ',', '.');
        }
    }

    public function generateNomorKasKecil()
    {
        return $this->max('nomor_kas_kecil') + 1;
    }

    public function nomorDeposit()
    {
        return $this->max('nomor_deposit') + 1;
    }

    public function getFormatNomorDepositAttribute()
    {

        return $this->nomor_deposit != null ? "D".sprintf("%02d", $this->nomor_deposit) : '';
    }

    public function getFormatNomorKasKecilAttribute()
    {

        return $this->nomor_kas_kecil != null ? "KK".sprintf("%02d", $this->nomor_kas_kecil) : '';
    }

    public function dataTahun()
    {
        return $this->selectRaw('YEAR(tanggal) as tahun')->groupBy('tahun')->get();
    }

    public function kasBesarNow($bulan, $tahun)
    {
        return $this->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
    }

    public function lastKasBesarByMonth($month, $year)
    {
        return $this->whereMonth('tanggal', $month)->whereYear('tanggal', $year)->latest()->orderBy('id', 'desc')->first();
    }

    public function insertMasuk($data)
    {
        $data['nominal_transaksi'] = str_replace('.', '', $data['nominal_transaksi']);
        $data['tanggal'] = now();
        $data['jenis'] = 1;
        $saldo = $this->lastKasBesar()->saldo ?? 0;
        $data['saldo'] = $saldo + $data['nominal_transaksi'];

        $store = $this->create($data);

        return $store;

    }

    public function insertKasKecil()
    {
        $rekening = Rekening::where('untuk', 'kas-kecil')->first();

        $data['nominal_transaksi'] = 1000000;
        $nomor = $this->generateNomorKasKecil();
        $data['nomor_kas_kecil'] = $nomor;
        $data['tanggal'] = now();
        $data['jenis'] = 0;
        $data['saldo'] = $this->lastKasBesar()->saldo - $data['nominal_transaksi'];
        $data['nama_rek'] = $rekening->nama_rek;
        $data['bank'] = $rekening->bank;
        $data['no_rek'] = $rekening->no_rek;

        $store = $this->create($data);

        return $store;
    }

    // hapus ini nanti
    public function insertSaldoTemp()
    {
        $data['nominal_transaksi'] = 100000000;
        $data['tanggal'] = now();
        $data['jenis'] = 1;
        $saldo = $this->lastKasBesar()->saldo ?? 0;
        $data['saldo'] = $saldo + $data['nominal_transaksi'];
        $data['uraian'] = 'Coba masuk Saldo';
        $data['nama_rek'] = 'Kas Besar';

        $store = $this->create($data);

        return $store;
    }

    public function insertDeposit($data)
    {
        $rekening = Rekening::where('untuk', 'kas-besar')->first();

        $data['tanggal'] = now();
        $data['jenis'] = 1;
        $data['nominal_transaksi'] = str_replace('.', '', $data['nominal_transaksi']);
        $data['modal_investor'] = -$data['nominal_transaksi'];
        $data['no_rek'] = $rekening->no_rek;
        $data['nama_rek'] = $rekening->nama_rek;
        $data['bank'] = $rekening->bank;
        $data['nomor_deposit'] = $this->nomorDeposit();
        $lastKasBesar = $this->lastKasBesar();

        if ($lastKasBesar) {
            $data['saldo'] = $lastKasBesar->saldo + $data['nominal_transaksi'];
            $data['modal_investor_terakhir'] = $lastKasBesar->modal_investor_terakhir - $data['nominal_transaksi'];
        } else {
            $data['saldo'] = $data['nominal_transaksi'];
            $data['modal_investor_terakhir'] = $data['modal_investor'];
        }

        $store = $this->create($data);

        return $store;
    }

    public function insertWithdraw($data)
    {
        $rekening = Rekening::where('untuk', 'withdraw')->first();

        $data['uraian'] = 'Withdraw';
        $data['nominal_transaksi'] = str_replace('.', '', $data['nominal_transaksi']);
        $data['jenis'] = 0;
        $data['tanggal'] = now();
        $data['nama_rek'] = substr($rekening->nama_rek, 0, 15);
        $data['no_rek'] = $rekening->no_rek;
        $data['bank'] = $rekening->bank;
        $last = $this->lastKasBesar();
        $data['saldo'] = $last->saldo - $data['nominal_transaksi'];
        $data['modal_investor'] = $data['nominal_transaksi'];
        $data['modal_investor_terakhir']= $last->modal_investor_terakhir + $data['nominal_transaksi'];

        $store = $this->create($data);

        return $store;
    }
}
