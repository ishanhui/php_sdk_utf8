<?php
/**
 * 功能：1.14    协议快捷-协议确认 接口
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */
$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);
$api->setDebug(true);//记录错误日志
$order = array(
    'outTradeNo'=>'',
    'smsSerialNo'=>'',
    'smsCode' => '',
    'buyerName' => '',//买家姓名
    'cardNo' => '',//银行卡号

);

if ($api->treatyQuickPayConfirm($order)) {
    $ret = $api->getResponse();
    var_dump($ret);
} else {

    echo $api->getError();
}




