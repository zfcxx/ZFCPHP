<?php 
/**
* 
*/
class Contorller_cpzx 
{

	public function index(){

		$view=new View();
		$db=new ZFC_DB;
		// $arr=$db->select('wuji',['type'=>5],2,'order by id DESC');
		// $_SESSION['wuji_id']=$arr[0]['id'];
		// $view->assign('arr',$arr);
		// $view->assign('user_post','/index/post_wuji');
		$view->display('cpzx');

	}


}


?>