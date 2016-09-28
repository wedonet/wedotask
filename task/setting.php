<?php

require '../global.php';
require sysdir . 'task/cls_task.php';




class myclass extends cls_task {

    function __construct() {
        parent::__construct();

        define('sp', 'task/_setting');

        $act = $this->main->ract();

		switch ($act) {
			case '':
				$this->htmlmain();
				break;
			default;
				break;
		
		}
	}

	
	function htmlmain()
	{
		$h = $this->main->htm('main');

		crumb('<a href="setting.php">Setting</a>');

		$h = str_replace('{$main}', '', $h);
	

		$this->dohtml($h);
	} 
}

$myclass = new myclass();