<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 16/8/23
 * Time: 11:03
 */

include dirname(__FILE__)."/../common/common.php";
include dirname(__FILE__)."/../common/config.php";
include dirname(__FILE__)."/../common/getData.php";

$data = getData($GLOBALS['code']);
foreach ($GLOBALS['threshold'] as $key => $item) {
    if(isset($data[$key]) === false){
        continue;
    }

    if(isset($item['in']) === true){
        //买入判断
        if(abs(bcsub($data[$key][3], $item['in'], 2)) <= 1 ){
            //可以买入
            //记入redis每天只提醒一次
            send_msg('股票:'.$key.'已达到买入价格:'.$data[$key][3].'请关注!');
        }
    }

    if(isset($item['out']) === true){
        //卖出判断
        $positions = getPositions($key);
        if($positions[0] > 0 && abs(bcsub($data[$key][3], $item['out'], 2)) <= 1 ){
            //可以卖出
            //记入redis每天只提醒一次
            send_msg('股票:'.$key.'已达到卖出价格:'.$data[$key][3].'可卖数量为:'.$positions[0].', 请关注!');
        }
    }
}
