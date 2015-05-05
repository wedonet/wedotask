<?php

require('../../global.php');
require(sysdirad . 'inc/cls_ad.php');
require('main.php');

define('sp', 'admin/document/_list');

class Myclass extends Cls_ad {

	function __construct() {
		parent::__construct();

		$this->c_document = new Cls_document();
		$this->a_channel = & $this->c_document->a_channel;

		$act = $this->main->ract();

		switch ($act) {
			case '' : $this->Htmlmain(false);
				break;
			case 'del' : $this->Dodel();
				break;
		}
	}

	function Htmlmain() {
		$js = '';

		$h = $this->main->htm( 'main');
		$tli = $this->main->htm( 'li');

		crumb('管理');

		$rs['classid'] = $this->main->rqid('classid');
		
		$js .= '$("#classid").val("' . $rs['classid'] . '");' . PHP_EOL;

		$sql = 'select * from `' . sh . '_document` where 1 ';
		$sql .= ' and isdel=0 ';
		$sql .= ' and cid=' . $this->a_channel['id'];

		if ($rs['classid'] > -1) {
			$sql .= ' and classid=' . $rs['classid'];
		}
		$sql .=' order by cls asc, id desc';

		$li = $this->main->repm($sql, $tli, null, 0, true);

		$h = str_replace('{$filter}', $this->getfilter($rs), $h);
		$h = str_replace('{$js}', $js, $h);

		$h = str_replace('{$li}', $li, $h);
		$h = str_replace('{$pagelist}', $this->main->pagelist(), $h);

		$this->dohtml($h);
	}

	function Dodel() {
		$id = $this->main->rqid('id');

		$sql = 'update `' . sh . '_document` set isdel=1 where 1';
		$sql .= ' and id=' . $id;

		$this->main->execute($sql);

		htmlok();
	}

	function getfilter($rs) {


		$s = $this->main->htm('filter');
		$s = str_replace('{$cid}', $this->a_channel['id'], $s);
		$s = str_replace('{$optionclass}', $this->html->getoptionclassbychannel($this->a_channel['id']), $s);


		return $s;
	}

}

$Myclass = new Myclass();
unset($Myclass);






