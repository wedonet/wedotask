<?php

require 'global.php';

class Myclass {

	function __construct() {	
		$this->htmlmain();
	}

	function htmlmain() {
		
		define('sp', '_tags');

		$h = $GLOBALS['main']->htm('main');		


		crumb('标签说明');
		echo ( $GLOBALS['html']->dohtml($h) );
	}	
	

}


$Myclass = new Myclass();

