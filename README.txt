───────
 代码文件结构
───────
php_sdk_utf8
  │
  ├log┈┈┈┈┈┈┈┈┈┈┈┈┈ 日志文件夹
  │
  ├openapi┈┈┈┈┈┈┈┈┈┈┈ 类文件夹
  │  │
  │  ├config.php┈┈┈┈┈┈┈┈配置文件
  │  │
  │  ├Curl.php┈┈┈┈┈┈┈┈┈http通信类
  │  │
  │  ├Logger.php┈┈┈┈┈┈┈┈日志处理类
  │  │
  │  └Request.php┈┈┈┈┈┈┈ 接口请求提交类文件
  │
  ├ebank.php ┈┈┈┈┈┈┈┈┈┈调用网银支付
  ├qrCode.php┈┈┈┈┈┈┈┈┈┈调用二维码支付
  │
  ├query.php ┈┈┈┈┈┈┈┈┈┈交易状态查询接口
  │
  ├notify.php┈┈┈┈┈┈┈┈┈┈支付结果异步通知
  ├return.php┈┈┈┈┈┈┈┈┈┈支付结果同步通知
  │
  ├refund.php ┈┈┈┈┈┈┈┈┈ 发起退款接口
  ├refundQuery.php ┈┈┈┈┈┈┈查询退款结果
  │
  ├customQuery.php ┈┈┈┈┈┈┈报关结果查询
  ├customReport.php┈┈┈┈┈┈┈报关推送
  │
  └README.txt ┈┈┈┈┈┈┈┈┈ 使用说明文本
※注意※
需要修改配置的文件是：
openapi/config.php

