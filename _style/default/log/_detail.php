<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	
	{$tasktoolbar}
	
	{$crumb}

	&lt;div class="operate"&gt;
		
	&lt;/div&gt;
		
	
	&lt;table class="table1" cellspacing="0"&gt;
		&lt;tr&gt;
			&lt;td&gt;{$title}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;{$unick} - {$stime}  &amp;nbsp; 重要程度：{$importantint} &lt;/td&gt;
		&lt;/tr&gt;	


	

		&lt;tr&gt;
			&lt;td&gt;
			{$mycontent}
			&lt;/td&gt;
		&lt;/tr&gt;		
	&lt;/table&gt;
	
	&lt;div class="taskoperate" id="taskoperate"&gt;
		&lt;ul&gt;			
			&lt;li id="j_del"&gt;&lt;a href="operate.php?act=del&amp;amp;id={$id}" class="j_open" title="删除 {$title}"&gt;删除&lt;/a&gt;&lt;/li&gt;

		&lt;/ul&gt;
	&lt;/div&gt;

	

	{$bottom}
&lt;/div&gt;


&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){

		{$js}

	})
//--&gt;
&lt;/script&gt;</main><css readme="css"/></xml>
