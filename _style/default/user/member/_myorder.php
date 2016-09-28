<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$crumb}

&lt;p&gt;&amp;nbsp;&lt;/p&gt;


&lt;table class="table1 j_list" cellspacing="0" id="hotel_member_order"&gt;
	&lt;tr&gt;
	&lt;th width="40"&gt;ID&lt;/th&gt;
	&lt;th width="*"&gt;酒店名称 / 房态&lt;/th&gt;
	&lt;th width="60"&gt;房量(间)&lt;/th&gt;
	&lt;th width="40"&gt;总价&lt;/th&gt;
	&lt;th width="160"&gt;时间&lt;/th&gt;
	&lt;th width="60"&gt;状态&lt;/th&gt;
	&lt;th width="120"&gt;操作&lt;/th&gt;
	&lt;/tr&gt;
	{$li}
&lt;/table&gt;

{$pagelist}

&lt;script type="text/javascript" src="/_js/bll.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	//用户定单管理格式化操作内容
	operatehotelcsutom();
})	
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;script type="text/javascript" src="/_js/bll.js"&gt;&lt;/script&gt;</css><li readme="li">&lt;tr&gt;
	&lt;td&gt;{$id}&lt;/td&gt;
	&lt;td&gt;{$酒店名称} {$房态}&lt;/td&gt;
	&lt;td&gt;{$roomcount}&lt;/td&gt;
	&lt;td&gt;{$allprice}&lt;/td&gt;
	&lt;td&gt;{$mydate1} 至 {$mydate2}&lt;/td&gt;
	&lt;td&gt;{$定单状态}&lt;/td&gt;
	&lt;td class="j_customoperate"&gt;
		&lt;a href="?act=view&amp;amp;id={$id}"&gt;查看&lt;/a&gt; 
		&lt;a href="?act=edit&amp;amp;id={$id}" class="j_edit_{$mystatus} none"&gt;修改&lt;/a&gt;
		&lt;a href="?act=cancel&amp;amp;id={$id}" title="取消{$mydate1}至{$mydate2},{$房态} 定单" class="j_cancel_{$mystatus} j_del none "&gt;取消&lt;/a&gt;
	&lt;/td&gt;
&lt;/tr&gt;</li><form readme="form">{$crumb}


&lt;p&gt;&amp;nbsp;&lt;/p&gt;

&lt;form method="post" action="{$action}" id="myform"&gt;


	&lt;table class="table1" cellspacing="1" &gt;
		&lt;tr&gt;
			&lt;th colspan="2"&gt;房态名称 - 早餐说明&lt;/th&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;房间数量&lt;/td&gt;
			&lt;td&gt;
				&lt;select name="roomcount" id="roomcount"&gt;
					&lt;option value="1"&gt;1&lt;/option&gt;
					&lt;option value="2"&gt;2&lt;/option&gt;
					&lt;option value="3"&gt;3&lt;/option&gt;
					&lt;option value="4"&gt;4&lt;/option&gt;
					&lt;option value="5"&gt;5&lt;/option&gt;
				&lt;/select&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;入住时间&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="mydate1" id="mydate1" value="{$mydate1}" /&gt; 
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;离店时间&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="mydate2" id="mydate2" value="{$mydate2}" /&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;客人姓名&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="guestname1" id="guestname1" value="{$guestname1}" /&gt; &amp;nbsp; 
				&lt;span id="guestname2" style="display:none"&gt;姓名2&lt;input type="text" name="guestname2" value="{$guestname2}" /&gt;&lt;/span&gt; &amp;nbsp;
				&lt;span id="guestname3" style="display:none"&gt;姓名3&lt;input type="text" name="guestname3" value="{$guestname3}" /&gt;&lt;/span&gt; &amp;nbsp;
				&lt;span id="guestname4" style="display:none"&gt;姓名4&lt;input type="text" name="guestname4" value="{$guestname4}" /&gt;&lt;/span&gt; &amp;nbsp;
				&lt;span id="guestname5" style="display:none"&gt;姓名5&lt;input type="text" name="guestname5" value="{$guestname5}" /&gt;&lt;/span&gt; &amp;nbsp;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;联系手机&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="guestmobile" value="{$guestmobile}" /&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;Email&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="text" name="guestmail" value="{$guestmail}" /&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr valign="top"&gt;
			&lt;td&gt;留房时间&lt;/td&gt;
			&lt;td&gt;
				{$arrivetime1}:00 至 {$arrivetime2}:00
			&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr valign="top"&gt;
			&lt;td&gt;房费总计&lt;/td&gt;
			&lt;td&gt;
				{$allprice} 元
			&lt;/td&gt;
		&lt;/tr&gt;

	


		&lt;tr&gt;
			&lt;td&gt;&amp;nbsp;&lt;/td&gt;
			&lt;td&gt;
				&lt;input type="submit" value=" 提 交 " onclick="j_post('myform')" /&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

	&lt;/table&gt;	  
	  
&lt;/form&gt;





&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	$('#mydate1').datepicker();	
	$('#mydate2').datepicker();	

	$(".j_codestr").getcode();

	$("#roomcount").val("{$roomcount}");

	$("#roomcount").bind("change", function(){
		var v = $(this).val()*1;
		var v2=v+1;

		for (var i=2; i&lt;v2; i++)
		{
			$("#guestname"+i).show();
		}

	})
})

//--&gt;
&lt;/script&gt;</form><detailorder readme="订单详细信息">{$crumb}


&lt;p&gt;&amp;nbsp;&lt;/p&gt;

&lt;table class="table1" cellspacing="1" &gt;
	&lt;tr&gt;
		&lt;th colspan="2"&gt;{$roomname}&lt;/th&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td width="108"&gt;房间数量&lt;/td&gt;
		&lt;td width="*"&gt;{$roomcount} 间&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;入住时间&lt;/td&gt;
		&lt;td&gt;{$mydate1}&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;离店时间&lt;/td&gt;
		&lt;td&gt;{$mydate2}&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;客人姓名&lt;/td&gt;
		&lt;td&gt;{$guestname1} {$guestname2} {$guestname3} {$guestname4} {$guestname5}&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;联系手机&lt;/td&gt;
		&lt;td&gt;{$guestmobile}&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr&gt;
		&lt;td&gt;Email&lt;/td&gt;
		&lt;td&gt;{$guestmail}&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr valign="top"&gt;
		&lt;td&gt;留房时间&lt;/td&gt;
		&lt;td&gt;{$arrivetime1}:00 至 {$arrivetime2}:00	&lt;/td&gt;
	&lt;/tr&gt;

	&lt;tr valign="top"&gt;
		&lt;td&gt;房费总计&lt;/td&gt;
		&lt;td&gt;{$allprice} 元	&lt;/td&gt;
	&lt;/tr&gt;
&lt;/table&gt;	  
	  




&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){

})

//--&gt;
&lt;/script&gt;</detailorder></xml>
