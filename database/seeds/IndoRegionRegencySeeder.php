<?php

use Illuminate\Database\Seeder;
use App\Helpers\RawDataGetter;

class IndoRegionRegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
     * 
     * @return void
     */
    public function run()
    {
        echo "[+] Importing Regency - Wilayah Indonesia [MFD & MBS Badan Pusat Statistik] \n";
        $regencies = RawDataGetter::get('regencies');
        DB::table('indoregion_regencies')->insert($regencies);
    }
}
