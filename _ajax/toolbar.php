<?php
//

require('../global.php');

define('sp','ajax/_toolbar');

$Myclass = new Myclass();

class Myclass
{
	
	function __construct()
	{
		$this->htmlmain();
		san();
	} // end func


	
	
	function htmlmain()
	{
		$main =& $GLOBALS['main'];

		$u_id = $main->user['id'];
		


	} // end func
	


} // end class

