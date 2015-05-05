<?php

require '../global.php';
require (sysdir . 'log/cls_log.php' );

class Myclass extends cls_log{

    function __construct() {
        parent::__construct();

        define('sp', 'log/_detail');

        crumb('<a href="index.php">日志</a>');

        $this->htmlmain();

        san();
    }

    function htmlmain() {
        $js = '';
        
        $h = $this->main->htm('main');

        title('日志');


        /* 接收参数 */
        $id = $this->main->rqid('id');

        /* 提取内容 */
        $sql = 'select * from `' . sh . '_updatelog` where 1 ';

        $sql .= ' and isdel=0 ';

        $sql .= ' and id=' . $id;

		$h = $this->main->repm($sql, $h);

      

        crumb('详细信息');
        
        $h = str_replace('{$js}', $js, $h);


        $this->html->addjs(webdir . 'ckeditor/ckeditor.js');
        $this->dohtml($h);
    }

    function reply($taskid) {
        $tli = $this->main->htm('li');

        $sql = 'select * from `' . sh . '_retask` where 1';
        $sql .= ' and taskid=' . $taskid;
        $sql .= ' and isdel=0';
        $sql .= ' order by id ';

        $li = $this->main->repm($sql, $tli);

        return $li;
    }

	function updaterduids($result){
		if ( '' == $result['rduids'].''){
			$rduids = ','.$this->main->user['id'].',';
		}
		else{
			$rduids = $result['rduids'].$this->main->user['id'].',';
		}

		$sql = 'update `'.sh.'_task` set rduids="'.$rduids.'" where 1 ' ;
		$sql .= ' and id='.$result['id'];

		$this->main->execute($sql);
	}

// end func
}

$Myclass = new Myclass();
unset($Myclass);

