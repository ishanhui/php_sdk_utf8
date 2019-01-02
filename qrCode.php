<?php
/**
 * 功能：1.1    扫码支付 接口
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */
$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);
$api->setDebug(true);//记录错误日志
$order = array(
    'outTradeNo' => time(),//商户平台的订单号，确保唯一性
    'payType' => 10,//10-获取微信二维码；20-获取支付宝二维码。
    'payMoney' => 1, //支付金额，单位分,无小数点
    'goodsDesc' => '测试订单',//订单描述
    'buyerName' => '张三',//买家姓名
    'buyerCertNo' => '510901197502176549',//买家身份证号
    'buyerPhone' => '13122334455',//买家手机号
    'ip' => $api->getIp(),//交易终端的IP地址
    'notifyUrl' => $config['payNotifyUrl'],//支付结果异步通知地址
);

if ($api->getQrCode($order)) {
    $ret = $api->getResponse();
    // 请商户自行处理二维码渲染
    // javascript生成二维码图片 可参考 https://github.com/davidshimjs/qrcodejs
    echo '获取二维码成功<br>';
    echo $ret['qrCodeUrl'];
} else {
    echo '获取二维码失败<br>';
    echo $api->getError();
}




