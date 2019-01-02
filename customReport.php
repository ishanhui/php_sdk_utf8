<?php
/**
 * 功能：2.1 报关推送
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */
$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);
$api->setDebug(true);//记录错误日志
$order = array(
    'outTradeNo' => time(),//请求流水号，唯一标识该笔请求
    'payTradeNo' => '',//支付单对应的请求流水号
    'oriMchOrder' => '', //商户平台订单号
    'goodsDesc' => '测试订单',//订单描述
    'goodsNum' => '1',//商品数量
    'payMoney' => '100',//支付金额，单位分（100表示1元）
    'goodsMoney' => '100',//支付货款，单位分（100表示1元）
    'freight' => '0',//支付运费，单位分（100表示1元）
    'tax' => '0',//支付税款，单位分（100表示1元）
    'customType' => '',//海关通道，参考《海关通道列表》
    'customCode' => '',//海关编码，参考《海关代码表》
    'ciqCode' => '',//国检编码，参考《国检代码表》（需要上报国检时填写）
    'note' => '',//备注信息
    'ip' => '',//交易终端的IP地址
);

if ($api->customReport($order)) {
    $ret = $api->getResponse();
    echo '报关信息提交成功';
} else {
    echo '报关信息提交失败<br>';
    echo $api->getError();
}