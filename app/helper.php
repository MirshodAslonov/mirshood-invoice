<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
function throwErrors($errors, $code = 400)
{
    if (DB::transactionLevel()) DB::rollBack();
    throw new HttpResponseException(errors($errors, $code));
}

/**
 * @param $message
 * @param int $code
 * @throws HttpResponseException
 */
function throwError($message)
{
    throwErrors(['success'=>false,'errors' => ['message' => $message]]);
}
function throwValidationError($data,$message="Error",int $code = 400)
{
    throwErrors(['message'=>$message,'errors' => $data], $code);
}

function failedValidation($validator)
{
    $errors = [];
    foreach ($validator->errors()->toArray() as $key => $value) {

        $errors[$key] = $value[0];
    }
    throwErrors(['message'=>"Error fields",'errors' => $errors]);
}

/* RESPONSE */

/**
 * Response JSON success
 */
function success($data = false): JsonResponse
{
    if ($data === false) $data = ['success' => true];
    return response()->json($data);
}
function success_list($data=false): JsonResponse
{
    if ($data === false){
        $data = ['success' => true];
    }else{
        $data=$data->toArray();
        unset(
            $data['first_page_url'],
            $data['last_page_url'],
            $data['links'],
            $data['path'],
            $data['last_page'],
            $data['next_page_url'],
            $data['prev_page_url'],
            $data['from'],
            $data['to']
        );
    }


    return response()->json($data);

}

/**
 * Response JSON errors
 */
function errors($errors, int $code = 400): JsonResponse
{
    return response()->json($errors, $code);
}
function error($message, int $code = 400): JsonResponse
{
    return errors(['errors' => [['message' => $message]]], $code);
}
function bindRepo($interface, $repo)
{
    app()->bind($interface,
        $repo);
    return app()->make($interface);
}

function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('тийин' ,'тийин' ,'тийин',	 1),
        array('сум'   ,'сум'   ,'сум'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}
