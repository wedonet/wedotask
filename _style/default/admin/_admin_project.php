<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class='navoperate'&gt;
	&lt;ul&gt;
		&lt;li&gt;[&lt;a href="?act=creat"&gt;添加项目&lt;/a&gt;]&lt;/li&gt;
	&lt;/ul&gt;
&lt;/div&gt;

&lt;table class="table1 j_list" cellspacing='0'&gt;
&lt;tr&gt;
  &lt;th&gt;ID&lt;/th&gt;
  &lt;th&gt;名称&lt;/th&gt;
  &lt;th&gt;状态&lt;/th&gt;
  &lt;th&gt;添加时间&lt;/th&gt;
  &lt;th width="150"&gt;操作&lt;/th&gt;
&lt;/tr&gt;
{$li}
&lt;/table&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;
	&lt;td width="30"&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$mystatus}&lt;/td&gt;
	&lt;td&gt;{$stime}&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="?act=edit&amp;amp;id={$id}"&gt;修改&lt;/a&gt; &amp;nbsp; 
		&lt;a href="?act=del&amp;amp;id={$id}" class="j_del" title="删除"&gt;删除&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li><myform readme="myform">&lt;form method="post" action="{$action}" name="myform" id="myform"&gt;
  &lt;table class="table1" cellspacing="0"&gt;
    &lt;tr&gt;
      &lt;td width="80"&gt;项目名称:&lt;cite&gt;*&lt;/cite&gt;&lt;/td&gt;
      &lt;td width="*"&gt;
			&lt;input type="text" name="title" id="title" value="{$title}" size="40" /&gt;			
		&lt;/td&gt;
    &lt;/tr&gt;

  

    &lt;tr&gt;
	&lt;td&gt;状态&lt;/td&gt;
	&lt;td&gt;
	&lt;select name="mystatus" id="mystatus"&gt;
		&lt;option value="New"&gt;New&lt;/option&gt;
		&lt;option value="Done"&gt;Done&lt;/option&gt;
	&lt;/select&gt;&lt;/td&gt;
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
	$("#mystatus").val("{$mystatus}");
})	
//--&gt;
&lt;/script&gt;</myform></xml>
