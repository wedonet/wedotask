<?php

require( '../inc/cls_ad.php' ); //管理文件夹的main

class Cls_style {

	function __construct() {
		$this->c_ad = new Cls_ad;
		$this->main = & $GLOBALS['main'];
		$this->html = & $GLOBALS['html'];

		$this->rootpath = webdir . '_style/';

		title('模板');
		crumb('<a href="./">模板</a>');

		$this->c_ad->addcss(admindir . 'css/admin_style.css?' . t);
		$this->c_ad->addjs(admindir . 'js/admin_style.js');
	}

	function getupdir($dir) {
		$s = '';
		$a = explode('/', $dir);
		if (count($a) < 2) {
			return $dir;
		} else {
			$a = array_slice($a, 0, count($a) - 1);
		}

		return join($a, '/');
	}

	function getext($s) {
		$s = strtolower($s);
		$a = explode('.', $s);
		return $a[count($a) - 1];
	}

	/* 从全路径返回最后的文件名 */

	function truename($path) {
		$a = explode('/', $path);
		return $a[count($a) - 1];
	}

}