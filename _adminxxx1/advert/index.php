<?php
require('../../global.php');

define('sp', 'admin/_admin_advert');

crumb('广告');

$act = $we->ract();

switch ($act) {
	case ''					: Main(); break;
	case 'creat'			: MyForm(false); break;
	case 'nsave'			: SaveForm(false); break;

	case 'edit'				: MyForm(true); break;
	case 'esave'			: SaveForm(true); break;
	case 'del'				: DoDel(); break;
}
san();

/*===========================================================*/
function Main(){
	$we =& $GLOBALS['we'];
	$h = $GLOBALS['main']->style(sp, 'main');
	$tli = $GLOBALS['main']->style(sp, "li");

	$GLOBALS['html']->mytitle='广告管理';

	$sql = 'select * from `' .sh. '_advert`  order by cls asc,id asc';

	$li = $we->repm($sql, $tli);

	$h = str_replace('{$li}', $li, $h);

	$GLOBALS['html']->adhead();
	$GLOBALS['html']->crumbad();
	echo $h;
	$GLOBALS['html']->adfoot();	
} // end func

function MyForm($isedit){
	$h = $GLOBALS['main']->style(sp, 'form');

	crumb('内容');

	if ($isedit) {
	    $id = $GLOBALS['main']->rqid('id');

		$sql = 'select * from `' .sh. '_group` where id=:id';
		$para[':id'] = $id;

		$h = str_replace('{$th}', '编辑用户组', $h);
		$h = str_replace('{$action}', '?act=esave&amp;id='.$id, $h);
		$h = $GLOBALS['main']->repm($sql, $h, $para);
	}
	else {
		$h = str_replace('{$action}', '?act=nsave', $h);
		$h = str_replace('{$cls}', '100', $h);

		$h = $GLOBALS['main']->removemdbfield($h, sh.'_advert');
	}

	$GLOBALS['html']->dohtmlad($h);
}


function SaveForm( $isedit ){

	$rs['title'] = $GLOBALS['main']->request('名称', 'title', 'post', 'char', 2, 50, 'encode');
	$rs['readme'] = $GLOBALS['main']->request('说明', 'readme', 'post', 'char', 2, 255, 'encode', FALSE);
	$rs['strcode'] = $GLOBALS['main']->request('代码', 'strcode', 'post', 'char', 2, 500, '', FALSE);

	$rs['url'] = $GLOBALS['main']->request('地址', 'url', 'post', 'char', 2, 200, 'encode', FALSE);
	$rs['img1'] = $GLOBALS['main']->request('图片1', 'img1', 'post', 'char', 2, 200, 'encode', FALSE);
	$rs['img2'] = $GLOBALS['main']->request('图片2', 'img2', 'post', 'char', 2, 200, 'encode', FALSE);
	$rs['flash'] = $GLOBALS['main']->request('Flash', 'flash', 'post', 'char', 2, 200, 'encode', FALSE);

	$rs['cls'] = $GLOBALS['main']->rqid('cls', 100);
	$rs['time1'] = $GLOBALS['main']->request('开始时间', 'time1', 'post', 'date', 2, 20);
	$rs['time2'] = $GLOBALS['main']->request('结止时间', 'time2', 'post', 'date', 2, 20);

	$rs['isuse'] = $GLOBALS['main']->rqid('isuse', 1);

	$rs['other'] = $GLOBALS['main']->request('备注', 'other', 'post', 'char', 1, 500, 'encode', FALSE);

	ajaxerr('');

	if ( $isedit ) {
	
	}
	else {
		
	}
	
	jsucok();

//	$img1 = wwwwwwwwwwwwwwwwwwwww
//	$img2 = wwwwwwwwwww
//	$flash = wwwwwwwwwwwwwwwwwwww
//	$cls = 100
//	$time1 = 111
//	$time2 = 1111
//	$isuse = 1
//	$other = 1111111111
	
} // end func