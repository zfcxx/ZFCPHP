<?php defined('SYSPATH_ZFC') or die('No direct script access.');
   /*后台页码类*/                               
class page{
	public $_value;
	public $_page_text;
	public $_table;
	/*
	$table 数据表
	$page页码数
	$perpage 每页个数
	$where 条件 ['字段'=>'内容']
	$like 模糊查询 ['字段'=>'内容']
	$in_ar 多个查询 ['字段'=>'内容']
	$order 排序

	 */
 	public function asd($table='',$order='',$page=1,$perpage=20,$where=[],$like=[],$in_ar=[],$pagenum=5){
		$curpage=$page;
		$where_v='';
		if(!empty($table)){
			$where_z='';
			if(!empty($where)){
				 $where_v='where ';
				foreach ($where as $k => $v) {
					$where_z.="{$k}={$v}";
				}
			}
			$kk_z='';
			if(!empty($like)){
				if(empty($where_v)){
					$where_v='where ';
					$kk_z=' (';
				}else{
					$kk_z='and (';
				}
				
				foreach($like as $k=>$v){
					$kk_z.=" `{$k}` LIKE '%{$v}%' or";
				}	
				$kk_z=rtrim($kk_z,"or");
				$kk_z.=')';

			}
			$in_='';
			if(!empty($in_ar)){
				$kd=array_keys($in_ar);
				$kd=$kd[0];
				if(empty($where_v)){
					$where_v='where ';
				$in_.=' '.$kd.' in (';
				}else{
					$in_.=' and '.$kd.' in (';
				}
				
				
				
				foreach ($in_ar as $k => $v) {
					$in_.="'{$v}',";
				}
				$in_=rtrim($in_,",");
				$in_=$in_.' )';
			}
			$page=($page-1)*$perpage;
			$sql2 = "select count(*) as total from  `".DB_PREFIX."{$table}` {$where_v} {$where_z} {$kk_z} {$in_}";
			$totalpage = DB::query ( Database::SELECT, $sql2 )->execute ()->as_array();
			$totalpage = ceil($totalpage[0]['total']/$perpage);//总页码
			$startpage = $curpage - floor($pagenum/2);//
			$endpage = $curpage + floor($pagenum/2);
			//首页特殊处理
			if($startpage<1){
				if($totalpage<$pagenum){
		         $startpage =1;
				$endpage = $totalpage;
				}else{
				$startpage = 1;
				$endpage = $pagenum;
			   }
		    }
				//尾页特殊处理
			if($endpage>$totalpage){
				if($totalpage<$pagenum){
			        $startpage =1;
					$endpage = $totalpage;
				}else{
					$startpage = ($totalpage - $pagenum + 1);
					$endpage = $totalpage;
				}
			}

			//循环动态输出分页
			$page_text = '';
			if($curpage!=1){
				$page_text = '<a href="'.$_SERVER['REDIRECT_URL'].'?page=1" onclick="ajax_a($(this).attr(\'href\'));return false;"  class="page_cc" title="First Page">&laquo; 首页</a>';
				$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.($curpage-1).'" onclick="ajax_a($(this).attr(\'href\'));return false;" class="page_cc" title="Previous Page">&laquo; 上一页</a>';
			}
			for($i=$startpage;$i<=$endpage;$i++){
				if($i == $curpage){
					$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.$i.'"  onclick="ajax_a($(this).attr(\'href\'));return false;" class="number current page_cc" title="'.$i.'">'.$i.'</a>';
				}else{
					$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.$i.'" onclick="ajax_a($(this).attr(\'href\'));return false;" class="number page_cc" title="'.$i.'">'.$i.'</a>';
				}
			}
			if($curpage!=$totalpage){
				$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.($curpage+1).'" onclick="ajax_a($(this).attr(\'href\'));return false;" class="page_cc" title="Next Page">下一页 &raquo;</a>';
				$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.$totalpage.'" onclick="ajax_a($(this).attr(\'href\'));return false;" class="page_cc" title="Last Page">尾页 &raquo;</a>';
			}
			$sql="select * from  `".DB_PREFIX."{$table}` {$where_v} {$where_z} {$kk_z} {$in_} {$order} limit {$page},{$perpage}";
			$this->_value = DB::query ( Database::SELECT, $sql )->execute ()->as_array();
			$this->_page_text=$page_text;
			$this->_table=$table;
			return $this;
			// exit;
			// return '';
			// $ret=xg($ret);
			// $vv=(string)View::factory('ASD/AJAX/'.$table)->set('goods_li',$ret)->set('page_text',$page_text);
			// $vv=str_replace(array("\r\n", "\r", "\n","\t"), "", $vv);  
			// return $vv;
		}else{
			return '无表';
		}
	}


public function home($table='',$order='',$page=1,$perpage=20,$where=[],$like=[],$in_ar=[],$pagenum=5){
		$curpage=$page;
		$where_v='';
		if(!empty($table)){
			$where_z='';
			if(!empty($where)){
				 $where_v='where ';
				foreach ($where as $k => $v) {
					$where_z.=" `{$k}`='{$v}' and";
				}
				$where_z=rtrim($where_z,'and');
			}
			$kk_z='';
			if(!empty($like)){
				if(empty($where_v)){
					$where_v='where ';
					$kk_z=' (';
				}else{
					$kk_z='and (';
				}
				
				foreach($like as $k=>$v){
					$kk_z.=" `{$k}` LIKE '%{$v}%' or";
				}	
				$kk_z=rtrim($kk_z,"or");
				$kk_z.=')';

			}
			$in_='';
			if(!empty($in_ar)){
				$kd=array_keys($in_ar);
				$kd=$kd[0];
				if(empty($where_v)){
					$where_v='where ';
				$in_.=' '.$kd.' in (';
				}else{
					$in_.=' and '.$kd.' in (';
				}
				
				
				
				foreach ($in_ar as $k => $v) {
					$in_.="'{$v}',";
				}
				$in_=rtrim($in_,",");
				$in_=$in_.' )';
			}
			$page=($page-1)*$perpage;
			$sql2 = "select count(*) as total from  `".DB_PREFIX."{$table}` {$where_v} {$where_z} {$kk_z} {$in_}";
			$totalpage = DB::query ( Database::SELECT, $sql2 )->execute ()->as_array();
			$totalpage = ceil($totalpage[0]['total']/$perpage);//总页码
			$startpage = $curpage - floor($pagenum/2);//
			$endpage = $curpage + floor($pagenum/2);
			//首页特殊处理
			if($startpage<1){
				if($totalpage<$pagenum){
		         $startpage =1;
				$endpage = $totalpage;
				}else{
				$startpage = 1;
				$endpage = $pagenum;
			   }
		    }
				//尾页特殊处理
			if($endpage>$totalpage){
				if($totalpage<$pagenum){
			        $startpage =1;
					$endpage = $totalpage;
				}else{
					$startpage = ($totalpage - $pagenum + 1);
					$endpage = $totalpage;
				}
			}

			//循环动态输出分页
			$page_text = '';
			$type=isset($_GET['type'])?'&type='.$_GET['type']:'';
			if($curpage!=1){
				// $page_text = '<a href="'.$_SERVER['REDIRECT_URL'].'?page=1" onclick="ajax_a($(this).attr(\'href\'));return false;"  class="page_cc" title="First Page">&laquo; 首页</a>';
				$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.($curpage-1).$type.'" title="上一页" class="page_prev" class="page_cc" title="Previous Page">&lt;</a>';
			}
			for($i=$startpage;$i<=$endpage;$i++){
				if($i == $curpage){
					$page_text .='<span class="page_cur">'.$i.'</span>';
					// $page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.$i.'"  onclick="ajax_a($(this).attr(\'href\'));return false;"  title="'.$i.'">'.$i.'</a>';
				}else{
					$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.$i.$type.'" onclick="ajax_a($(this).attr(\'href\'));return false;"  title="'.$i.'">'.$i.'</a>';
				}
			}
			if($curpage!=$totalpage){
				$page_text .='<span>....</span>';
				$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.$totalpage.$type.'"  title="Last Page">'.$totalpage.'</a>';
				$page_text .= '<a href="'.$_SERVER['REDIRECT_URL'].'?page='.($curpage+1).$type.'" class="page_next"  title="Next Page">&gt;</a>';
				
			}
			$sql="select * from  `".DB_PREFIX."{$table}` {$where_v} {$where_z} {$kk_z} {$in_} {$order} limit {$page},{$perpage}";
			$this->_value = DB::query ( Database::SELECT, $sql )->execute ()->as_array();
			$this->_page_text=$page_text;
			$this->_table=$table;
			return $this;
			// exit;
			// return '';
			// $ret=xg($ret);
			// $vv=(string)View::factory('ASD/AJAX/'.$table)->set('goods_li',$ret)->set('page_text',$page_text);
			// $vv=str_replace(array("\r\n", "\r", "\n","\t"), "", $vv);  
			// return $vv;
		}else{
			return '无表';
		}
	}

	 

}


?>