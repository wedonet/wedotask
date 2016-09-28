<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="navoperate"&gt;
	&lt;ul&gt;
		&lt;li&gt;&lt;a href="?act=creat" class="j_open"&gt;添加新管理员&lt;/a&gt;&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;
&lt;table cellspacing="0" class="table1 j_list"&gt;
&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="150"&gt;用户名&lt;/th&gt;
	&lt;th width="150"&gt;昵称&lt;/th&gt;
	&lt;th&gt;用户组&lt;/th&gt;
	&lt;th&gt;管理员类型&lt;/th&gt;
	&lt;th width="160"&gt;操作&lt;/th&gt;
&lt;/tr&gt;
{$li}
&lt;/table&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$u_name}&lt;/td&gt;
	&lt;td&gt;{$u_nick}&lt;/td&gt;
	&lt;td&gt;{$u_gname}&lt;/td&gt;
	&lt;td&gt;{$a_gname}&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="?act=edit&amp;amp;id={$id}" class="j_open"&gt;修改&lt;/a&gt; &amp;nbsp; 
		&lt;a href='?act=del&amp;amp;id={$id}' title="删除:{$u_name}" class="j_del alarm"&gt;删除&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li><form readme="form">&lt;div class="pxmiddle"&gt;
&lt;div class="th"&gt;{$th}&lt;/div&gt;
&lt;form method="post" id="formad" action="{$action}" class="ac"&gt;
	&lt;table cellspacing="0" class="table1"&gt;
		&lt;tr&gt;
			&lt;td&gt;管理员用户名:&lt;br /&gt;&lt;u&gt;必须是已注册用户名&lt;/u&gt;&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_name" value="{$u_name}" &gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;管理员类型:&lt;br /&gt;&lt;/td&gt;
			&lt;td&gt;
				&lt;select name="a_gic" id="a_gic"&gt;
				&lt;option value=""&gt;选择管理员类型&lt;/option&gt;
				{$optiongroupadmin}
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;管理员密码:&lt;span id="divpass" style="display:none"&gt;&lt;br /&gt;如果不修改密码请不要填写&lt;/span&gt;&lt;/td&gt;
			&lt;td&gt;&lt;input type="password" name="u_pass"&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;管理员密码:&lt;br /&gt;&lt;u&gt;请再输入一次&lt;/u&gt;&lt;/td&gt;
			&lt;td&gt;&lt;input type="password" name="u_pass2"&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;&lt;/td&gt;
			&lt;td&gt;&lt;input type="submit" name="save" value="提 交" onclick="j_repost('formad')" class="submit1"&gt;&lt;/td&gt;
		&lt;/tr&gt;
	&lt;/table&gt;

&lt;/form&gt;
&lt;/div&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$("#a_gic").val("{$a_gic}");
})	
//--&gt;
&lt;/script&gt;</form><formgid readme="formgid">&lt;div class="pxsmall"&gt;&#13;
&lt;div class="th"&gt;管理员身份&lt;/div&gt;&#13;
&lt;form method="post" id="formad" action="{$action}" class="ac"&gt;&#13;
	&lt;table cellspacing="0" class="table0"&gt;&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;管理员用户名:&lt;/td&gt;&#13;
			&lt;td&gt;{$user_name}&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;管理员类型:&lt;br /&gt;&lt;/td&gt;&#13;
			&lt;td&gt;&#13;
				&lt;select name="gid" id="gid"&gt;&#13;
				&lt;option value=""&gt;选择管理员类型&lt;/option&gt;&#13;
				{$optiongroupadmin}&#13;
				&lt;/select&gt;&#13;
			&lt;/td&gt;&#13;
		&lt;/tr&gt;	&#13;
&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;&lt;/td&gt;&#13;
			&lt;td&gt;&lt;input type="submit" name="save" value="提 交" onclick="j_repost('formad')" class="submit1"&gt;&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
	&lt;/table&gt;&#13;
&#13;
&lt;/form&gt;&#13;
&lt;/div&gt;&#13;
&#13;
&lt;script type="text/javascript"&gt;&#13;
&lt;!--&#13;
$(document).ready(function(){&#13;
	$("#gid").val("{$gid}");&#13;
})	&#13;
//--&gt;&#13;
&lt;/script&gt;</formgid><formpass readme="formpass">&lt;div class="pxsmall"&gt;&#13;
&lt;div class="th"&gt;重设密码&lt;/div&gt;&#13;
&lt;form method="post" id="formad" action="{$action}" class="ac"&gt;&#13;
	&lt;table cellspacing="0" class="table0"&gt;&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;管理员用户名:&lt;/td&gt;&#13;
			&lt;td&gt;{$user_name}&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;新密码:&lt;/td&gt;&#13;
			&lt;td&gt;&lt;input type="password" name="user_pass1"&gt;&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;确认新密码:&lt;br /&gt;&lt;u&gt;请再输入一次&lt;/u&gt;&lt;/td&gt;&#13;
			&lt;td&gt;&lt;input type="password" name="user_pass2"&gt;&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;&lt;/td&gt;&#13;
			&lt;td&gt;&lt;input type="submit" name="save" value="提 交" onclick="j_repost('formad')" class="submit1"&gt;&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
	&lt;/table&gt;&#13;
&#13;
&lt;/form&gt;&#13;
&lt;/div&gt;</formpass></xml>
