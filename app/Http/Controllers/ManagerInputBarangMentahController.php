<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\BarangMentah;

class ManagerInputBarangMentahController extends Controller
{
    public function index()
    {
        return view('user.manager.input_barang_mentah');
    }

    public function action(Request $request)
    {
        if(!$request->has('action')) return abort(404);
        
        switch($request->input('action'))
        {
            case 'search':
                $request->validate(['search' => 'required|min:3']);
                $search = $request->input('search');
                $barang = Barang::where('nama', 'LIKE', "%$search%")->get();
                return response()->json(['status' => 'success', 'result' => $barang]);
                break;
            
            case 'riwayat':
                $barang = BarangMentah::with('barang')
                    ->where('user_id', Auth()->user()->id)->get();

                return response()->json(['status' => 'success', 'result' => $barang]);
                break;
            
            case 'addnew':
                $request->validate([
                    'barang' => 'required|integer',
                    'stok' =>   'required|integer'
                ]);
                
                $barang = Barang::findOrFail($request->input('barang'));

                $barang = BarangMentah::create([
                    'barang_id' => $request->input('barang'),
                    'user_id' => Auth()->user()->id,
                    'stok' => $request->input('stok'),
                    'total' => $request->input('harga'),
                ]);

                
                
                $user = \App\User::with('roles')->whereHas('roles', function($q){
                    return $q->whereIn('name', ['admin', 'pengepak']);
                });        
                
                $alluser = $user->get();

                foreach($alluser as $user)
                {
                    notification()->stack(
                        'Konfirmasi Barang Mentah', 
                        'Beberapa Barang Mentah Telah Ditambahkan',
                        $user->id, 
                        url('user/manager/barang-mentah'),
                        'info'
                    );
                }

                

                return response()->json(['status' => 'success', 'result' => $barang->id]);
                break;
        }
    }
}
