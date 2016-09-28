/*我的未读任务，显示新*/
function formatnew(obj, uid){
	$("."+obj).each(function(){
		var v=''; //显示在容器里的值

		var s = $(this).text();

		var a = s.split('|');

		/*执行人有我，但已执行人没我，则显示新*/
		if ( a[0].indexOf(uid) >= 0  && a[1].indexOf(uid)<1 )
		{
			s = '<img src="'+webdir + 'task/images/new.png"'+' alt="" height="10" align="absmiddle" />';
		}
		else{
			s = '';
		}

		$(this).replaceWith(s);
	})
}