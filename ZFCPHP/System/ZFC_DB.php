<?php defined('SYSPATH_ZFC') or die('No direct script access.');
class ZFC_DB{
	public $_sql;
	// global $_DB_PREFIX;	
	public $is_sql=false;
	//是否开启回转
	public $_roll=false;
	public $_is_roll=0;// 1 ：开始回转 0 ：停止回转
	public $_conn=null;
						/*封装连接数据库*/
	public	function connect($host = '',$dbuser = '',$dbpasswd = '',$dbname = '',$chang=false){
		try {
			$dsn="mysql:host=$host;dbname=$dbname";
		   return $dbh = new PDO($dsn, $dbuser, $dbpasswd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set names '.DB_CHARSET)); //初始化一个PDO对象
		} catch (PDOException $e) {
		    die ("Error!: " . $e->getMessage() . "<br/>");
		}
		if($chang){
			//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
			$db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
		}
	}

/*插入一条数据*/
	public function insert($table,$arr){
		$z_k='';
		$z_v='';
		foreach ($arr as $key => $value) {
		        $z_k.="`{$key}`,";
		        $value=mysql_real_escape_string($value);
		        $z_v.="'{$value}',";
		 }
		 $z_k=rtrim($z_k,',');
		 $z_v=rtrim($z_v,',');
	    $this->_sql="INSERT INTO  `".DB_PREFIX."{$table}` ({$z_k}) VALUES ({$z_v})";
	    if($this->is_sql){
	    return $this->_sql;
	    }else{
	    return $this->query('INSERT',$this->_sql);	
	    }
		
	}

	/*查询数据*/
	public function select($table='',$where=[],$limit=[],$order='',$key=''){
		if(empty($table)){
			return 'table empty';
		}
		$where_z='';
		if(!empty($where)){
			$where_z='where ';
			if(is_array($where)){
				
				foreach ($where as $k => $v) {
					$v=mysql_real_escape_string($v);
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
	 	$this->_sql="SELECT * FROM  `".DB_PREFIX."{$table}` {$where_z} {$order} {$limit_z}";
	 	if($this->is_sql){
	    	return $this->_sql;
	    }else{
	    	$query= $this->query('SELECT',$this->_sql);	
	    
			$data = array();//定一个空数组 存放数据
			if($query){
				foreach($query as $assoc){//执行数据库语句 返回记录集（特殊资源类型）
					if(empty($key))
					$data[] = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
					else
					$data[$assoc[$key]] = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
				}
			}
			return $data;
		}
		
	}

	/*修改数据*/
	public function update($table='',$data=[],$where=[]){
		if(empty($table)){
			return 'table empty';
		}
		$where_z='';
		if(!empty($where)){
			$where_z='where ';
			if(is_array($where)){
				
				foreach ($where as $k => $v) {
					$v=mysql_real_escape_string($v);
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
					$v=mysql_real_escape_string($v);
						$data_z.="`{$k}`='{$v}',";
				}	
			}else{
				$data_z.=$data;
			}
				
		}else{
			return 'where empty';	
		}
		$data_z=rtrim($data_z,",");
	 	$this->_sql="UPDATE  `".DB_PREFIX."{$table}` SET {$data_z} {$where_z}";
	 	if($this->is_sql){
	    	return $this->_sql;
	    }else{
	    	return $this->query('UPDATE',$this->_sql);	
	    }
		
	}

/*插入多条数据*/
	public function Arrinsert($table,$data){
		$this->_sql='';
		foreach($data as $arr ){
			$z_k='';
			$z_v='';
			foreach ($arr as $key => $value) {
			        $z_k.="`{$key}`,";
			        $value=mysql_real_escape_string($value);
			        $z_v.="'{$value}',";
			 }
			 $z_k=rtrim($z_k,',');
			 $z_v=rtrim($z_v,',');
		    $this->_sql.="INSERT INTO  `".DB_PREFIX."{$table}` ({$z_k}) VALUES ({$z_v});";	
		}
		if($this->is_sql){
	    	return $this->_sql;
	    }else{
	    	return $this->query('INSERT',$this->_sql);	
	    }
	}

/*删除数据*/
	public function delete($table='',$where=[]){
		if(empty($table)){
			return 'table empty';
		}
		$where_z='';
		if(!empty($where)){
			$where_z='where ';
			if(is_array($where)){
				
				foreach ($where as $k => $v) {
					$v=mysql_real_escape_string($v);
						$where_z.=" `{$k}`='{$v}' and";
				}	
			}else{
				$where_z.=$where;
			}
				
		}else{
			return 'where empty';	
		}
		$where_z=rtrim($where_z,"and");
	 	$this->_sql="DELETE FROM  `".DB_PREFIX."{$table}`  {$where_z}";
		if($this->is_sql){
	    	return $this->_sql;
	    }else{
	    	return $this->query('DELETE',$this->_sql);	
	    }
		
	}

/*运行数据库语句*/
	public function query($ff='',$sql,$is=0,$database='',$hostname='',$username='',$password=''){
		global $arr_db;
		if(empty($database))
			$database=DB_NAME;
		if(empty($hostname))
			$hostname=DB_HOST;
		if(empty($username))
			$username=DB_USER;
		if(empty($password))
			$password=DB_PASSWORD;
		try {
			if(!$this->_conn)
				$this->_conn =$this->connect($hostname,$username,$password,$database);
			if($this->_roll===1&&$this->_is_roll===0){
				$this->_is_roll=1;
				$this->_conn->beginTransaction(); 
			}
			if('SELECT'===$ff)
			 return	$this->_conn->query($sql);
			 $res=$this->_conn->exec($sql) or die(print_r($this->_conn->errorInfo(), true));;
			if($this->_roll===0&&$this->_is_roll===1){
				$this->_conn->rollBack();
			}
			if($this->_roll===0){
				$this->_conn=null;
			}
		} catch (PDOException $e) {
		    die ("Error!: " . $e->getMessage() . "<br/>");
		}
		// $res = mysqli_query($conn,$sql);//第一个参数连接数据库返回的句柄  ， 第二参数执行语句
		return $res;
	}


	/*关联查询
	$list原数据
	$table 要关联的表
	$k1 原数据关联字段
	$k2 关联的表的字段
	$where关联的条件
	$show 表显示的字段  *注：一定有$where里面的字段
	*/
	public function zfc_join($list=[],$table='',$k1='',$k2='',$where=[],$show=''){
        $li='';
        foreach($list as $k=>$v){
            $li.="'".$v[$k1]."',";
        }
         $li=rtrim($li,',');
         // if(!empty($where)){
         //    $where=' and '.$where;
         // }
         if(empty($show)){
            $sql="SELECT * from `{$table}` where `{$k2}` in({$li})";
         }else{
            $sql="SELECT {$show} from `{$table}` where `{$k2}` in({$li})";
         }
         $li_z=$this->as_array($sql);
         foreach($list as $k=>$v){
            foreach($li_z as $kk=>$vv){
                $tii=true;
                if($v[$k1]!=$vv[$k2]){
                    $tii=false;
                }
                foreach($where as $kkk=>$vvv){
                    if($v[$kkk]!=$vv[$vvv]){
                        $tii=false;
                    }
                }
                if($tii){
                    $list[$k]=array_merge($list[$k],$vv);
                }

            }
         }
        return $list;
    }


	public function as_array($sql){
		$query = $this->query('SELECT',$sql);//调用封装执行sql语句函数
		$data = array();//定一个空数组 存放数据
		if($query){
			foreach($query as $assoc){//执行数据库语句 返回记录集（特殊资源类型）
					$data[] = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
			}
		}
		return $data;
	}

}



