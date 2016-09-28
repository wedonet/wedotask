<?php

require('../global.php');
require(sysdir . '_inc/cls_login.php');


define('sp', 'service/_login');


class Myclass extends Cls_html
{   

    function __construct(){
		parent::__construct();

		crumb('<li>登录</li>');

		$act = $this->main->ract();

		switch ($act) {
			case '' : $this->myform();
				break;
			case 'chklogin' :
				loadclass('Cls_login', 'Cls_login');
				$GLOBALS['Cls_login']->chklogin();
				break; //检测用户登录
			case 'loginout' : $this->DoLoginOut();
				break;

			case 'ajaxlogin' : FormAjaxLogin();
				break; //ajax登录

			case 'chkloginajax' : chkloginajax();
				break; //ajax登录确认
		}
		san();
	}


	function myform() {
	
		$h = $this->main->htm('main');

		$h = str_replace('{$action}', '?act=chklogin', $h);

		/* 检测来源,来源于本站时加入session */
		if ( TRUE == $this->main->chkpost() ) {
			//只取100个字符, 多了截掉
			$comeurl = substr($_SERVER['HTTP_REFERER'], 0, 100);

			//存入session,以便返回来时的网址
			$_SESSION['comeurl'] = $comeurl;
		}

		$GLOBALS['html']->title = '登录';

		echo $GLOBALS['html']->dohtml($h);
	}


	function DoLoginOut() {
		//取消在线状态

		if ('' != $this->main->user['id']) {
			$sql = "update `" . sh . "_user` set u_online=0 where u_online=1 and id=" 
					  . $this->main->user['id'];

			$this->main->execute($sql);

			loadclass('c_login', 'Cls_login');
			$GLOBALS['c_login']->loginout();
		}


		autolocate("/", 1000);

		ajaxinfo('退出成功,系统将自动返回首页');
	}
} // end class


$Myclass = new Myclass();
unset($Myclass);