<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="mainlogin"&gt;
	&lt;div class="crumblogin"&gt;
		&lt;ul&gt;
			&lt;li class="pos"&gt;&lt;a href="/"&gt;{$webname}&lt;/a&gt;&lt;/li&gt;
			&lt;li&gt;用户注册&lt;/li&gt;
		&lt;/ul&gt;
	&lt;/div&gt;

	&lt;!-- 选择用户 --&gt;
	&lt;div class="selectusertype tab1"&gt;
		&lt;ul&gt;
			&lt;li class="person"&gt;&lt;a href="?utype=person"&gt;用户注册&lt;/a&gt;&lt;/li&gt;
			&lt;li class="company" style="display:none"&gt;&lt;a href="?utype=company"&gt;商家注册&lt;/a&gt;&lt;/li&gt;
		&lt;/ul&gt;
		&lt;div class="clear"&gt;&lt;/div&gt;
	&lt;/div&gt;

	&lt;div class="loginblock reg"&gt;
		&lt;p&gt;&lt;/p&gt;
		&lt;form name="myform" id="myform" action="{$action}" method="post" class="regform"&gt;
		&lt;table cellspacing="0" width="90%" align="center"&gt;
			&lt;tr&gt;
				&lt;td class="labal"&gt;手机&lt;/td&gt;
				&lt;td&gt;
					&lt;input name="u_mobile" id="u_mobile" size="20" maxlength="50" class="inp1" /&gt;
					请正确填写您的手机号, 以便及时确认预订信息
					&lt;div&gt;&amp;nbsp;&lt;/div&gt;
				&lt;/td&gt;			
			&lt;/tr&gt;	

			&lt;tr&gt;
				&lt;td class="labal"&gt;邮箱&lt;/td&gt;
				&lt;td&gt;
					&lt;input name="u_mail" id="u_mail" size="20" maxlength="50" class="inp1" /&gt;&lt;span id="j_u_mail"&gt;&lt;/span&gt;
					找回密码用
					&lt;div&gt;&amp;nbsp;&lt;/div&gt;
				&lt;/td&gt;			
			&lt;/tr&gt;	

			&lt;tr&gt;
				&lt;td class="labal"&gt;密码&lt;/td&gt;
				&lt;td&gt;
					&lt;input type="password" maxlength="16" size="20" name="u_pass" id="u_pass" class="inp1" /&gt; 
					6-20字符,由字母,数字组成
					&lt;/td&gt;			
			&lt;/tr&gt;

			&lt;tr&gt;
				&lt;td class="labal"&gt;确认密码&lt;/td&gt;
				&lt;td&gt;
					&lt;input type="password" maxlength="16" size="20" name="u_pass2" id="u_pass2" class="inp1" /&gt; 
					请重新输入一次密码
				&lt;/td&gt;			
			&lt;/tr&gt;


			&lt;tr&gt;
				&lt;td class="labal"&gt;验证码&lt;/td&gt;
				&lt;td&gt;
					&lt;input name="codestr" size="4" maxlength="4" class="j_codestr inp1" /&gt; &lt;span&gt;点击输入框获取验证码&lt;/span&gt;
					&lt;div&gt;&amp;nbsp;&lt;/div&gt;
				&lt;/td&gt;			
			&lt;/tr&gt;	
		&lt;/table&gt;

		&lt;div style="padding-top:10px;"&gt;您的电话, 手机,邮箱不会显示在网站上.&lt;/div&gt;

		&lt;div class="operate"&gt;&lt;input type="submit" id="submit" value="同意以下协议, 进入下一步" onclick="j_post('myform')" /&gt;&lt;/div&gt;

		




		&lt;/form&gt;

		&lt;div class="agreement border1"&gt;
			&lt;div class="p"&gt;{$agreement}&lt;/div&gt;
		&lt;/div&gt;

	&lt;/div&gt;
&lt;/div&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$(".tab1 .{$utype}").addClass("on");
})	
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;link rel="stylesheet" href="../_css/login.css?{$timestamp}" type="text/css" /&gt;
&lt;script type="text/javascript" src="../_js/reg.js{$timestamp}"&gt;&lt;/script&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$(":input.j_codestr").getcode();	//验证码
	$("#myform").holdfault(); //fouse 后移除错误提示
})	
//--&gt;
&lt;/script&gt;</css><agreement readme="agreement">注册说明</agreement><mailtitle readme="注册成功邮件标题">注册成功邮件标题</mailtitle><mailbody readme="注册成功邮件内容">注册成功邮件内容</mailbody></xml>
