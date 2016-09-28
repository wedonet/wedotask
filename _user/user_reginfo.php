<?php
/**
 * 商家注册资料.
 * 
 * @author  YiLinSun 
 * @version 1.0
 * @package main
 */
require_once('../global.php');
require_once('main.php');
require_once('../_inc/cls_login.php');

/*检测权限*/
$we->chkuserpanel( 'member' );

/*定义模板位置*/
define('sp', 'user/_user_reginfo');

$html->cssinfo = $we->style(sp, 'css');

/*设置title*/
$html->mytitle = '注册资料';

crumb('注册资料');

$act = $we->ract();
switch ($act) {
	case ''			: Main(); break;
	case 'save'		: SaveForm(); break;
}


san();


function Main(){
	$h = $GLOBALS['we']->style(sp, 'main');

	$sql = 'select * from `'.sh.'_user` where id='.$GLOBALS['main']->u_id.' limit 1 ';

	$h = str_replace('{$action}', '?act=save', $h);
	$h = str_replace('{$u_pass}', '', $h);
	$h = str_replace('{$u_pass2}', '', $h);

	$h = $GLOBALS['main']->repm( $sql, $h );

	$h = wrapmain($h); //包上一层并输出
} // end func


function SaveForm(){
	$we = $GLOBALS['main'];
	$rs['u_name']		= $we->request('用户名', 'u_name', 'post', 'char', 5, 20, 'invalid');
	$rs['u_nick']		= $we->request('称呼', 'u_nick', 'post', 'char', 5, 20, 'invalid', FALSE);
	$rs['u_phone']		= $we->request('电话', 'u_phone', 'post', 'phone', 6, 20, '', false);
	$rs['u_mobile']	= $we->request('手机', 'u_mobile', 'post', 'mobile', 6, 20);
	$rs['u_mail']		= $we->request('邮箱', 'u_mail', 'post', 'mail', 6, 50, '', false);
	$rs['u_pass']		= $we->request('密码', 'u_pass', 'post', 'char', 5, 20, '', FALSE);

	$u_pass2 = $we->request('确认密码', 'u_pass2', 'post', 'char', 5, 20, '', FALSE);

	ajaxerr();

	/*检测两次输入密码是否一致*/
	if ($rs['u_pass'] !== $u_pass2) {
		ajaxerr('两次输入密码不同, 请重新输入', 'u_pass');
	}

	/*对密码进行加密*/
	$rs['u_pass'] = md5( $rs['u_pass'].$rs['randcode'] );

	/*检测用户名是否存在*/
	if ( hasname($rs['u_name']) ) {
		ajaxerr('<li>您填写的用户名已经存在, 请重新填写</li>', 'u_name');
	}

	/*检测手机是否存在*/
	if ( hasmobile($rs['u_mobile']) ) {
		ajaxerr('<li>您填写的手机号已经存在, 请重新填写</li>', 'u_mobile');
	}

	/*检测邮箱是否存在*/
	if ( hasmail($rs['u_mail']) ) {
		ajaxerr('<li>您填写的邮箱已经存在, 请重新填写</li>', 'u_mail');
	}

	if ($rs['u_nick']=='') {
		$rs['u_nick'] = substr( $rs['u_mobile'], 0 , 7); 
	}

	//其它值
	$rs['u_face'] = '/_images/noface.png';


	//if 需要审核
	$rs['ispass'] = 1;


	$rs['u_regtime']	= time();
	$rs['u_endtime']	= time()+86400*3650; //默认有效期10年

	$rs['u_err'] = 0;
	$rs['u_searchpasserr'] = 0;
	$rs['u_searchpasserrtime'] = time();

	
	$rs['islock'] = 0;
	$rs['u_stime'] = time();

	$rs['fromuid'] = $we->u_id;
	$rs['fromunick'] = $we->u_nick;



	$we->pdo->begintrans();

	try{
		/*存进数据库*/
		$id = $we->pdo->insert( sh.'_user', $rs );

		/*更新这个用户组的会员数加一*/
		$sql = 'update `' .sh. '_group` set countuser= (select count(*) from '.sh.'user where u_gid='.$rs['u_gid'].') where id='.$rs['u_gid'];
		$we->execute($sql);

		$we->pdo->submittrans();
	}
	catch ( PDOEXception $e ) {
		$we->pdo->rollbacktrans();
	}




	/*自动登录*/


	/*成功提示*/
	autolocate ( "" ); //2秒后自动关闭

	$sucmsg = '<li class="h1"><a href="?">添加成功, 三秒后自动返回列表页</a></li>'.PHP_EOL;

	ajaxinfo ( $sucmsg );	
} // end func




