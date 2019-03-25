<?php

use Illuminate\Database\Seeder;
use App\Helpers\RawDataGetter;

class IndoRegionDistrictSeeder extends Seeder
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
        echo "[+] Importing District - Wilayah Indonesia [MFD & MBS Badan Pusat Statistik] \n";
        $districts = RawDataGetter::get('districts');
        DB::table('indoregion_districts')->insert($districts);
    }
}
