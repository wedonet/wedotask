<?xml version="1.0" encoding="utf-8"?>
<xml>
<main readme="main">&lt;div class='navoperate'&gt;
	&lt;ul&gt;
		&lt;li&gt;[&lt;a href="?act=creat&amp;amp;pid=0" class="j_open"&gt;添加功能&lt;/a&gt;]&lt;/li&gt;
		&lt;li&gt;[&lt;a href="javascript:void(0)" onclick="j_post('formpower')"&gt;保存权限&lt;/a&gt;]&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;form method="post" action="?act=savepower" id="formpower"&gt;
	&lt;table class="table1 j_list" cellspacing="0" &gt;
		&lt;tr&gt;
			&lt;th width="30"&gt;ID&lt;/th&gt;
			&lt;th width="200"&gt;名称&lt;/th&gt;
			&lt;th width="200"&gt;地址&lt;/th&gt;		
			&lt;th width="*"&gt;权限&lt;/th&gt;
			&lt;th width="30"&gt;排序&lt;/th&gt;
			&lt;th width="140"&gt;操作&lt;/th&gt;
		&lt;/tr&gt;
		{$li}
	&lt;/table&gt;
	
&lt;/form&gt;</main>
<li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;&lt;div class="depth{$depth}"&gt;{$title}&lt;/div&gt;&lt;/td&gt;
	&lt;td&gt;{$urlcode}&lt;/td&gt;
	&lt;td&gt;{$grouppower}&lt;/td&gt;
	&lt;td&gt;{$cls}&lt;/td&gt;
	&lt;td&gt;
	&lt;a href="?act=creat&amp;amp;pid={$id}&amp;amp;cid={$cid}&amp;amp;plusid={$plusid}" class="j_open"&gt;添加&lt;/a&gt; |
	&lt;a href="?act=edit&amp;amp;id={$id}" class="j_open"&gt;修改&lt;/a&gt; |	
	&lt;a href="?act=del&amp;amp;id={$id}" class="j_del alarm" title="删除{$title}"&gt;删除&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li>
<form readme="form">&lt;div class="pxmiddle"&gt;
	&lt;div class="th"&gt;功能设置 - {$title}&lt;/div&gt;

	&lt;form method="post" action="{$action}" name="myform" id="myform"&gt;
	&lt;table cellspacing="0" class="table1 j_list"&gt;

	&lt;tr id="linepid"&gt;
		&lt;td&gt;上级&lt;/td&gt;
		&lt;td&gt;
			&lt;select name="pid" id="pid"&gt;
				{$optionpid}
			&lt;/select&gt;
		&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;名称&lt;/td&gt;
		&lt;td&gt;&lt;input type="text" name="titlecode" value="{$titlecode}" size="60" /&gt;&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;地址&lt;/td&gt;
		&lt;td&gt;&lt;input type="text" name="urlcode" id="urlcode" value="{$urlcode}" size="60" /&gt;&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;参数&lt;/td&gt;
		&lt;td&gt;&lt;input type="text" name="para" id="para" value="{$para}" size="60" /&gt;&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;排序&lt;/td&gt;
		&lt;td&gt;
			&lt;input type="text" name="cls" id="cls" value="{$cls}" size="4" /&gt; &amp;nbsp; 
			频道ID &lt;input type="text" name="mycid" value="{$cid}" size="4" /&gt; &amp;nbsp;
			插件ID &lt;input type="text" name="plusid" value="{$plusid}" size="16" /&gt; &amp;nbsp;
		&lt;/td&gt;
	&lt;/tr&gt;

	&lt;/table&gt;
	&lt;div class="operate"&gt;&lt;input type="submit" value=" 保 存 " class="submit" onclick="j_repost('myform')" /&gt;&lt;/div&gt;
	&lt;/form&gt;	

&lt;/div&gt;


&lt;script type="text/javascript"&gt;
	$(document).ready(function(){
		$("#pid").val("{$pid}");
		{$js}
	})
&lt;/script&gt;</form>
<power readme="power"/><powerli readme="powerli"/></xml>
