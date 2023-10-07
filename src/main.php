<?php

$results = [];
$response = 'We are waiting for your throw.';

$glassWithBones = [
    1 => '1.jpg',
    2 => '2.jpg',
    3 => '3.jpg',
    4 => '4.jpg',
    5 => '5.jpg',
    6 => '6.jpg',
];

function throwing():array
{
    $results = [];
    for($i = 1; $i < 6; $i++) {
        $results[] = mt_rand(1, 6);
    }
    shuffle($results);
    return $results;
}

function checkCombinations(array $results):array
{
    $resp = [
        'pair' => 0,
        'two_pairs' => 0,
        'triple' => 0,
        'smallStreet' => 0,
        'bigStreet' => 0,
        'fullHouse' => 0,
        'square' => 0,
        'poker' => 0,
        'chance' => 0
    ];
    
    $str = implode('', $results);
    if(preg_match('/12456/', $str)) {
        $resp['chance'] = 1;
    }
    for($i = 0; $i < count($results); $i++) {
        if(isset($results[$i+1]) && $results[$i] === $results[$i+1]) {
            if(isset($results[$i+2]) && $results[$i+1] === $results[$i+2]) {
                if(isset($results[$i+3]) && $results[$i+2] === $results[$i+3]) {
                    if(isset($results[$i+4]) && $results[$i+3] === $results[$i+4]) {
                        $resp['poker'] = 1;
                    } else {
                        $resp['square'] = 1;
                    }
                } else {
                    $resp['triple'] = 1;
                }
            } else {
                if($resp['pair'] === 1) {
                    $resp['two_pairs'] = 1;
                } else {
                    $resp['pair'] = 1;
                }
            }
        }
    }
    if($resp['two_pairs']) {
        $resp['pair'] = 0;
    } elseif($resp['triple']) {
        $resp['two_pairs'] = 0;
        $resp['pair'] = 0;
    } elseif ($resp['square']) {
        $resp['triple'] = 0;
        $resp['two_pairs'] = 0;
        $resp['pair'] = 0;
    } elseif ($resp['poker']) {
        $resp['square'] = 0;
        $resp['triple'] = 0;
        $resp['two_pairs'] = 0;
        $resp['pair'] = 0;
    }
    return $resp;
}

function createResponse(array $check):string
{
    $respStr = '';
    foreach($check as $key => $value) {
        if($value) {
            $respStr .= 'You have ' . $key;
        }
    }
    if(empty($respStr)) {
        $respStr = 'No winning combinations.';
    }
    return $respStr;
}

if(isset($_POST['btn'])) {
    $results = throwing();
    $check = checkCombinations($results);
    $response = createResponse($check);
}
