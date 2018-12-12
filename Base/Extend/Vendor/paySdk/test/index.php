<?php
/**
 * 此demo只做案例 其他接口同理即可
 *
 */
namespace shq\openapi\test;
include_once '../vendor/autoload.php';
use shq\openapi\OpenApi;
use shq\openapi\request\OpenapiPaymentOrderQuery;
use shq\openapi\request\OpenapiPaymentOrderScan;
class payDaikuan{
/*json_encode([
'merchant_order_sn' => time().'882115120',
'type' => 1,
'auth_code' => '130229144446577736',
'total_fee' => 0.01,
'store_id' => 27532
])*/
//二维码支付接口
/*          ['merchant_order_sn'=>'订单号','type'=>'1 2]','total_fee'=>'0.5']
 *
 * */
    public function qrcodePay($data_text){
        $data=json_encode($data_text);
        $api = new OpenApi();
        $api->appId = '20170620182400239879';
        $api->appSecret = 'c51b948aa935338cc96439d90806b09c';
        $request = new OpenapiPaymentOrderScan();
        $request->setContent($data);
        $result = $api->execute($request);
        return $result;
    }
    //h5
    /*          ['prepay_id'=>'订单号']
     *
     * */
    public function h5Pay($data_text){
        $data=json_encode($data_text);
        $api = new OpenApi();
        $api->appId = '20161213205027645722';
        $api->appSecret = '6bdd32ced8aa455fd16837f66ed352a0';
        $request = new OpenapiPaymentOrderScan();
        $request->setContent($data);
        $result = $api->execute($request);
        return $result;
    }
    //查询接口
    /*          ['merchant_order_sn'=>'订单号']
     *
     * */
    public function orderQuery($data_text){
        $data=json_encode($data_text);
        $api = new OpenApi();
        $api->appId = '20170620182400239879';
        $api->appSecret = 'c51b948aa935338cc96439d90806b09c';
        $request = new OpenapiPaymentOrderQuery();
        $request->setContent($data);
        $result = $api->execute($request);
        return $result;
    }
}

/*$api = new OpenApi();
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
var_dump($result);*/