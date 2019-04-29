<?php

namespace App\Helpers;
use DB;

Class Investor {

    // Pemasukan keseluruhan
    public static function keuntunganKotor() {
        $pemasukan = DB::table('transaksi_barang')
            ->select(DB::raw('transaksi_barang.created_at ,sum(transaksi_barang.harga) as nominal, YEAR(transaksi_barang.created_at) year, MONTH(transaksi_barang.created_at) month'))
            ->groupBy('month', 'year')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return $pemasukan;
    }

    // Pengeluaran keseluruhan Transaksi Masuk dan Biaya_operasional
    public static function pengeluaran($namaTabel) {
        $a = '';
        if ($namaTabel == 'biaya_operasional') {
            $a = 'biaya';
        } else {
            $a = 'harga';
        }

        $pengeluaran = DB::table($namaTabel)
            ->select(DB::raw(''.$namaTabel.'.created_at ,sum('.$namaTabel.'.'.$a.') as nominal, YEAR('.$namaTabel.'.created_at) year, MONTH('.$namaTabel.'.created_at) month'))
            ->groupBy('month', 'year')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return $pengeluaran;
    }

    // Menghitung total transaksi
    public static function totalPengeluaran() {
        $dataArr = 0;
        $pengeluaran = [];

        foreach (self::pengeluaran('transaksi_masuk')->pluck('nominal') as $i => $transaksi) {
            if (empty(self::pengeluaran('biaya_operasional')->pluck('nominal')[$i])) {
                $dataArr = 0;
            } else {
                $dataArr = self::pengeluaran('biaya_operasional')->pluck('nominal')[$i];
            }

            array_push($pengeluaran, $transaksi + $dataArr);

            $i++;
        }

        return $pengeluaran;
    }

    // Total Investasi terakhir
    public static function totalInvestasi() {
        $total_investasi = DB::table('investasi')
            ->having('status', '=', '1')
            ->latest()->first();

        return $total_investasi;
    }

    // keuntungan per bulan
    public static function keuntunganBulan($bulan, $tahun) {
        $keuntungan_bulan = DB::table('transaksi_barang')
            ->select(DB::raw('transaksi_barang.created_at ,sum(transaksi_barang.harga) as nominal, YEAR(transaksi_barang.created_at) year, MONTH(transaksi_barang.created_at) month'))
            ->groupBy('month', 'year')
            ->having('month', '=', $bulan)
            ->having('year', '=', $tahun)
            ->get();

        return $keuntungan_bulan;
    }

    // pengeluaran transaksi masuk per bulan
    public static function pengeluaranBulanTransaksi($bulan, $tahun) {
        $pengeluaran_bln = DB::table('transaksi_masuk')
            ->select(DB::raw('transaksi_masuk.created_at ,sum(transaksi_masuk.harga) as nominal, YEAR(transaksi_masuk.created_at) year, MONTH(transaksi_masuk.created_at) month'))
            ->groupBy('month', 'year')
            ->having('month', '=', $bulan)
            ->having('year', '=', $tahun)
            ->get();

        return $pengeluaran_bln;
    }

    // pengeluaran transaksi masuk per bulan
    public static function pengeluaranBulanOperasional($bulan, $tahun) {
        $pengeluaran_bln = DB::table('biaya_operasional')
            ->select(DB::raw('biaya_operasional.created_at ,sum(biaya_operasional.biaya) as nominal, YEAR(biaya_operasional.created_at) year, MONTH(biaya_operasional.created_at) month'))
            ->groupBy('month', 'year')
            ->having('month', '=', $bulan)
            ->having('year', '=', $tahun)
            ->get();

        return $pengeluaran_bln;
    }

    public static function totalPengeluaranBulan($transaksiMasuk, $operasional) {
        return $transaksiMasuk + $operasional;
    }

    // menghitung keuntungan bersih keseluruhan
    public static function keuntunganBersih($keuntunganKotor) {
        $keuntunganBersih = [];

        $tranMasuk = 0;
        $tranOperasional = 0;
        foreach ($keuntunganKotor->pluck('nominal') as $i => $keuntunganKotor) {
            if (empty(self::pengeluaran('transaksi_masuk')->pluck('nominal')[$i]) || empty(self::pengeluaran('biaya_operasional')->pluck('nominal')[$i])) {
                $tranMasuk = 0;
                $tranOperasional = 0;
            } else {
                $tranMasuk = self::pengeluaran('transaksi_masuk')->pluck('nominal')[$i];
                $tranOperasional = self::pengeluaran('biaya_operasional')->pluck('nominal')[$i];
            }
            $totalPengeluaran = $tranMasuk + $tranOperasional;
            $rumus = (($keuntunganKotor - $totalPengeluaran) * 40/100) - ((($keuntunganKotor - $totalPengeluaran) * 40/100) * (2.5/100)) ;

            array_push($keuntunganBersih, $rumus);

            $i++;
        }

        return $keuntunganBersih;
    }


    // Menghitung keuntungan bersih bulan tertentu
    public static function keuntunganBersihBulan($keuntunganKotor, $transaksiMasuk, $operasional) {
        /**
         * Rumus [ 40% = Bagi hasil ; 2,5% = Zakat  ]
         * Keuntungan_bersih = Keuntungan_kotor - Pengeluaran
         * keuntungan_real = (keuntungan_bersih * 40%) - (keuntungan_bersih * 2,5%)
         */

        $totalPengeluaranBulan = self::totalPengeluaranBulan($transaksiMasuk, $operasional);
        $keuntunganBersih =  (($keuntunganKotor - $totalPengeluaranBulan) * 40/100) - ((($keuntunganKotor - $totalPengeluaranBulan) * 40/100) * (2.5/100)) ;

        return $keuntunganBersih;
    }
}

