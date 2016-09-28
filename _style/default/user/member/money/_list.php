<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$crumb}
&lt;table class="table1 j_list" cellspacing="0"&gt;
	&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="*"&gt;款项名称&lt;/th&gt;
	&lt;th&gt;收入&lt;/th&gt;
	&lt;th&gt;支出&lt;/th&gt;
	
	&lt;th&gt;支付方式&lt;/th&gt;
	
	&lt;th&gt;当前余额&lt;/th&gt;
	&lt;th&gt;时间&lt;/th&gt;

	&lt;th&gt;操作人&lt;/th&gt;
	&lt;th&gt;备注&lt;/th&gt;
	&lt;/tr&gt;
	
	{$li}
&lt;/table&gt;
{$pagelist}</main><css readme="css"/><li readme="循环">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$title}&lt;/td&gt;
	&lt;td&gt;{$myvalue_no0}&lt;/td&gt;
	&lt;td&gt;{$myvalueout_no0}&lt;/td&gt;
	
	&lt;td&gt;{$mywayname}&lt;/td&gt;
	
	&lt;td&gt;{$sumperson}&lt;/td&gt;
	&lt;td&gt;{$stime_dateformat2}&lt;/td&gt;
	
	&lt;td&gt;{$dnick}&lt;/td&gt;
	&lt;td&gt;&lt;div class="over" style="width:150px"&gt;&lt;span class="title"&gt;&lt;a href="javascript:void(0)" title="{$other}"&gt;{$other}&lt;/a&gt;&lt;/span&gt;&lt;/div&gt;&lt;/td&gt;
&lt;/tr&gt;</li></xml>
