<?php
/**
 * 生产环境网关地址：https://api.ishanhui.cn
 * 测试环境网关地址：https://test.api.ishanhui.cn
 * 请商户修改以下配置
 */
return array(
    'serverUrl' => 'http://127.0.0.1:9104',// 网关地址，结尾不带“/”
    'merchantId' => '11077227',// 闪汇平台商户号
    'privateKey' => '815B0EC74FB841A4BDDE19DD0C5589DE',// 分配的密钥
    'payReturnUrl' => 'http://localhost/return.php',// 支付结果同步通知地址，不要带get参数
    'payNotifyUrl' => 'http://localhost/notify.php',// 支付结果异步通知地址，不要带get参数
);