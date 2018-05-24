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


//获取url地址参数 
function convertUrlQuery($query){
    $query=strstr($query,'?');
    $query=ltrim($query,'?');
  $queryParts = explode('&', $query);
  $params = array();
  foreach ($queryParts as $param) {
    $item = explode('=', $param);
    $params[$item[0]] = $item[1];
  }
  return $params;
}



?>