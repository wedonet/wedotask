<?php

/**
 * 文章模块分类管理
 *
 * @YilinSun
 * @version 1.0
 */
require('../../global.php');
require( sysdirad . 'inc/Cls_ad.php');
require( sysdir . '_inc/cls_class.php');

class Myclass extends Cls_ad {

	function __construct() {
		parent::__construct();

		define('sp', 'admin/_admin_class');

		loadclass('c_class', 'Cls_class');
		$this->c_class = & $GLOBALS['c_class'];

		$this->c_class->cid = $this->main->rqid('cid');
		$this->c_class->module = $this->main->request('', 'module', 'get', 'char', 1, 20, 'encode', false);

		showerr();

		if ($this->c_class->cid < 0) {
			showerr(1018);
		}

		//提取频道
		$this->a_channel = $this->main->getarr('channel', $this->c_class->cid);
		if (false == $this->a_channel) {
			showerr('没提取到这个频道:' . $this->cid);
		}

		crumb($this->a_channel['title']);
		crumb('分类管理');

		$act = $this->main->ract();

		switch ($act) {
			case '':
				$this->main();
				break;
			case 'creat':
				$this->Myform(false);
				break;
			case 'edit':
				$this->Myform(true);
				break;
			case 'nsave':
				$this->Saveform(false);
				break;
			case 'esave':
				$this->Saveform(true);
				break;
			case 'savecls':
				$this->Savecls();
				break;
			case 'mycontent':
				$this->mycontent();
				break;
			case 'savecontent':
				$this->savecontent();
			default :
				showerr('act错误');
				break;
		}

		san();
	}

	function main() {
		$h = $this->main->htm("main");
		$tli = $this->main->htm("li");

		$sql = 'select * from `' . sh . '_class` where 1 ';

		$sql .= ' and cid=' . $this->c_class->cid;
		$sql .= ' and module ="' . $this->c_class->module . '" ';
		$sql .= ' order by treeid asc';

		$li = $GLOBALS['main']->repm($sql, $tli);

		$h = str_replace('{$cid}', $this->c_class->cid, $h);
		$h = str_replace('{$li}', $li, $h);

		$this->dohtml($h);
	}

	function Myform($isedit) {
		$h = $this->main->htm("form");

		$id = $GLOBALS['main']->rqid('id');

		$h = str_replace('{$optionclass}', $this->c_class->GetOptionClass(), $h);
		$h = str_replace('{$selimg}', $this->html->selimg('preimg'), $h);

		if ($isedit) {
			crumb('编辑分类');

			$sql = 'select * from `' . sh . '_class` where id=' . $id;
			$h = str_replace('{$action}', '?act=esave&amp;cid=' . $this->c_class->cid . '&amp;id=' . $id, $h);
			$h = str_replace('{$th}', '编辑分类', $h);

			$h = $GLOBALS['main']->repm($sql, $h);
		} else {
			crumb('添加分类');

			$h = str_replace('{$action}', '?act=nsave&amp;cid=' . $this->c_class->cid, $h);
			$h = str_replace('{$cls}', '100', $h);
			$h = str_replace('{$mypercent}', '100', $h);
			$h = str_replace('{$isgood}', '0', $h);

			$h = $GLOBALS['main']->removemdbfield($h, sh . '_class');
		}

		$this->dohtml($h);
	}

	function Saveform($isedit) {

		$this->c_class->Saveform($isedit);

		$sucmsg = '<li>保存成功,窗口将在二秒后自动返回分类管理!</li>' . PHP_EOL;
		$sucmsg .= '<li><a href="?cid=' . $this->c_class->cid . '">返回分类管理</a></li>' . PHP_EOL;

		ajaxinfo($sucmsg);
	}

	/* 保存排序 */

	function Savecls() {
		$this->c_class->Savecls();

		jsucok();
	}

// end func

	/**
	 * 删除这个栏目和当前分类相关的内容.
	 */
	function moduledelclass($cid, $idpath) {
		/* 此分类下的文章分类归0 */
		$sql = 'update `' . sh . '_document` set classid=0 where 1=1 ';
		$sql .= ' and cid=' . $cid;
		$sql .= ' and classid in (select id from `' . sh . 'class` where idpath like "' . $idpath . '%")';

		$GLOBALS['we']->execute($sql);
	}

	/* 编辑分类内容 */

	function mycontent() {
		$h = $this->main->htm('content');

		crumb('描述');

		$cid = $this->c_class->cid;
		$id = $this->main->rqid('id');

		$h = str_replace('{$action}', '?act=savecontent&amp;cid=' . $cid . '&amp;id=' . $id, $h);

		$sql = 'select * from `' . sh . '_class` where cid=' . $cid . ' and id=' . $id;

		$h = $this->main->repm($sql, $h);

		$this->addjs(webdir . 'ckeditor/ckeditor.js');

		$this->dohtml($h);
	}

	/* 保存分类内容 */

	function savecontent() {
		$cid = $this->c_class->cid;
		$id = $this->main->rqid("id");

		$mycontent = $this->main->request('描述', 'mycontent', 'post', 'char', 1, 99999, '', FALSE);

		ajaxerr();

		
		$rs['mycontent'] = $mycontent;

		/* 更新 */
		$this->main->pdo->update(sh . '_class', $rs, ' cid=' . $cid . ' and id= ' . $id);

		/* 成功提示并自动关闭 */
		jsucclose();
	}

// end func
}

// end class
//$c->cid = $GLOBALS['we']->rqid('cid');
//$c->cic = $GLOBALS['we']->ract('cic');
//$c->main();
//unset($c);


$Myclass = new Myclass();
unset($Myclass);






