<?php
/*  [作者:zhangfucheng]*********************************
    */
define('SYSPATH_ZFC','ZFCPHP');
if(!defined('SYSPATH_LOCALHOST'))
define('SYSPATH_LOCALHOST','');
if(PATH_SEPARATOR==':')
	$mdg='/';
else 
	$mdg='\\';
$_ADDRESS_LOCALHOST=explode($mdg,SYSPATH_LOCALHOST);
$_ADDRESS_='';
for($i=0; $i<count($_ADDRESS_LOCALHOST)-1;$i++){
	$_ADDRESS_.=$_ADDRESS_LOCALHOST[$i].'/';
}
_zhangfucheng_xx_vv($_ADDRESS_.'ZFCPHP/System');
_zhangfucheng_xx_vv($_ADDRESS_.'ZFCPHP/Class','class');
if(defined('USER_CONFIG'))
	require USER_CONFIG;
	else
	require 'config.php';
function _zhangfucheng_xx_vv($wj,$name=''){
	$ddd=[];
	if($dir=opendir($wj)){
		while(($file=readdir($dir))!==false){
		$ddd[]=$file;
		}
		foreach ($ddd as $key => $value) {
			if($value =='.' || $value =='..'||!strstr($value,'.php'))
				  continue;
				if(!$name)
		    		require  $wj.'/'.$value;   
		    	elseif(strstr($value,$name))
		    		require  $wj.'/'.$value;
		}
		closedir($dir);
	}
	
}
/**
*  张富城
*  路由类
*/
class host_curl {
	public static $_url=[];//路由替换
	public static $_re_url=[];//正则路由
	public static $_msg='';
	public static $_controlName='';
	public static $_methodName=''; 
	public static $_nc=0;//第几个开始路由
	/*
	
		$fh 路由符
		$C_name 默认控制器
		$S_name 默认方法
		$suffix 过滤后缀名
	*/
	public function _host_route($fh='/',$C_name='index',$S_name='index',$suffix='html|php'){
		$url=$_SERVER['REQUEST_URI'];
		try{
		if(strstr(strrev($_SERVER['REQUEST_URI']),'/')==strstr(strrev($_SERVER['PHP_SELF']),'/')){
			self::$_controlName=empty($_GET['c'])?$C_name:$_GET['c'];	
			self::$_methodName=empty($_GET['s'])?$S_name:$_GET['s'];	
		}else{
			$url='/'.trim($url,'/');
			if(isset(self::$_url[$url])){
				 $url=self::$_url[$url];
				 $this->convertUrlQuery($url);
			}elseif(!empty(self::$_re_url)){
				foreach(self::$_re_url as $ku=>$vu){	
					$url=preg_replace($ku,$vu,$url);
				}
			}
			if(strstr($url,'?')){
				$url=strstr($url,'?',true);
				$url=rtrim($url,'?');
			}
			$url=trim($url,'/');
			$url_address=explode($fh,$url);
			$url_address[0]=trim($url_address[0],$fh);
			self::$_controlName='';
			self::$_methodName='';
			foreach($url_address as $key=>$value){
				if($key<self::$_nc){
					$_GET[]=$value;
					continue;
				}
				$value=preg_replace('/.('.$suffix.')/','',$value);
				self::$_methodName=(!empty($value)&&empty(self::$_methodName)&&!empty(self::$_controlName))?$value:self::$_methodName;
				self::$_controlName=(!empty($value)&&empty(self::$_controlName))?$value:self::$_controlName;
			}
		}
		self::$_controlName=empty(self::$_controlName)?$C_name:self::$_controlName;
		self::$_methodName=empty(self::$_methodName)?$S_name:self::$_methodName;
		$file='../Controller/'.self::$_controlName.'.class.php';
		self::$_controlName='Contorller_'.self::$_controlName;
		if(is_readable($file)){	
			require $file;	
			if(!class_exists(self::$_controlName)){
				self::$_msg=$url.' : 控制器未定义!';
				return false;
			}
			$directory=new self::$_controlName;
			if(!method_exists($directory,self::$_methodName)){
				if(!method_exists($directory,$S_name)){
					self::$_msg=$url.' : 未定义方法！';
			    	return false;
				}
			    self::$_methodName=$S_name;
			}
			if(!empty($url_address)){
				$kx='';
				foreach($url_address as $k=>$v){
					if(self::$_methodName!=$v&&self::$_controlName!='Contorller_'.$v){
						if(isset($url_address[$k+1])){
							$_GET[$v]=$url_address[$k+1];
							$kx=$k+1;
						}elseif($k!=$kx){
							$_GET[]=$v;	
						}
					
					}
				}
			}
			$method=self::$_methodName;
			$directory->$method();
			return true;
		}
			self::$_msg=$url.' : 找不到控制器!';
			return false;
		}catch(Exception $e)
		 {
		 self::$_msg='Message: ' .$e->getMessage();
		 }
	}

	//获取url地址参数 
	public function convertUrlQuery($query){
	  if($query=strstr($query,'?')){
	    $query=ltrim($query,'?');
	  	$queryParts = explode('&', $query);
	  	foreach ($queryParts as $param) {
	    $item = explode('=', $param);
	    $_GET[$item[0]] = $item[1];
	  	}
	  }
	  	return true;
	}


}
class View
{
	protected $data = [];
 
	public function display($file,$q=0)
	{
	extract($this->data);
	 if(empty($q))
		include '../Views/'.$file.'.php';
		else
		include $file;
	}
	 
	public function assign($key, $value)
	{
	$this->data[$key] = $value;
	}
}

//模型方法
function D($name){
    require_once SYSPATH_LOCALHOST.'/Model/'.$name.'.Model.php';
    return new $name;
}


