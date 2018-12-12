<?php
/**
 * CLogFileHandler.php
 * @author  lmh <lmh@fshows.com|Q:991564110>
 * @link http://www.51youdian.com/
 * @copyright 2015-2016 51youdian.com
 * @package Liquidation\request\CLogFileHandler
 * @since 1.0
 * @date: 2016/9/13- 15:01
 */

namespace shq\openapi;


class CLogFileHandler
{
    private $handle = null;

    public function __construct($file = '')
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . date('Ymd') . DIRECTORY_SEPARATOR;
        !is_dir($dir) && mkdir($dir, 0777, true);
        $this->handle = fopen($dir . $file, 'a');
    }

    public function write($msg)
    {
        fwrite($this->handle, $msg, 4096);
    }

    public function __destruct()
    {
        fclose($this->handle);
    }
}