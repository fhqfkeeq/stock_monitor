<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 16/8/22
 * Time: 16:22
 */


/**
 * 数据含义
 * [0] => 柳钢股份           名称
 * [1] => 3.760             今日开盘价
 * [2] => 3.770             昨日收盘价
 * [3] => 3.750             当前价格
 * [4] => 3.810             今日最高价
 * [5] => 3.730             今日最低价
 * [6] => 3.750             买一
 * [7] => 3.760             卖一
 * [8] => 9023827           成交的股票数(除以100为手)
 * [9] => 34092545.000      成交金额(元)
 * [10] => 370050           买一申请数(370050股 = 3700手)
 * [11] => 3.750            买一报价
 * [12] => 114900           买二申请数
 * [13] => 3.740            买二报价
 * [14] => 202100           买三申请数
 * [15] => 3.730            买三报价
 * [16] => 233300           买四申请数
 * [17] => 3.720            买四报价
 * [18] => 113100           买五申请数
 * [19] => 3.710            买五报价
 * [20] => 65000            卖一申请数
 * [21] => 3.760            卖一报价
 * [22] => 163920           卖二
 * [23] => 3.770            卖二
 * [24] => 103400           卖三
 * [25] => 3.780            卖三
 * [26] => 120700           卖四
 * [27] => 3.790            卖四
 * [28] => 253091           卖五
 * [29] => 3.800            卖五
 * [30] => 2016-08-22       日期
 * [31] => 15:00:00         时间
 * [32] => 00
 * [33] => -0.01            涨跌额
 * [34] => -0.26%           涨跌幅
 */

//include "./common.php";

function getData($code)
{
    $code_list = explode(',', $code);

    $url = 'http://hq.sinajs.cn/list=' . $code;
//$url = 'http://qt.gtimg.cn/q=sz000858';
    $info = curl_get($url);
    preg_match_all('/"(.*)"/', $info, $data);

    foreach ($data[1] as $key => $item) {
        $item_data = explode(',', $item);
        $item_data[0] = iconv("GBK", "UTF-8", $item_data[0]);
        //计算涨跌额
        $zde = bcsub($item_data[3], $item_data[1], 2);
        //计算涨幅
        $zf = bcdiv($zde, $item_data[3], 4) * 100;
        $item_data[] = $zde;
        $item_data[] = $zf . "%";

        $return_data[$code_list[$key]] = $item_data;
    }

    return $return_data;
}

function getPositions($code){
    $positions = [
        'sh600149' => ['0' , '0.00'],
    ];

    return $positions[$code];
}