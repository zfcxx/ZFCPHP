<?php 
/**
* 
*/
class Contorller_index extends Controller_B
{

	public function index(){
		$this->start_view();//压缩处理
		$view=new View();
		$db=new ZFC_DB;
		$arr=['title'=>'ZFCPHP框架','text'=>'欢迎使用ZFCPHP'];
		$view->assign('arr',$arr);
		$view->display('index');
		$html = ob_get_contents();
		$this->end_view($html);//压缩输出
		
	}


}


?>