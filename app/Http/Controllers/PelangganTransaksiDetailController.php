<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Images;

use App\Models\Transaksi;
use App\Models\TransaksiBatal;
use App\Models\Rekening;
use App\Models\TransaksiBukti;


class PelangganTransaksiDetailController extends Controller
{
    public function index(Request $request, $kode)
    {
        $transaksi = Transaksi::where('kode', $kode)->where('user_id', Auth()->user()->id)->first();
        // return $transaksi;
        if ($transaksi == null) return abort(404);
        $bank = Rekening::all();
        
        $result = \Carbon\Carbon::parse($transaksi->created_at);
        if ( $result->addDays(1)->isPast() ) {
            if ( $transaksi->batal == null) 
            {
                $delete = TransaksiBatal::create([
                    'transaksi_id' => $transaksi->id,
                    'catatan' => "waktu tunggu kadaluarsa"
                ]);

                return redirect()->to( url()->current() );
            } else { $waktu = [0,0,0]; }
        } else{
            $created = \Carbon\Carbon::parse($transaksi->created_at)->addDays(1);
            $akhir = $created->diff(\Carbon\Carbon::now())->format('%d:%h:%i:%s');
            $waktu = explode(':', $akhir);
        }

        return view('pelanggan.transaksi_detail', compact('transaksi', 'bank', 'waktu'));
    }

    public function action(Request $request, $kode)
    {
        $transaksi = Transaksi::where('kode', $kode)->where('user_id', Auth()->user()->id)->first();
        if ($transaksi == null) return abort(404);

        $gambar = Images::upload('image', null, null, '150x150');
        $delete = TransaksiBukti::where('transaksi_id', $transaksi->id)->delete();
        $bukti = TransaksiBukti::create([
            'transaksi_id' => $transaksi->id,
            'gambar_id' => $gambar->id
        ]);

        return redirect()->route('transaksi.detail', ['kode' => $kode]);
    }
}
