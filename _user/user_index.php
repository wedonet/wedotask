<?php
/**
 * 控制面板.
 * 
 * @author  YiLinSun 
 * @version 1.0
 * @package main
 */
require_once('../global.php');

switch ( $we->user['u_gic'] ){
	//商家
	case 200:
		
		break;
	
	//会员
	case 300:
		break;
	
	//其它不让跳转
}

san();