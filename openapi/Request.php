<?php
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Curl.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Logger.php';

class Openapi_Request
{
    /**
     * @var int 商户号
     */
    protected $merchantId;

    /**
     * @var string 密钥
     */
    protected $privateKey;

    /**
     * @var string 网关地址
     */
    protected $serverUrl;

    /**
     * @var array|null 网关返回参数
     */
    protected $response = array();

    /**
     * @var int 通信超时时间
     */
    protected $timeout = 10;

    /**
     * @var String 错误消息
     */
    protected $error;

    /**
     * @var bool 是否打印日志
     */
    protected $debug = true;

    /**
     * @var string SDK版本
     */
    protected $sdkVersion = '1.0.0';

    public function __construct($config)
    {
        $this->merchantId = $config['merchantId'];
        $this->privateKey = $config['privateKey'];
        $this->serverUrl = $config['serverUrl'];
    }

    /**
     * 调用获取支付二维码接口
     * @param array $orderInfo 订单信息
     * @return bool 是否请求成功
     */
    public function getQrCode($orderInfo)
    {
        $orderInfo['merchantId'] = $this->merchantId;
        return $this->request('/pay/qr.do', $this->addSign($orderInfo));
    }

    /**
     * 条码支付
     * @param $orderInfo
     * @return bool 是否请求成功
     */
    public function barcodePay($orderInfo)
    {
        $orderInfo['merchantId'] = $this->merchantId;
        return $this->request('/pay/barcode.do', $this->addSign($orderInfo));
    }

    /**
     * H5支付
     * @param $orderInfo
     * @return bool
     */
    public function h5Pay($orderInfo)
    {
        $orderInfo['merchantId'] = $this->merchantId;
        return $this->request('/pay/h5.do', $this->addSign($orderInfo));
    }

    /**
     * 发起网银支付
     * @param array $data
     * @return string form Html code 输出到浏览器
     */
    public function ebankPay($data)
    {
        $data['merchantId'] = $this->merchantId;
        return $this->formPost('/pay/ebank.action', $this->addSign($data));
    }

    /**
     * 发起快捷支付
     * @param array $data
     * @return string form Html code 输出到浏览器
     */
    public function quickPay($data)
    {
        $data['merchantId'] = $this->merchantId;
        return $this->formPost('/pay/quickpay.action', $this->addSign($data));
    }

    public function customReport($data)
    {
        $data['merchantId'] = $this->merchantId;
        return $this->request('/custom/report.do', $this->addSign($data));
    }

    public function customReport1($data)
    {
        $data['merchantId'] = $this->merchantId;
        return $this->request('/custom/report1.do', $this->addSign($data));
    }

    public function customQuery($outTradeNo)
    {
        $data = array(
            'merchantId' => $this->merchantId,
            'outTradeNo' => $outTradeNo
        );
        return $this->request('/custom/query.do', $this->addSign($data));
    }

    /**
     * 校验消息的合法性（是否由网关发出）
     * @param string $notifyId 消息ID
     * @return bool 是否校验成功
     */
    public function verifyNotify($notifyId)
    {
        $requestData = $this->addSign(array('merchantId' => $this->merchantId, 'notifyId' => $notifyId));
        $r = $this->request('/pay/verify.do', $requestData, 'get');
        if (!$r) {
            $this->log($this->error = 'notify id verify fail');
        }
        return $r;
    }

    /**
     * 查询订单支付状态
     * @param string $outTradeNo 商户订单号
     * @return bool 是否查询成功
     */
    public function queryPayStatus($outTradeNo)
    {
        $requestData = $this->addSign(array('merchantId' => $this->merchantId, 'outTradeNo' => $outTradeNo));
        return $this->request('/pay/query.do', $requestData, 'post');
    }

    /**
     * 订单退款
     * @param string $outTradeNo 商户平台的退款流水号(请确保唯一性)
     * @param string $payTradeNo 商户原交易订单号
     * @param int $refundMoney 退款金额(单位分)
     * @return bool 退款发起是否成功
     */
    public function refund($outTradeNo, $payTradeNo, $refundMoney)
    {
        $data = array(
            'merchantId' => $this->merchantId,
            'outTradeNo' => $outTradeNo,
            'payTradeNo' => $payTradeNo,
            'refundMoney' => $refundMoney
        );
        return $this->request('/pay/refund.do', $this->addSign($data));
    }

    /**
     * 退款订单查询
     * @param string $outTradeNo 商户平台的退款流水号
     * @return bool 是否调用成功
     */
    public function queryRefund($outTradeNo)
    {
        $data = array(
            'merchantId' => $this->merchantId,
            'outTradeNo' => $outTradeNo
        );
        return $this->request('/pay/queryRefund.do', $this->addSign($data));
    }

    /**
     * 与网关通信
     * @param string $uri 请求路径
     * @param array $data 请求数据
     * @param string $reqType http 请求方式GET OR POST
     * @return bool 请求是否成功
     */
    public function request($uri, $data, $reqType = 'post')
    {
        if ($reqType == 'get') {
            $curl = new Openapi_Curl($this->serverUrl . $uri . '?' . http_build_query($data, '', '&'));
        } else {
            $curl = new Openapi_Curl($this->serverUrl . $uri);
            $curl->setPostMethod();
            $curl->addPostData(http_build_query($data, '', '&'));
        }
        $curl->setTimeout($this->timeout);
        $curl->send();
        try {
            if ($curl->getStatus() != 200) {
                throw new Exception('http connection fail');
            }
            if (!$curl->getBody()) {
                throw new Exception('read data fail');
            }
            $this->response = json_decode($curl->getBody(), true);
            if (!$this->response) {
                throw new Exception('json decode fail');
            }
            if (!isset($this->response['retCode'])) {
                throw new Exception('miss retCode parameter');
            }
            if ($this->response['retCode'] !== '00') {
                $msg = 'retCode:' . $this->response['retCode'];
                if (isset($this->response['retMsg'])) {
                    $msg .= ',retMsg:' . $this->response['retMsg'];
                }
                throw new Exception($msg);
            }
            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            $info = array(
                'errorMsg:' . $e->getMessage(),
                'url:' . $curl->getUrl(),
                'httpStatus:' . $curl->getStatus(),
                'requestData:' . json_encode($data, JSON_UNESCAPED_UNICODE),
                'responseData:' . $curl->getBody()
            );
            $this->log(implode("\r\n", $info));
            return false;
        }
    }

    public function formPost($uri, $data)
    {
        $str = '<form action="' . $this->serverUrl . $uri . '" method="post" name="formPost">';
        foreach ($data as $k => $v) {
            $str .= '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
        $str .= '</form>';
        return $str . "<script>document.forms['formPost'].submit();</script>";
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $msg
     */
    public function log($msg)
    {
        if ($this->debug) {
            Openapi_Logger::instance()->error($msg);
        }
    }

    /**
     * 计算md5签名
     * @param array $data
     * @return string
     */
    public function sign($data)
    {
        foreach ($data as $key => $v) {
            if ($key == 'sign' || $v === '') unset($data[$key]);
        }
        ksort($data);
        $data = http_build_query($data, '', '&');
        $data = urldecode($data);
        return strtoupper(md5($data . $this->privateKey));
    }

    /**
     * 校验通知数据合法性
     * @param $data
     * @return bool
     */
    public function verify($data)
    {
        $keys = array('merchantId', 'sign');
        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                $this->log($this->error = 'miss parameter:' . $key);
                return false;
            }
        }

        if ($data['merchantId'] != $this->merchantId) {
            $this->log($this->error = 'merchantId mismatch');
            return false;
        }

        if ($data['sign'] != $this->sign($data)) {
            $this->log($this->error = 'sign error');
            return false;
        }

        return true;
    }

    /**
     * 获取客户端IP
     * @return String|null
     */
    public function getIp()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return null;
        }
    }

    /**
     * 给数据加上签名
     * @param array $data
     * @return array
     */
    private function addSign($data)
    {
        $data['sign'] = $this->sign($data);
        return $data;
    }

    /**
     * @return array|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param bool $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @return string
     */
    public function getSdkVersion()
    {
        return $this->sdkVersion;
    }
}