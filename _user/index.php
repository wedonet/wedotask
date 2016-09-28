<?php
/**
 * 个人首页.

 */
require('../global.php');

require(sysdir.'task/cls_task.php');


class Myclass extends cls_task {

    function __construct() {
        parent::__construct();

		/*定义模板位置*/
		define('sp', 'user/_index');

        crumb('<a href="index.php">任务管理</a>');

        $this->htmlmain();

        san();
    }

	function htmlmain(){
		$h = $this->main->htm('main');

		//$h = wrapmain($h); //包上一层

		

		$this->dohtml($h);
	} // end func

}

$Myclass = new Myclass();
unset($Myclass);
