<?php 
/**
* 
*/
class Contorller_index extends Controller_B
{

	public function index(){

		$view=new View();
		$db=new ZFC_DB;
		$arr=['title'=>'ZFCPHP框架','text'=>'欢迎使用ZFCPHP'];
		$view->assign('arr',$arr);
		$view->display('index');

	}


}


?>