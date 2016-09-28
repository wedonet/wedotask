<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	{$tasktoolbar}

	{$crumb}

	&lt;form method="post" action="{$action}" id="myform"&gt;
		
	
	&lt;table class="table1" cellspacing="0"&gt;
		&lt;tr&gt;
			&lt;td  width="120"&gt;任务名：&lt;/td&gt;
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
			&lt;td&gt;部门:&lt;/td&gt;
			&lt;td&gt;
				&lt;select name="dic" id="dic"&gt;
					&lt;option value=""&gt;&lt;/option&gt;
					{$optiondepartment}
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;任务类型:&lt;/td&gt;
			&lt;td&gt;
				&lt;select name="mytype" id="mytype"&gt;
					&lt;option value=""&gt;&lt;/option&gt;
					&lt;option value="normal"&gt;常规任务&lt;/option&gt;
					&lt;option value="bug"&gt;Bug修改&lt;/option&gt;
					&lt;option value="suggest"&gt;功能建议&lt;/option&gt;
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;执行人：&lt;/td&gt;
			&lt;td&gt;{$checkboxduid} &lt;a href="javascript:void(0)" class="j_showmore unline"&gt; &amp;gt;&amp;gt;更多...&lt;/a&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;验收人：&lt;/td&gt;
			&lt;td&gt;{$checkboxcuid}  &lt;a href="javascript:void(0)" class="j_showmore unline"&gt; &amp;gt;&amp;gt;更多...&lt;/a&gt;&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;级别:&lt;/td&gt;
				&lt;td&gt;重要程度：&lt;select name="zhongyao" id="zhongyao"&gt;
					&lt;option value="10"&gt;一般&lt;/option&gt;
					&lt;option value="20"&gt;重要&lt;/option&gt;
				&lt;/select&gt; &amp;nbsp; 
				紧极程度：

				&lt;select name="jinji" id="jinji"&gt;
					&lt;option value="10"&gt;一般&lt;/option&gt;
					&lt;option value="20"&gt;重要&lt;/option&gt;
				&lt;/select&gt; &amp;nbsp; 
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;计划完成时间：&lt;/td&gt;
			&lt;td&gt;&lt;input type="text" name="plantime" id="plantime" value="{$plantime}" size="20" /&gt;			
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;其它：&lt;/td&gt;
			&lt;td&gt;是否发布：
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

		var json_user = {$json_user};
		updateuseridlist(json_user); //显示出常用执行，验收人，和已选中的人
	})
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;script type="text/javascript" src="js/form.js"&gt;&lt;/script&gt;

&lt;style type="text/css"&gt;
	.myuser{
		display:inline;
		float:left;
		width:30%;
	}
&lt;/style&gt;</css><formmore readme="更多联系人">&lt;div class="pxmiddle"&gt;
	&lt;div class="th"&gt;更多&lt;/a&gt;&lt;/div&gt;
	&lt;div class="ac"&gt;
		&lt;form method="post" action="{$action}" id="formmore"&gt;
			&lt;ul&gt;
				{$li}
			&lt;/ul&gt;
			&lt;div class="clear"&gt;&lt;/div&gt;
			&lt;hr /&gt;
			
			&lt;input type="button" value=" 确 认 " onclick="updateuser('{$mytype}')" /&gt;
		&lt;/form&gt;
	&lt;/div&gt;
&lt;/div&gt;</formmore><formmoreli readme="更多联系人列表">&lt;li class="myuser"&gt;
	&lt;input type="checkbox" name="userlist" value="{$id}" /&gt; {$u_fullname} 
	
&lt;/li&gt;</formmoreli></xml>
