<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\TransaksiChart;
use App\Models\Barang;
use App\Models\Investasi;
use DB;

class InvestorController extends Controller
{
    /**
     * Untuk halaman ringkasan user/investor/ringkasan
     *
     * @return void
     */
    public function dashboard() {
        // Jml Sayur buah
        $jml_buah_sayur = count(Barang::all());

        // Total investasi
        $total_investasi = DB::table('investasi')
                            ->having('status', '=', '1')
                            ->latest()->first();

        // Keuntungan Bulan Ini
        $keuntungan_bulan = DB::table('transaksi_bayar')
                            ->select(DB::raw('transaksi_bayar.created_at ,sum(transaksi_bayar.nominal) as nominal, YEAR(transaksi_bayar.created_at) year, MONTH(transaksi_bayar.created_at) month'))
                            ->groupBy('month', 'year')
                            ->having('month', '=', date('m'))
                            ->get();
        // dd();

        // Graph Pemasukan
        $pemasukan = DB::table('transaksi_bayar')
        ->select(DB::raw('transaksi_bayar.created_at ,sum(transaksi_bayar.nominal) as nominal, YEAR(transaksi_bayar.created_at) year, MONTH(transaksi_bayar.created_at) month'))
        ->groupBy('month', 'year')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();
        // dd($pemasukan);
        $ambilBulan = $pemasukan->pluck('month');
        $ambilTahun = $pemasukan->pluck('year');

        $inputArr = [];
        $fixBulan = '';
        $fixTahun = $ambilTahun;
        $index = 0;
        foreach ($ambilBulan as $dataBulan) {

            if ($dataBulan == 1) {
                $fixBulan = 'Januari';
            }else if ($dataBulan == 2) {
                $fixBulan = 'Pebruari';
            }else if ($dataBulan == 3) {
                $fixBulan = 'Maret';
            }else if ($dataBulan == 4) {
                $fixBulan = 'April';
            }else if ($dataBulan == 5) {
                $fixBulan = 'Mei';
            }else if ($dataBulan == 6) {
                $fixBulan = 'Juni';
            }else if ($dataBulan == 7) {
                $fixBulan = 'Juli';
            } else if ($dataBulan == 8) {
                $fixBulan = 'Agustus';
            }else if ($dataBulan == 9) {
                $fixBulan = 'September';
            }else if ($dataBulan == 10) {
                $fixBulan = 'Oktober';
            }else if ($dataBulan == 11) {
                $fixBulan = 'Nopember';
            }else if ($dataBulan == 12) {
                $fixBulan = 'Desember';
            }

            array_push($inputArr, $fixBulan.' '.$fixTahun[$index]);
            $index++;
        }

        $chart = new TransaksiChart;
        $chart->loaderColor("#fffff");
        $chart->title('Grafik Pemasukan dan Pengeluaran', 25, '', 'bold');
        $chart->barWidth(0.8);
        $chart->labels($inputArr)->formatDatasets();
        $chart->dataset('Pemasukan', 'bar', collect($pemasukan->pluck('nominal')))
              ->backgroundColor("#1e90ff");
        // $chart->dataset('Pengeluaran', 'bar', [20000, 50000, 60000, 20000])->backgroundColor("#b22222");
        // Graph

        return view('user.manager.investor.dashboard', compact('chart', 'jml_buah_sayur', 'total_investasi', 'keuntungan_bulan'));
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
    public function keuangan() {
        return view('user.manager.investor.keuangan');
    }


}
// $tahun = 2019;

        // $rugi = DB::table('transaksi_bayar')
        // ->select('transaksi_bayar.created_at', DB::raw('sum(transaksi_bayar.nominal) as nominal, YEAR(transaksi_bayar.created_at) year, MONTH(transaksi_bayar.created_at) month'))
        // ->orderBy('nominal', 'asc')
        // ->groupBy('month', 'year')
        // ->get();

        // $arr = [];

        // for ($i = 0; $i < count($rugi); $i++) {
        //     array_push($arr, $rugi[$i]);
        // }

        // $fixBulan = collect($arr)->map(function ($item, $key) {
        //     return $item;
        // });

        // $transaksi = TransaksiBayar::where(DB::raw(
        //     "(DATE_FORMAT(created_at,'%Y'))"), date('Y'))->get();


         // $rugi = TransaksiBayar::where()
        // dd($rugi->pluck('nominal'));
        // $chart = Charts::multiDatabase('bar', 'highcharts')
		// 	      ->title("Monthly new Register Users")
        //           ->elementLabel("Total Users")
        //           ->colors(['#ff0000', '#fdgdfg'])
		// 	      ->dimensions(1000, 500)
        //           ->responsive(true)
        //         //   ->dataset('untung', collect($arr))
        //           ->dataset('rugi', $rugi->pluck('nominal'));
