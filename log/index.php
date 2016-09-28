<?php

require '../global.php';
require sysdir . 'log/cls_log.php';

class Myclass extends Cls_log {

    function __construct() {
        parent::__construct();

        define('sp', 'log/_index');

        crumb('更新日志');

        $this->htmlmain();

        san();
    }

	function htmlmain(){
		$js = '';

        $h = $this->main->htm('main');
        $tli = $this->main->htm('li');

        title('更新日志');       

        showerr();
  

        $sql = 'select * from `' . sh . '_updatelog` where 1 ';
        $sql .= ' and isdel=0 ';
        $sql .= ' order by id desc ';



        $li = $this->main->repm($sql, $tli, null, 0, true);

        /**/
        $h = str_replace('{$li}', $li, $h);
        $h = str_replace('{$pagelist}', $this->main->pagelist(), $h);

        $h = str_replace('{$js}', $js, $h);

        $this->dohtml($h);
	}



}

$Myclass = new Myclass();
unset($Myclass);

