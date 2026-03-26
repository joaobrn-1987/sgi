<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if(!function_exists('converterData')) {
    function converterData($dataConvert){
        $dataConvert2 = explode("/",$dataConvert);
        return $dataConvert2[2]."-".$dataConvert2[1]."-".$dataConvert2[0];
    }
}
if(!function_exists('converterReversoData')) {
    function converterReversoData($dataConvert){
        $dataConvert2 = new DateTime( $dataConvert );
        return $dataConvert2-> format( 'd/m/Y' );
    }
}
