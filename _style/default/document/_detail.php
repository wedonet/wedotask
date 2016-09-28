<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">{$top}

&lt;div class="main"&gt;
  &lt;div class="crumb"&gt;{$crumb}&lt;/div&gt;

  
  &lt;div class="column01"&gt;
    &lt;div class="block1"&gt;
      &lt;div class="title01"&gt;
        &lt;div class="t_t"&gt;{$channelname}&lt;/div&gt;
        &lt;span&gt;{$channeltip}&lt;/span&gt; &lt;/div&gt;
			&lt;div class="content"&gt;
      
          &lt;div class="title"&gt;{$title}&lt;/div&gt;
			{$mycontent}
      &lt;/div&gt;
      &lt;div class="clear"&gt;&lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
  &lt;div class="column02"&gt;
  
    &lt;div class="sidebar1 none" id="myclass"&gt;
      &lt;div class="title02"&gt;
        &lt;div class="t_t"&gt;本频道分类&lt;/div&gt;
        &lt;span&gt;CHANNEL&lt;/span&gt; &lt;/div&gt;
			&lt;ul class="list05" id="myclassli"&gt;
				{$li(class,current,classic,module,all,_li,liclass)}
			&lt;/ul&gt;
      &lt;div class="clear"&gt;&lt;/div&gt;
    &lt;/div&gt;
    

    

  &lt;/div&gt;
&lt;/div&gt;
&lt;div class="clear"&gt;&lt;/div&gt;
{$bottom}

&lt;script type="text/javascript"&gt;
&lt;!--
	$(document).ready(function(){

		//有分类时显示出分类框
		//&lt;表示有标签
		if ( $("#myclassli").html().indexOf('&lt;') &gt;-1 )
		{
		
			$("#myclass").show();
		}
	})
//--&gt;
&lt;/script&gt;</main><css readme="css"/></xml>
