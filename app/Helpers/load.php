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