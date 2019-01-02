<?php
/**
 * 功能：1.5 网银支付 接口
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */

$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
$api = new Openapi_Request($config);

$order = array(
    'outTradeNo' => time(),//商户平台的订单号，商户系统唯一
    'payMoney' => 10, //支付金额，单位分,无小数点
    'goodsDesc' => '测试订单',//订单描述
    'buyerName' => '张三',//买家姓名
    'buyerCertNo' => '510901197502176549',//买家身份证号
    'buyerPhone' => '13122334455',//买家手机号
    'ip' => $api->getIp(),//交易终端的IP地址
    'cardType' => '1',//银行卡类型: 1-借记卡，2-贷记卡
    'bankNo' => 'CCB',//银行代号，参见银行代号列表
    'userType' => '1',//用户类型：1-个人网银，2-企业网银
    'returnUrl' => $config['payReturnUrl'],//支付结果同步通知地址
    'notifyUrl' => $config['payNotifyUrl'],//支付结果异步通知地址
);
echo $api->ebankPay($order);