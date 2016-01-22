<?php
require_once('cls_note.php');

$j['user'] = $main->user;

class Myclass extends Cls_note{
	  function __construct() {
		parent::__construct();

	
		
		$this->j =& $GLOBALS['j'];
		
		$this->j['crumb'] = '<li>便签</li>'.PHP_EOL;

        
		$act = $this->main->ract();

		switch ($act) {
			case '':
				$this->htmlmain();
				break;
		}

		san();
    }

	 /**/
	 function htmlmain() {

		$taskstatus = $this->main->request('任务状态', 'taskstatus', 'cb', 'char', 0, 255, '', false);
		$showtype = $this->main->ract('showtype');

		if( ''==$taskstatus ){
			$taskstatus = 'New,Plan,Doing,Done,Delay,Cancel,Over';
		}

		$this->j['search']['mystatus'] = $taskstatus;
		$this->j['search']['showtype'] = $showtype;

		if(''!=$taskstatus){			
			$a = explode(',', $taskstatus);
			for($i=0; $i<count($a); $i++){
				$a[$i] = '"'.$a[$i].'"';
			}
			$taskstatus=join(',', $a);
		}

		$sql = 'select * from `'.sh.'_note` where 1 ';
		$sql .= ' and (showtype=0 or (showtype=1 and duid='.$this->main->user['id'].'))';
		$sql .= ' and mystatus in ('.$taskstatus.') ';
		

		switch ($showtype) {
			case 'release':
				$sql .= ' and suid='.$this->main->user['id'];
				break;
			case 'receive':
				$sql .= ' and duid='.$this->main->user['id'];
				break;
		
		}
		$sql .= ' and mystatus<>"Delete" ';
		$sql .= ' order by id  desc,rtimeint desc ';



		$result = $this->main->exers($sql);

		$this->j['list']= $result['rs'];

		/*提取id*/
		$a = [];
		foreach($result['rs'] as $v){
			$a[] = $v['id'];
		}
		if( count($a)>0){
			/*提取回复*/
			$sql = 'select * from `'.sh.'_notereply` where 1 ';
			$sql .= ' and fid in('.join(',', $a).')';
			$sql .= ' order by id asc ';

			$result = $this->main->executers($sql);

			$this->j['reply'] = $result;
		}else{
			$this->j['reply'] = [];
		}

		$this->j['pagelist'] =  $this->main->pagelist();	
	 }
}

$Myclass = new Myclass();
unset($Myclass);