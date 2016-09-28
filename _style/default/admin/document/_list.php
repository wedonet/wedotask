<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$filter}

&lt;table class="table1 j_list" cellspacing="0"&gt;
	&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="*"&gt;标题&lt;/th&gt;
	&lt;th width="180"&gt;分类&lt;/th&gt;
	
	&lt;th width="80"&gt;添加人&lt;/th&gt;
	&lt;th width="80"&gt;发布时间&lt;/th&gt;
	&lt;th width="50"&gt;排序&lt;/th&gt;
	&lt;th width="50"&gt;显示&lt;/th&gt;
	&lt;th width="50"&gt;推荐&lt;/th&gt;
	&lt;th width="120"&gt;管理&lt;/th&gt;
	&lt;/tr&gt;
	{$li}
&lt;/table&gt;

{$pagelist}

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	{$js}
})	
//--&gt;
&lt;/script&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$classname}&lt;/td&gt;
	&lt;td&gt;{$snick}&lt;/td&gt;
	&lt;td&gt;{$ptime_dateformat1}&lt;/td&gt;
	&lt;td&gt;{$cls}&lt;/td&gt;
	&lt;td class="j_tdright{$isshow}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td class="j_tdright{$isgood}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="creat.php?act=edit&amp;amp;cid={$cid}&amp;amp;id={$id}"&gt;编辑&lt;/a&gt;  &amp;nbsp;
		&lt;a href='?act=del&amp;amp;cid={$cid}&amp;amp;id={$id}' class="j_del alarm" title="删除{$title}"&gt;删除&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li><filter readme="filter">&lt;div class="listfilter"&gt;
&lt;form method="get" action=""&gt;
	&lt;input type="hidden" name="cid" value="{$cid}" /&gt;

	&lt;select name="classid" id="classid"&gt;
		&lt;option value=""&gt;分类&lt;/option&gt;


		&lt;option value="0"&gt;不属于任何分类&lt;/option&gt;
		{$optionclass}
	&lt;/select&gt;

	&lt;input type="submit" value="提交" /&gt;
&lt;/form&gt;
&lt;/div&gt;</filter></xml>
