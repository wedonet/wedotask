<?php
require('../global.php');




define('sp', 'service/_reg');

$html->crumb('<li>用户注册</li>');

$act = $main->ract();

switch ($act) {
	case ''					: myform(); break;
	case 'save'				: savereg(); break; //保存注册信息
}
san();

/*===========================================================*/
function myform(){
	$h = $GLOBALS['main']->style(sp, 'main');

	//get para
	//$utype = $GLOBALS['main']->request('用户类型', 'utype', 'get', 'char', 1, 10, 'invalid');

	//if ( empty($utype) ) {
	$utype = 'person';
	//}

	$h = str_replace( '{$utype}', $utype, $h );

	$h = str_replace( '{$agreement}', $GLOBALS['main']->style(sp, 'agreement'), $h );
	$h = str_replace( '{$action}', '?act=save', $h );

	$h = $GLOBALS['html']->dohtml($h);

	echo $h;
} // end func

function savereg(){
	$we =& $GLOBALS['main'];

	if ( !$we->codeistrue() ) {
	    ajaxerr(2004, 'codestr');
	}
	
	//如果已经登录了,踢自已下线
	

	$rs['u_gic'] = 300; //默认为普通会员

	$rs['u_mobile']		= $we->request('手机', 'u_mobile', 'post', 'mobile', 6, 20 );
	$rs['u_mail']		= $we->request('邮箱', 'u_mail', 'post', 'mail', 6, 50 );
	$rs['u_pass']		= $we->request('密码', 'u_pass', 'post', 'char', 5, 20 );

	$u_pass2 = $we->request('确认密码', 'u_pass2', 'post', 'char', 5, 20 );

	ajaxerr();


	/*检测两次输入密码是否一致*/
	if ($rs['u_pass'] !== $u_pass2) {
	    ajaxerr('两次输入密码不同, 请重新输入', 'u_pass');
	}

	$rs['randcode']		= $we->generate_randchar(8);


	/*对密码进行加密*/
	$rs['u_pass'] = md5( $rs['u_pass'].$rs['randcode'] );


	/*检测手机是否存在*/
	if ( hasmobile($rs['u_mobile']) ) {
		ajaxerr('<li>您填写的手机号已经存在, 请重新填写</li>', 'u_mobile');
	}

	/*检测邮箱是否存在*/
	if ( hasmail($rs['u_mail']) ) {
		ajaxerr('<li>您填写的邮箱已经存在, 请重新填写</li>', 'u_mail');
	}

	$rs['u_nick'] = substr( $rs['u_mobile'], 0 , 7).$we->generate_randchar(4); 

	$rs['u_gname'] = $we->getarrvalue('group', $rs['u_gic'], 'title');

	if ( $rs['u_gname'] === FALSE ) {
		showerr(1022);
	}

	//其它值
	$rs['u_face'] = '/_images/noface.png';

	//if 需要审核
	if ( 1 === CheckUser ){
		$rs['ispass'] = 0;
	}
	else{
		$rs['ispass'] = 1;
	}

	$rs['u_regtime']	= time();
	$rs['u_endtime']	= time()+86400*3650;

	$rs['u_err'] = 0;
	$rs['u_searchpasserr'] = 0;
	$rs['u_searchpasserrtime'] = time();

	
	$rs['islock'] = 0;
	$rs['stime'] = time();

	/*存进数据库*/
	$id = $we->pdo->insert(sh.'_user', $rs);

	/*更新这个用户组的会员数加一*/
	$sql = 'update `' .sh. '_group` set countuser=countuser+1 where ic='.$rs['u_gic'];
	$we->execute($sql);

	/*发送邮件确认信*/
	$subject = $GLOBALS['main']->style(sp, 'mailtitle');
	$mailbody = $GLOBALS['main']->style(sp, 'mailbody');
	$mail = new Cls_Mail();

	//$mail->smtp_mail($rs['u_mail'], $subject, $mailbody);

	$mail = null;

	/*清除验证码*/
	unset ($_SESSION['codestr']);

	/*自动登录*/


	/*成功提示*/
	autolocate ( webdir ); //2秒后自动关闭

	$sucmsg = '<li class="h1"><a href="' .webdir. '">注册成功, 三秒后自动返回首页</a></li>'.PHP_EOL;

	$sucmsg .= '<li><a href="/">现在就去预定房间!</a></li>'.PHP_EOL;

	ajaxinfo ( $sucmsg );
} // end func


function hasmobile( $v ){
	$sql = 'select count(*) from `'.sh.'_user` where u_mobile=:u_mobile';

	$para['u_mobile'] = $v;

	if ( $GLOBALS['main']->execount( $sql, $para )>0 ) {
		return TRUE;
	} 
	else {
		return FALSE;
	}
} // end func

function hasmail( $v ){
	$sql = 'select count(*) from `'.sh.'_user` where u_mail=:u_mail';

	$para['u_mail'] = $v;

	if ( $GLOBALS['main']->execount( $sql, $para )>0 ) {
		return TRUE;
	} 
	else {
		return FALSE;
	}
} // end func


