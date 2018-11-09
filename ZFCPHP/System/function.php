<?php defined('SYSPATH_ZFC') or die('No direct script access.');
 // require_once 'excel/PHPExcel.php';  
// require_once 'excel/PHPExcel/IOFactory.php';
// require_once 'excel/PHPExcel/Reader/Excel5.php';  
/*过滤压缩*/                           
function compress_html($string) {
    $string = str_replace("\r\n", '', $string); //清除换行符
    $string = str_replace("\n", '', $string); //清除换行符
    $string = str_replace("\t", '', $string); //清除制表符
    $pattern = array (
                    "/> *([^ ]*) *</", //去掉注释标记
                    "/[\s]+/",
                    "/<!--[\\w\\W\r\\n]*?-->/",
                    "/\" /",
                    "/ \"/",
                    "'/\*[^*]*\*/'"
                    );
    $replace = array (
                    ">\\1<",
                    " ",
                    "",
                    "\"",
                    "\"",
                    ""
                    );
    return preg_replace($pattern, $replace, $string);
}

/*递归*/
function getcat($table,$pid=0,$cat = array(),$balnk=''){
        // $sql="SELECT * FROM  `{$table}` where `top_id`={$pid}";
        // $data=DB::query ( Database::SELECT, $sql )->execute ()->as_array();
        $ddd=new ZFC_DB();
        $data=$ddd->select($table,['re_id'=>$pid]);
        $balnk .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        if($data){
            foreach ($data as  $v) {
                $v['category_name']=$balnk.'|-'.$v['category_name'];
                $cat[]=$v;
                $cat=getcat($table,$v['category_id'],$cat,$balnk);
            }
        }
        return $cat;
    }


function jump($url,$text){
echo "<script>alert('{$text}');location.href='".$url."';</script>";exit;
}

   // 执行curl post返回数据
function curl_post($strSumbitPage='', $data=[]){
    $strUserAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1";
    //提交
     // var_dump($strSumbitPage);
     // var_dump($data);exit;
    $post_data= http_build_query($data);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,1);//成功连接服务器前等待多久
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);//从服务器接收缓冲完成前需要等待多长时间
    curl_setopt($ch, CURLOPT_URL, $strSumbitPage); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HEADER, 0); //1-返回头部 0-不返回头部
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if(!empty($strUserAgent)) //用户代理
        curl_setopt($ch, CURLOPT_USERAGENT, $strUserAgent); //设置UA 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //解决服务器不能POST的办法
    $str = curl_exec($ch);
    curl_close($ch);
    return $str;
}


function get_description($description) {
    $description = htmlspecialchars_decode($description);

    $description = str_replace("    ", " ", $description);
    $description = str_replace("\t", " ", $description);
    $description = preg_replace("~<br/>~si", "\r\n", $description);
    $description = preg_replace("~<br>~si", "\r\n", $description);
    $description = preg_replace("~<br[ ]*/*[ ]*>~si", "\n", $description);
    $description = preg_replace("~</div>~si", "\r\n", $description);
    $description = preg_replace("~<[ ]*/p[ ]*>~si", "\r\n", $description);
    $description = preg_replace("~<p>~si", "\r\n", $description);
    $description = preg_replace("~<p [^<]*>~si", "\r\n", $description);
    $description = str_replace("<strong>", "", $description);
    $description = preg_replace("~<[^<]*>~si", "", $description);
    
    $description = preg_replace("~\r~si", "", $description);
    $description = preg_replace("~\n[ ]+~si", "\n", $description);
    $description = preg_replace("~[ ]+\n~si", "\n", $description);
    $description = preg_replace("~\n+~si", "\n", $description);
    
    $description = trim($description, " \n");
    return $description;
}


//毫秒
function getMillisecond() {
list($t1, $t2) = explode(' ', microtime());
return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}


//获取标签元素内容
//$strText html码
//$strBegin标签
//$div 标签类型
//$nInclude是否返回指定标签 0否 1是
function caiji_html($strText, $strBegin,$div='div', $nInclude=0) 
{
    $strBegin_old = $strBegin;
    $strBegin = preg_quote($strBegin);
    $strPattern = "~$strBegin(.*)~si";
    if(!preg_match($strPattern, $strText, $arrMatch))
        return ;
    $strText = $arrMatch[1];
    $strText = preg_replace("/<".$div."/si", '<'.$div, $strText);
    $strText = preg_replace("/<[^<>]*\/[ ]*".$div.">/si", "</".$div.">", $strText);
    $bEquate = false; //用于确认是否是对应的</div>
    $nDivLastPost = 0;
    $strTem = $strText;
    for($i = 0; $i < 1000; $i++)
    {
        $nDivPos = strpos($strTem, "</".$div.">");
        $nDivLastPost += $nDivPos;
        $strGet = substr($strText, 0, $nDivLastPost);
        $nDivBegin = substr_count($strGet, "<".$div."");
        $nDivEnd = substr_count($strGet, "</".$div.">");

        if($nDivBegin == $nDivEnd)
        {
            $bEquate = true;
            break;
        }
        $strTem = substr($strTem, $nDivPos+strlen("</".$div.">"));
        $nDivLastPost = $nDivLastPost + strlen("</".$div.">");
    }
    
    if(!$bEquate)
        return ;
        
    $strText = substr($strText, 0, $nDivLastPost);
    
    if(!$nInclude)
        return $strText;
    else
        return $strBegin_old.$strText."</".$div.">";
}




function zfc_md5($str){
    return md5('A$'.$str.'#zfc');
}


/**
* 安全过滤类-过滤javascript,css,iframes,object等不安全参数 过滤级别高
*  Controller中使用方法：$this->controller->fliter_script($value)
* @param  string $value 需要过滤的值
* @return string
*/
function fliter_script($value) {
$value = preg_replace("/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i","&111n\\2",$value);
$value = preg_replace("/(.*?)<\/script>/si","",$value);
$value = preg_replace("/(.*?)<\/iframe>/si","",$value);
return $value;
}
 
/**
* 安全过滤类-过滤HTML标签
*  Controller中使用方法：$this->controller->fliter_html($value)
* @param  string $value 需要过滤的值
* @return string
*/
function fliter_html($value) {
if (function_exists('htmlspecialchars')) return htmlspecialchars($value);
return str_replace(array("&", '"', "'", "<", ">"), array("&", "\"", "'", "<", ">"), $value);
}
 
/**
* 安全过滤类-对进入的数据加下划线 防止SQL注入
*  Controller中使用方法：$this->controller->fliter_sql($value)
* @param  string $value 需要过滤的值
* @return string
*/
function fliter_sql($value) {
$sql = array("select", 'insert', "update", "delete", "\'", "\/\*",
     "\.\.\/", "\.\/", "union", "into", "load_file", "outfile");
$sql_re = array("","","","","","","","","","","","");
return str_replace($sql, $sql_re, $value);
}
 
/**
* 安全过滤类-通用数据过滤
*  Controller中使用方法：$this->controller->fliter_escape($value)
* @param string $value 需要过滤的变量
* @return string|array
*/
function fliter_escape($value) {
if (is_array($value)) {
  foreach ($value as $k => $v) {
   $value[$k] = fliter_str($v);
  }
} else {
  $value = fliter_str($value);
}
return $value;
}
 
/**
* 安全过滤类-字符串过滤 过滤特殊有危害字符
*  Controller中使用方法：$this->controller->fliter_str($value)
* @param  string $value 需要过滤的值
* @return string
*/
function fliter_str($value) {
$badstr = array("\0", "%00", "\r", '&', ' ', '"', "'", "<", ">", "   ", "%3C", "%3E");
$newstr = array('', '', '', '&', ' ', '"', "'", "<", ">", "   ", "<", ">");
$value  = str_replace($badstr, $newstr, $value);
$value  = preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $value);
return $value;
}
 
/**
* 私有路劲安全转化
*  Controller中使用方法：$this->controller->filter_dir($fileName)
* @param string $fileName
* @return string
*/
function filter_dir($fileName) {
$tmpname = strtolower($fileName);
$temp = array(':/',"\0", "..");
if (str_replace($temp, '', $tmpname) !== $tmpname) {
  return false;
}
return $fileName;
}
 
/**
* 过滤目录
*  Controller中使用方法：$this->controller->filter_path($path)
* @param string $path
* @return array
*/
function filter_path($path) {
$path = str_replace(array("'",'#','=','`','$','%','&',';'), '', $path);
return rtrim(preg_replace('/(\/){2,}|(\\\){1,}/', '/', $path), '/');
}
 
/**
* 过滤PHP标签
*  Controller中使用方法：$this->controller->filter_phptag($string)
* @param string $string
* @return string
*/
function filter_phptag($string) {
return str_replace(array(''), array('<?', '?>'), $string);
}
 
/**
* 安全过滤类-返回函数
*  Controller中使用方法：$this->controller->str_out($value)
* @param  string $value 需要过滤的值
* @return string
*/
function str_out($value) {
$badstr = array("<", ">", "%3C", "%3E");
$newstr = array("<", ">", "<", ">");
$value  = str_replace($newstr, $badstr, $value);
return stripslashes($value); //下划线
}


//递归函数
function digui($cate,$pid=0){
    $arr=[];
    foreach($cate as $v){
        if($v['pid']==$pid){
            $v['child']=digui($cate,$v['category_id']);
            $arr[]=$v;
        }
    }
    return $arr;
}

 function address_name($province_id=0,$city_id=0,$area_id=0){
    $db=new ZFC_DB;
    if(!empty($province_id)){
        $province=$db->one('address_province','province_id='.$province_id);
    }
    if(!empty($city_id)){
        $city=$db->one('address_city','city_id='.$city_id);
    }
    if(!empty($area_id)){
        $area=$db->one('address_area','area_id='.$area_id);
    }
    return ['province'=>empty($province['province'])?'':$province['province'],'city'=>empty($city['city'])?'':$city['city'],'area'=>empty($area['area'])?'':$area['area']];

}


function user_css($region=0){
    $db=new ZFC_DB;
    $url=empty($_SERVER['REDIRECT_URL'])?'':$_SERVER['REDIRECT_URL'];
    $data=$db->select('html_css','region='.$region.' and (url="" or url="'.$url.'")','',''); 
    $text='';
    foreach($data as $v){
        $text.=$v['text'];
    }
    return $text;

}

function user_js($region=0){
    $db=new ZFC_DB;
    $url=empty($_SERVER['REDIRECT_URL'])?'':$_SERVER['REDIRECT_URL'];
    $data=$db->select('html_js','region='.$region.' and (url="" or url="'.$url.'")','',''); 
    $text='';
    foreach($data as $v){
        $text.=$v['text'];
    }
    return $text;
}

function user_html($region=0){
    $db=new ZFC_DB;
    // $url=empty($_SERVER['REDIRECT_URL'])?'':$_SERVER['REDIRECT_URL'];
    $data=$db->select('html','region='.$region.' and type=1','',''); 
    $text='';
    foreach($data as $v){
        $text.=user_coupon_html($v['text']);
    }
    return $text;
}

function user_coupon_html($text=''){
    $db=new ZFC_DB;
    if($tt=stristr($text,'{$coupon[')){
        $tt=stristr($tt,']}',true);
        $tt=str_replace('{$coupon[','',$tt);
        if(is_numeric($tt)){
            $coupon=$db->one('coupon','activity=0 and coupon_id='.$tt);
            if($coupon){
                if(!empty($coupon['img_id'])){
                    $img=$db->one('upload','upload_id='.$coupon['img_id']);
                }
                if($coupon['activity']==0){
                    if(empty($img['file'])){
                        $t2='<div onclick="coupon('.$tt.')" class="coupon_'.$tt.'" >'.$coupon['name'].'</div>';
                    }else{
                        $t2='<div onclick="coupon('.$tt.')" class="coupon_'.$tt.'" ><img src="'.HTTP_IMG_URL.$img['file'].'"/></div>';
                    } 
                    $text=str_replace('{$coupon['.$tt."]}",$t2,$text);
                }
                
            }
        }
    }
    return $text;
}

function upload_img($uploadImage,$title=''){
     // $uploadImage=$_FILES["uploadImage"];
    $da=[];
    if(empty($uploadImage))
        return false;
    
    if(is_array($uploadImage['name'])){
        foreach($uploadImage['name'] as $k=>$v){
            if(!empty($v))
            $da[$k]['name']=$v;
        }
        foreach($uploadImage['tmp_name'] as $k=>$v){
            if(!empty($v))
            $da[$k]['tmp_name']=$v;
        }
        foreach($uploadImage['type'] as $k=>$v){
            if($v!="image/png"&&$v!="image/jpeg"||!isset($da[$k])){
                unset($da[$k]);
            }else{
                $da[$k]['type']=$v;
            }
        }
        foreach($uploadImage['error'] as $k=>$v){
            if(empty($v)&&isset($da[$k]))
            $da[$k]['error']=$v;
            else
            unset($da[$k]);
        }
        foreach($uploadImage['size'] as $k=>$v){
            if($v<1024000&&isset($da[$k]))
                $da[$k]['size']=$v;
                else
                unset($da[$k]);
        }
    }else if(!empty($uploadImage['name'])&&empty($uploadImage['error'])){
        $da[0]=['name'=>$uploadImage['name'],'size'=>$uploadImage['size'],'type'=>$uploadImage['error'],'tmp_name'=>$uploadImage['tmp_name']];
    }
    $img=[];
    if(!empty($da)){
        // var_dump($da);exit;
        $file_arr=[];
        $db= new ZFC_DB;
        if(count($da)>20){
                exit(json_encode(['code'=>1000,'msg'=>'最多上传20张图片']));
        }

        //特殊情况
        $sum=$db->one('upload','','sum(`size`) as sum');
        global $user_config;
        if(!empty($user_config[0]['space_img'])){
            if($sum['sum']/1024/1024>$user_config[0]['space_img']){
                exit('图片储存空间已经使用完，请增加图片储存空间');
            }

        }
        //
        if(empty($title)){
            $id=0;
        }else{
            $one=$db->one('upload',['name'=>$title]);
            if(!$one){
                $id=$db->insert('upload',['name'=>$title]);
            }else{
                $id=$one['upload_id'];
            }
        }
        foreach($da as $v){
            $wz=strrpos($v['name'],'.');
            $fi=substr($v['name'],$wz);
            $arr=['name'=>$v["name"],'pid'=>$id,'type'=>1,'file'=>uniqid().rand(0,9).$fi,'size'=>ceil($v['size']/1024)];
            $is=$db->insert('upload',$arr);
            $arr['id']=$is;
            // var_dump($arr);exit;
            $img[]=$arr;
            $file_arr[$arr['file']]=$v['tmp_name'];

        }
        $oss=D('oss')->upload($file_arr); 
    }
    return $img;

}


function one_img($img){
    $img=explode(',',$img);
    if(!empty($img[0])){
        $db=new ZFC_DB;
        $img=$db->one('upload','upload_id='.$img[0]);
        if($img){
            return $img;
        }
    }
    return '';
}


// 查看是否为手机端的方法
//判断是手机登录还是电脑登录
function ismobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    
    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
 }

 
function is_ajax(){
    if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
    return true;
    }else{ 
        return false;
    }
}

function xCopy($source, $destination, $child){   
//用法 
// xCopy("feiy","feiy2",1):拷贝feiy下的文件到 feiy2,包括子目录
// xCopy("feiy","feiy2",0):拷贝feiy下的文件到 feiy2,不包括子目录
//参数说明
// $source:源目录名
// $destination:目的目录名
// $child:复制时，是不是包含的子目录

if(!is_dir($source)){
echo 'Error:the '.$source." is not a direction!";
return 0;
}
if(!is_dir($destination)){
    mkdir($destination,0777);
}
  
$handle=dir($source);   
while($entry=$handle->read()) {   
    if(($entry!=".")&&($entry!="..")){   
        if(is_dir($source."/".$entry)){   
            if($child)   
                xCopy($source."/".$entry,$destination."/".$entry,$child);   
        }else{  
            copy($source."/".$entry,$destination."/".$entry);   
        }   
    }   
}   
  
    return 1;   
}  

function get_limit(){
    $page=empty($_GET['page'])?1:abs((int)$_GET['page']);
    $limit=empty($_GET['limit'])?20:abs((int)$_GET['limit']);
    $s_limit=($page-1)*$limit;
    return [$s_limit,$limit];
}

 function delete_img($data=[]){
        $db=new ZFC_DB;
        global $al_img_file;
        $al_img_file=[];
        foreach($data as $k=>$v){
            $one=$db->one('upload','upload_id='.$v);
            if($one){
                if(!empty($one['file'])){
                    $al_img_file[]=$one['file'];
                    $in_id=$v;
                }else{
                    $in_id=list_in_img($v,'upload_id','pid');
                    $in_id=implode(',',$in_id);
                    // $in_id=rtrim($in_id,',');
                }
                
                $is=$db->delete('upload','upload_id in('.$in_id.')');   
            }

            
        }
        if(!empty($al_img_file)){
            $oss=D('oss')->delete($al_img_file); 
        }
        return true;
        
    }

function list_in_img($id,$id_name,$pid_name,$tr=[]){
    global $al_img_file;

    $db=new ZFC_DB;
    $arr=$db->select('upload','pid='.$id);
    foreach($arr aS $k=>$v){
        if(!empty($v['file'])){
            $al_img_file[]=$v['file'];
            $tr[]=$v[$id_name];
        }else{
          $tr=array_merge($tr,list_in_img($v[$id_name],$id_name,$pid_name,$tr));  
        }
        
    }
    $tr[]=$id;
    array_unique($tr);
    // $tr.=$id.',';
    return $tr;
}

function  view_gzip($str){
    //开始http压缩
    header ("Content-Type: text/html"); 
    header ("Content-Encoding: gzip");
    $json= gzencode($str, 9, FORCE_GZIP);//$gzip ? FORCE_GZIP : FORCE_DEFLATE);  
    echo $json;exit;
    
}

function menu_sort($menu_a,$navigation=''){
    if(!empty($navigation)){
      $navigation=explode(',',$navigation);
       $navmenu=[];
      foreach($navigation  as $vn){
        foreach($menu_a as $vc){
          if($vc['category_id']==$vn)
            $navmenu[]=$vc;
        }
      }
    }else{
      $navmenu=$menu_a;
    }
    return $navmenu;
}