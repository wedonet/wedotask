<body><!--头部-->
<div class="main">
	<div class="tasktoolbar">
	<ul>
		<li>部门：<?php echo $j['user']['u_dname']?></li>
		<li>姓名：<?php echo $j['user']['u_fullname']?></li>
		<li><a href="../service/login.php?act=loginout" class="j_open">退出</a></li>
	</ul>

	<ul class="fright">		
		<li>新任务(<span class="radius1" id="c_new">0</span>)</li>
		<li><a href="index.php?showtype=release">我发的任务(<span class="radius1" id="c_release">0</span>)</a></li>
		<li><a href="index.php?showtype=receive">我执行的任务(<span class="radius1" id="c_receive">0</span>)</a></li>
		<li><a href="index.php?showtype=check">我验收的任务(<span class="radius1" id="c_check">0</span>)</a></li>
		<li><a href="index.php?showtype=noshow">我的草稿</a></li>
		<li><a href="index.php">我的全部任务</a></li>
		<li><a href="list.php">全部任务</a></li>
		<li style="margin:0 0 0 40px"><a href="../_user/pass.php" class="j_open">修改密码</a></li>
		<li style="margin:0 10px 0 10px"><a href="/task/setting.php">参数设置</a></li>
	</ul>



	<div class="clear"></div>
</div>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*更新任务统计*/
		var href = "ajax/message.php";
		$.getScript(href, function(){
			if(  "0" != $("#c_new").text() && !$("#c_new").hasClass("havetask") ){
				$("#c_new").addClass("havetask");
			}
		});
		
		/*菜单选中*/
		$("#j_navtask").addClass("on");

	})
//-->
</script>

<div class="menu">
	<ul>
		<li style="display:none"><a href="/task/" id="j_object">项目</a></li>
		<li><a href="/task/" id="j_navtask">任务管理</a></li>
		<li><a href="/log/" id="j_navlog">更新日志</a></li>
	</ul>
	<div class="clear"></div>
</div>

<div class="crumb">
	<ul>
		<li class="present">当前位置:</li>
		<li class="home"><a href="/">首 页</a></li>
  		<?php echo $j['crumb']?>
	</ul>
	<div class="clear"></div>
</div>