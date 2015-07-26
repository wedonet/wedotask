<?php
/**
 * 管理员登录.
 *
 * @author  syl
 * @version 1.0
 */

require('../global.php');
require( sysdirad .'inc/cls_ad.php');
require( sysdir .'_inc/cls_login.php');


$Myclass = new Myclass();
unset($Myclass);

class Myclass
{
	
	function __construct()
	{
		$this->main =& $GLOBALS['main'];
		$this->html =& $GLOBALS['html'];

		crumb('<a href="?">管理员管理</a>');

		define('sp', 'admin/_admin_login');

		$act = $this->main->ract();
		switch ( $act ) {
			case ''			: $this->HtmlMain(); Break;
			case 'login'	: $this->DoLogin(); break;
		}
		san();	
	} // end func



	function HtmlMain(){
		$h = $GLOBALS['main']->htm('main');

		$h = str_replace('{$action}', '?act=login', $h);
		$h = str_replace('{$u_name}', $GLOBALS['main']->user['u_name'], $h);
		
		title('管理员登录');

		$h = $this->html->dohtml($h);

		echo $h;
	} // end func



	function DoLogin(){
		$we =& $GLOBALS['main'];

		/*检测验证码*/
		if ( FALSE === $we->codeistrue() ) {
			ajaxerr('验证码错误!');
		}

		/*接收参数*/
		$u_pass = $we->request('密码', 'u_pass', 'post', 'char', 5, 20);

		ajaxerr();

		/*通过用户名提取管理员信息*/
		$sql = 'select * from `'.sh.'_admin` where u_name=:u_name limit 1 ';

		$para['u_name'] = $GLOBALS['main']->u_name;

		$rs = $GLOBALS['main']->exeone( $sql, $para );

		if ( FALSE == $rs ) {
			ajaxerr('管理员用户名错误');
		}

		/*检测密码是否正确*/
		if ( md5( $u_pass.$rs['randcode'] ) != $rs['u_pass'] ) {
			ajaxerr('密码错误');
		}
		else {
			//清除验证码
			

			//管理员登录成功, 转入后台首页

			/*加密后的新密码写入cookie, 交给主类去判断*/
			$mytime = time()+3600*8; //保留八小时
			setcookie( CacheName."admin", $rs['u_pass'], $mytime );

			autolocate("admin_index.php");

			$sucmsg = '<li>登录成功, 两秒后转入后台首页</li>'.PHP_EOL;
			$sucmsg .= '<li><a href="admin_index.php">点击这里进入后台首页</a></li>'.PHP_EOL;


			ajaxinfo ($sucmsg);
		}

	} // end funcDoLogin
} // end class

