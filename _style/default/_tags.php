<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;div class="main"&gt;
	{$crumb}
	&lt;h1&gt;1. 显示记录列表: { $li(document,news,class,special,good,10,_li,title)} &lt;/h1&gt;

	&lt;p&gt;document:标签类型,document表示调用文档模块&lt;/p&gt;

	&lt;p&gt;news: 频道标识,必填&lt;/p&gt;

	&lt;p&gt;class:分类标识,没有可不填
	&lt;/p&gt;
	&lt;p&gt;special:专题标识,没有可不填
	&lt;/p&gt;
	&lt;p&gt;good:调用类型 new=最新, good=推荐
	&lt;/p&gt;
	&lt;p&gt;10=显示数量
	&lt;/p&gt;
	&lt;p&gt;_li :循环部分所在页
	&lt;/p&gt;
	&lt;p&gt;title: 循环部分代码名称
	&lt;/p&gt;

	&lt;h5&gt;显示结果:&lt;/h5&gt;
	{$li(document,document,class,special,new,10,_li,lititle)} 






	&lt;!-- 显示分类 --&gt;
	&lt;h1&gt;2.显示分类 {&lt;span&gt;$&lt;/span&gt;li(class,channelic,classic,showtype,_li,title)}&lt;/h1&gt;

	&lt;p&gt;class:标签类型,不变&lt;/p&gt;
	
	&lt;p&gt;channelic: 频道标识&lt;/p&gt;	

	&lt;p&gt;classic:分类标识&lt;/p&gt;

	&lt;p&gt;showtype:显示类型 classone=只显示一级分类 all=显示当前频道所有分类  current=显示当前分类的下级分类&lt;/p&gt;

	
	
	&lt;h5&gt;结果:&lt;/h5&gt;
	
	{$li(class,document,classic,all,_li,liclass)}






	&lt;h4&gt;3. 频道标签&lt;/h4&gt;
	{&lt;span&gt;$&lt;/span&gt;li(channel,type,page,nameul,nameli)}

	&lt;p&gt;channel:类型,保持不变&lt;/p&gt;
	&lt;p&gt;type:频道类型&lt;/p&gt;
	&lt;p&gt;page:页名,可省略 默认 _main &lt;/&gt;
	&lt;p&gt;nameul:容器代码名 可省略 默认 menuul&lt;/p&gt;
	&lt;p&gt;nameli:列表代码名 可省略 默认 menuli&lt;/p&gt;

	&lt;h5&gt;显示结果:&lt;/h5&gt;
	{$li(channel)}






	&lt;h4&gt;4. 模板标签&lt;/h4&gt;
	{&lt;span&gt;$&lt;/span&gt;li(style,page,name,showcount)}
	&lt;p&gt;style:类型&lt;/p&gt;
	&lt;p&gt;showcount:显示数量&lt;/p&gt;

	&lt;h5&gt;显示结果(top):&lt;/h5&gt;
	{$li(style,_main,top)}



	&lt;h4&gt;5.List标签&lt;/h4&gt;
	{&lt;span&gt;$&lt;/span&gt;li(list,page,name)}
	&lt;p&gt;page:&lt;/p&gt;
	&lt;p&gt;name:&lt;/p&gt;




	&lt;div style="height:100px"&gt;&lt;p style="margin:50px;text-align:center"&gt;{$debuginfo}&lt;/p&gt;&lt;/div&gt;
&lt;/div&gt;</main><css readme="css">&lt;link rel="stylesheet" type="text/css" href="{$webdir}_css/tags.css?{$timestamp}" /&gt;</css></xml>
