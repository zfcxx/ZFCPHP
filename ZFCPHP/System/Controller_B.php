<?php defined('SYSPATH_ZFC') or die('No direct script access.');
//自定义控制器方法
class Controller_B{

	function __construct (){
	}
	//开始http压缩
	function start_view(){
		header ("Content-Type: text/html"); 
        header ("Content-Encoding: gzip");
		ob_start();
	}
	//输出http压缩
	function end_view($html){
		ob_end_clean();
		$json= gzencode($html, 9, FORCE_GZIP);//$gzip ? FORCE_GZIP : FORCE_DEFLATE);  
        echo $json;
	}

}



