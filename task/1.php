<?php

require '../global.php';
require sysdir . 'task/cls_task.php';
require sysdir . 'task/main.php';

class Myclass extends Cls_task {

    private $j;

    function __construct() {
        parent::__construct();

        define('sp', 'task/_1');

        $this->j = & $GLOBALS['j'];

        $this->j['crumb'] = '<li>任务管理</li>' . PHP_EOL;

        $this->htmlmain();

        san();
    }

    function htmlmain() {
        $this->j['headtitle'] = '当前任务';


        $js = '';



        $dtime1 = $this->main->request('起始时间', 'dtime1', 'get', 'date', 6, 50, '', false);
        $dtime2 = $this->main->request('结止时间', 'dtime2', 'get', 'date', 6, 50, '', false);

        showerr();


		if ('' == $dtime1) {
			$dtime1 = date('Y-m-d', time());
		}

		if ('' == $dtime2) {
			$dtime2 = date('Y-m-d', time());
		}




       


        /* 时间 */
		/* 已经开始并且结束的 ==========================================*/

		$sql = 'select * from `' . sh . '_task` where 1 ';

		$this->j['l'][0]['title'] = '结束的任务';

        
        $sql .= ' and actualtimeint>=' . strtotime($dtime1);
		$sql .= ' and actualtimeint<=' . strtotime($dtime2);
       


        $sql .= ' and isdel=0 ';
        $sql .= ' and pid=0 ';

        $sql .= ' and myrange <> "discuss" ';
        $sql .= ' and myrange <> "adjust" ';

        //$sql .= ' order by id desc ';


        $result = $this->main->execute($sql);


  
        $this->j['v']['dtime1'] = $dtime1;
        $this->j['v']['dtime2'] = $dtime2;


        //$this->j['list'] = $result['rs'];
	
		$this->j['l'][0]['list'] = $result['rs'];
		
		/* /已经开始并且结束的 ==========================================*/




		/* 开始还没结束的（正在进行的） ==========================================*/
		$sql = 'select * from `' . sh . '_task` where 1 ';

		$this->j['l'][1]['title'] = '正在进行的任务(不分时间)';

        
        //$sql .= ' and dtimesint>=' . strtotime($dtime1);
		//$sql .= ' and dtimesint<=' . strtotime($dtime2);

		$sql .= ' and mystatus="doing" ';
        //$sql .= ' and mystatus<>"cancel" ';


        $sql .= ' and isdel=0 ';
        $sql .= ' and pid=0 ';

        $sql .= ' and myrange <> "discuss" ';
        $sql .= ' and myrange <> "adjust" ';

        //$sql .= ' order by id desc ';


        $result = $this->main->execute($sql);


  
        $this->j['v']['dtime1'] = $dtime1;
        $this->j['v']['dtime2'] = $dtime2;


        //$this->j['list'] = $result['rs'];
	
		$this->j['l'][1]['list'] = $result['rs'];






		/* 延期完成的 ==========================================*/
		$sql = 'select * from `' . sh . '_task` where 1 ';

		$this->j['l'][2]['title'] = '延期任务';

        
        $sql .= ' and plantimeint>=' . strtotime($dtime1);
		$sql .= ' and plantimeint<=' . strtotime($dtime2);

		$sql .= ' and mystatus<>"over" ';
        $sql .= ' and mystatus<>"cancel" ';


        $sql .= ' and isdel=0 ';
        $sql .= ' and pid=0 ';

        $sql .= ' and myrange <> "discuss" ';
        $sql .= ' and myrange <> "adjust" ';

        //$sql .= ' order by id desc ';


        $result = $this->main->execute($sql);


  
        $this->j['v']['dtime1'] = $dtime1;
        $this->j['v']['dtime2'] = $dtime2;


        //$this->j['list'] = $result['rs'];
	
		$this->j['l'][2]['list'] = $result['rs'];







		/*还没开始的 ========================================== */
		$sql = 'select * from `' . sh . '_task` where 1 ';

		$this->j['l'][3]['title'] = '还没开始的(不分时间)';

        


		$sql .= ' and mystatus="new" ';



        $sql .= ' and isdel=0 ';
        $sql .= ' and pid=0 ';

        $sql .= ' and myrange <> "discuss" ';
        $sql .= ' and myrange <> "adjust" ';

        //$sql .= ' order by id desc ';


        $result = $this->main->execute($sql);


  
        $this->j['v']['dtime1'] = $dtime1;
        $this->j['v']['dtime2'] = $dtime2;


        //$this->j['list'] = $result['rs'];
	
		$this->j['l'][3]['list'] = $result['rs'];




        require( tpath . 'task/_1.php');

        die;
    }

}

$Myclass = new Myclass();
unset($Myclass);

