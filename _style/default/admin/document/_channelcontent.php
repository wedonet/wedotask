<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;form method="post" action="{$action}" id="myform"&gt;
	
&lt;div class="th1"&gt;简介&lt;/div&gt;
&lt;textarea name="readme" id="readme" rows="3" cols="60" class="it"&gt;{$readme_htmlencode}&lt;/textarea&gt;
&lt;div class="th1"&gt;详细描述&lt;/div&gt;
&lt;textarea name="content" id="content" rows="3" cols="60"&gt;{$content_htmlencode}&lt;/textarea&gt;

&lt;p&gt;&lt;/p&gt;
&lt;div class="submit"&gt;
	&lt;input type="submit" value=" 提 交 " onclick="j_post('myform')" /&gt;
&lt;/div&gt;

&lt;/form&gt;
&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	wedoneteditor("content", 1, "{$editorup}");
})	
//--&gt;
&lt;/script&gt;</main><css readme="css">&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){
	wedoneteditor("content", 1);
})	
//--&gt;
&lt;/script&gt;</css></xml>
