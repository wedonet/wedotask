var webdir = "/";
var ttt = "";
var isdebug = false;

$(function(){
	
	$("a.j_open").j_open();	//模拟弹出
	
	//$("span.j_hover").j_hover();		//js下拉菜单
	j_load();		//Ajax载入网页
	//JT_init();		//
	
	//$("#pagecontent").autoimgsize(680);


	$("table.j_list").list();

	//focus后移除fault状态
	$("input").bind("focus", function(){
		$(this).removeClass("fault");
	})

	//为class=dellink的链接加删除确认
	$("a.j_del").bind("click",function(){
		if (confirm($(this).attr("title")))
		{
			return true;
		}
		else{
			return false;
		}
	});



	$(".j_temp").bind("click", function(){
		alert("制做中");
		return false;
	})

	//内容里的大图片自动居中
	$(".content img").each(function(){
		
		if($(this).width()>150) {
			$(this).wrap("<div class='center'></div>");
		}
	})
});

function d(str){
	document.write(str);
}

$.fn.j_open=function(){
	//模拟弹出窗口
	$(this).on("click", function(){

		//有rel的弹出框需要确认
		var title = $(this).attr("title");

		if ( (title !="") && (title != undefined) )
		{
			if (!confirm(title))
			{
				return false;
			}
		}

		var href=$(this).attr("href");
		if ("" == href)
		{
			alert("地址错误");
			return(false);
		}
	
		$("body").append(jumpdiv());
		$("#bg").height($(document).height()).bgiframe();
		$("#edit").dialog("").drag(function( ev, dd ){
			$(this).css({
				top: dd.offsetY,
				left: dd.offsetX
			});
		},{ handle:".th" });

		$("#editbody").load(href,{timestamp:new Date().getTime()},function(data){
			$("#edit").dialog("").show();

			//执行载入网页的js
			//var s = "<script type='text/javascript'>"+$("#edit .jsupdata").val()+"</script>";
			//$("#edit").append(s);			

			$("a.j_reopen").reopen();
			//if ($(data).find("#autoclose").length>0)
			//{
			//	setTimeout("autoclose()", $("#autoclose").text());
			//}
			//autoclose();
			//JT_init(); //tip
		});		
		closeedit();
		return false;
	});
}

$.fn.reopen=function(){
	$(this).bind("click",function(){
		$("#edit").css("z-index","1");
		$("body").append(rejumpdiv());
		$("#reeditbody").html(loading());
		$("#reedit").dialog("").show().css("z-index","502");		//添加正在执行标志
				$("#reeditbody").load($(this).attr("href")+"&timestamp="+new Date().getTime(),function(data){
					$("#reedit").dialog("");
					if ($(data).find("#autoclose").length>0)
					{
						setTimeout("autoclose()", $("#autoclose").text());
					}
			
				});

		$("#reclose").click(function(){
			$("#edit").css("z-index","501");
			$("#reedit").remove();			
		});
		return false;
	})	
}



function j_load(){
	$("a.j_load").each(function(){
		var obj = $(this);
		var url = obj.attr("href");
		var getobj = $(this).attr("rel"); //提取子页id=obj的容器

		$.get(url, {timestamp:new Date().getTime()}, function(data){
			obj.replaceWith(data);
		})
	});
}

function jumpdiv(){
	var s;	
	s ="<div id='bg'></div>";
	s+="<div id='edit' style='display:none'>";
	s+="	<div class='p'>";
	s+="		<a href='javascript:void(0)' id='close'><img src='" + webdir + "_images/close2.gif' alt='close2' title='关闭窗口' /></a>";
	s+="		<div id='editbody'><div class='loading'><img src='" + webdir + "_images/loading.gif' alt='loading' /></div></div>";
	s+="	</div>";
	s+="</div>";
	return s;
}

function rejumpdiv(){
	var s;
	s ="<div id='reedit'>";
	s+="<div class='p'>";
	s+="<a href='javascript:void(0)' id='reclose'><img src='" + webdir + "_images/close2.gif' alt='close2' title='关闭窗口' /></a>";
	s+="<div id='reeditbody'></div>";
	s+="<div id='closeall'><a href='javascript:void(0)' onclick='closewin()'>关闭全部窗口</a></div>";
	s+="</div></div>";
	return s;
}

function loading(){
	return "<div style='width:260px' id='loading'><div class='th'>操作提示</div><p><img src='" +webdir+ "_images/loading.gif' alt='正在执行' /> 正在执行...</p></div>"
}
function pageloading(){
	s ="<div id='bg'><table cellspacing='0'><tr><td><img src='" + webdir + "_images/loading.gif' alt='loading...' /></td></tr></table></div>";
	return s;
}

//显示隐藏指定容器
function togglediv(obj){$("#"+obj).toggle();}

$.fn.j_hover=function(){
	$(this).hover(
		function () {
			var obj=$(this);
			var href=obj.find("a").attr("href");
			var pos	=obj.find("a").attr("rel");
			if (pos=="right")
			{
				pos="hoverbody2";
			}
			else
			{
				pos="hoverbody";
			}
			if (href.indexOf("?")>0)
			{
				href+="&timestamp="+new Date().getTime();
			}
			else{
				href+="?timestamp="+new Date().getTime();
			}
			obj.css("position","relative").addClass("hover");
			obj.append("<div class='"+pos+"' id='hoverbody'><img src='"+webdir+"_images/loading.gif' alt='正在执行' /></div>");
			obj.find("#hoverbody").load(href,function(data){
				j_open();
				//obj.find("#hoverbody").dropShadow().bgiframe();
			});
		},
		function () {
			$(this).css("position","static").removeClass("hover");

			//$(this).find("#hoverbody").removeShadow().remove();
		}		
	);
}

//=========================================

function odepth(){
	$("option.odepth1").each(function(){
		$(this).html("|--"+$(this).html());
	});
	$("option.odepth2").each(function(){
		$(this).html("|----"+$(this).html());
	});
	$("option.odepth3").each(function(){
		$(this).html("|------"+$(this).html());
	});
}

function showimg(src,alt,width){
	document.write("<img src=\""+src+"\" alt=\""+alt+"\"");
	if(width.length>0){document.write(" width=\""+width+"\"");}
	document.write(" onload=\"rsimg(this,"+width+")\"");
	document.write(" />");
}
function rsimg(o,w){
	if(o.width>w){
		o.resized=true;
		o.width=w;
		o.height=(w/o.width)*o.height;
	}
}

function admin_Size(num,obj){
	var obj=document.getElementById(obj);
	if (parseInt(obj.rows)+num>=3) {
		obj.rows = parseInt(obj.rows) + num;
	}
	if (num>0)
	{
		obj.width="90%";
	}
}

function bbimg(o){
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;if (zoom>0) o.style.zoom=zoom+'%';
	return false;
}

function getsize(size) {
	if (size==null) return "";
	size = (size / 1024);
	size = Math.round(size);
	if(size==0){size=1}
	return (size+"k");
}

//控制字体大小
//size=12 14 或16
//str=obj
function doZoom(size,obj){
	$("."+obj).css("font-size",size+"px");
}

function checkradio(obj, value){
	$("input[name='"+obj+"'][value='"+value+"']").attr("checked","checked");
}

function checkcheckbox(obj, value){
	value = value.replace(/\s/g,""); //去除空格
	value=value.split(",");
	for (var i=0;i<value.length ;i++ )
	{
		checkradio(obj,value[i]);
	}
}

$.fn.tab=function(){
	//选项卡
	var obj=$(this);
	obj.find("a").bind("click",function(){
		var showid = $(this).attr("href");//将显示的容器ID
		var hideid = obj.find(".selected").removeClass("selected").attr("href"); //要隐藏的ID		
		obj.find(".selected").removeClass("selected");//移除选中状态		
		$(this).addClass("selected");//增加当前链接选中状态		
		$(hideid).hide();//隐藏以前显示的内容		
		$(showid).fadeIn("fast");//显示匹配内容
		this.blur();
		return false;
	});
}


//myevent 事件 click 或 hover
//myway ""=div , ajax=ajax方式载入
$.fn.tab1=function(myevent, myway){
	//选项卡
	var obj=$(this);
	
	switch (myevent){
		case "click":
			break;
		case "hover":
			break;
		case "mouseover":
			break;
		default:
			alert("tab1参数错误");
			break;		
	}
	
	obj.find("a").bind(myevent, function(){
		var showid = $(this).attr("rel");//将显示的容器ID
		var hideid = obj.find("li.on a").attr("rel"); //要隐藏的 div ID		


		obj.find(".on").removeClass("on");//移除选中状态		
		$(this).parent("li").addClass("on");//增加当前链接选中状态		
		$("#"+hideid).hide();//隐藏以前显示的内容		
		$("#"+showid).fadeIn("fast");//显示匹配内容
		this.blur();
		return false;
	});
}

$.fn.tabrel=function(){
	//选项卡
	var obj=$(this);
	obj.find("a").bind("click",function(){
		var showid = $(this).attr("rel");//将显示的容器ID
		var hideid = obj.find(".on a").attr("rel"); //要隐藏的ID		

		obj.find(".on").removeClass("on");//移除选中状态		

		$(this).parent().addClass("on");//增加当前链接选中状态		
		$("#"+hideid).hide();//隐藏以前显示的内容		
		$("#"+showid).fadeIn("fast");//显示匹配内容
		this.blur();
		return false;
	});
}


function confirmlink(obj){
	if (confirm(obj.title))
	{
		return true;
	}
	else{
		return false;
	}
}

$.fn.getcode=function(){
	$(this).one("focus", function(){
		var url = webdir+'_inc/getcode.php?t='+Math.random();
		$(this).next("span").load(url);
	});
}


//=============================在线编辑器
//模板在线编辑器
//num=1时是管理员编辑器,显示的功能多一些
//num=2时,是普通用户编辑器
//num=3:编辑模板
function wedoneteditor(obj, num, url)	{

	if ($("#"+obj).length<1)
	{
		return false;
	}
	switch (num)
	{
	case 1 :
		CKEDITOR.replace(obj,{
			filebrowserBrowseUrl: '/tools/myfiles.php?fromeditor=1',
			filebrowserWindowWidth: '880',
			filebrowserWindowHeight: '585'
		});
		break;
	case 2 :
		//if (ismaster==true)
		//{
		CKEDITOR.replace(obj,{
		});
		
		//}
		//else{
		//CKEDITOR.replace(obj,{});
		//}
		break;
	case 3 :
		CKEDITOR.replace(obj,{
			enterMode : CKEDITOR.ENTER_BR
		});
		break;
	}
}

function getUrlParam( paramName ) {
    var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' ) ;

    var match = window.location.search.match(reParam) ;

    return ( match && match.length > 1 ) ? match[ 1 ] : null ;
}

;$.fn.AddUrl=function(){
	$(this).bind("click", function(){
		//var funcNum = getUrlParam( 'CKEditorFuncNum' );
		var fileUrl = $(this).attr("href");
		//window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
		window.parent.opener.CKEDITOR.tools.callFunction( 3, fileUrl ,function(){
			window.parent.close();
		});

		return false;	
	})
}

function GetInnerHTML(obj)
{
	var oEditor = FCKeditorAPI.GetInstance(obj) ;
	return(oEditor.GetXHTML(true));
}

//向在线编辑器插入值
function InsertHTML(str)
{
	var oEditor = FCKeditorAPI.GetInstance("content") ;
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )
	{
		oEditor.InsertHtml(str) ;
	}
}
//str 图片obj
//向在线编辑器插入图片
function docoutengimg(obj,str){
{
	if (str.lenth==0){return false;}
	if (obj.length==0)	{return false;}
	//window.parent.CKEDITOR.instances.editor1.insertHtml("a");
	window.parent.CKEDITOR.instances.content.insertHtml("<img src=\""+$("#"+str).val()+"\" alt=''>");
}
}


function format_time(str,num){
	var str = str.split(" ");
	var myday = str[0];
	var mytime= str[1];
	switch (num)
	{
	case 1:
		return myday;
	}
}
//格式化货币
function format_currency(num){
	if (isNaN(num) || num=="") {
		return ("￥0.00元");	
	}
	else {		
		num = parseFloat(num);
		if (num==0)
		{
			return ("￥0.00元");	
		}
		else {
			return ("￥" + num.toFixed(2)+"元");
		}
	}
}

/*拆分tags*/
/*num=b*/
function gettags(num,str){
	str+="";
	if (str.length==0)
	{
		document.write("");		
	}
	else{
		str = str.split(",");
		for (i=0;i<str.length;i++)
		{
			document.write("<a href=\"?b="+num+"&amp;myfield=tags&amp;keyword="+str[i]+"\">"+str[i]+"</a> ");
		}
	}
}
function cutstring(str,start,len)
/**
* 截取指定长度的字符串（中英文混合）
* @author xwl
* @param String str 要截取的字符串
* @param Int start 起始位置
* @param Int length 截取长度
* @return String 截取以后字符串
**/ 
{

  var ilen = start + len;
  var reStr = "";

  if(str.length<=ilen){
    return str;
  }
  
  for(i=0; i<ilen; i++)
  {
    if(escape(str.substr(i,1))>0xa0)
    {
      reStr += str.substr(i,2);
      i++;
    }
    else{
      reStr += str.substr(i,1);
    }
  }
  return reStr + "...";
}





//全选
function checkall(obj){
	$("input[name="+obj+"]").each(function() {
		$(this).attr("checked", true);
	});
}
//全不选
function uncheckall(obj){
	$("#select").attr("checked", false);
	$("input[name="+obj+"]").each(function() {
		$(this).attr("checked", false);
	});
}

//反选
function contrasel(obj) {
	$("input[name="+obj+"]").each(function() {
	if($(this).attr("checked"))
	{
	$(this).attr("checked", false);
	}
	else
	{
	$(this).attr("checked", true);
	}
	});
}


function showmyurl(obj){
	var str=getobj(obj).value;
	str = str.replace(/\n/g,"#");
	str = str.replace(/\r/g,"");
	str=str.split("#");
	document.write("<ul>");
	for (var i=0;i<str.length;i++)
	{
		document.write("<li><a href='down.asp?"+window.location.href.split("?")[1]+"&amp;urlid="+i+"' target='_blank'>"+str[i].split("|")[0]+"</a></li>");
	}
	document.write("</ul>");
}
/*收藏夹*/
function setBookmark(url,str){if(str=='')str=url;if(document.all)window.external.AddFavorite(url,str);else alert('同时按下Ctrl和D添加到收藏夹:\n"'+url+'".');}

function closeedit(){

	$("#close").click(function(){
		if (ttt != "")
		{
			clearTimeout(ttt);
		};
		$("#edit iframe").remove();
		$("#edit").remove();

		$("#bg").remove();
		return false;//解决Gif不动的Ie6 Bug
	});
} 
function autoclose(){
	$("#reedit").fadeOut("slow");
	$("#edit").remove();
	$("#bg").remove();
}
function autolocate(x){
	//alert("a");
	window.location.href=x;
}

function closewin(){
	$("#reedit").remove();
	$("#edit").remove();
	$("#bg").remove();
	return false;
}

/*
2009-5-18 认为没用了,删除
$.fn.loading = function(){
	$("body").append("")
};
*/


//把图片插入到相对应input
function inserturl(obj,url){
	$("#"+obj).val(url);
	$("#close").click();
}

//===========================================
//表单部分
//适用于Ajax页面
function UpdateEditorValue(){
	if (typeof(CKEDITOR) != "undefined")
	{
	
    var textareas = $('textarea');
    $.each(textareas, function () {
        var idname = $(this).attr('id');
        var editor = CKEDITOR.instances[idname];
		if (typeof(editor) !="undefined")
		{
			$(this).val(editor.getData());
		}
    });
	
	};
}

function FckReset(){
	if ((typeof(FCKeditorAPI))!="undefined"){
		 for (i in FCKeditorAPI.__Instances)
		 {
			 FCKeditorAPI.__Instances[i].SetHTML('');
		 }
	}
}
function j_gpost(formid, action){
	var postdata= action +"&"+$("#"+formid).serialize();

	$.ajax({
		type: "POST",
		url:postdata,
		data:"",
		complete:function(Request){
			var s=Request.responseText;
			if (s=="refresh") //返回通知刷新网页
			{
				document.location.reload();
			}
			else{
				$("#editbody").html(s);
				$("#edit").dialog("");
				if ($(s).find("#autoclose").length>0)
				{
					setTimeout("autoclose()", $("#autoclose").text());
				}
			}
		}
	});
}

//Ajax提交表单
function j_post(formid){
	var obj=$("#"+formid);
	if (isdebug==true){obj.submit();return false;}	//调试时采用普通方式提交

	obj.bind("submit", function() { return false; });

	//更新编辑器内容到字段
	//官方的方法,但不能用于frame页
	//var MyObject = new UpdateField();
	//MyObject.UpdateEditorFormValue();

	//更新编辑器内容到字段
	UpdateEditorValue();
	var postdata= $("#"+formid).serialize();

	$("body").append(jumpdiv());
	$("#bg").height($(document).height()).bgiframe();
	$("#editbody").html(loading());
	$("#edit").dialog("").show().drag(function( ev, dd ){
			$( this ).css({
				top: dd.offsetY,
				left: dd.offsetX
			});
		},{ handle:".th" });		//添加正在执行标志
	var action=obj.attr("action");	

	$.ajax({
		type: "POST",
		url:action,
		data:postdata,
		complete:function(Request){
			var s=Request.responseText;
			if (s=="refresh") //返回通知刷新网页
			{
				document.location.reload();
			}
			else{
				$("#editbody").html(s);
				$("#edit").dialog("");
				if ($(s).find("#autoclose").length>0)
				{
					setTimeout("autoclose()", $("#autoclose").text());
				}
			}
		}
	});
	
	closeedit();
}
/*ajax提交表单,载入js*/
function j_post1(formid, showid){
	var obj=$("#"+formid);
	if (isdebug==true){obj.submit();return false;}	//调试时采用普通方式提交
	//更新编辑器内容到字段
	//UpdateEditorValue();
	var postdata= $("#"+formid).serialize();
	var action=obj.attr("action")+"&showid="+showid+"&timestamp="+new Date().getTime();	

	$.ajax({
		type: "POST",
		url:action,
		dataType: "script",
		data:postdata,
		complete:function(Request){
			//alert("b");
			//alert(Request.responseText);
			//var s=Request.responseText;
			//if (s.length>0)
			//{
			//	$("#"+showid).html(s).show();
			//}
		}			
	});
	obj.bind("submit", function() { return false; });
}
function j_post2(formid, action, msg){
	//Ajax提交,带改变form action
	if (msg !="")
	{
		if (!confirm(msg))
		{
			return false;
		}
	}
	$("#"+formid).attr("action",action);
	j_post(formid);
}
function j_repost2(formid, action, msg){
	//Ajax提交,带改变form action
	if (msg !="")
	{
		if (!confirm(msg))
		{
			return false;
		}
	}
	$("#"+formid).attr("action",action);
	j_repost(formid);
}
function j_repost(formid){
	//在模拟弹出窗口再post
	var obj=$("#"+formid)
	if (isdebug==true)	//调试时采用普通方式提交
	{
		obj.submit();
	}
	else {
		obj.bind("submit",function(){return false;})
		//如果用了在线编辑器,Then传值给content
		//更新编辑器内容到字段
		UpdateEditorValue();
		var postdata= obj.serialize();
		var action=obj.attr("action")+"&timestamp="+new Date().getTime();
		$("#edit").css("z-index","1");//'<syl>隐藏div<by syl>
		$("body").append(rejumpdiv());
		$("#reeditbody").html(loading());
		$("#reedit").dialog("").show().css("z-index","502");		//添加正在执行标志
		
		$.ajax({
			type: "POST",
			url:action,
			data:postdata,
			complete:function(Request){
				var s=Request.responseText;
				if (s=="refresh")
				{
					document.location.reload();
				}
				else{
					$("#reeditbody").html(s);
					$("#reedit").dialog("");
						if ($(s).find("#autoclose").length>0)
						{
							setTimeout("autoclose()", $("#autoclose").text());
						}

					//解决ie下不能自适应宽度
					//$("#closeall").width($("#reeditbody").innerWidth());
				}
			}
		});
		$("#reclose").click(function(){
			$("#edit").css("z-index","501");
			$("#reedit").remove();
		});
	}	
}

//提交表单,普通方式,通过链接改变form's action
//other submit
function dosubmit(obj, thisaction, confirmstr){
	if (confirmstr !="")
	{
		if (!confirm(confirmstr))
		{
			return false;
		}
	}
	$("#"+obj).attr("action",thisaction);

	setTimeout(function(){$('#'+obj).submit();},0);
}

function j_reset(){
	FckReset();
	return true;
}

function j_resource(){
	$("#j_source").bind("click",function(){
		$(this).replaceWith("<iframe frameborder='0' width='100%' height='260' scrolling='no' src='"+$(this).attr("href")+"'></iframe>");
		return false;
	});
}


;$.fn.dialog=function(pos){
	var wnd = $(window), doc = $(document),
		pTop = doc.scrollTop(), pLeft = doc.scrollLeft(),
		minTop = pTop;

	if ($.inArray(pos, ['center','top','right','bottom','left']) >= 0) {
		pos = [
			pos == 'right' || pos == 'left' ? pos : 'center',
			pos == 'top' || pos == 'bottom' ? pos : 'middle'
		];
	}
	if (pos.constructor != Array) {
		pos = ['center', 'middle'];
	}
	if (pos[0].constructor == Number) {
		pLeft += pos[0];
	} else {
		switch (pos[0]) {
			case 'left':
				pLeft += 0;
				break;
			case 'right':
				pLeft += wnd.width() - this.outerWidth();
				break;
			default:
			case 'center':
				pLeft += (wnd.width() - this.outerWidth()) / 2;
		}
	}
	if (pos[1].constructor == Number) {
		pTop += pos[1];
	} else {
		switch (pos[1]) {
			case 'top':
				pTop += 0;
				break;
			case 'bottom':
				pTop += wnd.height() - this.outerHeight();
				break;
			default:
			case 'middle':
				pTop += (wnd.height() - this.outerHeight()) / 2;
		}
	}

	// prevent the dialog from being too high (make sure the titlebar
	// is accessible)
	pTop = Math.max(pTop, minTop);
	this.css({top: pTop, left: pLeft});
	return this;
};




//ie6 Select bug
/*! Copyright (c) 2010 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version 2.1.2
 */

(function($){

$.fn.bgiframe = ($.browser.msie && /msie 6\.0/i.test(navigator.userAgent) ? function(s) {
    s = $.extend({
        top     : 'auto', // auto == .currentStyle.borderTopWidth
        left    : 'auto', // auto == .currentStyle.borderLeftWidth
        width   : 'auto', // auto == offsetWidth
        height  : 'auto', // auto == offsetHeight
        opacity : true,
        src     : 'javascript:false;'
    }, s);
    var html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="'+s.src+'"'+
                   'style="display:block;position:absolute;z-index:-1;'+
                       (s.opacity !== false?'filter:Alpha(Opacity=\'0\');':'')+
                       'top:'+(s.top=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')':prop(s.top))+';'+
                       'left:'+(s.left=='auto'?'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')':prop(s.left))+';'+
                       'width:'+(s.width=='auto'?'expression(this.parentNode.offsetWidth+\'px\')':prop(s.width))+';'+
                       'height:'+(s.height=='auto'?'expression(this.parentNode.offsetHeight+\'px\')':prop(s.height))+';'+
                '"/>';
    return this.each(function() {
        if ( $(this).children('iframe.bgiframe').length === 0 )
            this.insertBefore( document.createElement(html), this.firstChild );
    });
} : function() { return this; });

// old alias
$.fn.bgIframe = $.fn.bgiframe;

function prop(n) {
    return n && n.constructor === Number ? n + 'px' : n;
}

})(jQuery);







/*typeid=0 then 隐藏确定按钮; typeid=1 显示确定按钮*/
;$.fn.selectclass=function(href, typeid, myid){
	var obj=$(this);
	var offset = obj.offset();

	var s="";
	s = "<div id='bg'></div>";
	s += "<div id='edit'>";
	s += "<div class='p'>";
	s += "	<a href='javascript:void(0)' id='close'><img src='" + webdir + "_images/close2.gif' title='关闭窗口' /></a>";
	s += "	<div id='editbody' class='selectclass'><img src='" + webdir+ "_images/loading.gif' alt='loading'></div>";
	s += "</div>";
	s += "</div>";

	$(this).addClass("imselect"); //下拉框增加右键头

	$(this).bind("click",function(){
		$("body").append(s);
		$("#bg").height($(document).height()).bgiframe();
		$("#edit").css({
			"top":offset.top+3,
			"left":offset.left+3
		}).show().drag(function( ev, dd ){
			$( this ).css({
				top: dd.offsetY,
				left: dd.offsetX
			});
		},{ handle:".th" });
		$.getJSON(href, {timestamp:new Date().getTime(),typeid:typeid}, function(s){
			$("#editbody").html(s.html).loadclass(myid, obj);
		})				
		closeedit();

		return false;
	});

	$.fn.loadclass=function(myid, obj){
		$(this).find("a").bind("click", function(){
			$("#editbody").html("<img src='" + webdir + "_images/loading.gif' alt='loading'>"); //添加等待状态
			$.getJSON($(this).attr("href"), {timestamp:new Date().getTime(),typeid:typeid}, function(t){
				$("#editbody").html(t.html).loadclass(myid, obj);
				if (1==t.isleaf)
				{
					$("#"+myid).val(t.classid);		
					obj.val(t.thename);	
					$("#edit").remove();
					$("#bg").remove();	
					//alert("a");
				}
				$("#submitclass").bind("click", function(){
					$("#"+myid).val($("#sclassid").val());
					obj.val($("#sclassname").val());
					$("#edit").remove();
					$("#bg").remove();
				});

				//if ("" != obj.val())
				//{
					obj.next("img").show(); //显示取消链接
				//}
			});
			return false;		
		});
	};
	
	//取消选定的图片加链接,显示取消链接
	$(this).next("img").bind("click", function(){
		obj.val("");
		$("#"+myid).val("");
		$(this).hide();
	});

}


function selimg(preid, inputid, url){
	$("#"+preid).attr("src", url);
	$("#"+inputid).val(url);

	//关闭窗口
	
	//$("#edit iframe").remove();

	$("#bg").remove();
	$("#edit").remove();
}


function GetQueryString(locstring,str){
	var rs=new RegExp("(^|)"+str+"=([^\&]*)(\&|$)","gi").exec(locstring),tmp;
	if(tmp=rs)return tmp[2];
	return "没有这个参数";
}

$.fn.focusdiv=function(focus_width, focus_height, text_height){
	//循环部分 <li>{$preimg}|{$readhref}|{$title}</li>
	//var pics="/images/show.jpg|/images/show2.jpg";
	//var links = "/index.asp|/index.asp";
	//var texts = "text1|text2";
	//var interval_time=5 //图片停顿时间，单位为秒，为0则停止自动切换
	//var focus_width=280 //宽度
	//var focus_height=211 //高度
	//var text_height=20 //标题高度
	var swf_height = focus_height+text_height; //相加之和最好是偶数,否则数字会出现模糊失真的问题

	var pics	="";
	var links="";
	var texts="";
	var s;

	$(this).find("li").each(function(){
		s = $(this).html().split("|");
		pics	+=(s[0]+"|");
		links	+=(s[1]+"|");
		texts	+=(s[2]+"|");
	})

	pics	= pics.substr(0,pics.length-1);
	links = links.substr(0,links.length-1) ;
	texts = texts.substr(0,texts.length-1) ;

	$(this).flash({
		'swf' : '/flash/pixviewer.swf',
		'width':focus_width,
		'height': swf_height,
		'bgcolor' : "#F0F0F0",
		'menu=' : 'false',
		'quality' : 'high',
		'wmode' : 'transparent',
		'WMode' : 'Opaque',
		'flashvars': {
			'pics' : pics,
			'links' : links,
			'texts' : texts,
			'borderwidth' : focus_width,
			'borderheight' : focus_height,
			'textheight' : text_height
			}
	});
}

function focusjs(){
	var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
	var len = $("#focus ul li").length; //获取焦点图个数
	var index = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明长条
	var btn = "<div class='btnBg'></div><div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span>" + (i+1) + "</span>";
	}
	btn += "</div>"
	$("#focus").append(btn);
	$("#focus .btnBg").css("opacity",0.2);
	
	//为数字按钮添加鼠标滑入事件，以显示相应的内容
	$("#focus .btn span").mouseenter(function() {
		index = $("#focus .btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");
	
	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	$("#focus ul").css("width",sWidth * (len + 1));
	
	//鼠标滑入某li中的某div里，调整其同辈div元素的透明度，由于li的背景为黑色，所以会有变暗的效果
	$("#focus ul li div").hover(function() {
		$(this).siblings().css("opacity",0.7);
	},function() {
		$("#focus ul li div").css("opacity",1);
	});
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$("#focus").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			if(index == len) { //如果索引值等于li元素个数，说明最后一张图播放完毕，接下来要显示第一张图，即调用showFirPic()，然后将索引值清零
				showFirPic();
				index = 0;
			} else { //如果索引值不等于li元素个数，按普通状态切换，调用showPics()
				showPics(index);
			}
			index++;
		},3000); //此3000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		$("#focus ul").stop(true,false).animate({"left":nowLeft},500); //通过animate()调整ul元素滚动到计算出的position
		$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
	}
	
	function showFirPic() { //最后一张图自动切换到第一张图时专用
		$("#focus ul").append($("#focus ul li:first").clone());
		var nowLeft = -len*sWidth; //通过li元素个数计算ul元素的left值，也就是最后一个li元素的右边
		$("#focus ul").stop(true,false).animate({"left":nowLeft},500,function() {
			//通过callback，在动画结束后把ul元素重新定位到起点，然后删除最后一个复制过去的元素
			$("#focus ul").css("left","0");
			$("#focus ul li:last").remove();
		}); 
		$("#focus .btn span").removeClass("on").eq(0).addClass("on"); //为第一个按钮添加选中的效果
	}
}

/*取消链接*/
$.fn.unlink=function(){
	var obj=$(this);
	obj.each(function(){
		var s=$(this).html();
		$(this).replaceWith("<span class='color2'>"+s+"</span>").unbind("click");	
	});

}

/*格式化状态*/
$.fn.rore=function(){
	$(this).html(function(index, html){
		switch (html)
		{
		case "0" :
			return("");
			break;
		case "1" :
			return("<img src=\""+webdir+"images/check_right.gif\" />");
			break;
		case "2" :
			return("<img src=\""+webdir+"images/check_error.gif\" />");
			break;
		case "3" :
			return("<img src=\""+webdir+"images/stop.gif\" />");
			break;
		}

	});
}


$.fn.autoimgsize=function(width){
	if ($(this).length>0)
	{
		$(this).find("img").each(function(){
		
			if ($(this).width()>=width)
			{
				$(this).width(width);
			}
		});
	
	}
}

/*格式化输入框*/
;$.fn.formatinput=function(){
	var obj=$(this);
	var onid="";
	obj.find("input").each(function(){
		if ($(this).attr("type")=="text")
		{
			$(this).addClass("itext").inputon();
		}
	});
	obj.find("textarea").each(function(){
		$(this).addClass("itextarea").inputon();
	});
	obj.find("select").addClass("iselect");
}
;$.fn.inputon=function(){
	$(this).focus(function(){$(this).addClass("on")});
	$(this).blur(function(){$(this).removeClass("on")});
}

/*操作cookie*/
function setCookie(name,value,expire) {
var exp  = new Date();
exp.setTime(exp.getTime() + expire);
document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

function getCookie(name) {
var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
if(arr != null) return unescape(arr[2]); return null;
}

function delCookie(name){
var exp = new Date();
exp.setTime(exp.getTime() - 1);
var cval=getCookie(name);
if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

//选择图片
function filefrom(ftype){
	//var iframe = "<iframe src='"+url+"' frameborder='0' scrolling='no' width='100%' height='450'></iframe>";
	//$("#upcontent").html(iframe);
	var fromeditor = $("#fromeditor", window.parent.document).val();
	var funcnum = $("#funcnum").val();

	$("#frameclass").attr("src", webdir + "tools/myfiles.php?act=showclass&ftype=" + ftype + "&fromeditor="+fromeditor)+'&funcnum='+funcnum;
	$("#main").attr("src", webdir + "tools/myfiles.php?act=list&ftype=" + ftype + "&fromeditor="+fromeditor+"&funcnum="+funcnum);

	$("#tabup .on").removeClass("on");
	$("#ftype"+ftype).addClass("on");
	return false;
}

/*选择操作*/
;$.fn.seldo=function(){
	$(this).hover(
		function(){
			$(this).find("dd").show()
			.end().find("dt").addClass("on");
		},
		function(){
			$(this).find("dd").hide()
			.end().find("dt").removeClass("on");
		}
	);
}


//bgchecked, 如果和默认值不一样, 加一个背景
$.fn.bgchecked=function(){
	var defaultvalue = $(this).find("option:first").html();
	if (defaultvalue != $(this).val()) //值和默认的不一样, 表未已经做了选择
	{
		$(this).addClass("bgselected");
	}else{
		$(this).removeClass("bgselected");
	}
}

//
$.fn.j_getmore=function(){
	$(this).each(function(){
		var obj=$(this);
		obj.toggle(function(){
			var href=$(this).attr("href")+"&timestamp="+new Date().getTime();
			$.get(href, function(data){
				obj.closest("tr").after(data);
			})
			obj.css("background-position", "3px -47px");
		},
		function(){
			obj.closest("tr").siblings("tr").remove();
			obj.css("background-position", "3px 0.5px");
		});	
	})


}


$("a.spread").toggle(function(){
	var obj=$(this);
	obj.css("background-position", "10px -48px");
	if (true != obj.data("isopen"))
	{
		$.get($(this).attr("href"), {"timestamp": new Date().getTime()}, function(s){
			obj.data("isopen", true);
			obj.closest("table").append(s);
		});
	}
	else{
		obj.closest("table").find("tr:gt(0)").show();
	}
	},
	function(){
		var obj=$(this);
		obj.css("background-position", "10px 0.5px");
		obj.closest("table").find("tr:gt(0)").hide();
	
	}
)





$.fn.extdiv = function(href){
	$("body").append(jumpdiv());
	$("#bg").height($(document).height()).bgiframe();
	$("#edit").dialog("").show().drag(function( ev, dd ){
		$( this ).css({
			top: dd.offsetY,
			left: dd.offsetX
		});
	},{ handle:".th" });

	$("#editbody").load(href,{timestamp:new Date().getTime()},function(data){
		$("#edit").dialog("");
		$("#edit a.j_extdivlive").j_extdivlive();
	});		
	closeedit();
	return false;		
}

$.fn.j_extdivlive = function(){
	$(this).bind("click",function(){
		var href = $(this).attr("href");
		$("#editbody").load(href,{timestamp:new Date().getTime()},function(data){
			$("#edit").dialog("");
			$("#edit a.j_extdivlive").j_extdivlive();
		
		});	
		return false;
	})			
}

function getapplyinfo()
{
	var idlist="";
	
	$(":input[name=id]").each(function(){		
		idlist+=$(this).val()+",";
	});

	if (idlist.length>0)
	{
		idlist=idlist.substr(0,idlist.length-1);
		var href = "/ajax/getapplyinfo.asp?idlist="+idlist+"&timestamp="+new Date().getTime();
		//alert(href);
		$.getScript(href);
	}
}



function test1(){

}

//focus 后清除内容
function cleartext(obj, s){
	if(s == obj.value){
		obj.value="";
	}
	
}





 /**
 * 图片预加载等比例缩放
 */
$.fn.LoadImage = function(width, height, nopicsrc){

	//没有图片时显示这个
	if (nopicsrc == null)
	{
		nopicsrc = webdir + "_images/nopic.jpg";
	}

	$( this ).each(function(){

		var obj=$(this);
	
		if ($(this).parent()[0].tagName.toLowerCase() == "a")
		{
			obj.parent().wrap("<table width='100%' height='100%' style='overflow:hidden'><tr valign='middle'><td style='text-align:center;padding:0;vertical-align:middle'></td></tr></table>");
		}
		else{
			obj.wrap("<table width='100%' height='100%' style='overflow:hidden'><tr valign='middle'><td style='text-align:center;padding:0;vertical-align:middle'></td></tr></table>");
		}
		var src = obj.attr("src");

		if (src == "")
		{
			src = nopicsrc;
		}

		obj.attr("src", webdir + "_images/loading.gif");

		var img=new Image();
		img.src=src;

		if (img.complete)
		{
			doimg(obj, img);
			obj.attr("src", src);
		}
		else{
			$(img).load(function(){
				doimg(obj, img);
				obj.attr("src", src);
			});
		}
	});

	function doimg(obj, img){
		if (img.width>0 && img.height>0)
		{
			//宽,高比大于标准比例, 也就是说图片宽了
			if (img.width/img.height >= width/height)
			{
				if (img.width>width)
				{
					obj.attr("width", width);
				}
			}
			else{
				if (img.height>height)
				{
					obj.attr("height", height);
				}				
			}				
		}
	}

};

//
function formatfilelink(){
	var preid = $("#preid", window.parent.document).val();
	var obj = $("#obj", window.parent.document).val();
	var fromeditor = $("#fromeditor", window.parent.document).val();

	if (obj.length>0)
	{
		$(".url").bind("click", function(){
			var url = $(this).attr("href");
			var thumb = $(this).attr("rel");

			if ( obj.indexOf('preimg')>-1 )
			{
				window.parent.document.getElementById(obj).value=thumb;
			}
			else {
				window.parent.document.getElementById(obj).value=url;
			}
			
			if (preid.length>0)
			{
				window.parent.document.getElementById(preid).src=thumb;
			}
			//解决IE iframe后不能聚焦问题
			//$(window.parent.document.getElementById("focus")).focus();
			window.parent.document.getElementById(obj).focus();

			$(window.parent.document.getElementById("bg")).remove();
			$(window.parent.document.getElementById("edit")).remove();

			return false;	
		})
	}
	else if(fromeditor.length>0){
		$(".url").bind("click", function(){
			var url=$(this).attr("href");

			var dialog = window.parent.CKEDITOR.dialog.getCurrent();
			dialog.setValueOf('info','txtUrl',url);  // Populates the URL field in the Links dialogue.

			$(window.parent.document.getElementById("bg")).remove();
			$(window.parent.document.getElementById("edit")).remove();
			return false;			
		});			
	}
}

//Ajax Login Ajax登录
function AjaxPage(myhref){
	$("body").append(jumpdiv());
	$("#bg").height($(document).height()).bgiframe();
	$("#edit").dialog("").show().drag(function( ev, dd ){
		$(this).css({
			top: dd.offsetY,
			left: dd.offsetX
		});
	},{ handle:".th" });

	$("#editbody").load(myhref,{timestamp:new Date().getTime()},function(data){
		$("#j_codestr").getcode();
		$("#edit").dialog("");
	});		

	

	closeedit();
	return false;	
}



//关键词样式
$.fn.hotkey = function(){
	$(this).find("a").each(function(){
		//五选一
		var x = (parseInt(Math.random()*6) + 1); 
		$(this).addClass("hotkey"+x);
	})


}

$.fn.list=function(){
	var obj=$(this);
	obj.find("tr").hover(
		function(){ 
			$(this).addClass("hover");
		},
		function(){ //如果鼠标移到class为tableborder1的表格的tr上时，执行函数
			$(this).removeClass("hover");	 //移除该行的class,给这行添加class值为over，并且当鼠标移出该行时执行函数
	});
	obj.find("tr:even").addClass("alt");
	//列表刷新后,清除所有复选框
	obj.find("input[name=id]").attr("checked", false);
}

/*鼠标focus后移除错误提示*/
$.fn.holdfault=function(){
	$(this).find("input").bind("focus", function(){
		$(this).removeClass("fault");
	});
}

/*tab hover*/
//$.fn.tabhover = function(){
//   var delayTime = [];
//	var obj = $(this);
//
//   obj.each(function(index) {
//        $(this).hover(function() {
//            var _self = this;
//            delayTime[index] = setTimeout(function() {
//					 obj.removeClass("on");	
//                $(_self).addClass("on");
//            },
//            400)
//        },
//        function() {
//            clearTimeout(delayTime[index]);
//            $(this).removeClass("on");
//        })
//    });
//				
//				
//
//
//}


function tabhover(){
	var delaytime;

	$("#itab1 a").hover(function(){
		var _self = this;

		delaytime = setTimeout(function(){
				//文字color恢复
				$("#itab1 a").removeClass("on");
				$(".tabdiv").hide();

				$(_self).addClass("on");

				if ($(_self).hasClass("a1"))
				{
					$("#itab1").removeClass("sta2");
					$(".iorder").show();
				}
				else{
					$("#itab1").addClass("sta2");
					$(".ilogin").show();
				}
		},
		400)
	},
	function(){
		clearTimeout(delaytime);
	});
}

//多级地区联动
function multimenuarea(provinceid, cityid, districtid, bizareaid){
	//载入地区

	var href = webdir + "_ajax/area.php?act=getarea&provinceid="+provinceid+"&cityid="+cityid+"&districtid="+districtid+"&bizareaid="+bizareaid;

	//alert( href );
	$.getScript(href, function(){
		if ($.isNumeric(provinceid))
		{
			$("#provinceid").val(provinceid);
		}
		if ($.isNumeric(cityid))
		{
			$("#cityid").val(cityid);
		}
		
		if ($.isNumeric(districtid))
		{
			$("#districtid").val(districtid);
		}

		if ($.isNumeric(bizareaid))
		{
			$("#bizareaid").val(bizareaid);
		}
	});

	//省份变化后城市联动
	$("#provinceid").bind("change", function(){
		//清除原来的市
		$("#cityid option[value!='']").remove();
	
		//清除原来的区
		$("#districtid option[value!='']").remove();

		//清除原来的商业区
		$("#bizareaid option[value!='']").remove();

		//载入新的城市,如果省是直辖市 then 自动选中这个城市
		var provinceid = $(this).val();
		if ( "" != provinceid )	{
			var href = webdir + "_ajax/area.php?act=getsonofprovince&id="+provinceid;
			//alert(href);
			$.getScript(href, function(){
				//if 城市只有一个选项,then 选中这个
				var mycount = $("#cityid option").length;
				if ( 2==mycount ){
					$("#cityid option").get(1).selected = true;  
					$("#cityid").change();
				}			
			});			
		}
	})

	//城市变化后的联动
	$("#cityid").bind("change", function(){
		//清除原来的区
		$("#districtid option[value!='']").remove();

		//清除原来的商业区
		$("#bizareaid option[value!='']").remove();

		var cityid = $(this).val();
		
		if ( "" != cityid )	{
			var href = webdir + "_ajax/area.php?act=getsonofcity&id="+cityid;

			$.getScript(href);
		}

	})
		
}



//收藏
function tomyfav(){

	if (window.sidebar) {

		window.sidebar.addPanel("天津东丽旅游局官网", "http://www.tjdlly.gov.cn","");

	} 

	else if( document.all ) {

		window.external.AddFavorite("http://天津东丽旅游局官网", "http://www.tjdlly.gov.cn");

	}
	else if( window.opera && window.print ) {

		return true;

	}

}

//设为首页
function SetHome(url){


	if (document.all) {
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);
	}else{
		alert("您好,您的浏览器不支持自动设置页面为首页功能,请您手动在浏览器里设置该页面为首页!");
	}
}


//输入框的默认内容
$.fn.defaultkey=function( str ){
	var obj = $(this);

	var _width = obj.innerWidth();
	var _height = obj.innerHeight();
	var _top = obj.offset().top;
	var _left = obj.offset().left;




	var s = $("<div style='width:"+_width+"px;height:"+_height+"px;position:absolute;top:"+_top+"px;left:"+_left+"px;color:#bbb;line-height:"+_height+"px;text-align:left;font-size:"+obj.css("font-size")+";' >"+str+"</div>");

	s.bind("click", function(){
		s.remove();
		obj.focus();
	})

	$("body").append( s );



}



function myshow(){

	time1 
}


function doexport(obj){
	$("#"+obj+" input[name='act']").val("export");
	//alert($("#"+obj+" input[name='act']").val() );
	return true;
}
