<?php
define('APP_NAME','App');
define('APP_PATH', './App/');
define('RUNTIME_PATH','./Temp/');
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
define('APP_DEBUG', true);
if(PHP_VERSION < '5.2.0'){
    die('PHP version must be greater than 5.2.0 !');
}
require './Base/Base.php';
