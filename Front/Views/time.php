<?php defined('SYSPATH_ZFC') or die('No direct script access.');?>
<?php  require_once('head.php') ?>
	<h2>算数</h2>
	<div style="margin: 0 auto; height: 500px;">
		<form id='wujicc' action="<?php echo $user_post;?>" method='post'>
			<div style="line-height: 20px;text-indent:2em;margin: 20px 0;">
			游戏规则：2小时一轮，每一轮随机生成五个数随机加减乘除，而加减乘除每一个只使用一次，写出你的答案四舍五入保留两位小数，然后按决定。</div>
			<div style="margin: 0 auto;width: 450px"><sanp style='font-size: 20px'>这一轮随机生成为：</sanp></div>
			<div style="width: 300px;margin: 20px auto;">
			<sanp style='font-size: 20px;'>现在毫秒：</sanp><sapn id='time' style="height: 40px; font-size: 30px;width: 100px;" >0</sapn>
			</div>
			<div style="width: 300px;margin: 20px auto;">
			<sanp style='font-size: 20px;'>你的时间：</sanp><input style="height: 40px; font-size: 30px;width: 100px;" type="text" name="time">
			</div>
			<div style="width: 300px;margin: 20px auto;">
			<sanp style='font-size: 20px;'>多少币：</sanp><input style="height: 40px; font-size: 30px;width: 100px;" type="text" name="num">
			</div>
			<div href="javascript:;" onclick="order_post()" style="background: #222;font-size: 30px;color: #fff;width: 100px;height: 50px;margin: 0 auto;line-height: 50px;text-align: center;">决定</div>
		</form>
		<div id='time_msg'></div>
	</div>
	<script type="text/javascript">
		$ff=<?php echo $time?>;
		time_da();
		function time_da(){
			setInterval(function() {
				$ff++;
				if($ff==<?php echo $system;?>){
					$ff=0;
				}
				$('#time').html($ff);
			},1);
		}

		function order_post(){
				$.ajax({
					url:$('#wujicc').attr('action'),
			        data:$('#wujicc').serialize(),
			        dataType:'json',
			        type:'POST',
			        success:function($data){
			        	$('#time_msg').html($data.msg);
			        	$('#money_i').html($data.money);
			          // alert($data.msg);
			          // window.location.reload();
	        	}
			})
		}
	</script>
<?php  require_once('footer.php') ;?>