<?php 
header("Content-type: text/html; charset=utf-8");
define('SYSPATH_LOCALHOST',dirname(dirname(__FILE__)));//上一级位置
session_start();
define('USER_CONFIG',SYSPATH_LOCALHOST.'/Common/config.php');
require dirname(dirname(dirname(__FILE__))).'/ZFCPHP/fun.php';
require SYSPATH_LOCALHOST.'/Common/function.php';
?>