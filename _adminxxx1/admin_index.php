<?php

require('../global.php');
require( sysdirad.'inc/cls_ad.php');

$main->chkadmin();

define('sp', 'admin/_admin_index');

class Myclass {

    function __construct() {
        $this->main = & $GLOBALS['main'];

        $act = $this->main->ract();

        switch ($act) {
            case '' : $this->Main();
                break;
            case 'admin_main' : $this->admin_main();
                break;
        }
        san();
    }

    function Main() {
        $h = $this->main->htm('main');
        $h = str_replace('{$webname}', webname, $h);
        echo $h;
    }



    function admin_main() {
		loadclass('c_ad', 'Cls_ad');

		$this->c_ad =& $GLOBALS['c_ad']; 

        $this->c_ad->head();
        $this->c_ad->foot();
    }

}

$Myclass = new Myclass();
