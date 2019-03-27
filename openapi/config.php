<?php
/**
 * 生产环境网关地址：https://api.ishanhui.cn
 * 测试环境网关地址：http://test-api.tpddns.cn:81
 * 请商户修改以下配置
 */
return array(
    'serverUrl' => 'http://test-api.tpddns.cn:81',// 网关地址，结尾不带“/”
    'merchantId' => '11111111',// 闪汇平台商户号
    'privateKey' => '200A710CEABD4518AF9BC3A7A183B85D',// 分配的密钥
    'payReturnUrl' => 'http://localhost/return.php',// 支付结果同步通知地址，不要带get参数
    'payNotifyUrl' => 'http://localhost/notify.php',// 支付结果异步通知地址，不要带get参数
);