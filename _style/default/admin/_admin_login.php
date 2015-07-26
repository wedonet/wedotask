<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="mainlogin"&gt;
	&lt;div class="crumblogin"&gt;
		&lt;ul&gt;
			&lt;li class="pos"&gt;&lt;a href="/"&gt;{$webname}&lt;/a&gt;&lt;/li&gt;
			&lt;li&gt;管理员登录&lt;/li&gt;
		&lt;/ul&gt;
	&lt;/div&gt;

	&lt;div class="loginblock"&gt;

		&lt;div class="th"&gt;管理员登录&lt;/div&gt;

	
		&lt;form method="post" name="myform" id="myform" action="{$action}"&gt;

		&lt;table cellspacing="0" width="90%" align="center"&gt;
		&lt;tr&gt;&lt;th colspan="2"&gt;&lt;/th&gt;&lt;/tr&gt;
		&lt;tr&gt;
		&lt;td class="label"&gt;用户名&lt;/td&gt;
		&lt;td&gt;
			&lt;input name="u_name" id="u_name" size="20" maxlength="30" value="{$u_name}" disabled="disabled" /&gt;
			
		&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td class="label"&gt;管理密码&lt;/td&gt;
		&lt;td&gt;
			&lt;input name="u_pass" id="u_pass" type="password" size="20" maxlength="20" value="" tabindex="1" /&gt;
			
		&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td class="label"&gt;验证码&lt;/td&gt;
		&lt;td&gt;
			&lt;input name="codestr" size="4" maxlength="4"  class="j_codestr" tabindex="2" /&gt;
			&amp;nbsp;&lt;span&gt;点击输入框获取验证码&lt;/span&gt;
		&lt;/td&gt;
		&lt;/tr&gt;



		&lt;tr&gt;
		&lt;td&gt;&lt;/td&gt;
		&lt;td&gt;
			&lt;input name="login" class="submit" type="submit" value=" 提 交 " onclick="j_post('myform')" /&gt;&lt;/td&gt;
		&lt;/tr&gt;	
		
		&lt;/table&gt;	
		
		


		&lt;/form&gt;		
	&lt;/div&gt;

&lt;/div&gt;


&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		$("#u_pass").focus();
		
	})	
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;link rel="stylesheet" href="../_css/login.css?{$timestamp}" type="text/css" /&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$(":input.j_codestr").getcode();	//验证码
})	
//--&gt;
&lt;/script&gt;</css></xml>
