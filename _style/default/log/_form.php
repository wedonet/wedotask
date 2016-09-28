<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	{$tasktoolbar}

	{$crumb}

	&lt;form method="post" action="{$action}" id="myform"&gt;
		
	
	&lt;table class="table1" cellspacing="0"&gt;
		&lt;tr&gt;
			&lt;td&gt;Title：&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="title" size="80" value="{$title}" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;分类：&lt;/td&gt;
			&lt;td&gt;&lt;select name="classid" id="classid"&gt;
				&lt;option value=""&gt;&lt;/option&gt;
				{$optionclass}
			&lt;/select&gt;&lt;/td&gt;
		&lt;/tr&gt;

	
		&lt;tr&gt;
			&lt;td&gt;重要程度:&lt;/td&gt;
				&lt;td&gt;&lt;select name="importantint" id="importantint"&gt;
					&lt;option value="10"&gt;10&lt;/option&gt;
					&lt;option value="20"&gt;20&lt;/option&gt;
					&lt;option value="20"&gt;30&lt;/option&gt;
				&lt;/select&gt;  
			&lt;/td&gt;
		&lt;/tr&gt;




		&lt;tr&gt;
			&lt;td colspan="2"&gt;
			&lt;textarea name="mycontent" id="mycontent" rows="3" cols="60"&gt;{$mycontent_htmlencode}&lt;/textarea&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		
	&lt;/table&gt;
	&lt;/form&gt;

	&lt;div class=""&gt;&lt;input type="submit" value="submit" onclick="j_post('myform')"/&gt;&lt;/div&gt;
	{$bottom}
&lt;/div&gt;


&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		$("#classid").val("{$classid}");

		$("#importantint").val("{$importantint}");

		wedoneteditor("mycontent", 1);
	})
//--&gt;
&lt;/script&gt;</main><css readme="css"/></xml>
