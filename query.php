<?php
/**
 * 功能：1.9 订单支付结果查询
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */
$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);

$outTradeNo = 'test145878314075';//商户平台原交易订单号

if ($api->queryPayStatus($outTradeNo)) {
    echo '查询成功<br>';
    $ret = $api->getResponse();
    foreach ($ret as $k => $v) {
        echo $k . '=' . $v . '<br>';
    }
} else {
    echo '查询失败<br>';
    echo $api->getError();
}