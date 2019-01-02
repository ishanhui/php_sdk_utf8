<?php
/**
 * 功能：1.7 支付交易结果异步通知
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的实际情况，按照技术文档重新编写。
 */


$config = require dirname(__FILE__) . '/openapi/config.php';
require dirname(__FILE__) . '/openapi/Request.php';
//日志记录
Openapi_Logger::instance()->info('notify data:' . json_encode($_POST));
$api = new Openapi_Request($config);
$api->setDebug(true);//记录错误日志

if ($api->verify($_POST)) {//通知消息验证通过

    //判断该笔订单是否在商户网站中已经做过处理
    //如果没有做过处理，根据订单号（outTradeNo）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
    //请务必判断请求时的payMoney与通知时获取的payMoney 为一致的
    //如果有做过处理，不执行商户的业务程序
    if ($_POST['payStatus'] == 1) {//支付成功
        //商户系统的业务逻辑
    }
    echo 'success';//不要修改
} else {
    echo $api->getSdkVersion() . ':' . $api->getError();//不要修改
}

