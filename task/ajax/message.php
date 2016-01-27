<?php

require '../../global.php';


class Myclass {

    function __construct() {
		$this->main =& $GLOBALS['main'];    

        $this->showcount();

        san();
    }

	/*显示统计*/
	function showcount(){
		$js = '';


		/*我收的新任务*/
		$sql = 'select count(*) from `'.sh.'_task` where 1 ';
		$sql .= ' and mystatus<>"over" ';
		$sql .= ' and mystatus<>"cancel" ';
		$sql .= ' and duids like "%,' . $this->main->user['id'] . ',%"';
		$sql .= ' and isdel=0 ';
		$sql .= ' and isshow=1 ';
		$sql .= ' and rduids not like "%,' . $this->main->user['id'] . ',%"'; //未读过的, 实现方法是已读人里没有我
		$sql .= ' and myrange<>"discuss" ';
		$sql .= ' and myrange<>"adjust" ';
		
		$result = $this->main->execount( $sql );

		$js .= '$("#c_new").text('.$result.');'.PHP_EOL;


		/*我发的,未完成的任务*/
		$sql = 'select count(*) from `'.sh.'_task` where 1 ';
		$sql .= ' and mystatus<>"over" ';
		$sql .= ' and mystatus<>"cancel" ';
		$sql .= ' and suid=' . $this->main->user['id'];
		$sql .= ' and isdel=0 ';
		$sql .= ' and isshow=1 ';
		$sql .= ' and myrange<>"discuss" ';
		$sql .= ' and myrange<>"adjust" ';
		
		$result = $this->main->execount( $sql );

		$js .= '$("#c_release").text('.$result.');'.PHP_EOL;

		/*我收的未完成的任务*/
		$sql = 'select count(*) from `'.sh.'_task` where 1 ';
		$sql .= ' and mystatus<>"over" ';
		$sql .= ' and mystatus<>"cancel" ';
		$sql .= ' and duids like "%,' . $this->main->user['id'] . ',%"';
		$sql .= ' and isdel=0 ';
		$sql .= ' and isshow=1 ';
		$sql .= ' and myrange<>"discuss" ';
		$sql .= ' and myrange<>"adjust" ';
				
		$result = $this->main->execount( $sql );

		$js .= '$("#c_receive").text('.$result.');'.PHP_EOL;

		/*我测的未完成的任务*/
		$sql = 'select count(*) from `'.sh.'_task` where 1 ';
		$sql .= ' and mystatus<>"over" ';
		$sql .= ' and mystatus<>"cancel" ';
		$sql .= ' and cuids like "%,' . $this->main->user['id'] . ',%"';
		$sql .= ' and isdel=0 ';
		$sql .= ' and isshow=1 ';
		$sql .= ' and pid=0 ';
		$sql .= ' and myrange<>"discuss" ';
		$sql .= ' and myrange<>"adjust" ';
				
		$result = $this->main->execount( $sql );

		$js .= '$("#c_check").text('.$result.');'.PHP_EOL;

		echo $js;

	}
}

$Myclass = new Myclass();
unset($Myclass);

