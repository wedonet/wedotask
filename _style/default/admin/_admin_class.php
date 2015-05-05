<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;form method="post" action="" name="myform" id="myform"&gt;
&lt;div class="navoperate"&gt;
	&lt;ul&gt;
	&lt;li&gt;[&lt;a href="?act=creat&amp;amp;cid={$cid}"&gt;添加新分类&lt;/a&gt;]&lt;/li&gt;
	&lt;li&gt;[&lt;a href="javascript:void(0)" onclick="j_post2('myform', '?act=savecls&amp;amp;cid={$cid}', '')"&gt;保存排序&lt;/a&gt;]&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;table class='table1 j_list' cellspacing="0"&gt;
	&lt;tr&gt;
		&lt;th width="40"&gt;ID&lt;/th&gt;
		&lt;th width="80"&gt;编码&lt;/th&gt;
		&lt;th width="*"&gt;名 称&lt;/th&gt;
		&lt;th width="40"&gt;权重&lt;/th&gt;
		&lt;th width="40"&gt;排序&lt;/th&gt;
		&lt;th width="80"&gt;目录&lt;/th&gt;
		&lt;th width="150"&gt;模板&lt;/th&gt;
		&lt;th width="30"&gt;推荐&lt;/th&gt;
		&lt;th width="30"&gt;显示&lt;/th&gt;
		&lt;th width="180"&gt;操作&lt;/th&gt;
	&lt;/tr&gt;
	{$li}
&lt;/table&gt;
&lt;/form&gt;

&lt;div class="tip1"&gt;
	&lt;dl&gt;
		&lt;dt&gt;操作说明:&lt;/dt&gt;
		&lt;dd&gt;设置分类关键词和分类说明有助于搜索引擎排位&lt;/dd&gt;
		&lt;dd&gt;推荐的分类可以按分组调用&lt;/dd&gt;
	&lt;/dl&gt;
&lt;/div&gt;</main><css readme="css"/><li readme="li">&lt;tr class="j_linecolor" id="j_line_{$id}"&gt;
	&lt;td&gt;{$id}&lt;input type="hidden" name="id[]" value="{$id}" /&gt;&lt;/td&gt;
	&lt;td&gt;{$ic}&lt;/td&gt;
	&lt;td align="left"&gt;&lt;span class="depth{$depth}"&gt;&lt;a href='?act=list&amp;amp;cid={$cid}&amp;amp;classid={$id}'&gt;{$title}&lt;/a&gt;&lt;/span&gt;&lt;/td&gt;
	&lt;td&gt;{$mypercent}&lt;/td&gt;
	&lt;td&gt;&lt;input type="text" name="cls[]" value="{$cls}" size="5" maxlength="5" style="text-align:right;" /&gt;&lt;/td&gt;
	&lt;td align='left'&gt;{$sdir}&lt;/td&gt;
	&lt;td&gt;{$mystyle}&lt;/td&gt;
	&lt;td class="j_tdright{$isgood}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td class="j_tdright{$isshow}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="?act=mycontent&amp;amp;cid={$cid}&amp;amp;id={$id}"&gt;分类内容&lt;/a&gt; | 
		&lt;a href='?act=edit&amp;amp;cid={$cid}&amp;amp;id={$id}'&gt;编辑分类&lt;/a&gt; | 
		&lt;a href='?act=del&amp;amp;cid={$cid}&amp;amp;id={$id}' class="j_del" title="删除{$title}"&gt;删除&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li><form readme="form">&lt;form method="post" action="{$action}" id="classinfo" name="classinfo"&gt;
&lt;table class="table1" cellspacing="0"&gt;

&lt;tr&gt;
	&lt;td width="140"&gt;所属分类:&lt;cite&gt;*&lt;/cite&gt;&lt;/td&gt;
	&lt;td width="*"&gt;
	&lt;select name="pid" id="pid"&gt;
		&lt;option value="0"&gt;作为一级分类&lt;/option&gt;
		{$optionclass}
	&lt;/select&gt;
	&lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
	&lt;td&gt;编码:&lt;/td&gt;
	&lt;td&gt;
    &lt;input type="text" name="ic" size="20" value="{$ic}" /&gt;
 &lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
	&lt;td&gt;名称:&lt;cite&gt;*&lt;/cite&gt;&lt;/td&gt;
	&lt;td&gt;
    &lt;input type="text" name="title" maxlength="255" size="50" value="{$title}" /&gt;
 &lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
	&lt;td&gt;目录:&lt;/td&gt;
	&lt;td&gt;
    &lt;input type="text" name="sdir" maxlength="255" size="50" value="{$sdir}" /&gt;
 &lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
&lt;td&gt;提示:&lt;/td&gt;
&lt;td&gt;
	&lt;input type="text" name="tip" maxlength="255" size="50" value="{$tip}"/&gt;
 &lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
&lt;td&gt;介绍:&lt;/td&gt;
&lt;td&gt;
&lt;textarea name="readme" id="readme" rows="3" cols="20" class="inputtext"&gt;{$readme_htmlencode}&lt;/textarea&gt;
&lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
&lt;td&gt;关键词:&lt;/td&gt;
&lt;td&gt;
	&lt;input type="text" name="tags" maxlength="255" size="50" value="{$tags}" /&gt;
&lt;/td&gt;
&lt;/tr&gt;


&lt;tr&gt;
	&lt;td&gt;模板路径:&lt;/td&gt;
	&lt;td&gt;&lt;input type="text" name="mystyle" id="mystyle" value="{$mystyle}" size="50" /&gt;&lt;/td&gt;
&lt;/tr&gt;

&lt;tr style="display:none"&gt;
	&lt;td&gt;内容页模板:&lt;/td&gt;
	&lt;td&gt;&lt;input type="text" name="mystyledetail" id="mystyledetail" value="{$mystyledetail}" size="50" /&gt;&lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
&lt;td&gt;Keywords:&lt;/td&gt;
&lt;td&gt;&lt;input type="text" name="mykeywords" id="mykeywords" value="{$mykeywords}" size="50" /&gt;&lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
&lt;td&gt;Description:&lt;/td&gt;
&lt;td&gt;
&lt;textarea name="mydescription" id="mydescription" rows="3" cols="20" class="inputtext"&gt;{$mydescription}&lt;/textarea&gt;
&lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
&lt;td&gt;图标路径:&lt;/td&gt;
&lt;td&gt;
&lt;input type="text" name="preimg" id="preimg" maxlength="255" class="inputtext2" value="{$preimg}" /&gt;
&lt;a href="{$selimg}" class="j_open"&gt;图片库&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;

&lt;tr&gt;
	&lt;td&gt;其它:&lt;/td&gt;
	&lt;td&gt;
	显示:&lt;select id="isshow" name="isshow"&gt;&lt;option value="1"&gt;是&lt;/option&gt;&lt;option value="0"&gt;否&lt;/option&gt;&lt;/select&gt;
	推荐:&lt;select id="isgood" name="isgood"&gt;&lt;option value="1"&gt;是&lt;/option&gt;&lt;option value="0"&gt;否&lt;/option&gt;&lt;/select&gt;
	排序:&lt;input type="text" name="cls" id="cls" maxlength="3" size="3" value="{$cls}" /&gt;
	权重:&lt;input type="text" name="mypercent" id="mypercent" maxlength="5" size="5" value="{$mypercent}" /&gt;
	&lt;/td&gt;
&lt;/tr&gt;



&lt;/table&gt;
&lt;div class="operate"&gt;&lt;input type="button" name="save" value="保 存" onclick="j_post('classinfo')" /&gt;&lt;/div&gt;
&lt;/form&gt;


&lt;script type="text/javascript"&gt;
$(document).ready(function(){
	$("#pid").val("{$pid}");
	$("#isgood").val("{$isgood}");
	$("#isshow").val("{$isshow}");
	odepth();
})
&lt;/script&gt;</form><formedit readme="formedit">&lt;form method="post" id="myform" action="{$action}"&gt;&#13;
	&lt;textarea id="content" name="content" rows="20" cols="40" style="width:98%"&gt;{$content_htmlencode}&lt;/textarea&gt;&#13;
	&lt;div class="operate"&gt;&#13;
	&lt;input type="button" value="保 存" onclick="j_post('myform')" class="submit" /&gt;&#13;
	&lt;/div&gt;&#13;
&lt;/form&gt;</formedit><formpower readme="formpower">&lt;form method="post" id="formbatch" action="?act=dobatchclass&amp;cid={$cid}"&gt;&#13;
&lt;table class="t1" cellspacing='0' &gt;&#13;
	&lt;tr valign="top"&gt;&#13;
		&lt;td width="250" style="padding:7px;"&gt;&#13;
			&lt;b&gt;选择分类&lt;/b&gt;&#13;
			&#13;
			&lt;ul&gt;{$classlist}&lt;/ul&gt;&#13;
			&lt;p&gt;&lt;/p&gt;&#13;
			[&lt;a href="javascript:checkall('id')"&gt;全选&lt;/a&gt;]&#13;
			[&lt;a href="javascript:contrasel('id')"&gt;反选&lt;/a&gt;]&#13;
			&#13;
		&lt;/td&gt;&#13;
&#13;
		&lt;td&gt;&#13;
		&lt;table class="t0 j_linecolor" cellspacing='0'&gt;&#13;
			&lt;tr&gt;&#13;
				&lt;td width="150"&gt;浏览记录列表权限:&lt;/td&gt;&#13;
				&lt;td&gt;&lt;input type="hidden" name="viewcls" id="viewcls" class="j_makecls" /&gt;&lt;/td&gt;&#13;
			&lt;/tr&gt;&#13;
&#13;
			&lt;tr&gt;&#13;
				&lt;td&gt;查看记录内容权限:&lt;/td&gt;&#13;
				&lt;td&gt;&lt;input type="hidden" name="readcls" id="readcls" class="j_makecls" /&gt;&lt;/td&gt;&#13;
			&lt;/tr&gt;&#13;
		&lt;/table&gt;&#13;
		&lt;/td&gt;&#13;
	&lt;/tr&gt;&#13;
&lt;/table&gt;&#13;
&lt;div class="operate"&gt;&lt;input type="button" value="保 存" onclick="j_post('formbatch')"&gt;&lt;/div&gt;&#13;
&lt;/form&gt;</formpower><content readme="分类内容">&lt;form method="post" action="{$action}" name="myform" id="myform"&gt;
  &lt;table class="table1" cellspacing="0"&gt;
   &lt;tr&gt;
		&lt;td&gt;{$title}&lt;/td&gt;
	&lt;/tr&gt;



    &lt;tr&gt;

      &lt;td colspan="2"&gt;
			&lt;textarea name="mycontent" id="mycontent" rows="5" cols="60"&gt;{$mycontent_htmlencode}&lt;/textarea&gt;
		&lt;/td&gt;
    &lt;/tr&gt;




	 &lt;tr&gt;
		
		&lt;td colspan="2"&gt;&lt;input type="button" name="submit" class="submit1" value="保 存" onclick="j_post('myform')" /&gt;&lt;/td&gt;
	 &lt;/tr&gt;

  &lt;/table&gt;

&lt;/form&gt;



&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){


	wedoneteditor("mycontent", 1);

	
})	
//--&gt;
&lt;/script&gt;</content></xml>
