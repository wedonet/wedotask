<?php
/**
 * 操作后的提示信息.
 * 
 * @author  YilinSun 
 * @version 1.0
 */

/*错误提示*/
function showerr($str=null){
	/*没填错误信息时, 从全局errmsg检测一下*/
	if (null === $str) {
		if ('' != $GLOBALS['main']->errmsg) {
			$str = $GLOBALS['main']->errmsg;
		}
	}
	else {
		if (is_numeric($str)) {
		    $str = getfaultname($str);
		}	
	}	
	
	if (strlen($str.'')>0) {
		echo $str;
		die;
	}	
} 

function ajaxerr($str=null, $back=null){
	if (null === $str) {
		//if 没输入错误信息, then 从类里找
		if ('' != $GLOBALS['main']->errmsg) {
			$str = $GLOBALS['main']->errmsg;
		}
	}

	if (null ===$back) {
		if ('' != $GLOBALS['main']->back) {
			$back = $GLOBALS['main']->back;
		}	    
	}

	//有错误信息
	if (null !== $str) {
		if ($back !== null) {
			echo '<script type="text/javascript">'.PHP_EOL;
			echo '<!--'.PHP_EOL;
		    
			$a = explode(',', $back);

			for ($i=0; $i<count($a); $i++) {
				if ($a[$i] != '') {
					echo '$("input[name='.$a[$i].']").addClass("fault");';       
				}
			}
				
			echo '//-->'.PHP_EOL;
			echo '</script>'.PHP_EOL;
		}
		if (is_numeric($str)) {
		    $str = getfaultname($str);
		}

		ajaxinfo ($str, 'err');
	}
} // end func


/**
 * @自动关闭弹出窗口
 */
function autoclose($x=2000){
	//$x = 多少毫秒后关闭
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'setTimeout("autoclose()", "'.$x.'");'.PHP_EOL;
	echo '</script>'.PHP_EOL;   
} // end func


//普通提交后返回
function htmlok(){
	header('Location:' . $_SERVER['HTTP_REFERER']);
	die;
} // end func

function jok(){
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'setTimeout("window.location.reload()", "400");'.PHP_EOL;
	echo '</script>'.PHP_EOL;
	//die;
} // end func


/*jquery success Ajax 操作成功后返回*/
function jsucok(){
	jok();
	ajaxinfo ('<li>执行成功, 一秒后自动刷新</li>');
}





/**
 * 执行成功后自动关闭弹出窗口
*/
function jsucclose( $mess=null ){
	autoclose(1000); 
	ajaxinfo ('<li>执行成功, 弹出窗口将在二秒后自动关闭</li>'.PHP_EOL.$mess );
	die();
}

/**/
function ajaxinfo( $str, $mode='suc' ){
	$infoimg = ''; //控制显示什么背景

	if (strpos($str, '<li>') === false) {
	    $str = '<li>' .$str. '</li>';
	}
	echo '<div style="width:400px;" class="ajaxinfo">' .PHP_EOL;

	if ('suc' == $mode) {
	    echo '<div class="th">执行成功!</div>'.PHP_EOL;
		$infoimg = webdir . '_images/check_right.gif';
	}
	else {
	    echo '<div class="th">执行失败!</div>'.PHP_EOL;
		$infoimg = webdir . '_images/check_error.gif';
	}
	
	echo '<ul style="background:url(' .$infoimg. ') no-repeat 5px 5px;">'.PHP_EOL;
	echo $str.PHP_EOL;;
	echo '</ul>'.PHP_EOL;
	echo '</div>'.PHP_EOL;

	//失败时就不再进行下去了
	if ('suc' != $mode) {
		die;
	}
}

/*loading 是否显示 loading 图片*/
function autolocate($url=null, $timeafter=2000, $loading=null ){
	if ( $url === null ) {
		$url = $GLOBALS['main']->scriptname;
	}
	
	if ( null !== $loading ){
		echo ('<div class="pxsmall center" style="padding:50px;"><img src="/_images/loading.gif" alt="" /></div>');		
	}

	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'ttt = setTimeout("autolocate('.Chr(39).$url.Chr(39).')", '. $timeafter .');'.PHP_EOL;
	echo '</script>'.PHP_EOL;
} // end func

function log_message($level = 'error', $message, $php_error = FALSE){
	//static $_log;

	//if (config_item('log_threshold') == 0)
	//{
	//	return;
	//}

	//$_log =& load_class('Log');
	//$_log->write_log($level, $message, $php_error);
}







