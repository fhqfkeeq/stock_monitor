<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 16/8/1
 * Time: 14:59
 */

function curl_post($url = '', $params = array()){
    $tmpInfo = '';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $tmpInfo = curl_exec($curl);
    if (curl_errno ( $curl )) {
        //echo '<pre><b>错误:</b><br />' . curl_error ( $curl );
    }
    curl_close($curl);
    return $tmpInfo;
}

function curl_get($url = ''){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $tmpInfo = curl_exec($curl);
    if (curl_errno ( $curl )) {
        //echo '<pre><b>错误:</b><br />' . curl_error ( $curl );
    }
    curl_close($curl);
    return $tmpInfo;
}