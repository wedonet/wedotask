<?php
require('../global.php');
require( sysdirad . 'inc/cls_ad.php');

crumb('文件管理');


class Myclass extends Cls_ad{
	
	function __construct()
	{
		parent::__construct();

			$act = $GLOBALS['we']->ract();

	switch ( $act ) {
		default				:HtmlMain(); break;
	
	}
	







} // end class



$Myclass = new Myclass();
unset($Myclass);