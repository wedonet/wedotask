<?php

require 'global.php';

class P_map  {

	function __construct() {
	
		$this->htmlmain();
	}

	function htmlmain() {
		
		define('sp', '_map');

		$h = $GLOBALS['main']->style(sp, 'main');
	

		echo ( $h );
	}	
	

}


$P_map = new P_map(); 