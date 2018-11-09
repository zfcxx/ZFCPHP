<?php defined('SYSPATH_LOCALHOST') or die('No direct script access.');
if(preg_match("~\.zfc~si", $_SERVER['SERVER_NAME'])){ //-----------本地---------------
	/** WordPress数据库的名称 */
	define('DB_NAME', 'du');

	/** MySQL数据库用户名 */
	define('DB_USER', 'root');

	/** MySQL数据库密码 */
	define('DB_PASSWORD', '');

	/** MySQL主机 */
	define('DB_HOST', 'localhost');

	/** 创建数据表时默认的文字编码 */
	define('DB_CHARSET', 'utf8mb4');

	/** 数据库整理类型。如不确定请勿更改 */
	define('DB_COLLATE', 'du_');
	/**
	 *数据表前缀。
	 *
	 */
	define('DB_PREFIX','');
}else{
	define('DB_NAME', 'du2');

	/** MySQL database username */
	define('DB_USER', 'root');

	/** MySQL database password */
	define('DB_PASSWORD', '');

	/** MySQL hostname */
	define('DB_HOST', 'localhost');

	/** Database Charset to use in creating database tables. */
	define('DB_CHARSET', 'utf8mb4');

	/** The Database Collate type. Don't change this if in doubt. */
	define('DB_COLLATE', '');
		/**
	 *数据表前缀。
	 *
	 */
	define('DB_PREFIX','');
}

//路由方式
$host_curl=new host_curl();

//路由替换
$host_curl::$_url=[
	'/zfc_user'=>'/user',
];

//正则路由
$host_curl::$_re_url=[
	'/(.*?)p/'=>'/index/index/',
];

// host_curl::_host_route('-');//路由方式
if(!$host_curl->_host_route())
echo $host_curl::$_msg;


?>