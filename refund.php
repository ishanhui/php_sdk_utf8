<?php
/**
 * 功能：1.10 退款发起
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */
$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);
$api->setDebug(true);//记录错误日志
$outTradeNo = time();//商户平台的订单号，确保唯一性
$payTradeNo = 'test1544671314034'; // 原交易订单号
$refundMoney = 10; //退款金额，单位分
if ($api->refund($outTradeNo, $payTradeNo, $refundMoney)) {
    $ret = $api->getResponse();
    echo '发起退款成功<br>';
    echo $ret['qrCodeUrl'];
} else {
    echo '发起退款<br>';
    echo $api->getError();
}