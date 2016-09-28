<?php
/**
 * 上传文件的分类管理.
 * 
 * @author  CU 
 * @version 1.0
 * @package main
 */

/*
<%
'<syl>附件管理器的分类管理<by syl>

Sub ListClass()
	Dim sql, tli, li

	h = WeDoNet.Style(sp, "ulclass")
	tli = WeDoNet.Style(sp, "liclass")

	sql = "select * from ["& sh &"_upclass] where ftype="& ftype
	sql = sql & " and uid=" & WeDoNet.user_id

	li = WeDoNet.RepM(sql, tli, 9, 0, "")

	H = Replace(H, "{$ftype}", ftype)
	H = Replace(H, "{$li}", li)
	H = Replace(H, "{$pagelist}", page.pagelist("", 1))

	Html.adhead()
	Response.Write h
	Response.Write "</body></html>"
End Sub

Sub SaveClass(isedit)
	Dim title
	Dim sql

	title = WeDoNet.Requeststr("分类名称", "title", "post", 1, 1, 20, 30, 1)	

	Html.ajaxerr("")
	
	If isedit Then 
		sql = "update "& sh &"_upclass set title='"& WeDoNet.Checkstr(title) &"' where id=" & WeDoNet.Rqid("id")
		sql = sql & " and uid = "& WeDoNet.user_id
	Else 
		sql = "insert into "& sh &"_upclass (uid, ftype, title) values ("& WeDoNet.user_id &", "& ftype &", '"& WeDoNet.Checkstr(title) &"')"
	End If 

	WeDoNet.execute(sql)

	sucmsg = "<li class='h1'>保存成功</li>" & vbcrlf
	sucmsg = sucmsg & "<li>系统将自动返回</li>" & vbcrlf

	Html.Jok()
	Html.ajaxinfo sucmsg, 1

	'ajaxinfo sucmsg, 1
End Sub

Public Sub Jok()
	Response.Write "<script type=""text/javascript"">"
	Response.Write "setTimeout('ReloadFrame()', '500');"
	Response.Write "</script>"
End Sub

'<syl>删除分类<by syl>
Sub DelClass()
	Dim sql

	'<syl>删除分类<by syl>
	sql = "delete from "& sh &"_upclass where id= " & WeDoNet.Rqid("id")
	sql = sql & " and uid=" & WeDoNet.user_id

	WeDoNet.execute(sql)

	'<syl>更新原分类的文件所属分类为0(不属于任何分类)<by syl>
	sql = "update "& sh &"_uplist set myclassid=0 where id= " & WeDoNet.Rqid("id")
	sql = sql & " and uid=" & WeDoNet.user_id

	WeDoNet.execute(sql)

	Jok()
End Sub

Sub FormClass()
	Dim sql

	H = WeDoNet.Style(sp, "formclass")

	id = WeDoNet.Rqid("id")

	sql = "select * from ["& sh &"_upclass] where id=" & id
	sql = sql & " and uid=" & WeDoNet.user_id

	H = Replace(H, "{$action}", "?act=esaveclass&amp;id=" & id)
	h = WeDoNet.RepM(sql, h, "", 1, "")
	
	Response.Write h
End Sub
%>
*/