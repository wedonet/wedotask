<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="mainlogin"&gt;
	&lt;div class="crumblogin"&gt;
		&lt;ul&gt;
			&lt;li class="pos"&gt;&lt;a href="/"&gt;{$webname}&lt;/a&gt;&lt;/li&gt;
			&lt;li&gt;会员登录&lt;/li&gt;
		&lt;/ul&gt;
	&lt;/div&gt;

	&lt;div class="loginblock"&gt;

		&lt;div class="th"&gt;会员登录&lt;/div&gt;

	
		&lt;form method="post" name="myform" id="myform" action="{$action}"&gt;

		&lt;table cellspacing="0" width="90%" align="center"&gt;
		&lt;tr&gt;&lt;th colspan="2"&gt;&lt;/th&gt;&lt;/tr&gt;
		&lt;tr&gt;
		&lt;td class="label"&gt;用户名&lt;/td&gt;
		&lt;td&gt;
			&lt;input name="u_name" id="u_name" size="20" maxlength="30" value="" tabindex="1" /&gt;
			&lt;a href="reg.php" style="display:none"&gt;注册用户&lt;/a&gt;
		&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td class="label"&gt;登录密码&lt;/td&gt;
		&lt;td&gt;
			&lt;input name="u_pass" type="password" size="20" maxlength="20" value="" tabindex="2" /&gt;
			&lt;a href="javascript:void(0)" style="display:none"&gt;忘记密码!&lt;/a&gt;
		&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td class="label"&gt;验证码&lt;/td&gt;
		&lt;td&gt;
			&lt;input name="codestr" size="4" maxlength="4"  class="j_codestr" tabindex="3" /&gt;
			&amp;nbsp;&lt;span&gt;点击输入框获取验证码&lt;/span&gt;
		&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td&gt;&lt;/td&gt;
		&lt;td&gt;
			&lt;input type="checkbox" name="savecookie" id="savecookie" value="1" /&gt;
			自动登录
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
		$("#user_name").focus();
		
	})	
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;link rel="stylesheet" href="../_css/login.css?{$timestamp}" type="text/css" /&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$(":input.j_codestr").getcode();	//验证码
})	
//--&gt;
&lt;/script&gt;</css><ajaxlogin readme="ajaxlogin">&lt;div class="chatlogin" id="chatlogin"&gt;&#13;
	&lt;div class="p"&gt;&#13;
		您还没有登录, 请登录后聊天&#13;
	&lt;/div&gt;&#13;
	&lt;hr /&gt;&#13;
	&lt;div class="l"&gt;&#13;
		&lt;ul&gt;&#13;
			&lt;li&gt;&lt;a href="/login.asp?act=login"&gt;登录&lt;/li&gt;&#13;
			&lt;li&gt;&lt;a href="javascript:void(0)" onclick="chatcancel()"&gt;取消&lt;/a&gt;&lt;/li&gt;&#13;
		&lt;/ul&gt;&#13;
	&lt;/div&gt;&#13;
&lt;/div&gt;</ajaxlogin><formajaxlogin readme="formajaxlogin">&lt;div class="pxmiddle"&gt;
	&lt;div class="th"&gt;用户登录&lt;/div&gt;

	&lt;form method="post" name="myform" id="formlogin" action="/login.asp?act=chkloginajax"&gt;

	&lt;table cellspacing="0" cellpadding="0" border="0" class="table2" width="80%" align="center"&gt;

	&lt;tr&gt;
	&lt;td&gt;用户名称:&lt;/td&gt;
	&lt;td&gt;&lt;input name="user_name" id="user_name" size="20" maxlength="30" value="" tabindex="1" /&gt;&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
	&lt;td&gt;登录密码:&lt;/td&gt;
	&lt;td&gt;&lt;input name="user_pass" type="password" size="20" maxlength="20" value="" tabindex="2" /&gt; &amp;nbsp;&lt;a href="/login.asp?act=bymail"&gt;忘记密码!&lt;/a&gt;&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
	&lt;td&gt;验证码:&lt;/td&gt;
	&lt;td&gt;&lt;input name="codestr" size="4" maxlength="4" class="j_codestr" tabindex="3" id="j_codestr" /&gt;&amp;nbsp;&lt;span&gt;点击输入框获取验证码&lt;/span&gt;&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
	&lt;td&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td&gt;&lt;input type="checkbox" name="savecookie" value="1" tabindex="4" checked="checked" /&gt; 七天内自动登录&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
	&lt;td&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td&gt;&lt;input name="login" class="submit" type="submit" value=" 登 录 " onclick="j_repost('formlogin')" /&gt;&lt;/td&gt;
	&lt;/tr&gt;

	&lt;/table&gt;

	&lt;/form&gt;			

	&lt;div class="tip1" style="margin:20px 40px;"&gt;
		&lt;dl&gt;
		&lt;dt&gt;提示&lt;/dt&gt;
		&lt;dd&gt;如果您还不是酷联网会员, &lt;a href="/login.asp"&gt;点击这里注册&lt;/a&gt;&lt;/dd&gt;
		&lt;/dl&gt;
	&lt;/div&gt;
&lt;/div&gt;</formajaxlogin></xml>
