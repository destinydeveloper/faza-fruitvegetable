<?php

use Illuminate\Database\Seeder;
use App\Helpers\RawDataGetter;

class IndoRegionProvinceSeeder extends Seeder
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
        echo "[+] Importing Province - Wilayah Indonesia [MFD & MBS Badan Pusat Statistik] \n";
        $provinces = RawDataGetter::get('provinces');
        DB::table('indoregion_provinces')->insert($provinces);
    }
}
