<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;form method="post" action="{$action}" id="myform"&gt;
	&lt;ul&gt;
		{$li}
	&lt;/ul&gt;

	&lt;div class="clear"&gt;&lt;/div&gt;
	&lt;hr /&gt;

	&lt;input type="submit" value="保存" onclick="j_post('myform')" /&gt;
&lt;/form&gt;

&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){
		{$js}
	})
	
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;style type="text/css"&gt;
	.myuser{
		display:inline;
		float:left;
		width:30%;
		height:28px;
		line-height:28px;
	}
&lt;/style&gt;</css><li readme="li">&lt;li class="myuser"&gt;
	&lt;input type="checkbox" name="id[]" value="{$id}" /&gt; {$u_fullname} 	
&lt;/li&gt;</li></xml>
