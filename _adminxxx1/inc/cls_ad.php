<?php



class Cls_ad {
	public $topplus='';

	function __construct() {
		$this->main =& $GLOBALS['main'];
		$this->html =& $GLOBALS['html'];

		/*====检测权限*/
		/*----后台登录页不检测*/
		$notcheckpage = 'admin_login.php';
		if ( false !== stripos( $notcheckpage, $this->main->scriptname )) {
			$this->main->chkadmin();
		}		
	}

	function addcss($filename) {
		$this->topplus .= '<link rel="stylesheet" type="text/css" href="' . $filename . '" />' . PHP_EOL;
	}

	function addjs($filename) {
		$this->topplus .= '<script type="text/javascript" src="' . $filename . '"></script>' . PHP_EOL;
	}



	/* 增加文件载入后的执行函数 */
	
	function PlusFun($str) {
	  $s = '<script type="text/javascript">' . PHP_EOL;
	  $s .= '<!--' . PHP_EOL;
	  $s .= '$(function(){' . $str . '})' . PHP_EOL;
	  $s .= '//-->' . PHP_EOL;
	  $s .= '</script>' . PHP_EOL;
	  $this->topplus .= $s;
	}
	 

	function head() {
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . PHP_EOL;
		echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">' . PHP_EOL;
		echo '<head>' . PHP_EOL;
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . PHP_EOL;
		echo '<meta http-equiv="Content-Language" content="zh-CN" />' . PHP_EOL;
		echo '<title>' . $GLOBALS['html']->title . '</title>' . PHP_EOL;

		//'<syl>head要在各处用,所以要加上webdir<by syl>
		echo '<link rel="stylesheet" type="text/css" href="' . admindir . 'css/main.css?t=' . t . '" />' . PHP_EOL;
		echo '<script src="/_js/base.js?' . t . '" type="text/javascript"></script>' . PHP_EOL; //核心js库
		echo '<script src="/_js/main.js?' . t . '" type="text/javascript"></script>' . PHP_EOL; //核心js库

		echo '<script src="' . admindir . 'js/main.js?' . t . '" type="text/javascript"></script>' . PHP_EOL; //管理中心js库

		echo '<script type="text/javascript" src="/_js/ui/jquery.ui.core.js"></script>' . PHP_EOL;
		echo '<script type="text/javascript" src="/_js/ui/jquery.ui.widget.js"></script>' . PHP_EOL;
		echo '<script type="text/javascript" src="/_js/ui/jquery.ui.datepicker.js"></script>' . PHP_EOL;
		echo '<script src="/_js/ui/i18n/jquery.ui.datepicker-zh-CN.js" type="text/javascript"></script>' . PHP_EOL;


		echo '<link type="text/css" href="/_js/ui/css/jquery.ui.all.css" rel="stylesheet" />' . PHP_EOL;


		echo $this->topplus;

		/* 限制IE使用非兼容模式 */
		echo '<meta http-equiv="X-UA-Compatible" content="IE=8" />' . PHP_EOL;

		echo '</head>' . PHP_EOL;
		echo '<body>' . PHP_EOL;
		echo '<div class="main">' . PHP_EOL;
		//<syl>框架上部不能有body,否则无法显示<by syl>
		//<syl>防重复提交<by syl>
		//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//	$GOLBAL['wedonet']->ChkRePost();
		//}
	}

	function foot() {
		echo '<div class="foot">' . PHP_EOL;
		echo '<span class="wedonet">Powered by <a href="http://www.wedonet.com" title="">www.wedonet.com</a></span>	查询数据库 ' . $this->main->sqlquerynum . '次 Run Time：' . round((microtime(true) - pagestarttime), 4) . ' 秒.' . PHP_EOL;
		echo '</div>' . PHP_EOL;
		echo '</div><p></p></body></html>' . PHP_EOL;
	}

	function dohtml($s) {
		$this->head();
		$this->crumb();

		//$s = $this->replaceallflag($s);    
		if (stripos($s, '{$admindir}') != false)
			$s = str_replace('{$admindir}', admindir, $s);

		echo $s;


		$this->foot();
	}
	
	
	function crumb($str = null) {
		if ($str === null) {
			$str = $this->html->crumb;
		}
		echo '<div class="crumb">' . PHP_EOL;
		echo '	您现在的位置:' . PHP_EOL;
		echo '		<ul>' . PHP_EOL;
		echo $str;
		echo '		</ul>' . PHP_EOL;
		echo '	<div class="fright prepage">' . PHP_EOL;
		echo '		<a href="javascript:history.go(-1);">&lt;&lt; 返回上一页</a>' . PHP_EOL;
		echo '	</div>' . PHP_EOL;
		echo '	<div class="clear"></div>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}




	function getdebuginfo() {
		return '<span class="runtime">&nbsp;&nbsp;Run Time:' . round((microtime(true) - pagestarttime), 4) . ' 秒</span>,	<span>查询:' . $GLOBALS['main']->sqlquerynum . '次</span>';
	}

}