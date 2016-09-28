$(document).ready(function(){
	//选择本频道内网页
	$("#selectpage").hover(
	  function () {
		 $(this).find("dd").show();
	  },
	  function () {
		 $(this).find("dd").hide();
	  }
	); 
})

//提交部分模板
function updatepart(){
	$("a.j_updatetemplate").click(function(){
		var obj=$(this).find("img");
		var num = $(this).attr("rel");
		var str = $("#str_"+ num).val();

		$(this).find("img").attr("src","../images/loading.gif");
	
		var href = encodeURI($(this).attr("href")) + "&t=" + new Date().getTime();

		$.ajax({
			type: "POST",
			url:href,
			data:{templatestr:str},
			complete:function(Request){
				var s=Request.responseText;
				if (s.length>0)
				{
					alert(s);
					alert("请重新登录");
					obj.attr("src","../images/submit.gif");		
				}
				else{
					obj.hide();			
					obj.attr("src","../images/submit.gif");		
					obj.fadeIn("slow");
				}

			}
		});
		return false;


});
};
function hotkeysave(){
	$("textarea.vtextarea").bind('keydown', function(event){
		var obj=$(this).attr("id");
		if (event.ctrlKey&&83==event.keyCode)
		{
			$("#s"+obj).click();
			return(false);
		}
	})

	$("textarea.vtextarea").keydown(function(event){
		if (9==event.keyCode)
		{
			$(this).insertAtCaret("	");
			return false;
		};
	});
}


//另一个插件, 在光标处插入字符
(function($){
$.fn.extend({
insertAtCaret: function(myValue){
var $t=$(this)[0];
if (document.selection) {
this.focus();
sel = document.selection.createRange();
sel.text = myValue;
this.focus();
}
else
if ($t.selectionStart || $t.selectionStart == '0') {
var startPos = $t.selectionStart;
var endPos = $t.selectionEnd;
var scrollTop = $t.scrollTop;
$t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
this.focus();
$t.selectionStart = startPos + myValue.length;
$t.selectionEnd = startPos + myValue.length;
$t.scrollTop = scrollTop;
}
else {
this.value += myValue;
this.focus();
}
}
})
})(jQuery); 