<?php
namespace shq\openapi;


use shq\openapi\request\OpenapiRequest;
use shq\openapi\request\OpenapiRequestData;

class OpenApi
{
    //网关
    public $gatewayUrl = "https://shq-api.51fubei.com/gateway";

    public $appId;
    public $appSecret;

    public function __construct()
    {
        //初始化日志
        Log::Init(new CLogFileHandler(date('Y-m-d') . '.log'), 15);
        Log::DEBUG("begin:");
    }

    /**
     * md5方式签名
     * @param  array $params 待签名参数
     * @return string
     */
    protected function generateMd5Sign($params)
    {
        $string = $this->getSignParams($params) . $this->appSecret;
        return strtoupper(md5($string));
    }

    /**
     * @param $params
     * @return string
     */

    protected function getSignParams($params)
    {
        ksort($params);
        $attachString = "";
        foreach ($params as $k => $v) {
            $attachString .= $k . "=" . trim($v) . "&";
        }
        return trim($attachString, "&");
    }

    public function execute(OpenapiRequest $request)
    {
        //设置 获取业务参数
        $apiParams = $request->getApiParas();
        //公共请求参数
        $sysData = new OpenapiRequestData();
        $sysData->setAppId($this->appId);
        $sysData->setMethod($request->getMethod());
        $sysData->setFormat('json');
        $sysData->setSignMethod('md5');
        $sysData->setNonce(self::getNonceStr());
        $sysData->setVersion($request->getVersion());

        $sysParams = $sysData->getValues();
        //签名
        $sysParams["sign"] = $this->generateMd5Sign(array_merge($apiParams, $sysParams));
        Log::DEBUG('sysparams:' . json_encode($sysParams));
        Log::DEBUG('apiParams:' . json_encode($apiParams));
        //发起HTTP请求
        try {
            $respObject = self::postCurl(json_encode(array_merge($sysParams, $apiParams)), $this->gatewayUrl);
        } catch (Exception $e) {
            Log::DEBUG('exception:' . $e->getMessage());
            return false;
        }
        Log::DEBUG('resp-Object:' . json_encode($respObject));
        return $respObject;

    }

    /**
     * @param int $length
     * @return string
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * @param $json
     * @param $url
     * @param bool $useCert
     * @param int $second
     * @return mixed
     */
    private static function postCurl($json, $url, $useCert = false, $second = 30)
    {
        // 初始化curl
        $ch = curl_init();
        // 设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        // 运行curl
        $data = curl_exec($ch);
        // 返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException ("curl出错，错误码:$error");
        }
    }
}