<?php
// require __DIR__ . "/Account.php";
// require __DIR__ . "/Images.php";


if (! function_exists('account')) {
    function account()
    {
        return app(\App\Helpers\Account::class);
    }
}
if (! function_exists('images')) {
    function images()
    {
        return app(\App\Helpers\Images::class);
    }
}
if (! function_exists('notification')) {
    function notification()
    {
        return app(\App\Helpers\Notification::class);
    }
}
if (! function_exists('keranjang')) {
    function keranjang()
    {
        return app(\App\Helpers\Keranjang::class);
    }
}
if (! function_exists('transaksi')) {
    function transaksi()
    {
        return app(\App\Helpers\Transaksi::class);
    }
}

/**
 * Investor
 */

if (! function_exists('toRupiah')) {
    function toRupiah($value)
    {
    return 'Rp. '. number_format($value);
    }
}

if (! function_exists('numberPagination')) {
    function numberPagination($pagination){
        $number = 1;

        if (request()->has('page') && request()->get('page') > 1) {
        $number += (request()->get('page') - 1) * $pagination;
        }

        return $number;
    }
}


if (!function_exists('convertBulan')) {
        function convertBulan($nomorBulan) {
            if ($nomorBulan == 1) {
                return 'Januari';
            } else if ($nomorBulan == 2) {
                return 'Pebruari';
            } else if ($nomorBulan == 3) {
                return 'Maret';
            } else if ($nomorBulan == 4) {
                return 'April';
            } else if ($nomorBulan == 5) {
                return 'Mei';
            } else if ($nomorBulan == 6) {
                return 'Juni';
            } else if ($nomorBulan == 7) {
                return 'Juli';
            } else if ($nomorBulan == 8) {
                return 'Agustus';
            } else if ($nomorBulan == 9) {
                return 'September';
            } else if ($nomorBulan == 10) {
                return 'Oktober';
            } else if ($nomorBulan == 11) {
                return 'Nopember';
            } else if ($nomorBulan == 12) {
                return 'Desember';
            }
        }
}
