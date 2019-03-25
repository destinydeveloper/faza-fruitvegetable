<?php

use Illuminate\Database\Seeder;
use App\Helpers\RawDataGetter;
use App\Models\Village;

class IndoRegionVillageSeeder extends Seeder
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
        echo "[+] Importing Village - Wilayah Indonesia [MFD & MBS Badan Pusat Statistik] \n";
        $villages = RawDataGetter::get('villages');
        DB::transaction(function() use($villages) {
            $collection = collect($villages);
            $parts = $collection->chunk(1000);
            foreach ($parts as $subset) {
                DB::table('indoregion_villages')->insert($subset->toArray());
            }
        });
    }
}
