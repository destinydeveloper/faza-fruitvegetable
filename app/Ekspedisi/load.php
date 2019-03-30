<?php
$allEkspedisi = [
    'jne' => '\App\Ekspedisi\Jne',
    'tiki' => '\App\Ekspedisi\Tiki',
    'pos' => '\App\Ekspedisi\Pos'
];

/*
 *
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *
 */
$GLOBALS['allEkspedisi'] = $allEkspedisi;
function Ekspedisi()
{
    $tes = '';
    return app(\App\Ekspedisi\Ekspedisi::class, ['allEkspedisi' => $GLOBALS['allEkspedisi']]);
}
