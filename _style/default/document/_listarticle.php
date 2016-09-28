<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}
&lt;div class="main"&gt;
  &lt;div class="crumb"&gt;{$crumb}&lt;/div&gt;
  &lt;div class="clear"&gt;&lt;/div&gt;
  &lt;div class="column01"&gt;
    &lt;div class="block1"&gt;
      &lt;div class="title01"&gt;
        &lt;div class="t_t"&gt;{$channelname}&lt;/div&gt;
        &lt;span&gt;{$channeltip}&lt;/span&gt; &lt;/div&gt;
      &lt;ul class="list_text"&gt;
        {$list}
      &lt;/ul&gt;
      &lt;div class="clear"&gt;&lt;/div&gt;
      {$pagelist} &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="column02"&gt;
    &lt;div class="sidebar1"&gt;
      &lt;div class="title02"&gt;
        &lt;div class="t_t"&gt;本频道分类&lt;/div&gt;
        &lt;span&gt;CHANNEL&lt;/span&gt; &lt;/div&gt;
      &lt;ul class="list05" id="myclassli"&gt;
        {$li(class,current,classic,module,all,_li,liclass)}
      &lt;/ul&gt;
      &lt;div class="clear"&gt;&lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="sidebar1"&gt;
      &lt;div class="title02"&gt;
        &lt;div class="t_t"&gt;通知公告&lt;/div&gt;
        &lt;span&gt;NOTICE&lt;/span&gt; &lt;/div&gt;
      &lt;ul class="list03 over"&gt;
        {$li(document,adv,class,special,new,8,_li,liview)}
      &lt;/ul&gt;
      &lt;div class="clear"&gt;&lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="sidebar1"&gt;
      &lt;div&gt;&lt;a href="/map.php" target="_blank"&gt;&lt;img src="{$styledir}/images/map.png" alt=""/&gt;&lt;/a&gt;&lt;/div&gt;
    &lt;/div&gt;
    &lt;div class="sidebar1"&gt;
      &lt;div class="sidebar1_bg"&gt;
        &lt;div class="title03"&gt;
          &lt;div class="t_t"&gt;联系我们&lt;/div&gt;
          &lt;span&gt;CONTACT US&lt;/span&gt; &lt;/div&gt;
        &lt;div class="tel"&gt;&lt;a href="#"&gt;022-11111111&lt;/a&gt;&lt;/div&gt;
        &lt;div class="email"&gt;&lt;a href="#"&gt;dllyjghhd@126.com&lt;/a&gt;&lt;/div&gt;
        &lt;div class="line"&gt;&lt;/div&gt;
        &lt;div class="title03"&gt;
          &lt;div class="t_t"&gt;友情链接&lt;/div&gt;
          &lt;span&gt;LINKS&lt;/span&gt; &lt;/div&gt;
        &lt;div class="link"&gt;&lt;a href="#"&gt; 东丽之窗&lt;/a&gt;&lt;/div&gt;
        &lt;div class="link"&gt;&lt;a href="#"&gt; 中国天津旅游政务网&lt;/a&gt;&lt;/div&gt;
        &lt;div class="link"&gt;&lt;a href="#"&gt; 天津旅游资讯网&lt;/a&gt;&lt;/div&gt;
        &lt;div class="link"&gt;&lt;a href="#"&gt; 天津欢乐谷&lt;/a&gt;&lt;/div&gt;
        &lt;div class="link"&gt;&lt;a href="#"&gt; 东丽湖门户网&lt;/a&gt;&lt;/div&gt;
        &lt;div class="link"&gt;&lt;a href="#"&gt; 天海风水上休闲运动俱乐部&lt;/a&gt;&lt;/div&gt;
        &lt;div class="link"&gt;&lt;a href="#"&gt; 华明镇&lt;/a&gt;&lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;div class="clear"&gt;&lt;/div&gt;
{$bottom}</main><css readme="css"/><li readme="li循环">&lt;li&gt;
	&lt;div class="info02"&gt;
		&lt;div class="title"&gt;&lt;a href="{$href}"&gt;{$title}&lt;/a&gt;&lt;/div&gt;
		&lt;div class="readme"&gt;{$readme}&lt;/div&gt;
	&lt;/div&gt;
&lt;div class="clear"&gt;&lt;/div&gt;
&lt;/li&gt;</li></xml>
