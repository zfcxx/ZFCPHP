<?php defined('SYSPATH_ZFC') or die('No direct script access.');?>
<!DOCTYPE html>
<html lang="en-US"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>321游戏网</title>
  	<!-- <script  type="text/javascript" src='/public/index?js=jquery.min.js'></script> -->
  	<script  type="text/javascript" src='//cdn.bootcss.com/jquery/2.0.3/jquery.min.js'></script>
	<!-- <script src="https://www.google~|com/recaptcha/api.js" async defer></script>   -->
</head>

<body class="body-bg"> 
<style type="text/css">
/*.l_co {border-left: 1px solid #000;}*/
.ta tr{margin-bottom: 20px; font-size: 20px; }
.ta tr td{line-height: 20px; min-width: 100px;}
</style> 

<div style="width: 80%;margin: 0 auto;height: 50px;text-align: center;font-size: 30px;">321游戏网</div>
<div style="width: 70%;margin:0 auto;text-align: center; ">
	
	<div style="margin: 0 auto; height: 500px; border:1px solid #000;">
		<h2>登录</h2>
		<form id="login_post" style="margin: 20px auto;width: 300px;" action="/login/login" method='post'>
			<table class="ta" cellpadding="20" >
				<tr>
					<td>用户名：</td>
					<td><input type="text" regx="^\s*[A-Za-z0-9\u4e00-\u9fa5_-]{3,12}\s*$" name="username"></td>
				</tr>
				<tr>
					<td>密码：</td>
					<td><input type="password" regx="^[\@A-Za-z0-9\!#$\%\^\&amp;\*\.\~\-\_]{6,16}$" name="password"></td>
				</tr>
			</table>
			
			
		<button  href="javascript:;" class="g-recaptcha" data-sitekey="6LecBTcUAAAAACWzAWtw5olKjTZr2q9X8gMtnXZK"  data-callback='onSubmit' style="background: #222;font-size: 30px;color: #fff;width: 100px;height: 50px;margin: 0 auto;line-height: 50px;text-align: center;"> 登录</button>
		</form>
		<div style="max-width: 600px; margin: 0 auto;"><a href="/login/wjmm" style="float: left;margin-top:50px ">《《忘记密码</a><a href="/login/register"  style="float: right;margin-top:50px ">注册用户》》</a></div>
	</div>
</div>
<script type="text/javascript">
$('#login_post').submit(function(){

// function onSubmit() {
 $.ajax({
        url:$(this).attr('action'),
        data:$(this).serialize(),
        dataType:'json',
        type:'POST',
        success:function($data){
         if($data.code!=1){
             alert($data.msg);
         }else{
         	window.location.href='/index';
         }
        }
    }) 
 return false;
})
</script>

</body></html>