<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="修改回复的表单">{$top}
&lt;div class="main"&gt;
	
	{$tasktoolbar}
	
	{$crumb}
	
	
	&lt;form method="post" action="{$action}" id="myform"&gt;
		&lt;div style="height:20px"&gt;&lt;/div&gt;

		&lt;p&gt;
		主题:&lt;input type="text" name="title" id="title" size="50" value="{$title}" /&gt;

		类型： {$mytypename}
		

		&lt;p&gt;
			&lt;textarea name="mycontent" id="mycontent" rows="3" cols="60"&gt;{$mycontent_htmlencode}&lt;/textarea&gt;
		&lt;/p&gt;
		&lt;input type="submit" value="submit" onclick="j_post('myform')" class="submit_task" /&gt;
	&lt;/form&gt;
&lt;/div&gt;


&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		wedoneteditor("mycontent", 1);
		
	

	})
//--&gt;
&lt;/script&gt;</main><css readme="css"/></xml>
