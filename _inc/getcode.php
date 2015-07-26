<?php
require('../global.php');
require(sysdir.'_setting/code.php');

main();



function main(){
	$a = $GLOBALS['code'];

	$mykey = array_rand($a);

	$s = $a[$mykey][0] . ' (请输入正确答案)';

	$_SESSION['codestr'] = $a[$mykey][1];
	
    echo $s;
} // end func
san();