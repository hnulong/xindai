<?php
/**
 * Created by PhpStorm.
 * User: Somnus
 * Date: 2016/11/9
 * Time: 17:28
 */
/**
 * [writeArr 写入配置文件方法]
 * @param  [type] $arr      [要写入的数据]
 * @param  [type] $filename [文件路径]
 * @return [type]           [description]
 */
function writeArr($arr, $filename) {
    return file_put_contents($filename, "<?php\r\nreturn " . var_export($arr, true) . ";");
}

function delDir($path){
    if ( $handle = opendir( "$path" ) ){
        while ( false !== ( $item = readdir( $handle ) ) ) {
            if ( $item != "." && $item != ".." ) {
                if ( is_dir( "$path/$item" ) ) {
                    delDir( "$path/$item" );
                } else {
                    unlink( "$path/$item" );
                }
            }
        }
        closedir( $handle );
    }
}
//验证身份证
function check_user_card($name,$usercard){
    $key='f7be99073541c15a0a580dc1d4d157bd';
    $url = "http://open.sudadata.com/api/api/getidcard.html?key={$key}&cardNo={$usercard}&realName={$name}";
    return lock_curl($url,[]);
}
//curl 操作  参考格式
/*$post_data["apikey"]='15ff8e3ab8bc4f020968af8e6b283803';
		$post_data["deviceid"]='210351';
		$post_data["command"]='04';
		$post_data["lockid"]='01';
		$post_data["group"]='01';
		$post_data["pw"]='123456';
		$post_data["time"]=201704251230*/
function lock_curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
    //curl_setopt($ch, CURLOPT_POST, 1);
// post的变curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}