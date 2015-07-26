<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"&gt;
&lt;html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN"&gt;
&lt;head&gt;

&lt;title&gt;{$webname} - 管理中心&lt;/title&gt;
&lt;meta http-equiv="Content-Type" content="text/html; charset=utf-8" /&gt;

&lt;link href="css/main.css" rel="stylesheet" type="text/css" /&gt;
&lt;script type="text/javascript" src="../_js/base.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="../_js/main.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript"&gt;
$(document).ready(function(){
&lt;!--
	if($.browser.mozilla==true){
		$("#navleft").attr("scrolling","auto");
		$("#mainindex").attr("scrolling","auto");
	}
//--&gt;
})
&lt;/script&gt;

&lt;style type="text/css"&gt;
	body {height:100%; overflow:visible;}
	table{
		border:0;
		width:100%;
		height:100%;
	}
	td{height:100%;padding:0;margin:0;}
	td.left{width:200px;}
&lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;

&lt;table width="100%"  border="0"&gt;
&lt;tr&gt;
&lt;td class="left"&gt;
&lt;iframe id="navleft" src="admin_left.php"  frameborder="0" scrolling="yes" style="height: 100%; width:200px;" &gt;&lt;/iframe&gt;
&lt;/td&gt;
&lt;td class="right"&gt;

&lt;iframe id="mainindex" name="mainindex" src="admin_index.php?act=admin_main" frameborder="0" scrolling="yes" style="height: 100%; width:100%;"&gt;&lt;/iframe&gt;&lt;/td&gt;
&lt;/tr&gt;
&lt;/table&gt;
&lt;/body&gt;
&lt;/html&gt;</main></xml>
