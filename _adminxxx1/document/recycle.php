<?php

require('../../global.php');
require(sysdirad . 'inc/cls_ad.php');
require('main.php');

define('sp', 'admin/document/_recycle');

class Myclass extends Cls_ad {

	function __construct() {
		parent::__construct();

		$this->c_document = new Cls_document();
		$this->a_channel = & $this->c_document->a_channel;

		$act = $this->main->ract();

		switch ($act) {
			case '' : $this->HtmlMain(false);
				break;
			case 'restore' : $this->DoRestore();
				break;
			case 'remove' : $this->DoRemove();
				break;
		}
		san();
	}

	function HtmlMain() {
		$h = $this->main->htm('main');
		$tli = $this->main->htm('li');

		crumb('管理' . $this->a_channel['cha_unit']);

		$sql = 'select * from `' . sh . '_document` where 1 ';
		$sql .= ' and cid=' . $this->a_channel['id'];
		$sql .= ' and isdel=1 ';
		$sql .='order by cls asc, id desc';

		$li = $this->main->repm($sql, $tli, null, 0, true);

		$h = str_replace('{$li}', $li, $h);
		$h = str_replace('{$pagelist}', $this->main->pagelist(), $h);

		$this->dohtml($h);
	}

// end func

	function DoRestore() {
		$id = $this->main->rqid('id');

		$sql = 'update `' . sh . '_document` set isdel=0 where 1';
		$sql .= ' and id=' . $id;

		$this->main->execute($sql);

		htmlok();
	}

// end func

	function DoRemove() {
		$id = $this->main->rqid('id');

		$sql = 'delete from `' . sh . '_document` where 1';
		$sql .= ' and id=' . $id;

		$this->main->execute($sql);

		htmlok();
	}

// end func
}

$Myclass = new Myclass();
unset($Myclass);
