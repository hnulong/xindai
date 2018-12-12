<?php
namespace shq\openapi\request;

class OpenapiPaymentOrderQuery implements OpenapiRequest
{

    private $method = 'openapi.payment.order.query';

    private $version = '1.0';

    private $content = '';

    private $apiParas = array();

    public function setContent($content)
    {
        $this->content = $content;
        $this->apiParas["biz_content"] = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function getApiParas()
    {
        return $this->apiParas;
    }

}

;