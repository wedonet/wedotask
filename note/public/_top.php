<?php
$j =& $GLOBALS['j'];




?>

<body><!--头部-->
<div class="main">
	<div class="tasktoolbar">
	<ul>
		<li>部门：<?php echo $j['user']['u_dname']?></li>
		<li>姓名：<?php echo $j['user']['u_fullname']?></li>
		<li><a href="../service/login.php?act=loginout" class="j_open">退出</a></li>
	</ul>

	<ul class="fright">		

		<li><a href="index.php?taskstatus[]=New&amp;showtype=receive">New(<span class="radius1" id="c_New">0</span>)</a></li>
		<li><a href="index.php?taskstatus[]=Plan&amp;showtype=receive">Plan(<span class="radius1" id="c_Plan">0</span>)</a></li>

		<li><a href="index.php?taskstatus[]=Doing&amp;showtype=receive">Doing(<span class="radius1" id="c_Doing">0</span>)</a></li>
		<li style="display:none"><a href="index.php?taskstatus[]=Done&amp;showtype=receive">Done(<span class="radius1" id="c_Done">0</span>)</a></li>

		<li><a href="index.php?taskstatus[]=Delay&amp;showtype=receive">Delay(<span class="radius1" id="c_Delay">0</span>)</a></li>
		<li style="display:none"><a href="index.php?taskstatus[]=Cancel&amp;showtype=receive">Cancel(<span class="radius1" id="c_Cancel">0</span>)</a></li>
		<li style="display:none"><a href="index.php?taskstatus[]=Over&amp;showtype=receive">Over(<span class="radius1" id="c_Over">0</span>)</a></li>
		<li><a href="index.php?showtype=receive">All</a></li>


		<li style="margin:0 0 0 40px"><a href="../_user/pass.php" class="j_open">修改密码</a> &nbsp; </li>

	</ul>



	<div class="clear"></div>
</div>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		var href = '/api/note/public/top_.php';
		$.getJSON(href, function(json){
			for(var o in json){
				//alert(json[o].mystatus);
				$('#c_'+json[o].mystatus).text(json[o].mycount);
			}
		})

		/*菜单选中*/
		$("#j_navnote").addClass("on");

	})
//-->
</script>

<div class="menu">
	<ul>
		<li style="display:none"><a href="/task/" id="j_object">项目</a></li>
		<li><a href="/task/" id="j_navtask">任务管理</a></li>
		<li><a href="/log/" id="j_navlog">更新日志</a></li>


		<?php
		if( strpos( ',1,63,65,59,67,91', ','.$j['user']['id'].',')>-1) {
			echo '<li><a href="/note/" id="j_navnote">我的便签</a></li>';
		}

		
		?>


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