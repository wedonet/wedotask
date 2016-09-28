<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="navoperate"&gt;
	&lt;li&gt;[&lt;a href="?act=creat&amp;amp;cid={$cid}"&gt;添加新专题&lt;/a&gt;]&lt;/li&gt;
&lt;/div&gt;

&lt;table class="table1 j_list" cellspacing="0"&gt;
	&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="*"&gt;名 称&lt;/th&gt;
	&lt;th width="40"&gt;排序&lt;/th&gt;
	&lt;th width="40"&gt;推荐&lt;/th&gt;
	&lt;th width="30"&gt;开放&lt;/th&gt;
	&lt;th width="160"&gt;操作&lt;/th&gt;
 &lt;/tr&gt;
	{$li}
&lt;/table&gt;


&lt;div class="ostate"&gt;
	&lt;a name="creatreadme"&gt;&lt;/a&gt;
	&lt;h6&gt;操作说明:&lt;/h6&gt;
	&lt;ul&gt;
	&lt;li&gt;网站可以设置不同专题.比如产品频道,可以添加08年新品,**机构专用产品,**公司推荐产品等专题,每个频道也可以有自已的专题&lt;/li&gt;
	&lt;li&gt;删除专题不影响专题下的记录&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;
&lt;td&gt;{$id}&lt;/td&gt;
&lt;td&gt;{$title}&lt;/td&gt;
&lt;td&gt;{$cls}&lt;/td&gt;
&lt;td class="j_tdright{$isgood}"&gt;&amp;nbsp;&lt;/td&gt;
&lt;td class="j_tdright{$isopen}"&gt;&amp;nbsp;&lt;/td&gt;
&lt;td&gt;
&lt;a href="?act=edit&amp;amp;cid={$cid}&amp;amp;id={$id}"&gt;编辑&lt;/a&gt; | 
&lt;a href="?act=content&amp;amp;cid={$cid}&amp;amp;id={$id}"&gt;内容&lt;/a&gt; | 
&lt;a href="?act=del&amp;amp;cid={$cid}&amp;amp;id={$id}" class="j_del alarm" title="删除{$title}!"&gt;删除&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;</li><myform readme="myform">&lt;form method="post" action="{$action}" id="myform" name="myform" class="form1"&gt;
	&lt;table class='table1' cellspacing='0'&gt;

		&lt;tr&gt;
			&lt;td width="120"&gt;专题名称:&lt;cite&gt;*&lt;/cite&gt;&lt;/td&gt;
			&lt;td&gt;
			 &lt;input type="text" name="title" maxlength="255" class="inputtext" value="{$title}" /&gt;
		 &lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;提示:&lt;/td&gt;
			&lt;td&gt;
			 &lt;input type="text" name="tip" maxlength="255" class="inputtext" value="{$tip}" /&gt;
		 &lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td&gt;专题说明:&lt;/td&gt;
		&lt;td&gt;
			&lt;textarea name="readme" id="readme" rows="3" cols="20" class="inputtext"&gt;{$readme}&lt;/textarea&gt;
		&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td&gt;Title:&lt;/td&gt;
		&lt;td&gt;
			&lt;input type="text" name="mytitle" maxlength="255" class="inputtext" value="{$mytitle}"/&gt;
		 &lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td&gt;Kwywords:&lt;/td&gt;
		&lt;td&gt;
			&lt;input type="text" name="mykeywords" maxlength="255" class="inputtext" value="{$mykeywords}"/&gt;
		 &lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td&gt;Description:&lt;/td&gt;
		&lt;td&gt;
			&lt;input type="text" name="mydescription" maxlength="255" class="inputtext" value="{$mydescription}"/&gt;
		 &lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
		&lt;td&gt;图标路径:&lt;/td&gt;
		&lt;td&gt;
		&lt;input type="text" name="preimg" id="preimg" maxlength="255" class="inputtext2" value="{$preimg}" /&gt;
		&lt;a href="admin_files.asp?obj=preimg" onclick="return showinnew(this,640,480)"&gt;&lt;img src="../images/view.gif" title="浏览服务器" alt="view" align="absmiddle" /&gt;&lt;/a&gt;
		&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;其它&lt;/td&gt;
			&lt;td&gt;
			排序:&lt;input type="text" name="cls" id="cls" maxlength="3" size="3" Value="{$cls}" /&gt;

			开放:&lt;select id="isopen" name="isopen"&gt;
					&lt;option value="1"&gt;是&lt;/option&gt;
					&lt;option value="0"&gt;否&lt;/option&gt;
				&lt;/select&gt;

			推荐:&lt;select id="isgood" name="isgood"&gt;
					&lt;option value="1"&gt;是&lt;/option&gt;
					&lt;option value="0"&gt;否&lt;/option&gt;
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;&amp;nbsp;&lt;/td&gt;
			&lt;td&gt;
				&lt;div&gt;&lt;input type="button" value="保 存" onclick="j_repost('myform')" class="submit"&gt;&lt;/div&gt;
			&lt;/td&gt;
		&lt;/tr&gt;
	&lt;/table&gt;

	
&lt;/form&gt;


&lt;script type="text/javascript"&gt;
	$("#isgood").val("{$isgood}");
	$("#isopen").val("{$isopen}");
&lt;/script&gt;</myform><formcontent readme="formcontent">&lt;form method="post" id="myform" action="{$action}" class="form1"&gt;
	&lt;textarea id="content" name="content" rows="20" cols="40" style="width:98%"&gt;{$content_htmlencode}&lt;/textarea&gt;
	&lt;div class="operate"&gt;
	&lt;input type="button" value="保 存" onclick="j_post('myform')" class="submit" /&gt;
	&lt;/div&gt;
&lt;/form&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	wedoneteditor("content", 1);
})	
//--&gt;
&lt;/script&gt;</formcontent></xml>
