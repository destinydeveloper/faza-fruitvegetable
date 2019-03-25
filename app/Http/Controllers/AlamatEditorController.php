<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Alamat;
use App\User;

class AlamatEditorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) return response()->json([
            'status' => 'success',
            'result' => Auth()->user()->alamat
        ], 200);
        return view('user.alamat');
    }

    public function action(Request $request)
    {
        $request->validate(['action' => 'required']);

        switch($request->input('action'))
        {
            case 'getprovinces':
                return response()->json([
                    'status' => 'success',
                    'result' => Province::all()
                ], 200);
                break;

            case 'getregencies':
                $request->validate(['id' => 'required|integer']);
                $regency = Regency::whereProvinceId($request->input('id'))->get();
                return response()->json([
                    'status' => 'success',
                    'result' => $regency
                ], 200);
                break;

            case 'getdistrict':
                $request->validate(['id' => 'required|integer']);
                $district = District::whereRegencyId($request->input('id'))->get();
                return response()->json([
                    'status' => 'success',
                    'result' => $district
                ], 200);
                break;


            case 'getvillage':
                $request->validate(['id' => 'required|integer']);
                $Village = Village::whereDistrictId($request->input('id'))->get();
                return response()->json([
                    'status' => 'success',
                    'result' => $Village
                ], 200);
                break;
            
            case 'delete':
                $request->validate(['id' => 'required|integer']);
                $alamat = Alamat::findOrFail($request->input('id'))->delete();
                return response()->json([
                    'status' => 'success',
                    'result' => $alamat
                ], 200);
                break;

            case 'addnew':
                $request->validate([
                    'penerima' => 'required|min:5',
                    'no_telp' => 'required|min:10',
                    'village' => 'required|integer',
                    'kodepos' => 'required|integer',
                    'alamat_lengkap' => 'required|min:5',
                ]);
                
                $village = Village::findOrFail($request->input('village'));
                $district   = $village->district->name;
                $regency    = $village->district->regency->name;
                $province   = $village->district->regency->province->name;

                $alamat = Alamat::create([
                    'user_id' => Auth()->user()->id,
                    'alamat' => "$province, $regency, $district, $village->name",
                    'penerima' => $request->input('penerima'),
                    'no_telp' => $request->input('no_telp'),
                    'kodepos' => $request->input('kodepos'),
                    'alamat_lengkap' => $request->input('alamat_lengkap'),
                ]);

                return response()->json([
                    'status' => 'success',
                    'result' => $alamat->id
                ], 200);
                break;
                
        }
    }
}
