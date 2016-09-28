<?xml version="1.0" encoding="utf-8"?>
<xml><toolbar readme="工具栏">&lt;div class="tasktoolbar"&gt;
	&lt;ul&gt;
		&lt;li&gt;部门：{$u_dname}&lt;/li&gt;
		&lt;li&gt;姓名：{$u_fullname}&lt;/li&gt;
		&lt;li&gt;&lt;a href="../service/login.php?act=loginout" class="j_open"&gt;退出&lt;/a&gt;&lt;/li&gt;
	&lt;/ul&gt;

	&lt;ul class="fright"&gt;		
		&lt;li&gt;新任务(&lt;span class="radius1" id="c_new"&gt;0&lt;/span&gt;)&lt;/li&gt;
		&lt;li&gt;&lt;a href="index.php?showtype=release"&gt;我发的任务(&lt;span class="radius1" id="c_release"&gt;0&lt;/span&gt;)&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="index.php?showtype=receive"&gt;我执行的任务(&lt;span class="radius1" id="c_receive"&gt;0&lt;/span&gt;)&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="index.php?showtype=check"&gt;我验收的任务(&lt;span class="radius1" id="c_check"&gt;0&lt;/span&gt;)&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="index.php?showtype=noshow"&gt;我的草稿&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="index.php"&gt;我的全部任务&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="list.php"&gt;全部任务&lt;/a&gt;&lt;/li&gt;
		&lt;li style="margin:0 0 0 40px"&gt;&lt;a href="../_user/pass.php" class="j_open"&gt;修改密码&lt;/a&gt;&lt;/li&gt;
		&lt;li style="margin:0 10px 0 10px"&gt;&lt;a href="/task/setting.php"&gt;参数设置&lt;/a&gt;&lt;/li&gt;
	&lt;/ul&gt;



	&lt;div class="clear"&gt;&lt;/div&gt;
&lt;/div&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		/*更新任务统计*/
		var href = "ajax/message.php";
		$.getScript(href, function(){
			if(  "0" != $("#c_new").text() &amp;&amp; !$("#c_new").hasClass("havetask") ){
				$("#c_new").addClass("havetask");
			}
		});
		
		/*菜单选中*/
		$("#j_navtask").addClass("on");

	})
//--&gt;
&lt;/script&gt;</toolbar></xml>
