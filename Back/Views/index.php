<?php defined('SYSPATH_ZFC') or die('No direct script access.');?>
<?php  require_once('head.php') ?>
	<h2>算数</h2>
	<div style="margin: 0 auto; height: 500px;">
		<form id='wujicc' action="<?php echo $user_post;?>" method='post'>
			<div style="margin: 0 auto;width: 400px;margin-top:50px; "><sanp style='font-size: 20px'>上一轮答案：</sanp><sanp style='font-size: 30px;'><?php echo str_replace('/','÷',str_replace('*','×',$arr[1]['daan']))  ;?></sanp></div>
			<div style="line-height: 20px;text-indent:2em;margin: 20px 0;">
			游戏规则：2小时一轮，每一轮随机生成五个数随机加减乘除，而加减乘除每一个只使用一次，写出你的答案四舍五入保留两位小数，然后按决定。</div>
			<div style="margin: 0 auto;width: 450px"><sanp style='font-size: 20px'>这一轮随机生成为：</sanp><span style='font-size: 30px;'><?php $shuzi=explode(',',$arr[0]['co']); foreach($shuzi as $v){ echo $v.' ';} ;?></span></div>
			<div style="width: 300px;margin: 20px auto;">
			<sanp style='font-size: 20px;'>你的答案：</sanp><input style="height: 40px; font-size: 30px;width: 100px;" type="text" name="wjs">
			</div>
			<div style="width: 300px;margin: 20px auto;">
			<sanp style='font-size: 20px;'>多少币：</sanp><input style="height: 40px; font-size: 30px;width: 100px;" type="text" name="num">
			</div>
			<div href="javascript:;" onclick="order_post()" style="background: #222;font-size: 30px;color: #fff;width: 100px;height: 50px;margin: 0 auto;line-height: 50px;text-align: center;">决定</div>
		</form>
	</div>
	<script type="text/javascript">
		function order_post(){
				$.ajax({
					url:$('#wujicc').attr('action'),
			        data:$('#wujicc').serialize(),
			        dataType:'json',
			        type:'POST',
			        success:function($data){
			          alert($data.msg);
			          window.location.reload();
	        	}
			})
		}
	</script>
<?php  require_once('footer.php') ;?>