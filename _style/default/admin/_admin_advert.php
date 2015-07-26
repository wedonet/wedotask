<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="navoperate"&gt;
	&lt;ul&gt;
	&lt;li&gt;[&lt;a href="?act=creat"&gt;添加新广告&lt;/a&gt;]&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;table class="table1 j_list" cellspacing="0"&gt;
	&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="*"&gt;用户组名称&lt;/th&gt;
	&lt;th width="80"&gt;类型&lt;/th&gt;
	&lt;th width="150"&gt;会员列表&lt;/th&gt;
	&lt;th width="40"&gt;会员数&lt;/th&gt;
	&lt;th width="30"&gt;排序&lt;/th&gt;
	&lt;th width="30"&gt;使用&lt;/th&gt;
	&lt;th width="100"&gt;操作&lt;/th&gt;
	&lt;/tr&gt;
	{$li}
&lt;/table&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;&#13;
	&lt;td&gt;{$id}&lt;/td&gt;&#13;
	&lt;td&gt;{$title}&lt;/td&gt;&#13;
	&lt;td&gt;{$typename}&lt;/td&gt;&#13;
	&lt;td&gt;&lt;a href="admin_user.asp?act=userlist&amp;amp;gid={$id}"&gt;成员列表&lt;/a&gt;&lt;/td&gt;&#13;
	&lt;td&gt;{$countuser}&lt;/td&gt;&#13;
	&lt;td&gt;{$cls}&lt;/td&gt;&#13;
	&lt;td class="j_tdright{$isuse}"&gt;&amp;nbsp;&lt;/td&gt;&#13;
	&lt;td&gt;&#13;
		&lt;a href='?act=edit&amp;amp;id={$id}' class="j_open"&gt;编辑&lt;/a&gt; &#13;
		&lt;span class="unshow{$issys}"&gt; | &lt;a href='?act=del&amp;amp;id={$id}' class="j_delgroup j_del alarm" title="删除{$title}"&gt;删除&lt;/a&gt;&lt;/span&gt;&#13;
	&lt;/td&gt;&#13;
&lt;/tr&gt;</li><form readme="form">&lt;form method="post" action="{$action}" id="myform"&gt;
	&lt;table class="table0" cellspacing="1" &gt;
		&lt;tr&gt;
			&lt;td width="60"&gt;名称&lt;/td&gt;
			&lt;td width="*"&gt;&lt;input type="text" name="title" id="title" value="{$title}" size="20" class="inputa" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;说明&lt;/td&gt;
			&lt;td&gt;
				&lt;textarea rows="5" cols="60" name="readme"&gt;{$readme}&lt;/textarea&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;代码&lt;/td&gt;
			&lt;td&gt;
				&lt;textarea rows="5" cols="60" name="strcode"&gt;{$strcode}&lt;/textarea&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;地址&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="url" value="{$url}" class="inputa" /&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;图片1&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="img1" id="img1" value="{$img1}" size="60" /&gt; &lt;a href="{$selimg1}" class="j_open"&gt;上传&lt;/a&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;图片2&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="img2" id="img2" value="{$img2}" size="60" /&gt; &lt;a href="{$selimg2}" class="j_open"&gt;上传&lt;/a&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;Flash&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="flash" id="flash" value="{$flash}" size="60" /&gt; &lt;a href="{$selflash}" class="j_open"&gt;上传&lt;/a&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;排序(数字)&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="cls" id="cls" size="3" value="{$cls}" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;时间&lt;/td&gt;
			&lt;td&gt;开始:
				&lt;input type="text" name="time1" id="time1" value="{$time1}" size="12" /&gt; 结束:
				&lt;input type="text" name="time2" id="time2" value="{$time2}" size="12" /&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;使用&lt;/td&gt;
			&lt;td&gt;&lt;select name="isuse" id="isuse"&gt;
				&lt;option value="1"&gt;Yes&lt;/option&gt;
				&lt;option value="0"&gt;No&lt;/option&gt;
			&lt;/select&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;备注&lt;/td&gt;
			&lt;td&gt;&lt;textarea name="other" rows="4" cols="80"&gt;{$other}&lt;/textarea&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;&amp;nbsp;&lt;/td&gt;
			&lt;td&gt;&lt;input type="submit" name="submit" value="保存" class="submit1" onclick="j_repost('myform')" /&gt;&lt;/td&gt;
		&lt;/tr&gt;
	&lt;/table&gt;
&lt;/form&gt;


&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$("#isuse").val("{$isuse}");
})	
//--&gt;
&lt;/script&gt;</form></xml>
