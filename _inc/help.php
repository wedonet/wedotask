<?php



function pr(){
	$s = '';
	$s.= '<div style="width:600px;">'.PHP_EOL;
	$s.= '<table cellspacing="1" class="table1">'.PHP_EOL;
	$s.= '<tr>'.PHP_EOL;
	$s.= '<td>POST: ' .count($_POST). '</td>'.PHP_EOL;
	$s.= '<td>GET: ' .count($_GET). '</td>'.PHP_EOL;
	$s.= '</tr>'.PHP_EOL;
	$s.= '<tr valign="top">'.PHP_EOL;
	$s.= '<td>'.PHP_EOL;

	foreach ($_POST as $key=>$value ) {
		$s.= '$'.$key .' = '. $value . '<br />'.PHP_EOL;
	}

	$s.= '</td>'.PHP_EOL;
	$s.= '<td>'.PHP_EOL;
	
	foreach ($_GET as $key=>$value ) {
		$s.= '$'.$key .' = '. $value . '<br />'.PHP_EOL;
	}

	$s.= '</td>'.PHP_EOL;
	$s.= '</tr>'.PHP_EOL;
	$s.= '</table>'.PHP_EOL;
	$s.= '<br /><br />'.PHP_EOL;

	return $s;
} // end func

function wpr(){
   echo pr();
   die;
   
}


function print_ra( $rs ){
    return str_replace( "\n", '<br />', ( print_r( $rs, true )));
} // end func  str_replace( "\n", '<br />', ( print_r( $rs, true )));