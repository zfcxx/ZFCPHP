<?php
header("Content-type:text/html; charset=utf-8");

date_default_timezone_set("PRC");  //转换时区   // PRC 中华人民共和国
// global $arr_db; //在下面配置
// echo $arr_db;exit;
//方法命名规则：一般使用驼峰法：fun_mysqli_all  funMysqliAll  _fun_mysqli_all
/*
	$host 服务器地址
	$dbuser 数据库用户名
	$dbpasswd 数据库密码
	$dbname 数据库名
	$charset 数据库编码
*/

//定义connect函数  //局部   
									/*封装连接数据库*/
function connect($host = '',$dbuser = '',$dbpasswd = '',$dbname = '',$charset = 'utf8'){
	$conn = mysqli_connect($host,$dbuser,$dbpasswd,$dbname) or die('连接服务器失败');
	//mysqli_query('set names utf8');
	mysqli_query($conn,'set names '.$charset);//set names utf8
	return $conn;//返回出去$conn
}


									/*封装执行sql语句*/
function query($sql){
	global $arr_db; //在下面配置
	$conn = connect($arr_db['hostname'],$arr_db['username'],$arr_db['password'],$arr_db['database']);
	mysql_query($conn,"set names 'GBK'"); //使用GBK中文编码;  
	$res = mysqli_query($conn,$sql);//第一个参数连接数据库返回的句柄  ， 第二参数执行语句
	return $res;
}


									/*封装查询数据表*/
function getAll($sql){
	//$sql = 'select * from `name`';
	$query = query($sql);//调用封装执行sql语句函数
	$data = array();//定一个空数组 存放数据
	if($query){
		while($assoc = mysqli_fetch_assoc($query)){//执行数据库语句 返回记录集（特殊资源类型）
			$data[] = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
		}
	}
	return $data;
}
									/*封装查询一条*/
function getOne($sql){
	$query = query($sql);//调用封装执行sql语句函数
	//$data = array();//定一个空数组 存放数据
	if($query){
		//while($assoc = mysqli_fetch_assoc($query)){//执行数据库语句 返回记录集（特殊资源类型）
		$assoc = mysqli_fetch_assoc($query);
		$data = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
		//}
	}
	return $data;
}

									/*封装插入方法*/
// function insert($table,$arr){
// 	$key = '';//定义变量存放字段，初始化为空
// 	$value = '';//定义变量存放字段，初始化为空
// 	foreach($arr as $k => $v){
// 		$key .= $k.',';  //$key = $key.$k;   //拼接字段
// 		$value .= "'".$v."'".',';  //拼接值
// 	}
// 	//rtrim 删除字符串末端的空白字符
// 	$key = rtrim($key,',');
// 	$value = rtrim($value,',');

// 	$sql = 'INSERT INTO '.$table.' ('.$key.') VALUES ('.$value.')';
// 	//print_r($sql);die;//die停止往下面代码运行
// 	$res = query($sql);

// 	return $res;
// }
 function insert($table,$arr){
		$z_k='';
		$z_v='';
		foreach ($arr as $key => $value) {
		        $z_k.="`{$key}`,";
		        $value=str_replace("'","''",$value);
		        $z_v.="'{$value}',";
		 }
		 $z_k=rtrim($z_k,',');
		 $z_v=rtrim($z_v,',');
	     $sql="INSERT INTO  `{$table}` ({$z_k}) VALUES ({$z_v})";
		return $res = query($sql);
}
// 										/*封装修改方法*/
// function update($table,$arr,$where){
// 	$field = '';   //定义变量存放字段，初始化为空
// 	foreach($arr as $k => $v){
// 		$field .= $k.'='."'".$v."'".',';         //$arr = $arr.$k; 循环处理字段拼接好值 sex="男"
// 	}
// 	$field = rtrim($field,','); //删除末尾段多余的逗号
	
// 	$sql = 'update '.$table.' set '.$field.' where '.$where; //拼接要运行的sql语句
// 	//var_dump($sql);exit();
// 	$data = query($sql);  //调用执行sql语句函数
// 	return $data;  //返回$data出去外面
// }

function update($table='',$data=[],$where=[]){
		if(empty($table)){
			return 'table empty';
		}
		
		$where_z='';
		if(!empty($where)){
			$where_z='where ';
			if(is_array($where)){
				
				foreach ($where as $k => $v) {
					$v=str_replace("'","''",$v);
						$where_z.=" `{$k}`='{$v}' and";
				}	
			}else{
				$where_z.=$where;
			}
				
		}else{
			return 'where empty';	
		}
		$where_z=rtrim($where_z,"and");
		$data_z='';
		if(!empty($data)){
			if(is_array($data)){
				
				foreach ($data as $k => $v) {
					$v=str_replace("'","''",$v);
						$data_z.="`{$k}`='{$v}',";
				}	
			}else{
				$data_z.=$data;
			}
				
		}else{
			return 'where empty';	
		}
		$data_z=rtrim($data_z,",");
	 	$sql="UPDATE  `{$table}` SET {$data_z} {$where_z}";
		return	$data = query($sql);  //调用执行sql语句函数
		
}

/*
	$table 数据库表名
	$where 修改条件
*/
										/*封装删除方法*/
function delete($table,$where){
	$sql = 'delete from '.$table.' where '.$where;
	$data = query($sql);  //调用执行sql语句函数
	return $data;
}

function select($table='',$where=[],$limit=[],$order=''){
	if(empty($table)){
		return 'table empty';
	}
	$where_z='';
	if(!empty($where)){
		$where_z='where ';
		if(is_array($where)){
			
			foreach ($where as $k => $v) {
				$v=str_replace("'","''",$v);
					$where_z.=" `{$k}`='{$v}' and";
			}	
		}else{
			$where_z.=$where;
		}
			
	}
	$where_z=rtrim($where_z,"and");
	$limit_z='';
	if(!empty($limit)){
		$limit_z='limit ';
		if(is_array($limit)){
			foreach ($limit as $key => $value) {
				$limit_z.="{$value},";
			}
			$limit_z=rtrim($limit_z,",");	
		}else{
			$limit_z.=$limit;
		}
		
	}
 $sql="SELECT * FROM  `{$table}` {$where_z} {$order} {$limit_z}";
 $query = query($sql);//调用封装执行sql语句函数
 $data = array();//定一个空数组 存放数据
if($query){
	while($assoc = mysqli_fetch_assoc($query)){//执行数据库语句 返回记录集（特殊资源类型）
		$data[] = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
	}
}
return $data;
	
}

//事务处理
function begin($sql_arr){
	$conn = connect($arr_db['hostname'],$arr_db['username'],$arr_db['password'],$arr_db['database']);
	mysql_query($conn,"set names 'GBK'"); //使用GBK中文编码;  
	$res = mysqli_query($conn,$sql);//第一个参数连接数据库返回的句柄  ， 第二参数执行语句
	mysqli_query($conn,"BEGIN");
	$ff=true;
	foreach($sql_arr as $k=>$v){
		$res=query($v);
		if(!$res){
			$ff=false;
			mysqli_query($conn,'ROLLBACK');
		}
	}
	if($ff){
		mysqli_query($conn,'COMMIT');
	}
	mysqli_query($conn,'END');


}

//表锁定
function lock($table,$sql){
	mysqli_query($conn,"LOCK TABLES `{$table}` WRITE");
	$res=mysqli_query($conn,$sql);
	mysqli_query($conn,"UNLOCK TABLES");
	return $res;
}

?>