<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$crumb}

&lt;form method="post" action="{$action}" id="myform"&gt;
	&lt;table class="table1" cellspacing="0" &gt;

		&lt;tr&gt;
			&lt;td width="108"&gt;用户名&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_name" id="u_name" value="{$u_name}" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;称呼&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_nick" id="u_nick" value="{$u_nick}" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;联系电话&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_phone" id="u_phone" value="{$u_phone}" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;手机&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_mobile" id="u_mobile" value="{$u_mobile}" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;电子邮箱&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_mail" id="u_mail" value="{$u_mail}" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;密码&lt;/td&gt;
			&lt;td&gt;&lt;input type="password" name="u_pass" id="u_pass" value="{$u_pass}" size="20" /&gt; 不需要修改密码时请不要填写&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;确认密码&lt;/td&gt;
			&lt;td&gt;&lt;input type="password" name="u_pass2" id="u_pass2" value="{$u_pass}" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr style="display:none"&gt;
			&lt;td&gt;业务内容&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="checkbox" name="hashotel" id="hashotel" value="1" class="vmiddle" disabled="disabled" /&gt; 酒店 &amp;nbsp; 
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;&amp;nbsp;&lt;/td&gt;
			&lt;td&gt;&lt;input type="submit" value=" 提 交 " onclick="j_post('myform')" /&gt;&lt;/td&gt;
		&lt;/tr&gt;
	&lt;/table&gt;		
&lt;/form&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	checkradio("hashotel", "{$hashotel}");
})
//--&gt;
&lt;/script&gt;</main><css readme="css"/></xml>
