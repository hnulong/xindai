<?php
/**
 * 此demo只做案例 其他接口同理即可
 *
 */
namespace shq\openapi\test;
include_once '../vendor/autoload.php';
use shq\openapi\OpenApi;
use shq\openapi\request\OpenapiPaymentOrderSwipe;
echo 'ffff';
$api = new OpenApi();
$api->appId = '20161213205027645722';
$api->appSecret = '6bdd32ced8aa455fd16837f66ed352a0';
$request = new OpenapiPaymentOrderSwipe();
$request->setContent(json_encode([
    'merchant_order_sn' => time().'882115120',
    'type' => 1,
    'auth_code' => '130229144446577736',
    'total_fee' => 0.01,
    'store_id' => 27532
]));
$result = $api->execute($request);
var_dump($result);