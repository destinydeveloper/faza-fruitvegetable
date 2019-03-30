<?php

namespace App\Ekspedisi;

class Tiki implements BaseEkspedisi{
    /**
     * Key
     * Auth for RajaOngkir
     * @var string
     */
    protected $key = "2084349279dee9ad269308f9c1370717";

    
    /**
     * Information
     * Information Plugin
     * @return  array
     */
    public function info()
    {
        return [
            "name" => "TIKI",
            "version" => "1.0",
            "author" => "viandwi24",
            "description" => "Plugin TIKI untuk Cek Ongkir dan Resi."
        ];
    }

    /**
     * Calculate
     * Cek Ongkir - Dari ke Tujuan
     * @param   origin string,
     * @param   destination string,
     * @param   weight integer,
     * @return  obj
     */
    public function calculate($origin, $destination, $weight)
    {
        // get tipe kabupaten or kota
        $forceKabOrigin = false;
        $forceKabDestination = false;
        if (preg_match('/\KABUPATEN\b/', $origin)) {$forceKabOrigin = true; }
        if (preg_match('/\KABUPATEN\b/', $destination)) {$forceKabDestination = true; }

        $origin = str_replace('KABUPATEN ', '', $origin);
        $origin = str_replace('KOTA ', '', $origin);
        $destination = str_replace('KABUPATEN ', '', $destination);
        $destination = str_replace('KOTA ', '', $destination);

        // get semua kota
        $destination = ucfirst(strtolower($destination));
        $origin = ucfirst(strtolower($origin));
        $kota = $this->cURL("https://api.rajaongkir.com/starter/city");  


        // CARI KOTA DESTINASI      
        $kota_result = array_search($destination, array_column( (array) $kota , 'city_name'));
        $result = $kota[$kota_result];
        $destination_data = $result;
        if ($result['type'] == 'Kabupaten' && $forceKabDestination == false) 
        {
            if (isset($kota[$kota_result+1]))
            {
                $nd = $kota[$kota_result+1];
                if ($nd['type'] == 'Kota' && $nd['city_name'] == $destination)
                {
                    $destination_data = $nd;
                }
            }
        }


        // CARI KOTA ORIGIN   
        $kota_result = array_search($origin, array_column( (array) $kota , 'city_name'));
        $result = $kota[$kota_result];
        $origin_data = $result;
        if ($result['type'] == 'Kabupaten' && $forceKabOrigin == false) 
        {
            if (isset($kota[$kota_result+1]))
            {
                $nd = $kota[$kota_result+1];
                if ($nd['type'] == 'Kota' && $nd['city_name'] == $origin)
                {
                    $origin_data = $nd;
                }
            }
        }


        // HITUNG ONGKIR
        $origin_id = $origin_data['city_id'];
        $destination_id = $destination_data['city_id'];
        $option = [
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin_id&destination=$destination_id&weight=$weight&courier=tiki",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
            )
        ];

        $ongkir = $this->cURL("https://api.rajaongkir.com/starter/cost", $option)[0];
        
        dd([
            'ongkir' => $ongkir,
            'origin' => $origin_data,
            'destination' => $destination_data,
        ]);
    }


    /**
     * Trace & Track
     * Cek Resi - Lacak Barang
     * @param   resi string,
     * @return  obj
     */
    public function trace($resi)
    {

    }

    public function cURL($url, $newOption = [])
    {
        $curl = curl_init();
        $option = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: ".$this->key
            )
        );

        foreach($newOption as $i_k => $i)
        {
            if (isset($option[$i_k]) && \is_array($option[$i_k])) {
                array_push($option[$i_k], $i[0]);
            } else {
                $option[$i_k] = $i;
            }
        }

        // dd($option);

        curl_setopt_array($curl, $option);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $data = json_decode($response)->rajaongkir;
        if ($err) {
            throw new \Exception ("cURL Error #:" . $err);
        } else {
            $code = $data->status->code;
            $description = $data->status->description;
            if($code == 400){
                abort(404, $description);
            } else if($code == 200){
                return json_decode(json_encode($data->results), true);
            } else {
                abort($code);
            }
        }
    }
}