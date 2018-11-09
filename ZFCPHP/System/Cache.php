<?php defined('SYSPATH_ZFC') or die('No direct script access.');

class Cache{

	private $_catalog;
	public function M($catalog){
		$this->_catalog=$catalog;
		return $this;
	}
	public function is_($name){
		if(file_exists('cache/'.$this->_catalog.'/'.$name.'.text')){
			return true;
		}else{
			return false;
		}
	}
	public function get($name){
		if(file_exists('cache/'.$this->_catalog.'/'.$name.'.text')){
			$myfile = fopen('cache/'.$this->_catalog.'/'.$name.'.text', "r") or die("Unable to open file!");
			$mom=fread($myfile,filesize('cache/'.$this->_catalog.'/'.$name.'.text'));
			fclose($myfile);
			return $mom;
		}
	}

	public function set($name,$text){
	$text=compress_html($text);
	$myfile = fopen('cache/'.$this->_catalog.'/'.$name.'.text', "w") or die("Unable to open file!");
	fwrite($myfile,$text);
	fclose($myfile);

	}

	public function delete($name=''){
		if(empty($name)){
			$wj='cache/'.$this->_catalog.'/';
			$ddd=[];
			$dir=opendir($wj);
			while(($file=readdir($dir))!==false){
			$ddd[]=$file;
			}
			// print_r($ddd);
			foreach ($ddd as $key => $value) {
				if($value =='.' || $value =='..')
					  continue;
			   	unlink($wj.'/'.$value); //删除文件   

			}
			closedir($dir);
		}else{
			$filename = 'cache/'.$this->_catalog.'/'.$name.'.text'; 
			unlink($filename); //删除文件 
		}
	}	
}



