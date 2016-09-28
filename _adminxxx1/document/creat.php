<?php

require('../../global.php');
require(sysdirad . 'inc/cls_ad.php');
require('main.php');

define('sp', 'admin/document/_creat');

class Myclass extends Cls_ad {

	function __construct() {
		parent::__construct();

		$this->c_document = new Cls_document();
		$this->a_channel =& $this->c_document->a_channel;

		$act = $this->main->ract();

		switch ($act) {
			case '' : $this->Myform(false);
				break;
			case 'nsave' : $this->Saveform(false);
				break;
			case 'edit' : $this->Myform(true);
				break;
			case 'esave' : $this->Saveform(true);
				break;
		}
		san();
	}

	function Myform($isedit) {
		$js = '';

		$h = $this->main->htm( "myform");	

		//选择图片的链接
		$h = str_replace('{$selimg}', $this->html->selimg('preimg', 'preshow'), $h);
		$h = str_replace('{$optionclass}', $this->html->getoptionclassbychannel($this->a_channel['id']), $h);

		if ($isedit) {
			crumb('编辑动态');

			$id = $this->main->rqid('id');

			$h = str_replace('{$action}', '?act=esave&amp;cid=' . $this->a_channel['id'] . '&amp;id=' . $id, $h);

			$sql = 'select * from `' . sh . '_document` where 1';
			$sql .= ' and cid='.$this->a_channel['id'];
			$sql .= ' and id=' . $id;
			$sql .= ' and isdel=0 ';

			$h = $this->main->repm($sql, $h);
		} else {
			crumb('新建'.$this->a_channel['cha_unit']);

			$h = str_replace('{$action}', '?act=nsave&amp;cid=' . $this->a_channel['id'], $h);

			$h = str_replace('{$preimg}', '/_images/nopic.jpg', $h);

			$h = $this->main->removemdbfield($h, sh . '_document');
		}


		$h = str_replace('{$js}', $js, $h);


		$this->addjs(webdir . 'ckeditor/ckeditor.js');
		$this->dohtml($h);
	}

// end func

	function Saveform($isedit) {
		$main = & $this->main;

		$id = $main->rqid('id');

		$rs['cid'] = $this->a_channel['id'];
		$rs['cic'] = $this->a_channel['ic'];


		$rs['title'] = $main->request('标题', 'title', 'post', 'char', 1, 250, 'encode');
		$rs['classid'] = $main->rfid('classid', 0) . '';
		$rs['mytip'] = $main->request('提示', 'mytip', 'post', 'char', 1, 250, 'encode', false);
		$rs['readme'] = $main->request('描述', 'readme', 'post', 'char', 1, 250, 'encode', false);
		$rs['preimg'] = $main->request('预览图', 'preimg', 'post', 'char', 1, 250, 'encode', false);

		$rs['mytitle'] = $main->request('Title', 'mytitle', 'post', 'char', 1, 250, 'encode', false);
		$rs['mykeywords'] = $main->request('Keywords', 'mykeywords', 'post', 'char', 1, 250, 'encode', false);
		$rs['mydescription'] = $main->request('Description', 'mydescription', 'post', 'char', 1, 500, 'encode', false);

		$rs['cls'] = $main->rfid('cls', 100);
		$rs['isgood'] = $main->rfid('isgood', 0);
		$rs['hits'] = $main->rfid('hits', 0);
		$rs['isshow'] = $main->rfid('isshow', 0);
		$rs['ptime'] = $main->request('发布时间', 'ptime', 'post', 'date', 10, 20, null, false);

		$rs['mycontent'] = $main->request('描述', 'mycontent', 'post', 'char', 1, 255000);
		$rs['mycontentnojs'] = $main->security->xss_clean($rs['mycontent']);

		$rs['referenceurl'] = $main->request('参考地址', 'referenceurl', 'post', 'char', 1, 255, 'encode', FALSE);

		ajaxerr();


		//classname
		$rs['classname'] = '';
		if ('' != $rs['classid']) {

			$class = $this->main->getclass($this->a_channel['id']);


			if (is_array($class)) {
				if (array_key_exists($rs['classid'] . '', $class)) {
					$rs['classname'] = $class[$rs['classid']]['title'];
				}
			}
		}


		//ptime
		if ('' == $rs['ptime']) {
			$rs['ptime'] = time();
		} else {
			$rs['ptime'] = strtotime($rs['ptime']);
		}



		$rs['euid'] = $main->u_id;
		$rs['enick'] = $main->u_nick;
		$rs['etime'] = time();

		if ($isedit) {
			$main->pdo->update(sh . '_document', $rs, ' id=' . $id);
		} else {
			$rs['suid'] = $main->u_id;
			$rs['snick'] = $main->u_nick;
			$rs['stime'] = time();

			$rs['isdel'] = 0;

			$main->pdo->insert(sh . '_document', $rs);
		}

		$sucmsg = '<li>保存成功</li>' . PHP_EOL;
		$sucmsg .= '<li><a href="?cid=' . $this->a_channel['id'] . '">继续添加</a></li>' . PHP_EOL;
		$sucmsg .= '<li><a href="list.php?cid=' . $this->a_channel['id'] . '">返回列表</a></li>' . PHP_EOL;

		ajaxinfo($sucmsg);
		//$rs['title'] = $we->request();
	}

// end func
}

$Myclass = new Myclass();
unset($Myclass);
