<?php
/**
 * OpenapiRequestData.php
 * @author  lmh <lmh@fshows.com|Q:991564110>
 * @link http://www.51youdian.com/
 * @copyright 2015-2016 51youdian.com
 * @package shq\openapi\request\OpenapiRequestData
 * @since 1.0
 * @date: 2016/12/14- 16:42
 */

namespace shq\openapi\request;


class OpenapiRequestData
{
    /**
     * 公共请求参数
     * @var array
     */
    protected $values = [];

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @param $value
     */
    public function setAppId($value)
    {
        $this->values['app_id'] = $value;
    }

    /**
     * 移动支付平台分配给接入平台的服务商唯一的ID，请向相应的对接负责人获取
     * @return 值
     **/
    public function getAppId()
    {
        return $this->values['app_id'];
    }

    /**
     * 接口名称
     * @return mixed
     */
    public function getMethod()
    {
        return $this->values['method'];
    }

    /**
     * @param $value
     */
    public function setMethod($value)
    {
        $this->values['method'] = $value;
    }


    /**
     * @param $value
     */
    public function setFormat($value)
    {
        $this->values['format'] = $value;
    }

    /**
     *
     * @return mixed
     */
    public function getFormat()
    {
        return $this->values ['format'];
    }

    /**
     * @param $value
     */
    public function setSignMethod($value)
    {
        $this->values['sign_method'] = $value;
    }

    /**
     *
     * @return mixed
     */
    public function getSignMethod()
    {
        return $this->values ['sign_method'];
    }

    /**
     * @param $value
     */
    public function setSign($value)
    {
        $this->values['sign'] = $value;
    }

    /**
     * 获取签名，详见签名生成算法的值
     * @return mixed
     */
    public function getSign()
    {
        return $this->values ['sign'];
    }


    public function setNonce($value)
    {
        $this->values['nonce'] = $value;
    }

    /**
     * 获取签名，详见签名生成算法的值
     * @return mixed
     */
    public function getNonce()
    {
        return $this->values ['nonce'];
    }

    /**
     * 调用的接口版本，默认且固定为：1.0
     * @param $value
     */
    public function setVersion($value)
    {
        $this->values['version'] = $value;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->values ['version'];
    }

    /**
     * 请求参数的集合，最大长度不限，除公共参数外所有 请求参数都必须放在这个参数中传递
     * @param $value
     */
    public function setContent($value)
    {
        $this->values['biz_content'] = $value;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->values ['biz_content'];
    }
}