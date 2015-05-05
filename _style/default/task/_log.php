<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	
	{$tasktoolbar}
	
	{$crumb}
	
		


	&lt;div class="operate"&gt;
		
	&lt;/div&gt;
		
	
	&lt;table class="table1" cellspacing="0"&gt;
		&lt;tr&gt;
			&lt;td&gt;任务名：&lt;/td&gt;
			&lt;td&gt;{$title}{$isshow}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;部门:&lt;/td&gt;
			&lt;td&gt;{$dname}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;执行人：&lt;/td&gt;
			&lt;td&gt;{$dunames}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;验收人：&lt;/td&gt;
			&lt;td&gt;{$cunames}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;实际验收人：&lt;/td&gt;
			&lt;td&gt;{$actualcnames}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;级别:&lt;/td&gt;
				&lt;td&gt;重要程度：{$zhongyao} &amp;nbsp; 
				紧极程度：
				{$jinji} &amp;nbsp; 
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;计划完成时间：&lt;/td&gt;
			&lt;td&gt;{$plantime}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;状态：&lt;/td&gt;
			&lt;td&gt;{$mystatusname}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td colspan="2"&gt;
			{$mycontent}
			&lt;/td&gt;
		&lt;/tr&gt;		
	&lt;/table&gt;
	
	&lt;div class="taskoperate"&gt;
		&lt;ul&gt;
			&lt;li class="j_del"&gt;&lt;a href="operate.php?act=del&amp;amp;id={$id}" class="j_open" title="删除 {$title}"&gt;删除&lt;/a&gt;&lt;/li&gt;
		&lt;/ul&gt;
	&lt;/div&gt;

	&lt;table cellspacing="0" class="table1"&gt;
		&lt;tr&gt;
			&lt;th&gt;ID&lt;/th&gt;
			&lt;th&gt;内容&lt;/th&gt;
			&lt;th&gt;时间&lt;/th&gt;
			&lt;th&gt;操作人&lt;/th&gt;
		&lt;/tr&gt;
		{$li}
	&lt;/table&gt;

	

	{$bottom}
&lt;/div&gt;</main><css readme="css"/><li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$stime}&lt;/td&gt;
	&lt;td&gt;{$sname}&lt;/td&gt;
&lt;/tr&gt;</li></xml>
