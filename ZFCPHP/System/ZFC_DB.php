<?php defined('SYSPATH_ZFC') or die('No direct script access.');
class ZFC_DB{
	public $_sql;
	// global $_DB_PREFIX;	
	public $is_sql=false;
	//是否开启回转
	public $_roll=false;
	public $_is_roll=0;// 1 ：开始回转 0 ：停止回转
	public $_conn=null;
	public $_key='';
						/*封装连接数据库*/
	public	function connect($host = DB_HOST,$dbuser = DB_USER,$dbpasswd = DB_PASSWORD,$dbname = DB_NAME,$chang=false){
		try {
			
			$dsn="mysql:host=$host;dbname=$dbname";	
			
		    $dbh = new PDO($dsn, $dbuser, $dbpasswd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'set names '.DB_CHARSET)); //初始化一个PDO对象
		   	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		   	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		   	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		   	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		} catch (PDOException $e) {
		    die ("Error!: " . $e->getMessage() . "<br/>");
		}
		if($chang){
			//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true) 变成这样：
			$dbh->setAttribute(PDO::ATTR_PERSISTENT, true);
		}
		return $dbh;
	}

/*插入一条数据*/
	public function insert($table,$arr){
		$z_k='';
		$z_v='';
		foreach ($arr as $key => $value) {
		        $z_k.="`{$key}`,";
		        $value=$this->_escape_str($value);
		        $z_v.="{$value},";
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
	public function select($table='',$where=[],$limit=[],$order='',$keys='',$name='*'){
		if(empty($table)){
			return 'table empty';
		}
		$where_z='';
		if(!empty($where)){
			$where_z='where ';
			if(is_array($where)){
				
				foreach ($where as $k => $v) {
					$v=$this->_escape_str($v);
						$where_z.=" `{$k}`={$v} and";
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
	 	$this->_sql="SELECT $name FROM  `".DB_PREFIX."{$table}` {$where_z} {$order} {$limit_z}";
	 	if($this->is_sql){
	    	return $this->_sql;
	    }else{
	    	$this->_key=$keys;
	    	$query= $this->query('SELECT',$this->_sql);	
			return $query;
		}
		
	}

	/*查询数据*/
	public function count($table='',$where=[]){
		if(empty($table)){
			return 'table empty';
		}
		$where_z='';
		if(!empty($where)){
			$where_z='where ';
			if(is_array($where)){
				
				foreach ($where as $k => $v) {
					$v=$this->_escape_str($v);
						$where_z.=" `{$k}`={$v} and";
				}	
			}else{
				$where_z.=$where;
			}
				
		}
		$where_z=rtrim($where_z,"and");
	 	$this->_sql="SELECT count(*) as num FROM  `".DB_PREFIX."{$table}` {$where_z} limit 1";
	 	if($this->is_sql){
	    	return $this->_sql;
	    }else{
	    	$query= $this->query('SELECT',$this->_sql);	
			return isset($query[0]['num'])?$query[0]['num']:0;
		}
		
	}

	public function one($table='',$where=[],$name='*',$order=''){
		if(empty($table)){
			return 'table empty';
		}
		$where_z='';
		if(!empty($where)){
			$where_z='where ';
			if(is_array($where)){
				
				foreach ($where as $k => $v) {
					$v=$this->_escape_str($v);
						$where_z.=" `{$k}`={$v} and";
				}	
			}else{
				$where_z.=$where;
			}
				
		}
		$where_z=rtrim($where_z,"and");
	 	$this->_sql="SELECT $name FROM  `".DB_PREFIX."{$table}` {$where_z} {$order} limit 1";
	 	if($this->is_sql){
	    	return $this->_sql;
	    }else{
	    	$query= $this->query('SELECT',$this->_sql);	
			return isset($query[0])?$query[0]:false;
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
					$v=$this->_escape_str($v);
						$where_z.=" `{$k}`={$v} and";
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
					$v=$this->_escape_str($v);
						$data_z.="`{$k}`={$v},";
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
			        $value=$this->_escape_str($value);
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
					$v=$this->_escape_str($v);
						$where_z.=" `{$k}`={$v} and";
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
		if(!defined('SYSPATH_SQL_HOST')){
			if(empty(DB_NAME))
				exit();
			if(empty($database))
				$database=DB_NAME;
			if(empty($hostname))
				$hostname=DB_HOST;
			if(empty($username))
				$username=DB_USER;
			if(empty($password))
				$password=DB_PASSWORD;
		}
		try {
			if(!$this->_conn)
				$this->_conn =$this->connect($hostname,$username,$password,$database);
			if($this->_roll===1&&$this->_is_roll===0){
				$this->_is_roll=1;
				$this->_conn->beginTransaction(); 
			}
			if('SELECT'===$ff){
			 return	$this->select_arr($this->_conn->query($sql));
			}


			 $res=$this->_conn->exec($sql);
			if(!$res){
			      throw new PDOException('执行异常:'.$sql);
			   }
			if($this->_roll===0&&$this->_is_roll===1){
				 $this->_conn->commit();
				// $this->_conn->rollBack();
			}
			if('INSERT'===$ff&&$this->_roll===false)
			return $this->_conn->lastInsertId();

			if($this->_roll===0||$this->_roll===false){
				$this->_conn=null;
			}
		} catch (PDOException $e) {
			$this->_conn->rollBack();
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
		if(empty($list))
			return $list;
        $li=$this->arr_in($list,$k1);
        $where_t='';
        if(!is_array($where)){
        	$where_t=' and '.$where;
        }
         if(empty($show)){
            $this->_sql="SELECT * from  `".DB_PREFIX."{$table}` where `{$k2}` in({$li})  $where_t";
         }else{
            $this->_sql="SELECT `$k2`,{$show} from  `".DB_PREFIX."{$table}` where `{$k2}` in({$li})  $where_t";
         }
         $li_z=$this->as_array($this->_sql);
         foreach($list as $k=>$v){
            foreach($li_z as $kk=>$vv){
                $tii=true;
                if($v[$k1]!=$vv[$k2]){
                    $tii=false;
                }
                if(!empty($where)&&is_array($where)){
                	foreach($where as $kkk=>$vvv){
	                    if($v[$kkk]!=$vv[$vvv]){
	                        $tii=false;
	                    }
	                }
                }

                if($tii){
                    $list[$k]=array_merge($vv,$list[$k]);
                }

            }
         }
        return $list;
    }

   	public function select_arr($query){
   		$data = array();//定一个空数组 存放数据
		if($query){
			foreach($query as $assoc){//执行数据库语句 返回记录集（特殊资源类型）
				if(empty($this->_key)||!isset($assoc[$this->_key]))
				$data[] = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
				else
				$data[$assoc[$this->_key]] = $assoc;//循环遍历把获取的数据塞进$data[]这个数组里面
			}
		}
		$this->_conn=null;
		return $data;
   	}

    //获取数组某个值生成in条件
    public function arr_in($arr,$k){
    	$in='';
    	foreach($arr as $v){
    		$in.="'".$v[$k]."',";
    	}
    	return rtrim($in,',');
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

	public function _escape_str($str)
	{
		return stripslashes("'".str_replace("'","''",$str)."'");

	}


}



