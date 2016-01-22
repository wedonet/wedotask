<?php

require '../../../global.php';

$j =& $GLOBALS['j'];


topcount($j);

function topcount(&$j){
	$sql = 'select count(*) as mycount,mystatus from `'.sh.'_note` where suid=:uid group by mystatus';

	$main = $GLOBALS['main'];

	$result = $main->executers($sql, Array(':uid'=>$main->user['id']));

	echo json_encode($result);
}