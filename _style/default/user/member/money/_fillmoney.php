<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$crumb}

&lt;form action="{$action}" method="post" id="myform"&gt;
	&lt;table class="table1 j_list" cellspacing="0"&gt;
		&lt;tr&gt;
			&lt;th colspan="2"&gt;用户信息&lt;/th&gt;
		&lt;/tr&gt;
		&lt;tr&gt;
			&lt;td width="30%"&gt;用户ID&lt;/td&gt;
			&lt;td&gt;{$id}&lt;/td&gt;
		&lt;/tr&gt;
		&lt;tr&gt;
			&lt;td&gt;用户名&lt;/td&gt;
			&lt;td&gt;{$u_name}&lt;/td&gt;
		&lt;/tr&gt;
		&lt;tr&gt;
			&lt;td&gt;用户称呼&lt;/td&gt;
			&lt;td&gt;{$u_nick}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;总额&lt;/td&gt;
			&lt;td&gt;{$aall}&lt;/td&gt;
		&lt;/tr&gt;


		&lt;tr&gt;
			&lt;td&gt;可用余额&lt;/td&gt;
			&lt;td&gt;{$acanuse}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;冻结&lt;/td&gt;
			&lt;td&gt;{$afrize}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;入款&lt;/td&gt;
			&lt;td&gt;{$ain}&lt;/td&gt;
		&lt;/tr&gt;

		&lt;tr&gt;
			&lt;td&gt;支出&lt;/td&gt;
			&lt;td&gt;{$aout}&lt;/td&gt;
		&lt;/tr&gt;
	&lt;/table&gt;
	&lt;br /&gt;
	&lt;br /&gt;


	&lt;table class="table1 j_list" cellspacing="0"&gt;
		&lt;tr&gt;
			&lt;th colspan="2"&gt;充值&lt;/th&gt;
		&lt;/tr&gt;
	
		&lt;tr&gt;
			&lt;td&gt;选择支付方式&lt;/td&gt;
			&lt;td&gt;
				&lt;a href="{$hrefpay}" class="j_open"&gt;&lt;img src="/_images/pay/logo01.jpg" alt="" /&gt;&lt;/a&gt;
			&lt;/td&gt;
		&lt;/tr&gt;

		
	
	&lt;/table&gt;
&lt;/form&gt;</main><css readme="css"/><htmlpay readme="htmlpay">&lt;div class="pxmiddle"&gt;&#13;
	&lt;div class="th"&gt;在线支付&lt;/div&gt;&#13;
&#13;
	&lt;div class="ac"&gt;&#13;
		&lt;form method="post" action="{$action}" id="formpay"&gt;&#13;
			&lt;table class="table1" cellspacing="0" &gt;&#13;
				&lt;tr&gt;&#13;
					&lt;td width="30%"&gt;金额&lt;/td&gt;&#13;
					&lt;td&gt;&lt;input type="text" name="myvalue" id="myvalue" /&gt;元&lt;/td&gt;&#13;
				&lt;/tr&gt;&#13;
&#13;
				&lt;tr&gt;&#13;
					&lt;td&gt;&amp;nbsp;&lt;/td&gt;&#13;
					&lt;td&gt;&lt;input type="submit" value="提交" onclick="j_repost('formpay')" /&gt;&lt;/td&gt;&#13;
				&lt;/tr&gt;&#13;
			&lt;/table&gt;&#13;
		&lt;/form&gt;&#13;
	&lt;/div&gt;&#13;
&lt;/div&gt;</htmlpay></xml>
