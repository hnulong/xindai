<?php
/**
 * OpenapiRequest.php
 * @author  lmh <lmh@fshows.com|Q:991564110>
 * @link http://www.51youdian.com/
 * @copyright 2015-2016 51youdian.com
 * @package shq\openapi\request\OpenapiRequest
 * @since 1.0
 * @date: 2016/12/14- 16:42
 */
namespace shq\openapi\request;

interface OpenapiRequest
{

    public function getMethod();

    public function getVersion();

    public function getApiParas();
}