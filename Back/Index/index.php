<?php 
header("Content-type: text/html; charset=utf-8");
define('SYSPATH_LOCALHOST',dirname(dirname(__FILE__)));//上一级位置
session_start();
// echo dirname(dirname(__FILE__));exit;
require_once dirname(dirname(dirname(__FILE__))).'/ZFCPHP/fun.php';
require_once SYSPATH_LOCALHOST.'/Common/function.php';
?>