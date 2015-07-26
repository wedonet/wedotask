<?xml version="1.0" encoding="utf-8"?>
<xml><myform readme="新建动态表">&lt;form method="post" action="{$action}" name="myform" id="myform"&gt;
  &lt;table class="table1" cellspacing="0"&gt;
    &lt;tr&gt;
      &lt;td width="108"&gt;名称:&lt;/td&gt;
      &lt;td width="*"&gt;
			&lt;input type="text" name="title" id="title" value="{$title}" size="40" /&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;分类:&lt;/td&gt;
      &lt;td&gt;
			&lt;select name="classid" id="classid"&gt;
				&lt;option value=""&gt;选择分类&lt;/option&gt;
				{$optionclass}
			&lt;/select&gt;
		&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
      &lt;td&gt;提示:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="mytip" value="{$mytip}" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

	 &lt;tr&gt;
      &lt;td&gt;简介:&lt;/td&gt;
      &lt;td&gt;&lt;textarea name="readme" rows="3" cols="80"&gt;{$readme_htmlencode}&lt;/textarea&gt; &lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;预览图:&lt;/td&gt;
      &lt;td&gt;
			&lt;div class="selectimg"&gt;
				&lt;input type="hidden" name="preimg" id="preimg" value="{$preimg}" /&gt;
				&lt;a href="{$selimg}" class="j_open"&gt;&lt;img src="{$preimg}" id="preshow" width="120" alt="预览图" /&gt;&lt;/a&gt;
			&lt;/div&gt;			
		&lt;/td&gt;
    &lt;/tr&gt;



    &lt;tr&gt;
      &lt;td&gt;Title:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="mytitle" id="mytitle" value="{$mytitle}" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;Keywords:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="mykeywords" id="mykeywords" value="{$mykeywords}" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;Description:&lt;/td&gt;
      &lt;td&gt;&lt;textarea name="mydescription" id="mydescription" rows="2" cols="48" class="inputtext"&gt;{$mydescription}&lt;/textarea&gt;&lt;/td&gt;
    &lt;/tr&gt;

    &lt;tr&gt;
      &lt;td&gt;参考地址:&lt;/td&gt;
      &lt;td&gt;&lt;input type="text" name="referenceurl" value="{$referenceurl}" class="inputtext" /&gt;&lt;/td&gt;
    &lt;/tr&gt;


    &lt;tr&gt;
      &lt;td&gt;其它:&lt;/td&gt;
      &lt;td&gt;
			排序:&lt;input type="text" name="cls" value="{$cls}"  size="4" /&gt;&amp;nbsp;
			
			点击:&lt;input type="text" name="hits"  value="{$hits}"  size="4" /&gt;&amp;nbsp;

			推荐:&lt;input type="checkbox" name="isgood" value="1" class="vmiddle" /&gt; &amp;nbsp;
			
			显示:&lt;input type="checkbox" name="isshow" value="1" class="vmiddle" /&gt; &amp;nbsp;

			发布时间:&lt;input type="text" name="stime"  value="{$ptime_dateformat1}"  size="20" /&gt;&amp;nbsp;
		&lt;/td&gt;
    &lt;/tr&gt;


    &lt;tr&gt;

      &lt;td colspan="2"&gt;
			&lt;textarea name="mycontent" id="mycontent" rows="5" cols="60"&gt;{$mycontent_htmlencode}&lt;/textarea&gt;
		&lt;/td&gt;
    &lt;/tr&gt;




	 &lt;tr&gt;
		
		&lt;td colspan="2"&gt;&lt;input type="button" name="submit" class="submit1" value="保 存" onclick="j_post('myform')" /&gt;&lt;/td&gt;
	 &lt;/tr&gt;

  &lt;/table&gt;

&lt;/form&gt;



&lt;script type="text/javascript"&gt;
&lt;!--
$(document).ready(function(){

	$("#classid").val("{$classid}");

	checkcheckbox("isgood", "{$isgood}");
	checkcheckbox("isshow", "{$isshow}");

	wedoneteditor("mycontent", 1);

	{$js}
})	
//--&gt;
&lt;/script&gt;</myform><css readme="css"/></xml>
