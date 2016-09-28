<?php
/**
 * 控制面板公用函数.
 *
 * @author  YiLin Sun
 * @version 1.0
 */

crumb('控制面板');

function wrapmain( $str, $print=TRUE ){

	if ( $GLOBALS['we']->u_gic == 200 ) {
		$s = $GLOBALS['we']->style('user/biz/_main', 'main');
	}
	else if ( $GLOBALS['main']->u_gic == 300 ) {
		$s = $GLOBALS['main']->style('user/member/_main', 'main');
	}
	else {
		$s = $GLOBALS['main']->style('user/_main', 'main');
	}


	//控制面板的样式
	$GLOBALS['html']->cssinfo = $GLOBALS['main']->style('user/_main', 'css') . $GLOBALS['html']->cssinfo;

	$s = str_replace('{$main}', $str, $s);

	
	if ( $print ) {
		$s = dohtml($s); //替换标签
		return $s;
	}
	else {
		return $s;
	}

} // end func




function dohtml($s){

	$s = str_replace('{$head}', gethead(), $s);

	$s = str_replace('{$bottom}', getbottom(), $s);

	$s = str_replace('{$foot}', getfoot(), $s);

	$s = $GLOBALS['html']->replaceallflag($s);
	
	echo $s;
	
} // end func


function gethead(){

	$headplus = $GLOBALS['main']->style(sp, 'css');
	
	$s = $GLOBALS['main']->style('user/_main', 'head');

	$s = str_replace('{$headplus}', $headplus, $s);

	$s = str_replace('{$title}', $GLOBALS['html']->mytitle, $s);

	$s = str_replace('{$timestamp}', timestamp, $s);

	return $s;
} // end func


function getbottom(){
	return $GLOBALS['main']->style('user/_main', 'bottom');  
} // end func

function getfoot(){
	return $GLOBALS['main']->style('user/_main', 'foot');  
} // end func