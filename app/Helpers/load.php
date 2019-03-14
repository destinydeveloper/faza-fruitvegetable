<?php
require __DIR__ . "/Account.php";
require __DIR__ . "/Images.php";


if (! function_exists('account')) {
    function account()
    {
        return app(\App\helpers\Account::class);
    }
}
if (! function_exists('images')) {
    function images()
    {
        return app(\App\helpers\Images::class);
    }
}