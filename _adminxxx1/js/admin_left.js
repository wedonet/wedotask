$(document).ready(function(){
	//下级div显示开关
	$("h1.menuh1").click(function(){
		$(this).next("ul").toggle();
	});

	//载入内容管理
	//$("#admincontent").load("admin_index.asp?act=admin_left"+"&a="+new Date().getTime(),function(){
	//	$("#admincontent h1.menuh1").click(function(){
	//		$(this).next("ul").toggle();
	//	});
	//});
});