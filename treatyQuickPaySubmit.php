<?php
/**
 * 功能：1.15    协议快捷-扣款提交 接口
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */
$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);
$api->setDebug(true);//记录错误日志
$order = array(

    'outTradeNo' => time(),
    'buyerName' => '',//买家姓名
    'buyerCertNo' => '',//买家身份证号
    'buyerPhone' => '',//买家手机号
    'cardNo' => '',//银行卡号
    'goodsDesc' => '测试订单',
    'bankNo' => 'CMBC',
    'treatyNo' => '30000045065240',
    'payMoney'=>'100',
    'payType'=>'38',
    'notifyUrl'=>$config['payNotifyUrl'],
    'ip'=>'127.0.0.1'
);

if ($api->treatyQuickPaySubmit($order)) {
    $ret = $api->getResponse();
    var_dump($ret);
} else {

    echo $api->getError();
}




