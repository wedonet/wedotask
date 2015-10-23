<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
	
	{$tasktoolbar}
	
	{$crumb}

	&lt;div class="operate"&gt;
		
	&lt;/div&gt;

	&lt;h4 style="font-size:14px;font-weigh:bold;padding:10px 0;text-align:center;border-bottom:1px solid #333;height:14px;"&gt;
		&lt;span style="width:90%;overflow:hidden;float:left;white-space:nowrap;text-overflow:ellipsis;"&gt;ID:{$id}&amp;nbsp;&amp;nbsp;{$title}{$isshow} (by {$sname} {$stime}) -- &lt;span style="color:#00"&gt;{$mystatusname}&lt;/span&gt;&lt;/span&gt;
		&lt;span class="fright"&gt;&lt;a href="formson.php?act=creat&amp;amp;pid={$id}"&gt;[添加子任务]&lt;/a&gt;&lt;/span&gt;
		&lt;span class="clear"&gt;&lt;/span&gt;
	&lt;/h4&gt;
		
	
	&lt;table class="table1" cellspacing="0"&gt;

		&lt;tr&gt;
			&lt;td colspan="2"&gt;执行人：{$dunames} &amp;nbsp;&amp;nbsp;&amp;nbsp;
			计划完成时间：{$plantime} &amp;nbsp;&amp;nbsp;&amp;nbsp;
			重要程度：{$zhongyao} &amp;nbsp;&amp;nbsp;&amp;nbsp;
			紧极程度：{$jinji} &amp;nbsp; &lt;/td&gt;
		
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td width="200"&gt;验收人：&lt;/td&gt;
			&lt;td&gt;{$cunames}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;实际验收人：&lt;/td&gt;
			&lt;td&gt;{$actualcnames}&lt;/td&gt;
		&lt;/tr&gt;


		&lt;tr&gt;
			&lt;td colspan="2" style="padding:0"&gt;
			&lt;div class="mycontent"&gt;
			{$mycontent}
			&lt;/div&gt;
			&lt;/td&gt;
		&lt;/tr&gt;		
	&lt;/table&gt;
	
	&lt;div class="taskoperate" id="taskoperate"&gt;
		&lt;ul&gt;
			&lt;li id="j_publish" style="display:none"&gt;&lt;a href="operate.php?act=publish&amp;amp;id={$id}" class="j_open"&gt;发布&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_edit" style="display:none"&gt;&lt;a href="form.php?act=edit&amp;amp;id={$id}"&gt;修改&lt;/a&gt;&lt;/li&gt;

			&lt;li id="j_doing" style="display:none"&gt;&lt;a href="operate.php?act=doing&amp;amp;id={$id}" class="j_open"&gt;正在执行&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_done" style="display:none"&gt;&lt;a href="operate.php?act=done&amp;amp;id={$id}" class="j_open"&gt;完成&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_redo" style="display:none"&gt;&lt;a href="operate.php?act=redo&amp;amp;id={$id}" class="j_open"&gt;返工&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_check" style="display:none"&gt;&lt;a href="operate.php?act=ok&amp;amp;id={$id}" class="j_open"&gt;检测通过&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_cancel" style="display:none"&gt;&lt;a href="operate.php?act=cancel&amp;amp;id={$id}" class="j_open" title="取消 {$title}"&gt;取消&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_over" style="display:none"&gt;&lt;a href="?act=over&amp;amp;id={$id}"&gt;结束&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_log"&gt;&lt;a href="log.php?id={$id}" target="_blank"&gt;日志&lt;/a&gt;&lt;/li&gt;
			&lt;li id="j_del" style="display:none"&gt;&lt;a href="operate.php?act=del&amp;amp;id={$id}" class="j_open" title="删除 {$title}"&gt;删除&lt;/a&gt;&lt;/li&gt;

			&lt;li class0
			="fright" style="display:none"&gt;&lt;a href="javascript:void(0)" onclick="CKEDITOR.instances.mycontent.focus();$('#mytype').val('message');"&gt;留言&lt;/a&gt;&lt;/li&gt;
			&lt;li class="fright" style="display:none"&gt;&lt;a href="javascript:void(0)" onclick="CKEDITOR.instances.mycontent.focus();$('#mytype').val('redo');"&gt;返工&lt;/a&gt;&lt;/li&gt;
			&lt;li style="margin-left:100px;"&gt;&lt;/li&gt;
			{$showdetailoperate}
		&lt;/ul&gt;
	&lt;/div&gt;

	&lt;p&gt;&lt;/p&gt;

	{$mysonlist}
	{$reply}
	&lt;div&gt;&lt;/div&gt;
	&lt;form method="post" action="reply.php?act=nsave&amp;amp;id={$id}" id="myform"&gt;
		&lt;div style="height:20px"&gt;&lt;/div&gt;

		&lt;p&gt;
		&lt;div class="tasktitle"&gt;
			[回复] 主题: &lt;input type="text" name="title" id="title" size="50" value="{$title}" /&gt; &amp;nbsp;

			类型： 
			
			&lt;select id="mytype" name="mytype"&gt;
				&lt;option value="message"&gt;留言&lt;/option&gt;
				&lt;option value="redo"&gt;返工&lt;/option&gt;
				&lt;option value="info"&gt;验收信息&lt;/option&gt;
			&lt;/select&gt;&lt;/p&gt;
		&lt;/div&gt;
		&lt;p&gt;
			&lt;textarea name="mycontent" id="mycontent" rows="3" cols="60"&gt;&lt;/textarea&gt;
		&lt;/p&gt;
		&lt;input type="submit" value="submit" onclick="j_post('myform')"  class="submit_task" /&gt;
	&lt;/form&gt;

	

	{$bottom}
&lt;/div&gt;


&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		wedoneteditor("mycontent", 1);
		
		{$js}

	})
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;script type="text/javascript" src="{$webdir}task/js/task.js"&gt;&lt;/script&gt;</css><li readme="回复循环部分">&lt;div class="limessage limessage_{$mytype}"&gt;
	&lt;h4 style="font-size:14px;font-weight:bold;margin:5px 0;"&gt;[{$mytypename}] {$title} (by {$sname}) {$stime} &lt;/h4&gt;
	
	&lt;div style="font-size:14px;margin:20px 0"&gt;{$mycontent}&lt;/div&gt;

	&lt;div style="background:#eee"&gt;
		操作: &lt;a href="reply.php?act=edit&amp;amp;id={$id}"&gt;修改&lt;/a&gt; &amp;nbsp; 
		&lt;a href="reply.php?act=del&amp;amp;id={$id}" class="j_del" title="删除"&gt;删除&lt;/a&gt;
	&lt;/div&gt;
			
&lt;/div&gt;</li><ulmyson readme="子任务">&lt;div class="titlemyson"&gt;子任务&lt;/div&gt;

	&lt;div id="myson"&gt;
		&lt;table class="table1 j_list" cellspacing="0"&gt;
			&lt;tr&gt;
			&lt;th&gt;ID&lt;/th&gt;
			&lt;th style="width:320px"&gt;&amp;nbsp;&lt;/th&gt;

			&lt;th&gt;发布人&lt;/th&gt;
			
			
			&lt;th&gt;执行人&lt;/th&gt;
			&lt;th&gt;验收人/已验收&lt;/th&gt;

			&lt;th&gt;重&lt;/th&gt;
			&lt;th&gt;急&lt;/th&gt;
			
			
			&lt;th&gt;计划/实际&lt;/th&gt;
			
			&lt;th&gt;最后回复&lt;/th&gt;

			&lt;th width="50"&gt;状态&lt;/th&gt;
			&lt;/tr&gt;
			{$li}
		&lt;/table&gt;

	
	&lt;/div&gt;

	

&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){

		/*草稿显示为 稿*/
		$(".j_isshow").html(function(index, v){
			if ( "0" == v)
			{
				return "(稿)";
			}
			else{
				return "";
			}
			
		})


		formatnew('j_new', '{$uid}'); //我的未读任务，显示新

		

		{$js}
	})
//--&gt;
&lt;/script&gt;</ulmyson><limyson readme="子任务列表">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;
		&lt;a href="detailsontask.php?id={$id}" target="_blank"&gt;{$title}&lt;/a&gt; 
		&lt;span class="j_isshow"&gt;{$isshow}&lt;/span&gt;
		&lt;span class="j_new"&gt;{$duids}|{$rduids}&lt;/span&gt;
	&lt;/td&gt;

	&lt;td&gt;{$sname}&lt;br /&gt;{$ptime}&lt;/td&gt;
	
	&lt;td&gt;{$dname}&lt;br /&gt;{$dunames}&lt;/td&gt;
	&lt;td&gt;{$cunames} &lt;br /&gt; {$actualcnames}&lt;/td&gt;

	&lt;td class="j_tdright{$zhongyao}"&gt;&amp;nbsp;&lt;/td&gt;
	&lt;td class="j_tdright{$jinji}"&gt;&amp;nbsp;&lt;/td&gt;
	
	&lt;td&gt;{$plantime} &lt;br /&gt; {$actualtime}&lt;/td&gt;
	&lt;td&gt;{$lastuname}&lt;br /&gt;{$lasttime}&lt;/td&gt;

	&lt;td&gt;{$mystatusname}&lt;/td&gt;
&lt;/tr&gt;</limyson></xml>
