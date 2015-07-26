<?xml version="1.0" encoding="utf-8"?>
<xml><main readme="main">&lt;html&gt;
&lt;head&gt;
&lt;meta http-equiv="Content-Type" content="text/html; charset=utf-8" /&gt;
&lt;meta name="viewport" content="initial-scale=1.0, user-scalable=no" /&gt;
&lt;style type="text/css"&gt;
body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;}
#l-map{height:100%;width:78%;float:left;border-right:2px solid #bcbcbc;}
#r-result{height:100%;width:20%;float:left;}
&lt;/style&gt;
&lt;script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&amp;ak=60d8d6a26348e81eb05a7a7fb6345308"&gt;&lt;/script&gt;
&lt;title&gt;天津市东丽区旅游局&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;div id="l-map"&gt;&lt;/div&gt;
&lt;div id="r-result"&gt;&lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;
&lt;script type="text/javascript"&gt;
var map = new BMap.Map("l-map");            // 创建Map实例
map.centerAndZoom(new BMap.Point(117.414782,39.139605), 11);
var local = new BMap.LocalSearch(map, {
  renderOptions: {map: map, panel: "r-result"}
});
local.search("东丽区 餐饮 娱乐");
&lt;/script&gt;</main><css readme="css"/></xml>
