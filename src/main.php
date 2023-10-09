<?php

$results = [];
$response = 'We are waiting for your throw.';
$newResults = [];

/**
 * Puts random dice results into an array and shuffles it.
 * @return array
 */
function throwing():array
{
    $results = [];
    for($i = 1; $i < 6; $i++) {
        $results[] = mt_rand(1, 6);
    }
    shuffle($results);
    return $results;
}

/**
 * Checks the throw results for consistency.
 * @param array $results
 * @return array
 */
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
    } elseif (preg_match('/12345/', $str) || preg_match('/23456/', $str)) {
        $resp['bigStreet'] = 1;    
    } elseif (preg_match('/1234/', $str) || preg_match('/2345/', $str) || preg_match('/3456/', $str)) {
        $resp['smallStreet'] = 1;
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
    return $resp;
}

/**
 * Resets overlapping results.
 * @param array $finalArray
 * @return array
 */
function analysisFinalArray(array $finalArray):array
{
    if($finalArray['two_pairs'] && $finalArray['triple']) {
        $finalArray['pair'] = 0;
        $finalArray['two_pairs'] = 0;
        $finalArray['triple'] = 0;
        $finalArray['fullHouse'] = 1;
    } elseif ($finalArray['two_pairs'] && !$finalArray['triple']) {
        $finalArray['pair'] = 0;
    } elseif($finalArray['triple'] && !$finalArray['square']) {
        $finalArray['two_pairs'] = 0;
        $finalArray['pair'] = 0;
    } elseif ($finalArray['square'] && !$finalArray['poker']) {
        $finalArray['triple'] = 0;
        $finalArray['two_pairs'] = 0;
        $finalArray['pair'] = 0;
    } elseif ($finalArray['poker']) {
        $finalArray['square'] = 0;
        $finalArray['triple'] = 0;
        $finalArray['two_pairs'] = 0;
        $finalArray['pair'] = 0;
    }
    return $finalArray;
}

/**
 * Creates a new roll result taking into account the results of the first throw selected for saving.
 * @param array $checkedBones
 * @param array $oldResults
 * @return array
 */
function secondThrowing(array $oldResults, array $checkedBones):array
{
    $secondResults = [];
    if(count($checkedBones) > 0) {
        $countChecked = count($checkedBones);
        if($countChecked > 0) {
            $intermediateResults = [];
            foreach($checkedBones as $bone) {
                $intermediateResults[$bone] = $oldResults[$bone];
            }
            for($i = 0; $i < 5; $i++) {
                $secondResults[$i] = isset($intermediateResults[$i]) ? $intermediateResults[$i] : mt_rand(1, 6);
            }
        }
    } else {
        $secondResults = throwing();
    }
    return $secondResults;
}

/**
 * Creates a response based on an array of results.
 * @param array $check
 * @return string
 */
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
}

if(isset($_POST['btnSecond'])) {
    $results = $_POST['oldResults'];
    $checkedBones = isset($_POST['checkedBones']) ? $_POST['checkedBones'] : [];
    $newResults = secondThrowing($results, $checkedBones);
    $comparisonResults = checkCombinations($newResults);
    $resp = analysisFinalArray($comparisonResults);
    $response = createResponse($resp);
}
