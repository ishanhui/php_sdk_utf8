<?php
/**
 * 功能：1.11 退款查询
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */
$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);
$api->setDebug(true);//记录错误日志
$outTradeNo = '1544673750';//原退款流水号
if ($api->queryRefund($outTradeNo)) {
    $ret = $api->getResponse();
    echo '查询成功<br>';
    echo $ret['refundStatus'];
} else {
    echo '查询失败<br>';
    echo $api->getError();
}