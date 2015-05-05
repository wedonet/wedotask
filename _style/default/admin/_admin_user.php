<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="navoperate"&gt;
	&lt;ul&gt;
		&lt;li&gt;&lt;a href="?act=creat"&gt;添加用户&lt;/a&gt;&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;table class="table1 j_list" cellspacing="0"&gt;
  &lt;tr&gt;
	&lt;th width="40"&gt;用户ID&lt;/th&gt;
	&lt;th width="90"&gt;用户名&lt;/th&gt;
	&lt;th width="90"&gt;昵称&lt;/th&gt;
	&lt;th width="120"&gt;真实姓名&lt;/th&gt;
	&lt;th width="*"&gt;邮箱&lt;/th&gt;
	&lt;th width="60"&gt;用户组&lt;/th&gt;
	&lt;th width="80"&gt;部门&lt;/th&gt;
	&lt;th width="80"&gt;注册时间&lt;/th&gt;
	&lt;th width="30"&gt;审核&lt;/th&gt;
	&lt;th width="30"&gt;锁定&lt;/th&gt;
	&lt;th width="30" style="display:none"&gt;激活&lt;/th&gt;
	&lt;th width="240"&gt;操作&lt;/th&gt;
  &lt;/tr&gt;
  {$li}
&lt;/table&gt;

{$pagelist}
&lt;script type="text/javascript"&gt;
&lt;!--
	$("dl.seldo").seldo();
	{$js}
//--&gt;
&lt;/script&gt;</main><li readme="li">&lt;tr&gt;
&lt;td&gt;{$id}&lt;/td&gt;
&lt;td&gt;{$u_name}&lt;/td&gt;
&lt;td&gt;{$u_nick}&lt;/td&gt;
&lt;td&gt;{$u_fullname}&lt;/td&gt;
&lt;td&gt;{$u_mail}&lt;/td&gt;
&lt;td&gt;{$u_gname}&lt;/td&gt;
&lt;td&gt;{$u_dname}&lt;/td&gt;
&lt;td&gt;{$u_regtime_dateformat1}&lt;/td&gt;
&lt;td class="j_tdright{$ispass}"&gt;&lt;/td&gt;
&lt;td class="j_tdright{$islock}"&gt;&lt;/td&gt;
&lt;td class="j_tdright{$u_confiromed}" style="display:none"&gt;&lt;/td&gt;
&lt;td&gt;
	&lt;a href="?act=edit&amp;amp;id={$id}"&gt;编辑&lt;/a&gt; &amp;nbsp; 
	&lt;a href="?act=ispass&amp;amp;id={$id}" onclick="return confirm('审核通过ID={$id}的用户')"&gt;通过&lt;/a&gt;//&lt;a href="?act=unpass&amp;amp;id={$id}" onclick="return confirm('未审核通过ID={$id}的用户')"&gt;未过&lt;/a&gt; &amp;nbsp;
	&lt;a href="?act=islock&amp;amp;id={$id}" onclick="return confirm('锁定ID={$id}的用户')"&gt;锁定&lt;/a&gt;//&lt;a href="?act=unlock&amp;amp;id={$id}" onclick="return confirm('解锁ID={$id}的用户')"&gt;解锁&lt;/a&gt; &amp;nbsp;
	&lt;a href="?act=deluser&amp;amp;id={$id}" class="alarm j_del" title="删除用户 id={$id} 手机={$u_mobile}"&gt;删除&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;</li><userinfo readme="userinfo">&lt;div class="pxmiddle"&gt;&#13;
	&lt;div class="th"&gt;用户资料&lt;/div&gt;&#13;
	&lt;div class="ac"&gt;&#13;
		&lt;table class="table1" cellspacing="0" &gt;&#13;
			&lt;tr&gt;&#13;
				&lt;td&gt;用户名&lt;/td&gt;&#13;
				&lt;td&gt;{$user_name}&lt;/td&gt;&#13;
			&lt;/tr&gt;&#13;
&#13;
			&lt;tr&gt;&#13;
				&lt;td&gt;称呼&lt;/td&gt;&#13;
				&lt;td&gt;{$user_nickname}&lt;/td&gt;&#13;
			&lt;/tr&gt;&#13;
&#13;
			&lt;tr&gt;&#13;
				&lt;td&gt;联系电话&lt;/td&gt;&#13;
				&lt;td&gt;{$user_phone}&lt;/td&gt;&#13;
			&lt;/tr&gt;&#13;
&#13;
			&lt;tr&gt;&#13;
				&lt;td&gt;手机&lt;/td&gt;&#13;
				&lt;td&gt;{$user_mobile}&lt;/td&gt;&#13;
			&lt;/tr&gt;&#13;
&#13;
			&lt;tr&gt;&#13;
				&lt;td&gt;电子邮箱&lt;/td&gt;&#13;
				&lt;td&gt;{$user_mail}&lt;/td&gt;&#13;
			&lt;/tr&gt;&#13;
		&lt;/table&gt;&#13;
		&#13;
	&lt;/div&gt;&#13;
&lt;/div&gt;</userinfo><formpass readme="formpass">&lt;div class="pxsmall"&gt;
&lt;div class="th"&gt;重设密码&lt;/div&gt;
&lt;form method="post" id="formad" action="{$action}" class="ac"&gt;
	&lt;table cellspacing="0" class="table0"&gt;
		&lt;tr&gt;
			&lt;td&gt;用户名:&lt;/td&gt;
			&lt;td&gt;{$u_name}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;称呼:&lt;/td&gt;
			&lt;td&gt;{$u_nick}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;新密码:&lt;/td&gt;
			&lt;td&gt;&lt;input type="password" name="u_pass1"&gt;&lt;/td&gt;
		&lt;/tr&gt;
		&lt;tr&gt;
			&lt;td&gt;确认新密码:&lt;br /&gt;&lt;u&gt;请再输入一次&lt;/u&gt;&lt;/td&gt;
			&lt;td&gt;&lt;input type="password" name="u_pass2"&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;&lt;/td&gt;
			&lt;td&gt;&lt;input type="submit" name="save" value="提 交" onclick="j_repost('formad')" class="submit1"&gt;&lt;/td&gt;
		&lt;/tr&gt;
	&lt;/table&gt;

&lt;/form&gt;
&lt;/div&gt;</formpass><myform readme="myform">&lt;form method="post" action="{$action}" id="myform"&gt;
	&lt;table class="table1" cellspacing="0" &gt;

		&lt;tr&gt;
			&lt;td width="108"&gt;用户组&lt;/td&gt;
			&lt;td&gt;
				&lt;select name="u_gic" id="u_gic"&gt;
					&lt;option value=""&gt;&lt;/option&gt;
					{$optiongroup}
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;
	
		&lt;tr&gt;
			&lt;td&gt;部门&lt;/td&gt;
			&lt;td&gt;
				&lt;select name="u_dic" id="u_dic"&gt;
					&lt;option value=""&gt;&lt;/option&gt;
					{$optiondepartment}
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;
		
		&lt;tr&gt;
			&lt;td&gt;用户名&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_name" id="u_name" value="{$u_name}" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;真实姓名&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="u_fullname" id="u_fullname" value="{$u_fullname}" size="20" /&gt;&lt;/td&gt;
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
			&lt;td&gt;&lt;input type="password" name="u_pass" id="u_pass" value="" size="20" /&gt; &amp;nbsp;&lt;span id="divpass" style="display:none"&gt;不修改密码请不要填写&lt;/span&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;确认密码&lt;/td&gt;
			&lt;td&gt;&lt;input type="password" name="u_pass2" id="u_pass2" value="" size="20" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;头像&lt;/td&gt;
			&lt;td&gt;&lt;img src="{$u_face}" id="u_face_show" width="120" alt="" /&gt;
				&lt;input type="hidden"  name="u_face" id="u_face" value="{$u_face}" /&gt;
				&lt;div&gt;&lt;a href="{$selface}" class="j_open" &gt;选择图片&lt;/a&gt;&lt;/div&gt;
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
	$("#u_gic").val("{$u_gic}");
	$("#u_dic").val("{$u_dic}");


	{$js}
})
//--&gt;
&lt;/script&gt;</myform></xml>
