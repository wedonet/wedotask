<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	
	{$tasktoolbar}

	{$crumb}

	&lt;div style="margin:10px"&gt;
		&lt;div class="fright"&gt;
			&lt;ul&gt;
				&lt;li&gt;&lt;a href="form.php?act=creat"&gt;添加任务&lt;/a&gt;&lt;/li&gt;
			&lt;/ul&gt;
		&lt;/div&gt;
	&lt;/div&gt;

	&lt;div class="clear"&gt;&lt;/div&gt;

	&lt;div class=""&gt;
		&lt;form method="get" action="?" id="myform"&gt;
			&lt;input type="text" name="keywords" value="{$keywords}" /&gt;
			&lt;input type="hidden" name="outtype" value="view" id="outtype" /&gt;
			&lt;select name="taskstatus" id="taskstatus"&gt;
				&lt;option value=""&gt;任务状态&lt;/option&gt;
				&lt;option value="alive"&gt;活动任务&lt;/option&gt;
				&lt;option value="new"&gt;新任务&lt;/option&gt;
				&lt;option value="doing"&gt;正在执行&lt;/option&gt;				
				&lt;option value="redo"&gt;返工&lt;/option&gt;
				&lt;option value="done"&gt;已完成&lt;/option&gt;
				&lt;option value="over"&gt;已结束&lt;/option&gt;
			&lt;/select&gt;			

			&lt;select name="tasktype" id="tasktype"&gt;
				&lt;option value=""&gt;任务类型&lt;/option&gt;
				&lt;option value="normal"&gt;常规任务&lt;/option&gt;
				&lt;option value="bug"&gt;Bug修改&lt;/option&gt;
				&lt;option value="suggest"&gt;建议&lt;/option&gt;
				&lt;option value="willdo"&gt;需求&lt;/option&gt;
			&lt;/select&gt;	



			&amp;nbsp;
			计划时间：&lt;input type="text" name="dtime1" id="dtime1" size="10" value="{$dtime1}" /&gt; 至
			&lt;input type="text" name="dtime2" id="dtime2" size="10" value="{$dtime2}" /&gt;

			&lt;select name="taskuid" id="taskuid"&gt;				
				&lt;option value=""&gt;人员&lt;/option&gt;
				{$optionuser}
			&lt;/select&gt;

			&lt;select name="showtype" id="showtype"&gt;
				&lt;option value=""&gt;显示全部任务&lt;/option&gt;
				&lt;option value="release"&gt;发布的&lt;/option&gt;
				&lt;option value="receive"&gt;执行的&lt;/option&gt;				
				&lt;option value="check"&gt;验收的&lt;/option&gt;	
			&lt;/select&gt;

			&lt;input type="submit" value="submit" /&gt;
			&lt;input type="button" value="导出" onclick="emport()" /&gt;
		&lt;/form&gt;

		&lt;table class="table1 j_list" cellspacing="0"&gt;
			&lt;tr&gt;
			&lt;th&gt;ID&lt;/th&gt;
			&lt;th style="width:320px"&gt;&amp;nbsp;&lt;/th&gt;
			&lt;th&gt;任务类型&lt;/th&gt;
			&lt;th&gt;发布人&lt;/th&gt;
			
			
			&lt;th&gt;执行人&lt;/th&gt;
			&lt;th&gt;验收人/已验收&lt;/th&gt;

			&lt;th&gt;重要&lt;/th&gt;
			&lt;th&gt;紧急&lt;/th&gt;
			
			&lt;th&gt;计划/实际 时间&lt;/th&gt;
			
			&lt;th&gt;最后回复&lt;/th&gt;
			&lt;th&gt;状态&lt;/th&gt;
			&lt;/tr&gt;
			{$li}
		&lt;/table&gt;

		{$pagelist}
	&lt;/div&gt;

	{$bottom}
&lt;/div&gt;
&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		
		{$js}
	})

	function emport(){
		/*更新显示类型为导出*/
		$('#outtype').val('emport');
		/*提交表单*/
		$('#myform').submit();

	}
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){


	$("#dtime1,#dtime2").datepicker();
	
})	
//--&gt;
&lt;/script&gt;</css><li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;&lt;a href="detail.php?id={$id}" target="_blank"&gt;{$title}&lt;/a&gt; &lt;/td&gt;
	&lt;td&gt;{$mytypename}&lt;/td&gt;
	&lt;td&gt;{$sname}&lt;br /&gt;{$ptime}&lt;/td&gt;
	
	&lt;td&gt;{$dname}&lt;br /&gt;{$dunames}&lt;/td&gt;
	&lt;td&gt;{$cunames} &lt;br /&gt; {$actualcnames}&lt;/td&gt;

	&lt;td class="j_tdright{$zhongyao}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td class="j_tdright{$jinji}"&gt;&amp;nbsp;&lt;/td&gt;
	
	&lt;td&gt;{$plantime} &lt;br /&gt; {$actualtime}&lt;/td&gt;
	&lt;td&gt;{$lastuname}&lt;br /&gt;{$lasttime}&lt;/td&gt;

	&lt;td&gt;{$mystatusname}&lt;/td&gt;
&lt;/tr&gt;</li><liemport readme="liemport">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$mycontent}&lt;/td&gt;
	&lt;td&gt;{$mystatusname}&lt;/td&gt;
&lt;/tr&gt;</liemport></xml>
