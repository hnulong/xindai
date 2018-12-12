<?php
$notify = empty($_GET['notify']) ? 0 : $_GET['notify'];
$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
$url = dirname($url);
$url = str_replace('Pay','',$url) .'index.php?g=Pay&m=Res&a=';
if($notify){
	file_put_contents("./Log/paylog_".$_POST['order_no'].".txt", var_export($_POST,true));
	$order_no = $_POST['order_no'];
	$amount = $_POST['amount'];
	$url .= "notifyurl";
}else{
	file_put_contents("./Log/paylog_".$_GET['order_no'].".txt", var_export($_GET,true));
	$order_no = $_GET['order_no'];
	$amount = $_GET['amount'];
	$url .= "returnurl";
}
$url .= "&order_no={$order_no}&amount={$amount}";
header("Location: ".$url);
exit;