<?php

namespace App\Ekspedisi;

use Exception;

class Ekspedisi {
    protected $namespace = 'App\\Ekspedisi\\';
    protected $allEkspedisi = [];

    public function __construct($allEkspedisi)
    {
        $this->allEkspedisi = $allEkspedisi;
    }

    public function name($name)
    {
        $ekspedisi = $this->allEkspedisi;
        if (!isset($ekspedisi[$name])) return $this->errors('classNotFound', $name);
        
        $ekspedisi = $ekspedisi[$name];
        $ekspedisi = app($ekspedisi);

        return $ekspedisi;
    }

    public function get()
    {
        $ekspedisi = $this->allEkspedisi;
        $result = [];
        foreach($ekspedisi as $item_k => $item)
        {
            $result[$item_k] = $this->name($item_k)->info();
            $result[$item_k]['code'] = $item_k;
        }
        return (object) json_decode(json_encode($result));
    }


    public function errors(...$arr){
        $err = $arr[0];
        $message = '';
        switch($err)
        {
            case 'classNotFound':
                $message = "ClassNotFound : $arr[1]";
                break;
            
            default:
                break;
        }
        
        /*
         *
         * 
         * 
         * 
         * 
         * 
         */

        throw new Exception("[Ekspedisi Plugin] " . $message);
    }
}