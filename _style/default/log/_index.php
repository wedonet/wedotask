<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	

	{$tasktoolbar}

	{$menu}

	{$crumb}

	&lt;div style="margin:10px"&gt;
		&lt;div class="fright"&gt;
			&lt;ul&gt;
				&lt;li&gt;&lt;a href="form.php?act=creat"&gt;添加日志&lt;/a&gt;&lt;/li&gt;
			&lt;/ul&gt;
		&lt;/div&gt;
	&lt;/div&gt;

	&lt;div class="clear"&gt;&lt;/div&gt;

	&lt;div class=""&gt;
		&lt;form method="get" action="?"&gt;
			
		&lt;/form&gt;

		&lt;table class="table1 j_list" cellspacing="0"&gt;
			&lt;tr&gt;
				&lt;th width="40"&gt;ID&lt;/th&gt;
				&lt;th width="*"&gt;&amp;nbsp;&lt;/th&gt;
				&lt;th width="150"&gt;分类&lt;/th&gt;
	
				&lt;th width="100"&gt;提交人&lt;/th&gt;	
				&lt;th width="120"&gt;时间&lt;/th&gt;
				&lt;th width="80"&gt;重要程度&lt;/th&gt;			
			
			&lt;/tr&gt;
			{$li}
		&lt;/table&gt;

		{$pagelist}
	&lt;/div&gt;

	{$bottom}
&lt;/div&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="detail.php?id={$id}" target="_blank"&gt;{$title}&lt;/a&gt; 
	&lt;/td&gt;
	&lt;td&gt;{$classname}&lt;/td&gt;
	
	&lt;td&gt;{$unick}&lt;/td&gt;
	
	&lt;td&gt;{$stime}&lt;/td&gt;
	&lt;td&gt;{$importantint}&lt;/td&gt;
&lt;/tr&gt;</li></xml>
