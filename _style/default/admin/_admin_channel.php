<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class='navoperate'&gt;
	&lt;ul&gt;
		&lt;li&gt;[&lt;a href="?act=creatin&amp;amp;cha_type=0"&gt;添加系统频道&lt;/a&gt;]&lt;/li&gt;
		&lt;li&gt;[&lt;a href="?act=creatout&amp;amp;cha_type=20"&gt;添加外部频道&lt;/a&gt;]&lt;/li&gt;
		&lt;li style="display:none"&gt;[&lt;a href="?act=batchcls" class="j_open"&gt;批量设置权限&lt;/a&gt;]&lt;/li&gt;
		&lt;li style="display:none"&gt;[&lt;a href="?act=batchname" class="j_open"&gt;批量修改名称,排序&lt;/a&gt;]&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;table class="table1 j_list" cellspacing='0'&gt;
&lt;tr&gt;
  &lt;th&gt;ID&lt;/th&gt;
  &lt;th&gt;编码&lt;/th&gt;
  &lt;th&gt;名称&lt;/th&gt;
  &lt;th&gt;目录&lt;/th&gt;
  &lt;th&gt;模板目录&lt;/th&gt;
  &lt;th&gt;模板页&lt;/th&gt;
  &lt;th width="60"&gt;属性&lt;/th&gt;
  &lt;th&gt;模块&lt;/th&gt;
  &lt;th width="60"&gt;类型&lt;/th&gt;
  &lt;th width="30"&gt;显示&lt;/th&gt;
  &lt;th width="30"&gt;使用&lt;/th&gt;
  &lt;th width="40"&gt;排序&lt;/th&gt;
  &lt;th width="200"&gt;操作&lt;/th&gt;
&lt;/tr&gt;
{$li}
&lt;/table&gt;

&lt;div class="ostate"&gt;
	&lt;a name="creatreadme"&gt;&lt;/a&gt;
	&lt;h6&gt;操作说明:&lt;/h6&gt;
	&lt;ul&gt;
	&lt;li&gt;克隆新频道后请刷新页面,即可在管理菜单左侧看到相应的管理.&lt;/li&gt;
	&lt;li&gt;排序决定频道显示顺序,数字越小越靠前.&lt;/li&gt;
	&lt;li&gt;Title,Keywords,Description分别对应网页head中的相应内容,有助于搜索引擎排位&lt;/li&gt;
	&lt;li&gt;&amp;quot;频道提示&amp;quot;指鼠标移动到相应频道上时出现的提示信息&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$("a.icanghost0").unlink();
})	
//--&gt;
&lt;/script&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;
	&lt;td width="30"&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$ic}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$cha_dir}&lt;/td&gt;
	&lt;td&gt;{$cha_style}&lt;/td&gt;
	&lt;td&gt;{$cha_stylepage}&lt;/td&gt;
	&lt;td&gt;{$cha_typename}&lt;/td&gt;
	&lt;td&gt;{$cha_module}&lt;/td&gt;
	&lt;td&gt;{$mytype}&lt;/td&gt;
	&lt;td class="j_tdright{$cha_show}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td class="j_tdright{$isuse}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td&gt;{$cls}&lt;/td&gt;
	{$op}
&lt;/tr&gt;</li><formselfli readme="formselfli">&lt;li&gt;&#13;
&lt;h3 style="display:inline"&gt;自定义字段 other{$i} &lt;/h3&gt;&lt;input type="checkbox" id="usemyfield_{$i}" class="usemyfield" name="usemyfield_{$i}" value="1" /&gt;&#13;
	&lt;div id="myfield_{$i}" style="display:none"&gt;&#13;
		&lt;p&gt;字段名称和属性:&lt;br /&gt;&#13;
		&lt;input type="text" id="myfieldname_{$i}" name="myfieldname_{$i}" value="" size="30" /&gt;&#13;
		&lt;select id="mustfill_{$i}" name="mustfill_{$i}"&gt;&#13;
		&lt;option value="0"&gt;选填&lt;/option&gt;&#13;
		&lt;option value="1"&gt;必填&lt;/option&gt;&#13;
		&lt;/select&gt;&#13;
		&lt;select id="inputtype_{$i}" name="inputtype_{$i}"&gt;&#13;
		&lt;option value="0"&gt;文本框&lt;/option&gt;&#13;
		&lt;option value="1"&gt;文本区&lt;/option&gt;&#13;
		&lt;option value="2"&gt;附件框&lt;/option&gt;&#13;
		&lt;option value="3"&gt;单选框&lt;/option&gt;&#13;
		&lt;option value="4"&gt;复选框&lt;/option&gt;&#13;
		&lt;option value="5"&gt;列表框&lt;/option&gt;&#13;
		&lt;/select&gt;&#13;
		&lt;/p&gt;&#13;
		&lt;div id="option_{$i}"&gt;&#13;
		&lt;p&gt;选项(选项间用回车分隔,文本字段不需要填写):&lt;br /&gt;&#13;
		&lt;textarea id="otheroption_{$i}" name="otheroption_{$i}" rows="4" cols="50"&gt;&lt;/textarea&gt;&#13;
		&lt;/p&gt;&#13;
		&lt;/div&gt;&#13;
	&lt;/div&gt;&#13;
&lt;/li&gt;</formselfli><formin readme="系统频道,内部频道">&lt;form method="post" action="{$action}" name="myform" id="myform"&gt;
  &lt;table class="table1" cellspacing="0"&gt;
    &lt;tr&gt;
      &lt;td width="80"&gt;频道名称:&lt;cite&gt;*&lt;/cite&gt;&lt;/td&gt;
      &lt;td width="*"&gt;
			&lt;input type="text" name="title" id="title" value="{$title}" size="40" /&gt;
			&amp;nbsp;简称:&lt;input type="text" name="cha_unit" id="cha_unit" value="{$cha_unit}" size="10" /&gt;
			&amp;nbsp;编码:&lt;input type="text" name="ic" id="ic" value="{$ic}" size="20" /&gt;&lt;span class="gray"&gt;没有可以不填&lt;/span&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;频道目录:&lt;cite&gt;*&lt;/cite&gt;&lt;/td&gt;
      &lt;td&gt;
			&lt;input type="text" name="cha_dir" id="cha_dir" value="{$cha_dir}"  size="20" /&gt;
			&lt;span id="div_modulename"&gt;&amp;nbsp; 模块: &lt;input type="text" name="cha_modulename" value="{$cha_modulename}" /&gt;&lt;/span&gt;
			&lt;span style="display:none"&gt;&amp;nbsp; 关联数据表: &lt;input type="text" name="cha_mdb" value="{$cha_mdb}" size="20" /&gt;&lt;span class="gray"&gt;用逗号分隔,不需要带表前缀&lt;/span&gt;&lt;/span&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
      &lt;td&gt;频道提示:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="mytip" id="mytip" value="{$mytip}"  class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr style="display:none"  id="linecopystyle"&gt;
      &lt;td&gt;复制模板:&lt;/td&gt;
      &lt;td&gt;
			&lt;input type="checkbox" name="copystyle" value="1" /&gt; 原频道模板复制到新的频道
		&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
      &lt;td&gt;模板目录:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="cha_style" id="cha_style" value="{$cha_style}" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
      &lt;td&gt;模板页:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="cha_stylepage" id="cha_stylepage" value="{$cha_stylepage}" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;


    &lt;tr&gt;
      &lt;td&gt;频道介绍:&lt;br /&gt;支持Html&lt;/td&gt;
      &lt;td&gt;&lt;textarea name="readme" id="readme" rows="2" cols="48" class="inputtext"&gt;{$readme_htmlencode}&lt;/textarea&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;预览图:&lt;/td&gt;
      &lt;td&gt;
			&lt;input type="text" name="preimg" id="preimg" value="{$preimg}"  class="inputtext2" /&gt;&amp;nbsp;
			&lt;a href="{$selimg}" class="j_open"&gt;&lt;img src="images/view.gif" title="浏览服务器" alt="view" class="vmiddle" /&gt;&lt;/a&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;Title:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="mytitle" id="mytitle" value="{$mytitle}" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;Keywords:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="mykeywords" id="mykeywords" value="{$mykeywords}" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;Description:&lt;/td&gt;
      &lt;td&gt;&lt;textarea name="mydescription" id="mydescription" rows="2" cols="48" class="inputtext"&gt;{$mydescription}&lt;/textarea&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr id="chaopen"&gt;
		&lt;td&gt;其它&lt;/td&gt;
      &lt;td&gt;
			类型:&lt;input type="text" name="mytype" id="mytype" value="{$mytype}" size="10" /&gt;  &amp;nbsp;
			&lt;select name="cha_opentype" id="cha_opentype"&gt;
				&lt;option&gt;打开方式&lt;/option&gt;
          &lt;option value="1"&gt;新窗口&lt;/option&gt;
          &lt;option value="0"&gt;原窗口&lt;/option&gt;
        &lt;/select&gt;
      
      &amp;nbsp;&lt;select name="cha_show" id="cha_show"&gt;
			&lt;option&gt;是否显示&lt;/option&gt;
          &lt;option value="1"&gt;显示&lt;/option&gt;
          &lt;option value="0"&gt;不显示&lt;/option&gt;
      &lt;/select&gt;       
		
	   &amp;nbsp;&lt;select name="isuse" id="isuse"&gt;
			&lt;option&gt;使用:&lt;/option&gt;
          &lt;option value="1"&gt;使用&lt;/option&gt;
          &lt;option value="0"&gt;不使用&lt;/option&gt;
        &lt;/select&gt;
		
		&amp;nbsp;排序:&lt;input type="text" name="cls" id="cls" size="3" value="{$cls}" /&gt;

		&amp;nbsp;记录数/页:&lt;input type="text" name="cha_page" id="cha_page" value="{$cha_page}" size="3" /&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
		&lt;td&gt;&amp;nbsp;&lt;/td&gt;
		&lt;td&gt;&lt;input type="button" name="submit" class="submit" value="保 存" onclick="j_post('myform')" /&gt;&lt;/td&gt;
	 &lt;/tr&gt;

  &lt;/table&gt;

&lt;/form&gt;



&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$("#cha_opentype").val("{$cha_opentype}");
	$("#cha_show").val("{$cha_show}");
	$("#isuse").val("{$isuse}");
	$("#icanghost").val("{$icanghost}");

	{$js}
})	
//--&gt;
&lt;/script&gt;</formin><formout readme="外部频道的表单">&lt;form method="post" action="{$action}" id="myform"&gt;
  &lt;table class="t1" cellspacing="0"&gt;
    &lt;tr&gt;
      &lt;td width="88"&gt;频道名称:&lt;cite&gt;*&lt;/cite&gt;&lt;/td&gt;
      &lt;td width="*"&gt;
			&lt;input type="text" name="title" id="title" value="{$title}" size="40" /&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;编码&lt;/td&gt;
      &lt;td&gt;
			&lt;input type="text" name="ic" id="ic" value="{$ic}" size="20" /&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
      &lt;td&gt;链接地址:&lt;/td&gt;
      &lt;td&gt;&lt;input type='text' name='cha_url' id='cha_url' value='{$cha_url}' size="50" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt; 

	 &lt;tr&gt;
      &lt;td&gt;频道提示:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="mytip" id="mytip" value="{$mytip}"  class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;频道介绍:&lt;br /&gt;支持Html&lt;/td&gt;
      &lt;td&gt;&lt;textarea name="readme" id="readme" rows="2" cols="48" class="inputtext"&gt;{$readme_htmlencode}&lt;/textarea&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;图标路径:&lt;/td&gt;
      &lt;td width=*&gt;&lt;input type="text" name="preimg" id="preimg" value="{$preimg}"  class="inputtext2" /&gt;
			&lt;a href="{$selimg}" class="j_open"&gt;&lt;img src="images/view.gif" title="浏览服务器" alt="view" align="absmiddle" /&gt;&lt;/a&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr id="chaopen"&gt;
		&lt;td&gt;其它&lt;/td&gt;
      &lt;td&gt;&lt;select name='cha_opentype' id='cha_opentype'&gt;
				&lt;option&gt;打开方式&lt;/option&gt;
          &lt;option value='1'&gt;新窗口&lt;/option&gt;
          &lt;option value='0'&gt;原窗口&lt;/option&gt;
        &lt;/select&gt;
      
      &amp;nbsp;&lt;select name='cha_show' id='cha_show'&gt;
			&lt;option&gt;是否显示&lt;/option&gt;
          &lt;option value='1'&gt;显示&lt;/option&gt;
          &lt;option value='0'&gt;不显示&lt;/option&gt;
      &lt;/select&gt;       
		
	   &amp;nbsp;&lt;select name='isuse' id='isuse'&gt;
			&lt;option&gt;使用:&lt;/option&gt;
          &lt;option value='1'&gt;使用&lt;/option&gt;
          &lt;option value='0'&gt;不使用&lt;/option&gt;
        &lt;/select&gt;
     
		
		&amp;nbsp;排序:&lt;input type='text' name='cls' id='cls' size="3" value='{$cls}'&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
		&lt;td&gt;&amp;nbsp;&lt;/td&gt;
		&lt;td&gt;&lt;input type='button' name='submit' class="submit" value='保 存' onclick="j_post('myform')" /&gt;&lt;/td&gt;
	 &lt;/tr&gt;

  &lt;/table&gt;

&lt;/form&gt;



&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$('#cha_opentype').val('{$cha_opentype}');
	$('#cha_show').val('{$cha_show}');
	$('#isuse').val('{$isuse}');
})	
//--&gt;
&lt;/script&gt;</formout><opout readme="外部频道操作">&lt;td&gt;
		&lt;a href="{$cha_url}" target="_blank"&gt;浏览&lt;/a&gt; &amp;nbsp;
		&lt;a href="?act=editout&amp;amp;id={$id}"&gt;编辑&lt;/a&gt; &amp;nbsp;
		&lt;a href="?act=delout&amp;amp;id={$id}" class="j_del alarm" title="删除{$title}"&gt;删除&lt;/a&gt;
&lt;/td&gt;</opout><opin readme="内部频道操作">&lt;td&gt;
	&lt;a href="{$webdir}{$cha_dir}" target="_blank"&gt;浏览&lt;/a&gt; &amp;nbsp;
	&lt;a href="?act=editin&amp;amp;id={$id}"&gt;编辑&lt;/a&gt; &amp;nbsp;
	&lt;a href="?act=ghost&amp;amp;sourceid={$id}" class="icanghost{$icanghost}"&gt;克隆&lt;/a&gt; &amp;nbsp; 
	
	&lt;a href="?act=delin&amp;amp;id={$id}" class="j_del alarm" title="删除{$title},将连同此频道下的分类,记录,模板等相关信息一起删除"&gt;删除&lt;/a&gt;
&lt;/td&gt;</opin></xml>
