$(document).ready(function(){
	/*点更多，切换全显和部分显示*/
	$('.j_showmore').toggle(
		function(){
			$(this)
				.html('&lt;&lt;返回')
				.parent().find('span:hidden')
				.show()				
				.addClass('tempshow');
		},
		function(){
				$(this)
				.html('&gt;&gt;更多...')
				.parent().find('.tempshow')
				.hide()				
				.removeClass('tempshow');
		}
	)
})


/*把更多人追回到执行人或验收人*/
function updateuser_(mytype){
	var formid = 'formmore'; //更多联系人表单id
	var j_duid = 'j_duid'; //执行人最外面的Id
	var j_cuid = 'j_cuid'; //验收人最外面的id

	var currentdiv = '';
	var inputname = '';

	if ( 'd' == mytype)
	{
		var currentdiv=j_duid;
		var inputname = 'duids[]';
	}
	else{
		var currentdiv=j_cuid;
		var inputname = 'cuids[]';
	}
	


	$('#'+formid+' input[name="userlist"]').each(function(){
		if ($(this).attr('checked'))
		{
			var text = $(this).parent().text(); //姓名
			var uid = $(this).val(); //会员id


			var str = '<input type="checkbox" name="'+inputname+'" value="'+uid+'" class="vmiddle" checked="checked" /> '+text+' &nbsp; ';

			$('#'+currentdiv).append(str);
		}
		
	})


	$("#close").click(); //关闭窗口
	return false;
}

/*更新常用联系人*/
function updateuseridlist(json){
	var myuser = json.myuser; //设置的常用执行人和验收人

	for(var x in myuser){
		/*把常用执行人显示出来*/
		if ( 'd' == myuser[x].mytype )
		{
			formatd( myuser[x].myidlist );
		}

		/*把常用检测人显示出来*/
		if ( 'c' == myuser[x].mytype )
		{
			formatc( myuser[x].myidlist );
		}
	}	


	/*把选中的执行人也显示出来*/
	if('d_uids' in json){
		formatd( json.d_uids);
	}

	/*把选中的检测人显示出来*/
	if('c_uids' in json){
		formatc( json.c_uids);
	}

	//alert(("myuser" in json) );
}

/*显示出常用执行人*/
function formatd(uids){
	var a = uids.split(',');

	for (var i=0; i<a.length; i++)
	{
		if ( '' != a[i])
		{
			$('#j_d_'+a[i]).show();
		}		
	}
}

function formatc(uids){
	var a = uids.split(',');

	for (var i=0; i<a.length; i++)
	{
		if ( '' != a[i])
		{
			$('#j_c_'+a[i]).show();
		}		
	}
}