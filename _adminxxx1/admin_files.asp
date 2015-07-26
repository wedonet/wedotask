<!--#include file="../_setting/conn.asp"-->
<!--#include file = "../_Inc/UploadCls.asp"-->
<%

sp = "admin/_admin_files"
crumb = "<li><a href=""admin_files.asp"">文件管理</a></li>" & vbcrlf

Dim adminfiles

Set adminfiles = new adminfile

Set adminfiles = Nothing  

class adminfile

Private thisdir
Private topdir
Private FileType
Private fso
Private FsoFile
Private AllFileSize
Private totalPut
Private strTitle
Private DirFolder
Private DirFiles
Private phycurrentpath

Private sub Class_Initialize 
	
	Set Fso = Server.CreateObject(FsoObjName)

	TopDir		= webdir
	FileType		= LCase(Trim(Request("FileType")))
	ThisDir		= Trim(Request.QueryString("ThisDir"))

	if ThisDir<>"" Then '<syl>去除目录后的/<by syl>
		ThisDir = Replace(ThisDir & "/","//","/")
	Else	
		ThisDir = TopDir
	End If  

	phycurrentpath = Server.MapPath(ThisDir)

	If Not FSO.FolderExists(phycurrentpath) Then '<syl>不存在这个文件夹,由于从cookie提取当前文件夹,有可能出现文件夹已经删除的情况<by syl>
		ThisDir = "/"
		phycurrentpath = Server.MapPath(ThisDir)
	End If 

	Select Case wedonet.Ract
		Case "del"		: delfile
		Case "deldir"	: DoDelFolder()
		Case "Rname"	: Response.end
		Case "edit"		: fileinfo '<syl>编辑文件<by syl>
		Case "save"		: saveinfo 
		Case "upfile"	: upfile
		Case "creatdir": creatdir '<syl>添加新文件夹<by syl>
		'Case "edit"		: editfile
		Case Else		: Main
	End Select 
	
	Setallnothing()
End Sub 

Private Sub class_terminate()
	Set Fso = Nothing  
End Sub 


	


Sub Main()
	Dim FolderNuns, FileNums
	Dim objname	'<syl>文件名或文件夹名<by syl>
	Dim tli, li, s, operate

	'FolderNuns=FsoFile.SubFolders.count '<syl>目录数<by syl>
	'FileNums=FsoFile.Files.count	'<syl>文件数<by syl>
	'totalPut=FolderNuns+FileNums	'<syl>总数<by syl>
	Dim j, k
	Dim ext

	h = WeDoNet.Style(sp, "main")
	tli = WeDoNet.Style(sp, "li")


	H = Replace(H, "{$webdir}", webdir)
	H = Replace(H, "{$thisdir}", thisdir)
	H = Replace(H, "{$updir}", GetUpDir())

	Set FsoFile = Fso.GetFolder(phycurrentpath)

	H = Replace(H, "{$filesize}", GetSize(FsoFile.size,"b") )

	For Each DirFolder in FsoFile.SubFolders
		objname = DirFolder.Name
		
		operate = "<a href=""?act=deldir&amp;fpath="& thisdir & objname &""" title="""& objname &""" class=""j_del alarm"">删除</a>"
		
	
		s = tli
		s = Replace(s, "{$title}", objname)
		s = Replace(s, "{$filetype}", "folder")
		s = Replace(s, "{$size}", GetSize(DirFolder.size, "b"))
		s = Replace(s, "{$time}", DirFolder.DateLastModified)
		s = Replace(s, "{$href}", "?thisdir=" & thisdir & objname)
		s = Replace(s, "{$operate}", operate)
		li = li & s
		j=j+1
	Next

	H = Replace(H, "{$lifolder}", li)

	li = ""
	For Each DirFiles in FsoFile.Files
		objname = DirFiles.name
		ext = GetExt(objname)
	
		operate = "<a href=""?act=del&amp;fpath="& thisdir & objname &""" title="""& objname &""" class=""j_del alarm"">删除</a> "
		operate = operate & " | <a href="""& thisdir & objname &""" target=""_blank"">查看</a>" & vbcrlf
		
		If Instr("asp,css,js,txt,xml", ext)>0 Then 
			operate = operate & " | <a href=""?act=edit&amp;fpath="& thisdir & objname &""" class=""j_open"">修改</a>" & vbcrlf
		End If 
		s = tli
		s = Replace(s, "{$title}", objname)
		s = Replace(s, "{$filetype}", ext)
		s = Replace(s, "{$size}", GetSize(DirFiles.size, "b"))
		s = Replace(s, "{$time}", DirFiles.DateLastModified)
		s = Replace(s, "{$href}", "javascript:void(0)")
		s = Replace(s, "{$operate}", operate)
		li = li & s
		j=j+1		
	next  

	H = Replace(H, "{$lifile}", li)

	Set FsoFile = Nothing  

	Html.AddHeadFile("css/file.css")
	Html.title="文件管理"
	Html.adhead
	Html.Nstate(crumb)
	Response.Write h
	
	Html.Adfoot
End Sub	

Function GetUpDir()
	Dim strDir,strDir2,i
	strDir=""
	If ThisDir = "" then Exit Function
	strDir2=ThisDir
	strDir2=Split(strDir2,"/")
	for i=0 to Ubound(strDir2)-1
		if i<Ubound(strDir2)-1 then strDir=strDir & strDir2(i) & "/"
	next
	GetUpDir=strDir
End Function 

Public Function GetSize(Byval size,Byval unit)
	if isEmpty(size) or Not Isnumeric(size) then Exit Function
	size=CheckUnit(size,unit)
	if size>1024 then
		size=(size/1024)
		getsize=formatnumber(size,2) & " MB"
	else
		getsize=size & " KB"
		Exit Function
	end if
	if size>1024 then
		size=(size/1024)
		getsize=formatnumber(size,2) & " GB"
	end if
End Function 

Public Function CheckUnit(Byval size,Byval unit)
		Select Case Lcase(Unit)
		Case "b"
			CheckUnit = formatnumber(size/1024,2)
		Case "k"
			CheckUnit = size
		Case "m"
			CheckUnit = (size*1024)
		Case "g"
			CheckUnit = (size*1024*1024)
		Case Else
			CheckUnit = size
		End Select
End Function 

Sub creatdir
	Dim dirname
	Dim filepath
	Dim fullpath
	Dim Fso

	filepath	= Trim(Request.QueryString("filepath"))
	dirname		= wedonet.RequestStr("目录名称","dirname","post",1,1,20,0,1)
	Html.ShowErr("")
	dirname		= Replace(dirname,"/","")
	dirname		= Replace(dirname,"\","")
	dirname		= SanitizeFileName(dirname)
	fullpath	= Server.MapPath(filepath & dirname)

	Set FSO = Server.CreateObject(FsoObjName)
	If FSO.FolderExists(fullpath) Then
		Html.ShowErr("已经存在这个目录了")
	Else 
		FSO.CreateFolder fullpath
	End If
	Html.ok()
End Sub 

function SanitizeFileName( sNewFileName )
	Dim oRegex
	Set oRegex = New RegExp
	oRegex.Global		= True
	'if ( ConfigForceSingleExtension = True ) then
		oRegex.Pattern = "\.(?![^.]*$)"
		sNewFileName = oRegex.Replace( sNewFileName, "_" )
	'end if

	' remove \ / | : ? *  " < > and control characters
	oRegex.Pattern = "(\\|\/|\||:|\?|\*|""|\<|\>|[\u0000-\u001F]|\u007F)|'"

	SanitizeFileName = oRegex.Replace( sNewFileName, "_" )

	Set oRegex = Nothing
end function

Sub upfile()
	Dim xmlgroup, upset
	Dim File, sSaveFileName, F_FileName, sPathFileName, F_Viewname
	Dim sPreviewpath
	Dim FormName
	Dim thumbspath
	Dim uploadedfilename

    Set xmlgroup = application(CacheName & "_group").documentElement.selectSingleNode("li[@id='" & wedonet.User_gid & "']")
    If xmlgroup Is Nothing Then
        Html.ShowErr("您所在的用户组不存在,请重新登录")
    Else
        upset = xmlgroup.getAttribute("upset")&""
    End If
    If len(upset)=0 Then
		upset = "0|0|0|"
	End If
	upset = split(upset,"|")


	fuyou = wedonet.uploadsetting
	fuyou = Split(fuyou,"|||")

	Set Upload = New UpFile_Cls
	Upload.UploadType			= fuyou(1)			'<syl>设置上传组件类型<by syl>
	Upload.PreviewType		= fuyou(2)

	Upload.UploadPath			= Trim(Request.QueryString("filepath"))		'<syl>设置上传路径<by syl>
	Upload.InceptFileType	= upset(3)			'<syl>设置上传文件限制<by syl>
	Upload.MaxSize				= upset(2)			'<syl>单位 KB<by syl>
	Upload.InceptMaxFile		= 1					'<syl>每次上传文件个数上限<by syl>
	Upload.IsReName             = 0					'<syl>原文件名<by syl>

	Denied						= "asp"
	Upload.PreviewImageWidth	= fuyou(15)				'<syl>设置预览图片宽度<by syl>
	Upload.PreviewImageHeight	= fuyou(16)				'<syl>设置预览图片高度<by syl>
	Upload.DrawSizeType			= fuyou(17)	
	
	Upload.SaveUpFile

	If Upload.Count > 0 Then 
		If Upload.PreviewType<>999 Then '<syl>生成预览图<by syl>
			For Each FormName In Upload.UploadFiles
				Set File		= Upload.UploadFiles(FormName)
				If File.FileType=1 Then 
					thumbspath = Server.MapPath(Upload.UploadPath & "pre") '<syl>预览图路径<by syl>
					'<syl>不存在则生成<by syl>
					If FSO.FolderExists(thumbspath)=False Then
						FSO.CreateFolder (thumbspath)
					End If 
					sUploadDir = Upload.UploadPath
					uploadedfilename   = File.FileName
					F_FileName = sUploadDir & uploadedfilename
					F_Viewname = sUploadDir &"pre/"& Replace(File.FileName,File.FileExt,"") & "jpg"'<syl>生成预览图片路径<by syl>
					Upload.CreateView F_FileName,F_Viewname,"jpg"		

				End If 
				Set File = Nothing
			Next
		End If 
		'<syl>提取uploadedfilename=以前的字符,便于避免重复的uploadedfilename=<by syl>
		Response.Redirect split(Request.ServerVariables("HTTP_REFERER"),"&uploadedfilename=")(0) & "&uploadedfilename="&uploadedfilename
		
	Else
		Html.showerr("您上传的文件大小或格式不符合本站规定,请重新上传("&Upload.Description&")")
	End If
	Set Upload=Nothing  
End Sub 

Function GetExt(byval filename)
	GetExt = right(lcase(filename), (len(filename) - InstrRev(filename, ".")))
End Function 

Sub Del

End Sub


Sub DoDelFolder
	Dim dir, psydir, remdir
	Dim fso

	dir = Trim(Request.QueryString("fpath"))
	psydir = Server.MapPath(dir)

	Set fso = Server.CreateObject(FsoObjName)
	If fso.FolderExists(psydir) Then 
		fso.DeleteFolder(psydir)		
	End If 
	html.ok

End Sub

Sub DelFile
	Dim filename, psyfile
	Dim fso

	filename = Trim(Request.QueryString("fpath"))
	psyfile = Server.MapPath(filename)

	Set fso = Server.CreateObject(FsoObjName)
	'<syl>删除模板<by syl>
	If fso.fileexists(psyfile) Then 
		fso.deletefile (psyfile)
	End If 


	Set fso = Nothing  

	html.ok
End Sub 


Sub fileinfo
	Dim filepath, content

	h = WeDoNet.Style(sp, "formedit")
	
	Set	FsoFile = Fso.GetFolder(phycurrentpath)


	filepath = wedonet.RequestStr("文件名", "fpath", "get", 1, 2, 255, 0, 1)
	Html.ShowErr("")

	content = wedonet.LoadFile(filepath)
	
	h = replace(h, "{$action}", "?act=save&filepath="&filepath)
	H = Replace(H, "{$filepath}", filepath)
	h = Replace(h, "{$content}", server.htmlencode(content))
	Response.Write h
End Sub 

Sub saveinfo()
	Dim content

	content = Request.Form("content")
	wedonet.MakeHtml Request.Form("content"), Trim(Request.QueryString("filepath"))

	Html.AjaxInfo "保存成功", 1
End Sub



End class








%>