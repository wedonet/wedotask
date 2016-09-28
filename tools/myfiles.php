<?php

/**
 * 上传文件.
 * 
 * @author  YilinSun
 * @version 1.0
 * @package main
 */
require('../global.php');
require(sysdir . 'tools/myfiles_class.php');
require(sysdirad . 'inc/cls_ad.php');
require(sysdir . '_inc/cls_upload.php');
require(sysdir . '_inc/cls_image.php');

define('sp', 'tools/_myfiles');

$main->cssinfo = $main->htm('css');

$ftype = $main->rqid('ftype');

if ($ftype < 1) {
	$ftype = 1; //默认上传图片
}
define('Ftype', $ftype);

class Myclass {

	function __construct() {
		$this->main = & $GLOBALS['main'];
		$this->html = & $GLOBALS['html'];

		$act = $this->main->ract();

		switch ($act) {
			case '' : $this->Main();
				break;

			case 'showclass' : $this->ShowClass();
				break; //显示分类

			case 'list' : $this->HtmlList();
				break;

			case 'savefile' : $this->SaveFile();
				break;

			case 'del' : $this->DoDel();
				break;

			case 'edittitle' : $this->FormTitle();
				break;

			case 'savetitle' : $this->SaveTitle();
				break;
			Case "class" :
				ListClass();
				break;
			/*
			  '<syl>分类管理<by syl>
			  Case "showclass" : showclass() '<syl>显示分类<by syl>
			  Case "nsaveclass" : SaveClass(false) '<syl>保存用户分类<by syl>

			  Case "class" : ListClass() '<syl>管理分类, 添加,修改, 删除<by syl>
			  Case "delclass" : DelClass()
			  Case "editclass"	: FormClass() '<syl>编辑分类<by syl>
			  Case "esaveclass"	: SaveClass(true)
			 */
		}
		san();
	}

	function Main() {
		$fromeditor = $this->main->rqid('fromeditor');
		$preid = $this->main->request('preid', 'preid', 'get', 'char', 1, 50, '', FALSE);
		$obj = $this->main->request('obj', 'obj', 'get', 'char', 1, 50, '', false);

		showerr();

		$h = $this->main->htm('main');
		$h = str_replace('{$webdir}', webdir, $h);

		$js = '$("#ftype' . Ftype . '").addClass("on");' . PHP_EOL;

		$h = str_replace('{$this->mainbdir}', webdir, $h);
		$h = str_replace('{$ftype}', Ftype, $h);
		$h = str_replace('{$preid}', $preid, $h);
		$h = str_replace('{$obj}', $obj, $h);

		$h = str_replace('{$fromeditor}', $fromeditor, $h);



//显示在 编辑器里面时，加上头部
		if ($fromeditor == 1) {

//隐藏面包宵
			$js .= '$("#th").hide();';

			$h = str_replace('{$js}', $js, $h);

			$h = str_replace('{$funcnum}', $_GET['CKEditorFuncNum'], $h);

			$this->head();

			echo $h;
			echo '</div>';
		} else {
			$h = str_replace('{$js}', $js, $h);

			echo $h;
		}
	}

// end func

	/**
	 * 显示左侧分类导航.
	 */
	function ShowClass() {
		$h = $this->main->htm('divclass');
		$h = str_replace('{$webdir}', webdir, $h);
		$tli = '<li><a href="?act=list&amp;ftype=' . Ftype . '&amp;classid={$id}" target="main">{$title}</a></li>';

		$sql = 'select * from `' . sh . '_upclass` where ftype = ' . Ftype;
		$sql .= ' and uid=' . $this->main->u_id;

		$li = $this->main->repm($sql, $tli);

		$h = str_replace('{$li}', $li, $h);
		$h = str_replace('{$ftype}', Ftype, $h);
		$h = str_replace('{$this->mainbdir}', webdir, $h);

		echo $h;
	}

// end func

	function HtmlList() {
//$fromeditor = TRUE;
		$js = '';
		$c_ad = new Cls_ad();

		switch (Ftype) {
			case 1 :
				$h = $this->main->htm('ulpic');
				$tli = $this->main->htm('lipic');

				$mypagecount = 12;
				break;
			case 2 :
				$h = $this->main->htm('ulfile');
				$tli = $this->main->htm(sp, 'lifile');

				$mypagecount = 10;
				break;
			default :
				$h = $this->main->htm('ulfile');
				$tli = $this->main->htm('lifile');

				$mypagecount = 10;
				break;
		}

//接收
		$myclassid = $this->main->rqid('classid');
		$classname = $this->GetClassName($myclassid);
		$fromeditor = $this->main->rqid('fromeditor', 0);


		$utype = $this->main->request('utype', 'utype', 'post', 'char', 1, 50, 'invalid', FALSE);

//处理
		if ($myclassid < 0) {
			$myclassid = 0;
		}

		if ($utype = '') {
			$utype = '0,1';
		}

		$tli = str_replace('{$href}', '{$urlfile}', $tli);

		$sql = 'select * from `' . sh . '_uplist` where isdel=0 and ftype=' . Ftype . ' and uid=' . $this->main->u_id;

		if ($myclassid > -1) {
			$sql .= ' and myclassid=' . $myclassid;
		}

//来自在线编辑器时加
		if ($fromeditor == 1) {
			$h = str_replace('{$funcnum}', $_GET['funcnum'], $h);
			$js .= '$("a.url").AddUrl();';
		} else {
			$js .= 'formatfilelink();';
		}


//if ( $utype != '' ) {
//	$sql .= ' and utype in ('.$utype.')';
//	$js .= 'checkcheckbox("utype", "'.$utype.'")'.PHP_EOL;
//}

		$sql .= ' order by id desc';

		$li = $this->main->repm($sql, $tli, null, $mypagecount, True);

		$h = str_replace('{$action}', '?act=savefile&amp;myclassid=' . $myclassid . '&amp;ftype=' . Ftype, $h);

//$h = str_replace('{$myclassid}', $myclassid, $h);
		$h = str_replace('{$classname}', $classname, $h);
//$h = str_replace('{$ftype}', $ftype, $h);
		$h = str_replace('{$js}', $js, $h);
		$h = str_replace('{$li}', $li, $h);
		$h = str_replace('{$pagelist}', $this->main->pagelist(), $h);


		$c_ad->head();
		echo $h;
		echo '</div></body></html>';
	}

// end func

	function SaveFile() {
		$andpreimg = 1;

		$myclassid = $this->main->rqid('myclassid');

		if ($myclassid < 0) {
			$myclassid = 0;
		}

		$upload = new CI_Upload();

		$uploadpath = $this->getuploadpath(Ftype);

		$psyfile = sysdir . $uploadpath;

		$config['upload_path'] = $psyfile;


		switch (Ftype) {
			case 1 :
				/* 是图片 */
				$config['is_image'] = TRUE;

				/* 这里准备加参数设置 */
				$config['allowed_types'] = '*';
				$config['max_size'] = '20000';
				$config['max_width'] = '5048';
				$config['max_height'] = '5024';

				break;
			case 2:
				/* 检测是不是flash */
				$config['allowed_types'] = '*.swf';
				break;
			case 3:
				/* 检测是不是允许上传 */
				$config['allowed_types'] = '*';
				break;
			default:
				showerr(1022);
				break;
		}



		/* 文件名 = 用户ID, 当前日期时间, 随机数 */
		$config['file_name'] = $this->main->u_id . date('YmdHis') . rand(1000, 9999);


		$upload->initialize($config);

		$upload->do_upload('file1');

		if (count($upload->error_msg) > 0) {
			$upload->error_msg[0];
			showerr($upload->error_msg[0]);
		} else {
			$data = $upload->data();

			/* 上传完了,进行处理 */
			switch (Ftype) {
				case 1 :
					/* 图片 */
					if (!$data['is_image']) {
						showerr(1022);
					};

					/* 宽或高大于200,生成预览图 */
					if ($upload->image_width > 260 OR $upload->image_height > 260) {

						/* 开始生成预览图 */
						$config['image_library'] = 'gd2';
						$config['source_image'] = $psyfile . $data['file_name'];
						$config['new_image'] = $psyfile . 'thumb/';
						$config['create_thumb'] = TRUE;
						$config['thumb_marker'] = '';
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 260;
						$config['height'] = 260;

						$img = new CI_Image_lib($config);

						$img->resize();

						if ($img->display_errors() == '') {
//缩略成功,生成一个预览图路径
							//$urlthumb = $thumb_path . $upload->file_name;
							/*$urlthumb = $thumb_path . $upload->file_name;*/

							$rs["urlthumb"] = $uploadpath . 'thumb/' . $data['file_name'];
						} else {
							//echo ( $img->display_errors());
							//die;
							showerr('生成缩略图失败'.$img->display_errors());

//$urlthumb = $full_path;
//缩略图失败,用原图做缩略图路径
						}

						unset($img);
					} else {
						$rs["urlthumb"] = $uploadpath . $data['file_name'];
					}

					/* 向上传列表中添加图片地址及属性 */
					$sql = '';
					break;
				case 2:
					/**/
					break;
				default:
					break;
			}
		
			/* 取得原始文件名, 不带后缀 */
			$title = $upload->client_name;
			$title_ = explode('.', $title);
			$title = $title_[0];

//把路径和文件信息插入数据库
			$rs["uid"] = $this->main->user['id'];
			$rs["u_nick"] = $this->main->user['u_nick'];

			/* 暂时用文件名做描述 */
			$rs["title"] = $title;
			$rs["urlfile"] = $uploadpath . $data['file_name'];

			$rs["ftype"] = Ftype;


			$rs["stime"] = time();
			$rs["filesize"] = $upload->file_size;

			$rs["ufilewidth"] = $upload->image_width;
			$rs["ufileheight"] = $upload->image_height;


			$rs["myclassid"] = $myclassid;
			

			if (  '' == $rs["ufilewidth"] ){
				$rs["ufilewidth"] = 0;
			};
			if ( '' == $rs["ufileheight"] ) {
			    $rs["ufileheight"] = 0;
			}

			$this->main->pdo->insert(sh . '_uplist', $rs);

			htmlok();
		}

		unset($upload);

		htmlok();
	}

// end func
//==================================================================
	function GetClassName($myid) {
		switch ($myid) {
			case 0 :
				return '未分类的记录';
				break;
			case -1 :
				return '全部分类的记录';
				break;
			default :
				$sql = 'select title from `' . sh . '_upclass` where id=' . $myid . ' and uid=' . $this->main->u_id;

				$r = $this->main->execute($sql);

				if ($r !== FALSE) {
					return $r['title'];
				} else {
					return '';
				}
				break;
		}
	}

// end func


	/*
	 * 生成上传路径*
	 * 输入 $ftype=文件类型*
	 * 输出字符串路径, 输出前进行检测, 不存在则创建路径*
	 */

	function getuploadpath($ftype) {
		/* 总上传路径 */
		$s = '/_upload/';

		switch ($ftype) {
			case 1:
				$s .= 'images/';
				break;
			case 2:
				$s .= 'flash/';
				break;
			case 3:
				$s .= 'files/';
				break;
			default :
				showerr('文件类型错误!');
				break;
		}

		$s .= date('Ym') . '/';

		$psyfile = sysdir . $s;

		/* if 路径不存在,则新建文件夹 */
		if (!file_exists($psyfile)) {
			mkdir($psyfile, 0777);
		}

		/* if 预览路径不存在,则新建预览文件夹路径 */
		if (!file_exists($psyfile . 'thumb/')) {
			mkdir($psyfile . 'thumb/', 0777);
		}


		return $s;
	}

// end func

	function DoDel() {
		$id = $this->main->rqid('id');

		$sql = 'update `' . sh . '_uplist` set isdel=1 where 1';
		$sql .= ' and id=' . $id;
		$sql .= ' and isdel=0 ';
		$sql .= ' and uid=' . $this->main->u_id;

		$this->main->execute($sql);

		htmlok();
	}

// end func

	function FormTitle() {

		$id = $this->main->rqid('id');

		$sql = 'select * from `' . sh . '_uplist` where uid=' . $this->main->user['id'];
		$sql .= " and id=" . $id;

		$h = $this->main->htm('formtitle');

		$h = str_replace('{$action}', '?act=savetitle&amp;id=' . $id, $h);

		$h = $this->main->repm($sql, $h);

		echo ( $h );
	}

// end func

	function SaveTitle() {
		$id = $this->main->rqid('id');

		$p['title'] = $this->main->request('名称', 'title', 'post', 'char', 1, 50, 'encode');

		ajaxerr();

		$where = ' uid=' . $this->main->user['id'];
		$where .= ' and id=' . $id;

		$this->main->pdo->update(sh . '_uplist', $p, $where);

		$js = '<script type="text/javascript">' . PHP_EOL;
		$js .= '<!--' . PHP_EOL;
		$js .= '$("#title_' . $id . '").html("' . $p['title'] . '");' . PHP_EOL;
		$js .= '//-->' . PHP_EOL;
		$js .= '</script>' . PHP_EOL;

		echo $js;

		jsucclose();
	}

	
	function head()
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . PHP_EOL;
		echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">' . PHP_EOL;
		echo '<head>' . PHP_EOL;
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . PHP_EOL;
		echo '<meta http-equiv="Content-Language" content="zh-CN" />' . PHP_EOL;
		echo '<title>上传</title>' . PHP_EOL;

		//'<syl>head要在各处用,所以要加上webdir<by syl>
		echo '<link rel="stylesheet" type="text/css" href="' . admindir . 'css/main.css?t=' . t . '" />' . PHP_EOL;
		echo '<script src="'.webdir.'_js/base.js?' . t . '" type="text/javascript"></script>' . PHP_EOL; //核心js库
		echo '<script src="'.webdir.'_js/main.js?' . t . '" type="text/javascript"></script>' . PHP_EOL; //核心js库


		echo '<script type="text/javascript" src="'.webdir.'_js/ui/jquery.ui.core.js"></script>' . PHP_EOL;
		echo '<script type="text/javascript" src="'.webdir.'_js/ui/jquery.ui.widget.js"></script>' . PHP_EOL;
		echo '<script type="text/javascript" src="'.webdir.'_js/ui/jquery.ui.datepicker.js"></script>' . PHP_EOL;
		//echo '<script src="/_js/ui/i18n/jquery.ui.datepicker-zh-CN.js" type="text/javascript"></script>' . PHP_EOL;


		//echo '<link type="text/css" href="/_js/ui/css/jquery.ui.all.css" rel="stylesheet" />' . PHP_EOL;


		echo $this->html->topplus;

		/* 限制IE使用非兼容模式 */
		echo '<meta http-equiv="X-UA-Compatible" content="IE=8" />' . PHP_EOL;

		echo '</head>' . PHP_EOL;
		echo '<body>' . PHP_EOL;
		echo '<div class="main">' . PHP_EOL;
	} // end func

}

$Myclass = new Myclass();
unset($Myclass);