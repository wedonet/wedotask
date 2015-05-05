<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;table class="table1 j_list" cellspacing="0"&gt;
	&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="*"&gt;标题&lt;/th&gt;
	
	&lt;th width="80"&gt;添加人&lt;/th&gt;
	&lt;th width="80"&gt;发布时间&lt;/th&gt;
	&lt;th width="50"&gt;排序&lt;/th&gt;
	&lt;th width="50"&gt;显示&lt;/th&gt;
	&lt;th width="50"&gt;推荐&lt;/th&gt;
	&lt;th width="120"&gt;管理&lt;/th&gt;
	&lt;/tr&gt;
	{$li}
&lt;/table&gt;

{$pagelist}</main><css readme="css"/><li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$snick}&lt;/td&gt;
	&lt;td&gt;{$ptime_dateformat1}&lt;/td&gt;
	&lt;td&gt;{$cls}&lt;/td&gt;
	&lt;td class="j_tdright{$isshow}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td class="j_tdright{$isgood}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="?act=restore&amp;amp;cid={$cid}&amp;amp;id={$id}"&gt;恢复&lt;/a&gt;  &amp;nbsp;
		&lt;a href='?act=remove&amp;amp;cid={$cid}&amp;amp;id={$id}' class="j_del alarm" title="删除{$title}"&gt;物理删除&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li></xml>
