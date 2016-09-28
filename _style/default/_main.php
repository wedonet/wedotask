<?xml version="1.0" encoding="utf-8"?>
<xml><head readme="head">&lt;!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"&gt;
&lt;html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN"&gt;
&lt;head&gt;
&lt;title&gt;{$title}&lt;/title&gt;
&lt;meta http-equiv="Content-Type" content="text/html; charset=utf-8" /&gt;
&lt;meta name="keywords" content="{$keywords}" /&gt;
&lt;meta name="description" content="{$description}" /&gt;
&lt;meta http-equiv="Content-Language" content="zh-CN" /&gt;
&lt;meta name="generator" content="wedonet" /&gt;
&lt;meta http-equiv="X-UA-Compatible" content="IE=8" /&gt;

&lt;link rel="stylesheet" href="{$webdir}_css/main.css?{$timestamp}" type="text/css" /&gt;
&lt;link rel="stylesheet" href="{$styledir}css/_main.css?{$timestamp}" type="text/css" /&gt;

&lt;link rel="stylesheet" href="/task/css/task.css?{$timestamp}" type="text/css" /&gt;

&lt;script src="{$webdir}_js/base.js?{$timestamp}" type="text/javascript"&gt;&lt;/script&gt;
&lt;script src="{$webdir}_js/main.js?{$timestamp}" type="text/javascript"&gt;&lt;/script&gt;


&lt;!--jquery ui--&gt;
&lt;script type="text/javascript" src="/_js/ui/jquery.ui.core.min.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="/_js/ui/jquery.ui.widget.min.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="/_js/ui/jquery.ui.datepicker.min.js"&gt;&lt;/script&gt;
&lt;script src="/_js/ui/i18n/jquery.ui.datepicker-zh-CN.min.js" type="text/javascript"&gt;&lt;/script&gt;
&lt;script src="/_js/jquery.tools.min.js" type="text/javascript"&gt;&lt;/script&gt;
&lt;link type="text/css" href="/_js/ui/css/jquery.ui.all.css" rel="stylesheet" /&gt;


{$headplus}

&lt;link rel="shortcut icon" href="favicon.ico" /&gt;
&lt;/head&gt;
&lt;body&gt;</head><top readme="网页最上面的容器">&lt;!--头部--&gt;</top><page readme="翻页代码">&lt;div class="page"&gt;
	&lt;ul&gt;
		{$pre}
		{$pagelist}
		{$next}
	&lt;/ul&gt;
	&lt;div class="clear"&gt;&lt;/div&gt;
&lt;/div&gt;</page><foot readme="foot">&lt;/body&gt;
&lt;/html&gt;</foot><crumb readme="面包屑">&lt;div class="crumb"&gt;
	&lt;ul&gt;
		&lt;li class="present"&gt;当前位置:&lt;/li&gt;
		&lt;li class="home"&gt;&lt;a href="{$webdir}"&gt;首 页&lt;/a&gt;&lt;/li&gt;
         		{$li}
	&lt;/ul&gt;
	&lt;div class="clear"&gt;&lt;/div&gt;
&lt;/div&gt;</crumb><bottom readme="网页底部容器">&lt;div class="foot"&gt;
	&lt;p&gt;{$debuginfo}&lt;/p&gt;
&lt;/div&gt;</bottom><menu readme="导航">&lt;div class="menu"&gt;
	&lt;ul&gt;
		&lt;li style="display:none"&gt;&lt;a href="/task/" id="j_object"&gt;项目&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="/task/" id="j_navtask"&gt;任务管理&lt;/a&gt;&lt;/li&gt;
		&lt;li&gt;&lt;a href="/log/" id="j_navlog"&gt;更新日志&lt;/a&gt;&lt;/li&gt;
	&lt;/ul&gt;
	&lt;div class="clear"&gt;&lt;/div&gt;
&lt;/div&gt;</menu><menuli readme="导航的循环部分">&lt;li&gt;&lt;a href="{$href}" {$target} title="{$mytip}"&gt;{$title}&lt;/a&gt;&lt;/li&gt;</menuli><linews readme="酷连动态循环部分">&lt;li&gt;
    &lt;div class="title"&gt;&lt;a href="{$href}"&gt;{$title}&lt;/a&gt;&lt;/div&gt;
    &lt;div class="time"&gt;[{$ptime_dateformat4}]&lt;/div&gt;
&lt;/li&gt;</linews><lititle readme="只带标题的li">&lt;li&gt;
    &lt;div class="title"&gt;&lt;a href="{$href}"&gt;{$title}&lt;/a&gt;&lt;/div&gt;
&lt;/li&gt;</lititle><loading readme="Ajax跳转时的过场动画">&lt;div class="pxsmall"&gt;
	&lt;div style="padding:20px 50px;text-align:center;"&gt;
		&lt;img src="/_images/loading.gif" alt="Loading" /&gt;
	&lt;/div&gt;
&lt;/div&gt;</loading></xml>
