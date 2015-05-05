<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	{$tasktoolbar}

	{$crumb}

	&lt;form method="post" action="{$action}" id="myform"&gt;
		
	
	&lt;table class="table1" cellspacing="0"&gt;
		&lt;tr&gt;
			&lt;td  width="120"&gt;标题：&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="title" size="80" value="{$title}" /&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;执行人：&lt;/td&gt;
			&lt;td&gt;{$checkboxduid}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;验收人：&lt;/td&gt;
			&lt;td&gt;{$checkboxcuid}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;其它&lt;/td&gt;
			&lt;td&gt;
				重要程度：&lt;select name="zhongyao" id="zhongyao"&gt;
					&lt;option value="10"&gt;一般&lt;/option&gt;
					&lt;option value="20"&gt;重要&lt;/option&gt;
				&lt;/select&gt; &amp;nbsp; 

				紧极程度：

				&lt;select name="jinji" id="jinji"&gt;
					&lt;option value="10"&gt;一般&lt;/option&gt;
					&lt;option value="20"&gt;重要&lt;/option&gt;
				&lt;/select&gt; &amp;nbsp; 

				计划完成时间:
				&lt;input type="text" name="plantime" id="plantime" value="{$plantime}" size="20" /&gt;		&amp;nbsp; &amp;nbsp;
				是否发布:
				&lt;input type="radio" name="isshow" value="1" /&gt; 发布 &amp;nbsp; 
				&lt;input type="radio" name="isshow" value="0" /&gt; 草稿
			&lt;/td&gt;
		&lt;/tr&gt;


		&lt;tr&gt;
			&lt;td colspan="2"&gt;
			&lt;textarea name="mycontent" id="mycontent" rows="3" cols="60"&gt;{$mycontent_htmlencode}&lt;/textarea&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		
	&lt;/table&gt;
	&lt;/form&gt;

	&lt;div class=""&gt;&lt;input type="submit" value="submit" onclick="j_post('myform')" class="submit_task" /&gt;&lt;/div&gt;
	{$bottom}
&lt;/div&gt;


&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		$("#classid").val("{$classid}");
		$("#dic").val("{$dic}");
		$("#mytype").val("{$mytype}");

		checkcheckbox("duids[]", "{$duids}");
		checkcheckbox("cuids[]", "{$cuids}");
		$("#zhongyao").val("{$zhongyao}");
		$("#jinji").val("{$jinji}");		
		checkradio("isshow", "{$isshow}");


		$("#plantime").datepicker();

		wedoneteditor("mycontent", 1);
	})
//--&gt;
&lt;/script&gt;</main><css readme="css"/></xml>
