<?php defined('SYSPATH_ZFC') or die('No direct script access.');

class Controller_B{

	function __construct (){
		if(empty($_SESSION['name_user'])||empty($_SESSION['user_id'])){
			header("Location: /login"); 
		}
		if($_SESSION['name_user']===true||$_SESSION['user_id']===true){
			header("Location: /login"); 
		}
	}

	public function money(){
		$num=(int)$_POST['num'];
		if($num>$_SESSION['user_money']){
			exit(json_encode(['code'=>1,'msg'=>'金币不足']));
		}
	} 

	public function order_data($t_id,$num,$wuji,$daan='',$jl=0){
		$db=new ZFC_DB;
		$arr=[
				'user_id'=>$_SESSION['user_id'],
				'n_daan'=>$wuji,
				'daan'=>$daan,
				'time'=>time(),
				'type'=>$t_id,
				'money'=>$num,
				'wuji_id'=>$_SESSION['wuji_id'],
			];
			// $db->_BEGIN=true;
			
			$db->insert('user_order',$arr);
			if(!empty($jl)){
				//统计
				$db->insert('wuji_user_count',['n_daan'=>$wuji,'num'=>$num,'user_id'=>$_SESSION['user_id'],'type'=>$t_id,'wuji_id'=>$_SESSION['wuji_id']]);
			}
			// $db->_COMMIT=true;
			$db->update('user','money=money-'.$num,['user_id'=>$_SESSION['user_id']]);
			$_SESSION['user_money']-=$num;
			return $db->_msyql_if;
		// if($db->insert('user_order',$arr)){
		// 	if($db->update('user','money=money-'.$num,['user_id'=>$_SESSION['user_id']])){
		// 		$_SESSION['user_money']-=$num;
		// 		$db->insert('wuji_user_count',['n_daan'=>$wuji,'num'=>$num,'user_id'=>$_SESSION['user_id'],'wuji_id'=>$_SESSION['wuji_id']]);
		// 		return true;
		// 	}
			
		// }else{
		// 	return false;
		// }
	}

}



