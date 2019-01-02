<?php
/**
 * 功能：1.8 支付结果同步通知
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
    //请商户自行处理页面内容
    echo '同步通知校验成功<br>';

} else {
    //请商户自行处理页面内容
    echo '同步通知校验失败<br>';
    echo $api->getError();
}
