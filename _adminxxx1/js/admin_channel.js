

function formatoperate(){
	$("span.chaoperate").each(function(){
		//cha_moduleid|{$cha_type}|{$cha_dir}|{$cha_url}|{$icanghost}
		var setting=$(this).text().split("|");

		//外部频道转换链接成网址
		if (setting[1]=="2")
		{
			$(this).siblings(".browse").attr("href",setting[3]);
		}

		//取消外部频道,控制面版的参数设置
		if (setting[0]=="0" || setting[0]=="12")
		{
			$(this).siblings(".setting").attr("href","javascript:void(0)").addClass("gray");
		}

		//取消非内容模块的字段设置
		if (setting[0] != "1" && setting[0] !=7)
		{
			$(this).siblings(".other").attr("href","javascript:void(0)").addClass("gray");
		}

		//取消非克隆频道的克隆链接
		if (setting[4] != "1")
		{
			$(this).siblings(".ghost").attr("href","javascript:void(0)").addClass("gray");
		}

		//取消系统模块的删除链接
		if (setting[1]=="0")
		{
			$(this).siblings(".delchannel").attr("href","javascript:void(0)").addClass("gray");
		}
	});
}


//批量设置权限全选用户组
function selall(){
	checkall("cha_viewcls");
	checkall("cha_postcls");
	checkall("cha_searchcls");
	checkall("cha_recls");
	checkall("cha_passcls");
	checkall("cha_repasscls");
	checkall("cha_downcls");
}
//批量设置权限返选用户组
function consel(){
	contrasel("cha_viewcls");
	contrasel("cha_postcls");
	contrasel("cha_searchcls");
	contrasel("cha_recls");
	contrasel("cha_passcls");
	contrasel("cha_repasscls");
	contrasel("cha_downcls");
}

function otherjs(){
	//点击自定义字段后,显示右面的字段设置
	$(".usemyfield").click(function(){
		if ($(this).attr("checked")==true)
		{
			$(this).siblings("div").show(); 
		}
		else {
			$(this).siblings("div").hide(); 
		}
	});

	var cha_other = $("#cha_other").html().split("$");
	for (var i=0;i<10 ;i++ )
	{
		
		cha_other[i]=cha_other[i].split("@");
		if (cha_other[i][0]=="1")
		{			

			$("#myfield_"+i).show(); //显示字段参数
			$("#usemyfield_"+i).attr("checked",true); //选中状态
		}
		else {
			$("#usemyfield_"+i).attr("checked",false);//非选中状态
		}
		$("#mustfill_"+i).val(cha_other[i][1]); //是否必填
		$("#inputtype_"+i).val(cha_other[i][2]); //类型
		$("#myfieldname_"+i).val(cha_other[i][3]); //字段名称
		$("#otheroption_"+i).val(cha_other[i][4].replace(/\|/g,'\n')); //选项
	}	
}

function makerelate(){
	var avalue=$("#cha_relate").val().split(",");
	for (var i=0;i<avalue.length ;i++ )
	{
		$("input[name=cha_relate][value="+avalue[i]+"]").attr("checked","checked");
	}
}