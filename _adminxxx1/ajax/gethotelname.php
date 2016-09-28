<?php
require_once('../../global.php');

$act = $we->ract();

switch ( $act ) {
	default				: HtmlMain(); break;
}


function HtmlMain(){
	$hotelidlist = $GLOBALS['we']->rqidlist('hotelidlist');

	showerr();

	if ( '' != $hotelidlist) {
		$sql = 'select id,title from `'.sh.'_hotel` where id in ('.$hotelidlist.')';

		$rs = $GLOBALS['we']->execute( $sql );



		if ( false !== $rs ) {
			foreach ($rs['rs'] as $v ) {
				$t[ $v['id'] ] = $v['title'];
			}
			echo (json_encode($t));
		}
	}
}