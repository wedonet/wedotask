<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div style='width:820px'&gt;
&lt;div class='th' id="th"&gt;选择文件&lt;/div&gt;
&lt;div class='ac'&gt;
	&lt;input type="text" id="focus" class="focusbug" /&gt; &lt;!-- 解决ie focus bug --&gt;
	&lt;input type="hidden" id="obj" value="{$obj}" /&gt;
	&lt;input type="hidden" id="preid" value="{$preid}" /&gt;
	&lt;input type="hidden" id="fromeditor" value="{$fromeditor}" /&gt;
	&lt;div class="tabup" id='tabup'&gt;
		&lt;ul&gt;
			&lt;li id="ftype1"&gt;&lt;a href="javascript:void(0)" onclick='return filefrom(1)'&gt;图片&lt;/a&gt;&lt;/li&gt;
			&lt;li id="ftype2"&gt;&lt;a href="javascript:void(0)" onclick='return filefrom(2)'&gt;Flash&lt;/a&gt;&lt;/li&gt;
			&lt;li id="ftype3"&gt;&lt;a href="javascript:void(0)" onclick='return filefrom(3)'&gt;附件&lt;/a&gt;&lt;/li&gt;
		&lt;/ul&gt;
		&lt;div class='clear'&gt;&lt;/div&gt;&lt;/div&gt;
		
		&lt;div class="fleft" style="width:140px;height:468px;"&gt;		
			&lt;iframe name="frameclass" id="frameclass" src="{$webdir}tools/myfiles.php?act=showclass&amp;amp;ftype={$ftype}" frameborder="0" scrolling="no" width="100%"  height="100%"&gt;&lt;/iframe&gt;
		&lt;/div&gt;
		&lt;div id="upcontent" class="fright" style="width:660px;height:460px;"&gt;
			&lt;iframe name="main" id="main" src="{$webdir}tools/myfiles.php?act=list&amp;amp;ftype={$ftype}&amp;amp;funcnum={$funcnum}&amp;amp;fromeditor={$fromeditor}" frameborder="0" scrolling="no" width="100%" height="100%"&gt;&lt;/iframe&gt;
		&lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	{$js}
})
//--&gt;
&lt;/script&gt;</main><divclass readme="选择分类" content="&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;&#13;&#10;&lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot; xml:lang=&quot;zh-CN&quot; lang=&quot;zh-CN&quot;&gt;&#13;&#10;&lt;head&gt;&#13;&#10;&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot; /&gt;&#13;&#10;&lt;meta http-equiv=&quot;Content-Language&quot; content=&quot;zh-CN&quot; /&gt;&#13;&#10;&lt;title&gt;上传分类&lt;/title&gt;&#13;&#10;&lt;link rel=&quot;stylesheet&quot; type=&quot;text/css&quot; href=&quot;{$webdir}_css/main.css&quot; /&gt;&#13;&#10;&lt;link rel=&quot;stylesheet&quot; type=&quot;text/css&quot; href=&quot;css/myfile.css&quot; /&gt;&#13;&#10;&lt;base target=&quot;main&quot; /&gt;&#13;&#10;&lt;style type=&quot;text/css&quot;&gt;&#13;&#10;&#9;li{&#13;&#10;&#9;&#9;padding:3px 0;&#13;&#10;&#9;}&#13;&#10;&lt;/style&gt;&#13;&#10;&lt;/head&gt;&#13;&#10;&lt;body&gt;&#13;&#10;&#13;&#10;&lt;div style=&quot;margin-bottom:5px;height:462px;width:140px;overflow-y:scroll;text-align:left;&quot;&gt;&#13;&#10;&#9;&lt;div style=&quot;margin-bottom:5px&quot;&gt;&#13;&#10;&#9;&#9;&lt;b&gt;分类&lt;/b&gt;  [&lt;a href=&quot;?act=class&amp;amp;ftype={$ftype}&quot;&gt;管理分类&lt;/a&gt;]&#13;&#10;&#9;&lt;/div&gt;&#13;&#10;&#9;&lt;ul class='fileclass'&gt;&#13;&#10;&#9;&#9;&lt;li&gt;&lt;a href=&quot;?act=list&amp;amp;ftype={$ftype}&quot;&gt;所有分类的记录&lt;/a&gt;&lt;/li&gt;&#13;&#10;&#9;&#9;&lt;li&gt;&lt;a href=&quot;?act=list&amp;amp;ftype={$ftype}&amp;amp;classid=0&quot;&gt;未分类的记录&lt;/a&gt;&lt;/li&gt;&#13;&#10;&#9;&#9;{$li}&#13;&#10;&#9;&lt;/ul&gt;&#13;&#10;&lt;/div&gt;&#13;&#10;&#13;&#10;&lt;/body&gt;&#13;&#10;&lt;/html&gt;">&lt;!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"&gt;
&lt;html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN"&gt;
&lt;head&gt;
&lt;meta http-equiv="Content-Type" content="text/html; charset=utf-8" /&gt;
&lt;meta http-equiv="Content-Language" content="zh-CN" /&gt;
&lt;title&gt;上传分类&lt;/title&gt;
&lt;link rel="stylesheet" type="text/css" href="{$webdir}_css/main.css" /&gt;
&lt;link rel="stylesheet" type="text/css" href="{$webdir}_css/myfile.css" /&gt;
&lt;base target="main" /&gt;
&lt;style type="text/css"&gt;
	li{
		padding:3px 0;
	}
&lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;

&lt;div style="margin-bottom:5px;height:462px;width:140px;overflow-y:scroll;text-align:left;"&gt;
	&lt;div style="margin-bottom:5px"&gt;
		&lt;b&gt;分类&lt;/b&gt;  &lt;span style="display:none"&gt;[&lt;a href="?act=class&amp;amp;ftype={$ftype}"&gt;管理分类&lt;/a&gt;]&lt;/span&gt;
	&lt;/div&gt;
	&lt;ul class='fileclass'&gt;
		&lt;li&gt;&lt;a href="?act=list&amp;amp;ftype={$ftype}"&gt;所有分类的记录&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="?act=list&amp;amp;ftype={$ftype}&amp;amp;classid=0"&gt;未分类的记录&lt;/a&gt;&lt;/li&gt;
		{$li}
	&lt;/ul&gt;
&lt;/div&gt;

&lt;/body&gt;
&lt;/html&gt;</divclass><ulclass readme="分类管理">&lt;div class="listfilter"&gt;&#13;
&lt;form method="post" action="?act=nsaveclass&amp;amp;ftype={$ftype}" id="formclass"&gt;&#13;
&amp;nbsp;&amp;nbsp;添加新分类 &#13;
&lt;input type="text" name="title" value="" size="20" /&gt;&#13;
&lt;input type="submit" value="保存" onclick="j_post('formclass')" /&gt;&#13;
&lt;/form&gt;&#13;
&lt;/div&gt;&#13;
&#13;
&#13;
&#13;
&lt;table class="tu1 j_list" cellspacing="1" &gt;&#13;
&lt;tr&gt;&#13;
	&lt;th width="40"&gt;ID&lt;/th&gt;&#13;
	&lt;th width="*"&gt;名称&lt;/th&gt;&#13;
	&lt;th width="120"&gt;操作&lt;/th&gt;&#13;
&lt;/tr&gt;&#13;
{$li}&#13;
&lt;/table&gt;&#13;
{$pagelist}</ulclass><liclass readme="分类管理列表">&lt;tr&gt;&#13;
&lt;td&gt;{$id}&lt;/td&gt;&#13;
&lt;td&gt;{$title}&lt;/td&gt;&#13;
&lt;td&gt;&#13;
&lt;a href="?act=editclass&amp;amp;id={$id}" class="j_open"&gt;修改&lt;/a&gt; | &#13;
&lt;a href="?act=delclass&amp;amp;id={$id}" class="j_dellink j_open" title="删除{$title}"&gt;删除&lt;/a&gt;&#13;
&lt;/td&gt;&#13;
&lt;/tr&gt;</liclass><formclass readme="formclass">&lt;div class="pxsmall"&gt;&#13;
&lt;div class="thu1"&gt;修改分类&lt;/div&gt;&#13;
&lt;div class="ac"&gt;&#13;
	&lt;form method="post" action="{$action}" id="eformclass"&gt;&#13;
	&#13;
	&lt;p&gt;&lt;input type="text" name="title" value="{$title}" size="20" /&gt;&lt;/p&gt;&#13;
	&lt;p&gt;&lt;input type="submit" value="保存" onclick="j_post('eformclass')" /&gt;&lt;/p&gt;&#13;
	&lt;/form&gt;&#13;
	&lt;/div&gt;&#13;
&lt;/div&gt;</formclass><ulpic readme="ulpic">&lt;div class="listfilter"&gt;
	&lt;div style="display:inline;float:left;"&gt;{$classname} &amp;nbsp;&lt;/div&gt;
	&lt;input type="hidden" value="{$funcnum}" id="funcnum" /&gt;
	&amp;nbsp;&amp;nbsp;
	&lt;form method="post" action="{$action}" enctype="multipart/form-data" id="up" style="display:inline;float:right;"&gt;
		&lt;input type="file" size="20" name="file1" value="浏览" /&gt;
		&lt;input type="submit" value="上传" class="submit" /&gt;
	&lt;/form&gt;
	&lt;div class="clear"&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;p&gt;&lt;/p&gt;
&lt;ul class="picture"&gt;
	{$li}
&lt;/ul&gt;
&lt;div class="clear"&gt;&lt;/div&gt;
&lt;div class="line2"&gt;&lt;/div&gt;
{$pagelist}
&lt;p&gt;&lt;/p&gt;
&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){	

	

	$(".fileimg").LoadImage(120,90);

	{$js}	
})
&lt;/script&gt;</ulpic><lipic readme="lipic">&lt;li&gt;
&lt;div class="imgborder"&gt;&lt;a href="{$href}" target="_blank" class="url" rel="{$urlthumb}"&gt;&lt;img src="{$urlthumb}" alt="" class="fileimg" /&gt;&lt;/a&gt;&lt;/div&gt;
&lt;div class="center"&gt;&lt;span id="title_{$id}"&gt;{$title}&lt;/span&gt; &lt;span class="j_filesize"&gt;{$ufilewidth}*{$ufileheight}&lt;/span&gt;&lt;/div&gt;
&lt;div class="center"&gt;
&lt;a href="?act=edittitle&amp;amp;id={$id}" class="j_open"&gt;编辑&lt;/a&gt; | 
&lt;a href="?act=del&amp;amp;id={$id}" class="j_del" title="删除{$title}"&gt;删除&lt;/a&gt;
&lt;/div&gt;
&lt;/li&gt;</lipic><ulfile readme="ulfile">&lt;div class="listfilter"&gt;

&amp;nbsp;&amp;nbsp;

&lt;form method="post" action="{$action}" enctype="multipart/form-data" id="up" style="display:inline;"&gt;
	&lt;input type="hidden" value="{$funcnum}" id="funcnum" /&gt;
	&lt;input type="file" size="30" name="file1" value="浏览" /&gt;
	&lt;input type="submit" value="上传" onclick="checkupdate()" class="submit" /&gt;
&lt;/form&gt;
&lt;/div&gt;
&lt;p&gt;&lt;/p&gt;

&lt;table class="tu1" cellspacing="1" &gt;
	&lt;tr&gt;
		&lt;th width="30"&gt;ID&lt;/th&gt;
		&lt;th width="100"&gt;名称&lt;/th&gt;
		&lt;th width="*"&gt;路径&lt;/th&gt;
		&lt;th width="60"&gt;维度&lt;/th&gt;
		&lt;th width="50"&gt;大小(K)&lt;/th&gt;
		&lt;th width="80"&gt;操作&lt;/th&gt;
	&lt;/tr&gt;
	{$li}
&lt;/table&gt;


{$pagelist}
&lt;p&gt;&lt;/p&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	{$js}	
})
//--&gt;
&lt;/script&gt;</ulfile><lifile readme="lifile">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;&lt;div style="width:140px;overflow:hidden"&gt;&lt;a href="{$href}" target="_blank" class="url"&gt;&lt;span id="title_{$id}"&gt;{$title}&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;&lt;/td&gt;
	&lt;td&gt;&lt;div style="width:220px;overflow:hidden;white-space:nowrap;"&gt;{$urlfile}&lt;/div&gt;&lt;/td&gt;
	&lt;td&gt;{$ufilewidth}*{$ufileheight}&lt;/td&gt;
	&lt;td&gt;{$filesize}&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="?act=edittitle&amp;amp;id={$id}" class="j_open"&gt;编辑&lt;/a&gt; | 
		&lt;a href="?act=del&amp;amp;id={$id}" class="j_dellink" title="删除{$title}"&gt;删除&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</lifile><css readme="css">&lt;link rel="stylesheet" href="/_css/wedonet_main.css?{$timestamp}" type="text/css" /&gt;
&lt;link rel="stylesheet" href="/_css/wedonet_user.css?{$timestamp}" type="text/css" /&gt;

&lt;script type="text/javascript" src="/_js/upload.js?{$timestamp}"&gt;&lt;/script&gt;</css><ulflash readme="ulflash">&lt;div class="listfilter"&gt;

&amp;nbsp;&amp;nbsp;

&lt;form method="post" action="{$action}" enctype="multipart/form-data" id="up" style="display:inline;"&gt;
	&lt;input type="hidden" value="{$funcnum}" id="funcnum" /&gt;
	&lt;input type="file" size="30" name="file1" value="浏览" /&gt;
	&lt;input type="submit" value="上传" onclick="checkupdate()" class="submit" /&gt;
&lt;/form&gt;
&lt;/div&gt;
&lt;p&gt;&lt;/p&gt;
&lt;ul class="picture"&gt;{$li}&lt;/ul&gt;
&lt;div class="clear"&gt;&lt;/div&gt;
&lt;div class="line2"&gt;&lt;/div&gt;
{$pagelist}
&lt;p&gt;&lt;/p&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	{$js}	
})
//--&gt;
&lt;/script&gt;</ulflash><liflash readme="liflash">&lt;li&gt;&#13;
&lt;a href="{$href}" target="_blank" class="url"&gt;&lt;img src="{$ufilename}" alt="" height="120" /&gt;&lt;/a&gt;&#13;
&lt;div class="center"&gt;&lt;span id="title_{$rootid}"&gt;{$title}&lt;/span&gt; {$ufilewidth}*{$ufileheight}&lt;/div&gt;&#13;
&lt;div class="center"&gt;&#13;
&lt;a href='?act=edittitle&amp;amp;id={$id}&amp;amp;cid={$cid}&amp;amp;rootid={$rootid}' class="j_open"&gt;编辑&lt;/a&gt; | &#13;
&lt;a href="?act=delpic&amp;amp;rootid={$rootid}&amp;amp;cid={$cid}" class="j_dellink" title="删除{$title}"&gt;删除&lt;/a&gt;&#13;
&lt;/div&gt;&#13;
&lt;/li&gt;</liflash><formtitle readme="formtitle">&lt;div class="pxsmall"&gt;&#13;
&lt;div class="th"&gt;文件信息&lt;/div&gt;&#13;
&lt;form method="post" action="{$action}" id="formtitle" class="jform ac"&gt;&#13;
	&lt;table class="table0" cellspacing="0" &gt;&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;名称&lt;/td&gt;&#13;
			&lt;td&gt;&lt;input type="text" name="title" id="title" value="{$title}" /&gt;&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
&#13;
&#13;
&#13;
		&lt;tr&gt;&#13;
			&lt;td&gt;&lt;/td&gt;&#13;
			&lt;td&gt;&lt;input type="submit" value="提交" onclick="j_repost('formtitle')" /&gt;&lt;/td&gt;&#13;
		&lt;/tr&gt;&#13;
	&lt;/table&gt;&#13;
&lt;/form&gt;&#13;
&lt;/div&gt;</formtitle></xml>
