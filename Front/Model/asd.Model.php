<?php defined('SYSPATH_ZFC') or die('No direct script access.');
  /*ajax 视图模型*/                                
class asd extends page{

	public function views_x(){
		// echo $this->_table;exit;
		$vv=(string)View::factory('ASD/AJAX/'.$this->_table)->set('goods_li',$this->_value)->set('page_text',$this->_page_text);
		$vv=str_replace(array("\r\n", "\r", "\n","\t"), "", $vv);  
		 return $vv;
	}
	public function views_admin(){
		
		
		
		$level=DB::select()->from('menu')->execute()->as_array();
		$li=[];
		foreach ($level as $key => $value) {
			$li[$value['menu_id']]=$value['name'];
		}
		foreach ($this->_value as $k => $v) {

			$this->_value[$k]['level']=json_decode($v['level'],true);
			foreach ($this->_value[$k]['level'] as $kk => $vv) {
				$this->_value[$k]['level'][$kk]=$li[$vv];
			}
		}
		$vv=(string)View::factory('ASD/AJAX/'.$this->_table)->set('goods_li',$this->_value)->set('page_text',$this->_page_text);
		$vv=str_replace(array("\r\n", "\r", "\n","\t"), "", $vv);  
		 return $vv;
	}

	public function views_column(){
		// echo $this->_table;exit;
		$vv=(string)View::factory('ASD/AJAX/'.$this->_table)->set('column_li',$this->_value)->set('page_text',$this->_page_text);
		$vv=str_replace(array("\r\n", "\r", "\n","\t"), "", $vv);  
		 return $vv;
	}
}


?>