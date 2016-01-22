<?php

require '../global.php';
require sysdir . 'task/cls_task.php';
require sysdir . 'task/main.php';



class Myclass extends Cls_task {
	private $j;	

    function __construct() {
        parent::__construct();

        define('sp', 'task/_index');		
		
			$this->j =& $GLOBALS['j'];
		
        $this->j['crumb'] = '<li>任务管理</li>'.PHP_EOL;

        $this->htmlmain();

        san();
    }

	function htmlmain(){
		$this->j['headtitle'] = '任务';		


		$js = '';
   

        /* 接收参数 */
        $keywords = $this->main->request('关键词', 'keywords', 'get', 'char', 1, 50, '', false);
        $taskstatus = $this->main->request('任务状态', 'taskstatus', 'get', 'char', 1, 50, 'encode', false);
        $tasktype = $this->main->request('任务类型', 'tasktype', 'get', 'char', 1, 50, 'encode', false);
        $showtype = $this->main->request('显示类型', 'showtype', 'get', 'char', 1, 50, 'encode', false);

        $dtime1 = $this->main->request('计划时间起始时间', 'dtime1', 'get', 'date', 6, 50, '', false);
        $dtime2 = $this->main->request('计划时间结止时间', 'dtime2', 'get', 'date', 6, 50, '', false);

        showerr();

		switch ( $showtype ) {
			case '':
				$this->j['crumb'] .= '<li>新任务</li>'.PHP_EOL;
				break;
			case 'release':
				$this->j['crumb'] .= '<li>我发布的任务</li>'.PHP_EOL;
				break;
			case 'receive':
				$this->j['crumb'] .= '<li>我执行的任务</li>'.PHP_EOL;
				break;
			case 'check':
				$this->j['crumb'] .= '<li>我验收的任务</li>'.PHP_EOL;
				break;
			case 'noshow':
				$this->j['crumb'] .= '<li>草稿</li>'.PHP_EOL;
				break;
		}


        /* 没选任务状态,then列出所有进行中的任务 */
        if ('' == $taskstatus) {
            $taskstatus = 'alive';
        }
        $this->j['v']['taskstatus'] = $taskstatus;

        $sql = 'select * from `' . sh . '_task` where 1 ';

		//$sql .= ' and myrange<>"adjust" and myrange<>"discuss" ';

		//$sql .= 

        /* 任务状态 */
        switch ($taskstatus) {
            /* 所有活动任务,不包括结束的 */
            case 'alive':
                $sql .= ' and mystatus<>"over"  and mystatus<>"cancel" ';
                break;
            default:
                $sql .= ' and mystatus="' . $taskstatus . '" ';
                break;
        }

        /* 任务类型 */
        if ('' != $tasktype) {
            $sql .= ' and mytype="' . $tasktype . '" ';
        }
        $this->j['v']['tasktype'] = $tasktype;

        /* 显示类型 */


        
		switch ($showtype) {
			/*发的任务*/
			case 'release':
				$sql .= ' and suid=' . $this->main->user['id'];
				break;
			/*收的任务*/
			case 'receive':
				$sql .= ' and duids like "%,' . $this->main->user['id'] . ',%"';
				break;
			/*验收的任务*/
			case 'check': /*我验证收到*/
			   $sql .= ' and cuids like "%,' . $this->main->user['id'] . ',%"';
				break;
			default :
				$sql .= ' and (suid=' . $this->main->user['id'] . '
					or duids like "%,' . $this->main->user['id'] . ',%" 
					or cuids like "%,' . $this->main->user['id'] . ',%")';
				break;

			/* case 'noshow':
			  $sql .= ' and isshow=0 ';
			  break;
			 * 
			 */
		}
       
        $this->j['v']['showtype'] = $showtype;

        if ('noshow' == $showtype) {
            $sql .= ' and isshow=0 and suid='.$this->main->user['id'];
        } else {
            $sql .= ' and isshow=1 ';
        }


		/*计划时间段*/
		if ( '' != $dtime1 ){
			$sql .= ' and dtimesint>='.strtotime($dtime1);
		}

		if ( '' != $dtime2 ){
			$sql .= ' and dtimesint<='.strtotime($dtime2);
		}

        $sql .= ' and isdel=0 ';
		$sql .= ' and pid=0 ';
		
		$sql .= ' and myrange <> "discuss" ';
		$sql .= ' and myrange <> "adjust" ';
		
        $sql .= ' order by id desc ';

		$result = $this->main->exers($sql);


		$this->j['v']['keywords'] = $keywords; 
		$this->j['v']['dtime1'] = $dtime1; 
		$this->j['v']['dtime2'] = $dtime2;
		$this->j['v']['keywords'] = $keywords;

		$this->j['list'] = $result['rs'];
		$this->j['pagelist'] =  $this->main->pagelist();	


		

		require( tpath . 'task/_index.php');

		die;
	}



}

$Myclass = new Myclass();
unset($Myclass);

