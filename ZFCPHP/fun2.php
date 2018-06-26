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
	public function _host_route($fh='/',$C_name='index',$S_name='index',$html='.html',$nc=true){
		try{
		if(strstr(strrev($_SERVER['REQUEST_URI']),'/')==strstr(strrev($_SERVER['PHP_SELF']),'/')){
			self::$_controlName=empty($_GET['c'])?$C_name:$_GET['c'];	
			self::$_methodName=empty($_GET['s'])?$S_name:$_GET['s'];	
		}else{
			if(strstr($_SERVER['REQUEST_URI'],'?')){
				$url=strstr($_SERVER['REQUEST_URI'],'?',true);
				$url=rtrim($url,'?');
			}else{
				 $url=$_SERVER['REQUEST_URI'];
			}
			if(isset(self::$_url[$url])){
				 $url=self::$_url[$url];
			}elseif(!empty(self::$_re_url)){
				foreach(self::$_re_url as $ku=>$vu){	
					$url=preg_replace($ku,$vu,$url);
				}
			}
			$url=trim($url,'/');
			$url_address=explode($fh,$url);
			$url_address[0]=trim($url_address[0],$fh);
			self::$_controlName='';
			self::$_methodName='';
			foreach($url_address as $key=>$value){
				$value=rtrim($value,$html);
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
				foreach($url_address as $k=>$v){
					if(($k!=0&&$k!=1)||(self::$_methodName!=$v&&self::$_controlName!='Contorller_'.$v)){
					$_GET[]=$v;	
					}
				}
			}
			$directory->self::$_methodName();
			return true;
		}
			self::$_msg=$url.' : 找不到控制器!';
			return false;
		}catch(Exception $e)
		 {
		 self::$_msg='Message: ' .$e->getMessage();
		 }
	}
}
class View
{
	protected $data = [];
 
	public function display($file)
	{
	extract($this->data);
	 
	include '../Views/'.$file.'.php';
	}
	 
	public function assign($key, $value)
	{
	$this->data[$key] = $value;
	}
}

//模型方法
function D($name){
    require SYSPATH_LOCALHOST.'/Model/'.$name.'.Model.php';
    return new $name;
}

