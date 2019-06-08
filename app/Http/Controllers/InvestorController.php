<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\TransaksiChart;
use App\Models\Barang;
use App\Models\Investasi;
use App\Helpers\Investor;

use DB;

class InvestorController extends Controller
{
    /**
     * Untuk halaman ringkasan user/investor/ringkasan
     *
     * @return void
     */
    public function dashboard() {
        // $status = 0;
        // try {
            // Jml Sayur buah
            $jml_buah_sayur = count(Barang::all());

            // Total investasi
            $total_investasi = Investor::totalInvestasi();

            // Keuntungan kotor bulan ini
            $getKeuntunganKotor = Investor::keuntunganBulan(date('m'), date('Y'))->pluck('nominal')[0];

            /**
             * Pengeluaran bulan ini
             */

            // Pengeluaran transaksi_masuk per bulan
            $pengeluaran_transaksi = Investor::pengeluaranBulanTransaksi(date('m'), date('Y'))->pluck('nominal')[0];

            // Pengeluaran operasional per bulan
            $pengeluaran_operasional = Investor::pengeluaranBulanOperasional(date('m'), date('Y'))->pluck('nominal')[0];

            // Keuntungan bersih per bulan
            $keuntunganBersih = Investor::keuntunganBersihBulan($getKeuntunganKotor, $pengeluaran_transaksi, $pengeluaran_operasional) ;

            /**
             * Chart
             */

            //  Chart Pemasukan
            $pemasukan = Investor::keuntunganKotor();

            // Mengambil data dari query pemasukan
            $ambilBulan = $pemasukan->pluck('month');
            $ambilTahun = $pemasukan->pluck('year');

            $inputArr = [];
            $fixBulan = '';
            $fixTahun = $ambilTahun;
            $index = 0;
            foreach ($ambilBulan as $dataBulan) {

                $fixBulan = convertBulan($dataBulan);

                array_push($inputArr, $fixBulan.' '.$fixTahun[$index]);
                $index++;
            }


            // Chart Pengeluaran (Transaksi Masuk)
            $ambilPengeluaranTransaksi = Investor::pengeluaran('transaksi_masuk');

            // Chart Pengeluaran (Biaya Operasional)
            $ambilPengeluaranOperasional = Investor::pengeluaran('biaya_operasional');

            $transaksi_masuk = $ambilPengeluaranTransaksi->pluck('nominal');
            $biaya_operasional = $ambilPengeluaranOperasional->pluck('nominal');

            // Variabel yang dimasukna ke chart pengeluaran
            $pengeluaran = Investor::totalPengeluaran();

            $chart = new TransaksiChart;
            $chart->loaderColor("#fffff");
            $chart->title('Grafik Pemasukan dan Pengeluaran', 25, '', 'bold');
            $chart->barWidth(0.8);
            $chart->labels($inputArr)
                ->formatDatasets();
            $chart->dataset('Pemasukan', 'bar', collect($pemasukan->pluck('nominal')))
                ->backgroundColor("#1e90ff");
            $chart->dataset('Pengeluaran', 'bar', collect($pengeluaran))
                ->backgroundColor("#b22222");

            /**
             * Chart
            */
            return view('user.manager.investor.dashboard', compact('chart', 'jml_buah_sayur', 'total_investasi', 'keuntunganBersih'));
    }

    /**
     * Untuk halaman ringkasan user/investor/transaksi_investor
     *
     * @return void
     */
    public function transaksi_investor() {
        $investasi = DB::table('investasi')->orderBy('created_at', 'asc')->get();
        return view('user.manager.investor.transaksi_investor', compact('investasi'));
    }

    public function input_transaksi() {
        return view('user.manager.investor.input_investasi');
    }

    public function input_save(Request $request) {
        try {
            $request->validate([
                'nominal' => 'required|max:11'
            ]);

            Investasi::create([
                'user_id' => Auth()->user()->id,
                'nominal' => $request->nominal,
            ]);

            return redirect()->route('user.investor.transaksi_investor')
                             ->with(['success' => 'Investasi berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Untuk halaman ringkasan user/investor/transaksi
     *
     * @return void
     */
    public function keuangan(Request $request) {
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');

        $keuntunganKotor = 0;
        $keuntunganKotorBulan = 0;
        $convertBulan = [];
        $pengeluaran = 0;
        $cek = '';
        $laba = 0;

        try {
            if ($bulan == '' || $tahun == '') {
                $cek = 'kosong';
                $keuntunganKotor = Investor::keuntunganKotor();
                // dd($keuntunganKotor);
                foreach ($keuntunganKotor as $data) {
                    array_push($convertBulan, convertBulan($data->month).' '.$data->year);
                }

                $pengeluaran = Investor::totalPengeluaran();
                $laba = Investor::keuntunganBersih($keuntunganKotor);
            } else {
                $cek = 'terisi';
                $keuntunganKotorBulan = Investor::keuntunganBulan($bulan, $tahun);
                array_push($convertBulan, convertBulan($keuntunganKotorBulan->pluck('month')[0]).' '.$keuntunganKotorBulan->pluck('year')[0]);

                $transaksi_masuk = Investor::pengeluaranBulanTransaksi($bulan, $tahun)->pluck('nominal')[0];
                $operasional = Investor::pengeluaranBulanOperasional($bulan, $tahun)->pluck('nominal')[0];
                // total pengeluaran
                $pengeluaran = Investor::totalPengeluaranBulan($transaksi_masuk, $operasional);

                $laba = Investor::keuntunganBersihBulan($keuntunganKotorBulan->pluck('nominal')[0], $transaksi_masuk, $operasional);
            }
            // dd($cek, $convertBulan, $keuntunganKotorBulan, $pengeluaran, $laba);

            return view('user.manager.investor.keuangan', compact('cek' ,'keuntunganKotor', 'keuntunganKotorBulan', 'convertBulan', 'pengeluaran', 'laba'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => $e->getMessage()]);
        }
    }


}
