<?php

require('../../global.php');
require( 'cls_style.php' ); //模板main
require( sysdir . '_inc/cls_upload.php');

class Myclass extends Cls_style{

	function __construct() {
		parent::__construct();		

		$act = $this->main->ract();

		switch ($act) {
			case 'upfile':
				$this->doupfile();
				break;
			case 'creatdir':
				$this->creatdir();
				break;			
			case 'freadme':
				$this->freadme();
				break;
			case 'savereadme':
				$this->savereadme();
				break;
			case 'delfile':
				$this->delfile();
				break;
			case 'creatfile':
				$this->creatfile();
				break;

			case 'deldir':
				$this->deldir();
				break;

			case 'edittext':
				$this->edittext();
				break;
			case 'savetext':
				$this->savetext();
				break;
			default:
				$this->main();
				break;
		}
	}

	function main() {
		$dir = $_GET['dir'];

		$dirpath = $this->rootpath;

		$psypath = sysdir . $this->rootpath;

		$this->c_ad->head();
		$this->c_ad->crumb();

		echo '<table cellspacing="0" class="table1 j_list">' . PHP_EOL;
		echo '	<tr>' . PHP_EOL;
		echo '	<td>' . PHP_EOL;
		echo '		<a href="?act=list&amp;dir=' . $dir . '" title="返回到主目录" class="red">返回主目录</a> | ' . PHP_EOL;
		echo '		当前目录：' . $dir . '</td>' . PHP_EOL;
		echo '	<td>' . PHP_EOL;
		echo '		<a href="list.php?dir=' . $this->getupdir($dir) . '"><font color="ff0000">↑上一目录</font></a></td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '	<tr>' . PHP_EOL;
		echo '	<td colspan="2">' . PHP_EOL;
		echo '		<form method="post" action="?act=upfile&amp;dir=' . $dir . '" enctype="multipart/form-data" style="display:inline;">' . PHP_EOL;
		echo '		<input type="file" name="userfile" size="20" value="浏览" /> <input type="submit" class="uploadbutton" id="uploadbutton" value="上传文件" /> &nbsp; &nbsp; &nbsp; ' . PHP_EOL;
		echo '		</form>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;

		echo '		<form method="post" action="?act=creatdir&amp;dir=' . $dir . '" style="display:inline;">' . PHP_EOL;
		echo '		<input type="text" name="dirname" value="" size="15" maxlength="20" />' . PHP_EOL;
		echo '		<input type="submit" value="新建文件夹" />' . PHP_EOL;
		echo '		</form>&nbsp;&nbsp;&nbsp;&nbsp;' . PHP_EOL;

		echo '		<form method="post" action="?act=creatfile&amp;dir=' . $dir . '" style="display:inline;">' . PHP_EOL;
		echo '		<input type="text" name="filename" value="" size="15" maxlength="30" />' . PHP_EOL;
		echo '		<input type="submit" value="新建文件" />' . PHP_EOL;
		echo '		</form>' . PHP_EOL;
		echo '	</td>' . PHP_EOL;
		echo '	</tr>' . PHP_EOL;
		echo '</table>' . PHP_EOL;

		echo '<br />' . PHP_EOL;
		echo '<div id="list">' . PHP_EOL;
		echo '<table cellspacing="0" class="table1 j_list">' . PHP_EOL;
		echo '	 <tr>' . PHP_EOL;
		echo '		<th width="300">文件/文件夹名</th>' . PHP_EOL;
		echo '		<th width="*">说明</th>' . PHP_EOL;
		echo '		<th width="80">文件大小</th>' . PHP_EOL;
		echo '		<th width="150">最后修改时间</th>' . PHP_EOL;
		echo '		<th width="150">操作</th>' . PHP_EOL;
		echo '	 </tr>' . PHP_EOL;

		$mypath = $psypath . $dir;
		//stop($mypath);
		$dir_list = scandir($mypath);

		//循环文件夹
		foreach ($dir_list as $file) {
			if ($file != ".." && $file != ".") {
				if (is_dir($mypath . "/" . $file)) {
					$objname = $mypath . "/" . $file;
					$fname = $this->rootpath . $dir . '/' . $file;
					echo '<tr>' . PHP_EOL;
					echo '	<td><a href="?act=list&amp;dir=' . $dir . '/' . $file . '" class="folder"> ' . $file . '</a></td>' . PHP_EOL;
					echo '	<td><a href="' . $fname . '_.txt" class="j_load"></a></td>' . PHP_EOL; //说明
					echo '	<td>&nbsp;</td>' . PHP_EOL;
					echo '	<td>' . date('Y-m-d H:i:s.', fileatime($objname)) . '</td>' . PHP_EOL;
					echo '	<td>' . PHP_EOL;
					echo '	<a href="?act=freadme&amp;fname=' . $fname . '" class="j_open">说明</a> | ' . PHP_EOL;
					echo '	<a href="?act=deldir&amp;dir=' . $fname . '" class="j_del alarm" title="删除' . $fname . '">删除</a>' . PHP_EOL;
					echo '	</td>' . PHP_EOL;
					echo '</tr>' . PHP_EOL;
				}
			}
		}

		//循环文件
		foreach ($dir_list as $file) {
			$objname = $mypath . "/" . $file;
			$ext = $this->getext($file);
			$fname = $dirpath . $dir . '/' . $file;

			if (!is_dir($objname) and strpos($file, ".txt") === false) {
				echo '<tr>' . PHP_EOL;
				if ($ext == "php") {
					echo '<td><a href="edit.php?filename=' . $fname . '" style="text-decoration:none;">' . $file . '</a></td>' . PHP_EOL;
				} else {
					echo '<td>' . $file . '</td>' . PHP_EOL;
				}
				echo '	<td><a href="' . $fname . '_.txt" class="j_load"></a></td>' . PHP_EOL;
				echo '	<td>' . $GLOBALS['main']->getRealSize(filesize($objname)) . '</td>' . PHP_EOL; //文件大小
				echo '	<td>' . date('Y-m-d H:i:s.', fileatime($objname)) . '</td>' . PHP_EOL;
				echo '	<td>' . PHP_EOL;
				switch ($ext) {
					case 'gif' : case 'jpeg': case 'jpg': case 'png': case 'bmp': case 'tif': case 'tif':
						echo '<a href="' . $fname . '" target="_blank">查看</a> | ' . PHP_EOL;
						break;
					case 'php':
						echo '	<a href="edit.php?filename=' . $fname . '">编辑</a> | ' . PHP_EOL;
						break;
					case 'htm' : case 'html': case 'css': case 'js': case 'xml':
						echo '<a href="?act=edittext&amp;filename=' . $fname . '">修改</a> | ' . PHP_EOL;
						break;
				}

				//echo '<a href="lang.php?filename='.$fname.'">语言</a> | '; //语言

				echo '<a href="?act=freadme&amp;fname=' . $fname . '" class="j_open">说明</a> | ' . PHP_EOL;
				echo '		<a href="?act=delfile&amp;filename=' . $fname . '" title="删除' . $fname . '" rel="j_line_" class="j_del alarm">删除</a>' . PHP_EOL;
				echo '</td>' . PHP_EOL;
				echo '</tr>' . PHP_EOL;
			}
		}


		echo '</table>' . PHP_EOL;
		echo '</div>' . PHP_EOL; //关闭list

		$this->c_ad->foot();
	}

	function doupfile() {
		/* 上传文件 */

		$dir = $_GET['dir'];

		$psypath = sysdir . $this->rootpath . $dir;


		$upload = new CI_Upload();

		$config['upload_path'] = $psypath;
		$config['allowed_types'] = '*';
		$config['max_size'] = '2000';
		$config['max_width'] = '2048';
		$config['max_height'] = '2048';

		$upload->initialize($config);

		$upload->do_upload();

		if (count($upload->error_msg) > 0) {
			$upload->error_msg[0];
		} else {
			htmlok();
		}
	}

// end func

	function freadme() {
		$fname = $_GET['fname'];

		$mypath = sysdir . $fname;



		echo '<div class="pxsmall">' . PHP_EOL;
		echo '	<div class="th">' . $fname . '</div>' . PHP_EOL;
		echo '	<div class="ac">' . PHP_EOL;
		echo '		<form method="post" action="?act=savereadme&amp;fname=' . $fname . '" id="formreadme">' . PHP_EOL;
		echo '		<p><input type="text" name="content" id="content" value="" size="40" style="height:30px;line-height:30px;width:100%" /></p>' . PHP_EOL;
		echo '		<p><input type="submit" value="提交" class="submit1" onclick="j_repost(\'formreadme\')" /></p>' . PHP_EOL;
		echo '		</form>' . PHP_EOL;
		echo '	</div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;

		echo '<script type="text/javascript">' . PHP_EOL;
		echo '<!--' . PHP_EOL;
		echo '$(document).ready(function(){' . PHP_EOL;
		echo '	$.get("' . $fname . '_.txt",function(data){' . PHP_EOL;
		echo '	$("#content").val(data);' . PHP_EOL;
		echo '	});' . PHP_EOL;
		echo '})' . PHP_EOL;
		echo '//-->' . PHP_EOL;
		echo '</script>' . PHP_EOL;
	}

	function savereadme() {
		$fname = $_GET['fname'];

		//变为说明文件
		$fname .= "_.txt";

		$content = $_POST['content'];

		$mypath = sysdir . $fname;

		$myfile = fopen($mypath, 'w');

		fwrite($myfile, $content);

		fclose($myfile);

		jsucok();
	}

	function delfile() {

		$filename = $_GET['filename'];

		//要删除的目录必须位于这个目录下
		if (strpos($filename, '/_style/') === false) {
			showerr(1022);
		}

		$dirpath = sysdir . $filename;

		unlink($dirpath);

		htmlok();
	}

	function creatfile() {

		$dir = $_GET['dir'];

		$filename = $this->main->request('文件名', 'filename', 'post', 'char', 1, 50, 'folder');

		showerr();

		$dirpath = $dir . '/' . $filename;		

		$dirpath = sysdir . $this->rootpath . $dirpath;
		
		/*$$$$去掉两个//*/
		$dirpath = str_replace('//', '/', $dirpath);

		/* 检测文件是否存在 */
		if (file_exists($dirpath)) {
			showerr('<li>有同名文件, 请重新填写</li>');
		}

		
		$myfile = fopen($dirpath, 'a');
		
		
		fclose($myfile);

		htmlok();
	}

	function creatdir() {
		$dir = $_GET['dir'];

		$dirname = $this->main->request('文件夹名', 'dirname', 'post', 'char', 1, 50, 'folder');

		showerr();

		$dirpath = $dir . '/' . $dirname;
		$dirpath = sysdir . '/_style/' . $dirpath;


		/* 检测文件夹是否存在 */
		if (file_exists($dirpath)) {
			showerr('<li>有同名文件夹, 请重新填写</li>');
		}


		if (mkdir($dirpath, 0777)) {
			htmlok();
		} else {
			showerr('添加失败');
		}
	}

	function deldir() {
		$dir = $_GET['dir'];

		//要删除的目录必须位于这个目录下
		if (strpos($dir, '/_style/') === false) {
			showerr(1022);
		}

		$dirpath = sysdir . '/' . $dir;


		if (!file_exists($dirpath)) {
			showerr('<li>要删除的目录不存在!</li>');
		}

		$this->main->delDirAndFile($dirpath);

		htmlok();
	}

	function edittext() {
		$filename = Trim($_GET['filename']);

		crumb("修改页面");
		crumb($filename);
		
		$this->c_ad->head();
		$this->c_ad->crumb();

		$fpath = sysdir . '/' . $filename;
		$content = $this->main->read_file($fpath);

		if (false === $content) {
			$content = '';
		} else {
			$content = htmlspecialchars($content);
		}

		echo '<form method="post" action="?act=savetext&amp;filename=' . $filename . '" id="myform">' . PHP_EOL;
		echo '<textarea name="content" rows="32" cols="60" style="width:100%">' . $content . '</textarea>' . PHP_EOL;
		echo '<p></p>' . PHP_EOL;
		echo '<input type="submit" value="提交" onclick="j_post(\'myform\')" class="submit1" />' . PHP_EOL;
		echo '</form>' . PHP_EOL;

		$this->c_ad->foot();
	}

	function savetext() {
		$filename = Trim($_GET["filename"]);
		$content = Trim($_POST["content"]);

		$fpath = $this->main->mappath($filename);

		if ($this->main->write_file($fpath, $content)) {
			jsucclose();
		} else {
			showerr('<li>保存失败</li>');
		}
	}

}

$myclass = new Myclass();