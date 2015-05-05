<?xml version="1.0" encoding="utf-8"?>
<xml>
<main readme="main">&lt;div class="navoperate"&gt;
	&lt;ul&gt;
		&lt;li&gt;&lt;a href="?act=creat" class="j_open"&gt;添加新用户组&lt;/a&gt;&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;table class="table1 j_list" cellspacing="0"&gt;
	&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="140"&gt;编码&lt;/th&gt;
	&lt;th width="*"&gt;用户组名称&lt;/th&gt;
	&lt;th width="80"&gt;类型&lt;/th&gt;
	&lt;th width="150"&gt;会员列表&lt;/th&gt;
	&lt;th width="40"&gt;会员数&lt;/th&gt;
	&lt;th width="30"&gt;排序&lt;/th&gt;
	&lt;th width="30"&gt;使用&lt;/th&gt;
	&lt;th width="100"&gt;操作&lt;/th&gt;
	&lt;/tr&gt;
	{$li}
&lt;/table&gt;</main>
<li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$ic}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$typename}&lt;/td&gt;
	&lt;td&gt;&lt;a href="admin_user.php?act=userlist&amp;amp;gic={$ic}"&gt;成员列表&lt;/a&gt;&lt;/td&gt;
	&lt;td&gt;{$countuser}&lt;/td&gt;
	&lt;td&gt;{$cls}&lt;/td&gt;
	&lt;td class="j_tdright{$isuse}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td&gt;
		&lt;a href='?act=edit&amp;amp;id={$id}' class="j_open"&gt;编辑&lt;/a&gt; 
		&lt;span class="unshow{$issys}"&gt; | &lt;a href='?act=del&amp;amp;id={$id}' class="j_del alarm" title="删除{$title}"&gt;删除&lt;/a&gt;&lt;/span&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li>
<form readme="form">&lt;div class="pxmiddle"&gt;
&lt;div class="th"&gt;{$th}&lt;/div&gt;
	&lt;form method="post" action="{$action}" class="ac" id="formgroup"&gt;
	&lt;table class="table0" cellspacing="1" &gt;
		&lt;tr&gt;
			&lt;td width="60"&gt;名称&lt;/td&gt;
			&lt;td width="*"&gt;&lt;input type="text" name="title" id="title" value="{$title}" size="20"&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td width="60"&gt;编码&lt;/td&gt;
			&lt;td width="*"&gt;&lt;input type="text" name="ic" id="ic" value="{$ic}" size="20"&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;类型&lt;/td&gt;
			&lt;td&gt;
				&lt;select name="typeid" id="typeid"&gt;
					&lt;option value="0"&gt;用户组&lt;/option&gt;
					&lt;option value="1"&gt;管理组&lt;/option&gt;
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;排序(数字)&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="cls" id="cls" size="3" value="{$cls}"&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;是否使用&lt;/td&gt;
			&lt;td&gt;
			&lt;select name="isuse" id="isuse"&gt;
				&lt;option value="1"&gt;使用&lt;/option&gt;
				&lt;option value="0"&gt;停用&lt;/option&gt;
			&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;&amp;nbsp;&lt;/td&gt;
			&lt;td&gt;&lt;input type="submit" name="submit" value="保存" class="submit1" onclick="j_repost('formgroup')"&gt;&lt;/td&gt;
		&lt;/tr&gt;
	&lt;/table&gt;
	&lt;/form&gt;

&lt;/div&gt;
&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$("#typeid").val("{$typeid}");
	$("#isuse").val("{$isuse}");
})	
//--&gt;
&lt;/script&gt;</form>
</xml>
