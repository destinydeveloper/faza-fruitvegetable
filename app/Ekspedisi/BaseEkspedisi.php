<?php

namespace App\Ekspedisi;

interface BaseEkspedisi {
    public function info();
    public function calculate($origin, $destination, $weight);
    public function trace($resi);
}