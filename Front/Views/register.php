<?php defined('SYSPATH_ZFC') or die('No direct script access.');?>
<!DOCTYPE html>
<html lang="en-US"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>游戏网</title>
</head>
<body class="body-bg"> 
<style type="text/css">
/*.l_co {border-left: 1px solid #000;}*/
.ta tr{margin-bottom: 20px; font-size: 20px; }
.ta tr td{line-height: 20px; min-width: 100px;}
</style>  
<div style="width: 80%;margin: 0 auto;border:1px solid #000;height: 50px;"><sapn style='float: right;'>张先生 ￥ 121211 退出</sapn></div>
<div style="width: 70%;margin:0 auto;text-align: center; ">
	
	<div style="margin: 0 auto; height: 500px; border:1px solid #000;">
		<h2>注册</h2>
		<form style="margin: 20px auto;width: 300px;" id='reg_post' action="/login/reg_post" method='post'>
			<table class="ta" cellpadding="20" border="1">
				<tr>
					<td>用户名：</td>
					<td><input type="text" regx="^\s*[A-Za-z0-9\u4e00-\u9fa5_-]{3,12}\s*$" name="username">
					<div id='is_2' style="height: 10px; color: #f00; font-size: 15px;"></div></td>
				</tr>
                <tr>
                    <td>手机号：</td>
                    <td><input type="text" name="tel">
                    <div id='is_4'  style="height: 10px; color: #f00; font-size: 15px;"></div></td>
                </tr>
				<tr>
					<td>密码：</td>
					<td><input type="password" regx="^[\@A-Za-z0-9\!#$\%\^\&amp;\*\.\~\-\_]{6,16}$" name="password">
					<div id='is_3'  style="height: 10px; color: #f00; font-size: 15px;"></div></td>
				</tr>
				<tr>
					<td>确认密码：</td>
					<td><input type="password" regx="^[\@A-Za-z0-9\!#$\%\^\&amp;\*\.\~\-\_]{6,16}$" name="rpassword">
						<div id='is_3'  style="height: 10px; color: #f00; font-size: 15px;"></div>
					</td>
				</tr>
				<!-- <tr>
					<td>注册邮箱：</td>
					<td><input type="text" regx="^(0?1[3|4|5|7|8][0-9]\d{8})$"  name="email">
						<sanp id='is_email'></sanp>
					</td>
				</tr>
                <tr>
                    <td>邮箱验证码：</td>
                    <td><input type="text"  name="code"></td>
                    <td><a id='is_timeff'  href="javascript:;">获取验证码</a></td>
                </tr> -->
			</table>
			
			
		<input type="submit"  href="javascript:;"  style="background: #222;font-size: 30px;color: #fff;width: 100px;height: 50px;margin: 0 auto;line-height: 50px;text-align: center;" value='决定'> 
		</form>
		
	</div>
</div>
<script  type="text/javascript" src='/public/index?js=jquery.min.js'></script>
<script type="text/javascript">
    $(function(){
        $('#reg_post').submit(function(){
             $.ajax({
                    url:$(this).attr('action')+'?r_u_d=<?php echo empty($_GET['r_u_d'])?'':$_GET['r_u_d']; ?>',
                    data:$(this).serialize(),
                    dataType:'json',
                    type:'POST',
                    success:function($data){
                     if($data.code!=1){
                        if($data.code==10||$data.code==11){  
                         alert($data.msg);
                        }else{
                           $('#is_'+$data.code).html($data.msg); 
                        }
                        
                     }else{
                     	window.location.href='/index';
                     }
                    }
                }) 
             return false;
        })
    })
// $(function(){
// 	 var time_s=60;
//      var ff_cv=0;
//     $('#is_timeff').click(function(){
//         ff=1;
//         $('input[name="email"]').blur();
//         $('input[name="vcode"]').blur();
//          var email=$('input[name="email"]').val();
//         if($('#emailMsg').text().length>2&&$('#checkCodeMsg').text().length>2){
//             return false;
//         }
//            if(time_s==60){
//              $.ajax({
//                     url:'/login/fa_email',
//                     data:{email:email},
//                     dataType:'json',
//                     success:function($data){
//                     	if($data.code==1){
//                          ff_cv=1;
//                          time_v($('#is_timeff'));
//                     	}else{
//                     		$('#is_email').html($data.msg);
//                     	}
//                     }
//                 }) 
//        }
//     })

//     function time_v(o) {
//          console.log(time_s);
//         if (time_s == 0) {
//             // o.removeAttribute("disabled");          
//             o.text("重新获取验证码");
//             time_s = 60;
//         } else {
//             // o.setAttribute("disabled", true);
//             o.text("重新发送(" + time_s + ")");
//             time_s--;
//             // console.log(time_s);
//             setTimeout(function() {
//                 time_v(o)
//             },
//             1000)
//         }
//     }

// })

</script>
<script type="text/javascript">
</script>
</body></html>