<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;form method="post" id="myform" action="?act=clear"&gt;
&lt;table cellspacing="0" class="table1"&gt;
	&lt;tr&gt;&lt;th&gt;清除缓存数据&lt;/th&gt;&lt;/tr&gt;
	&lt;tr&gt;
		&lt;td&gt;
			&lt;input type="checkbox" name="cachetype[]" id="cache1" value="1" checked="checked" /&gt; 服务器内存缓存
			&lt;input type="checkbox" name="cachetype[]" id="field" value="field" checked="checked" /&gt; 数据库字段缓存
		&lt;/td&gt;
	&lt;/tr&gt;
&lt;/table&gt;
&lt;div class="operate"&gt;&lt;input type="button" value="点击这里执行清除缓存" onclick="j_post('myform')"&gt;&lt;/div&gt;
&lt;/form&gt;</main></xml>
