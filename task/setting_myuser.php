<?php

require '../global.php';
require sysdir . 'task/cls_task.php';




class myclass extends cls_task {

    function __construct() {
        parent::__construct();

        define('sp', 'task/_setting_myuser');

		crumb('<a href="setting.php">Setting</a>');

        $act = $this->main->ract();

		switch ($act) {
			case '':
				$this->htmlmain();
				break;
			case 'save':
				$this->save();
				break;
			default;
				break;
		
		}
	}

	
	function htmlmain()
	{
		$js = '';

		$h = $this->main->htm('main');
		$tli = $this->main->htm('li');

		$mytype = $this->main->request('类型', 'mytype', 'get', 'char', 1, 1, 'folder');

		showerr();

		/**/
		$js .= '$("#j_setting_myuser'.$mytype.'").addClass("on");'.PHP_EOL;
	
		/*提取所有用户*/
        $sql = 'select * from `' . sh . '_user` where 1 ';
        $sql .= ' and isdel=0 ';
        $sql .= ' and ispass=1 ';
		/*$sql .= ' and id in(Select myidlist from `'.sh.'_myuser` where mytype="'.$mytype.'" and uid='.$this->main->user['id'].')';*/

		$li = $this->main->repm($sql, $tli);

		/*提取已选的人更新到页面*/
		$sql = 'select myidlist from `'.sh.'_myuser` where 1';
		$sql .= ' and mytype="'.$mytype.'"';
		$sql .= ' and uid='. $this->main->user['id'];

		$a = $this->main->exeone($sql);
		if ( false !== $a ) {
			$mylist = explode(',', $a['myidlist']);

			foreach ($mylist as $k=>$v) {
				$js .= 'checkcheckbox("id[]", "'.$v.'");'.PHP_EOL;
			}
		}



		$tli = 'checkcheckbox("id[]", "{$duids}");';

		/*replace*/
		$h = str_replace('{$li}', $li, $h);
		$h = str_replace('{$js}', $js, $h);
		$h = str_replace('{$action}', '?act=save&amp;mytype='.$mytype, $h);


		$h = str_replace('{$main}', $h, $this->main->htm('main', 'task/_setting') );
	

		$this->dohtml($h);
	} 


	
	function save()
	{
		$js = '';

		$mytype = $this->main->request('类型', 'mytype', 'get', 'char', 1, 20);

		$uids = $this->main->ridlist('id');


		switch ($mytype){
			case 'd': //'dealuidlist':

				break;
			case 'c': //'checkuidlist':

				break;
		}

		
		/*生成数组*/
		$a['uid'] = $this->main->user['id'];
		$a['myidlist'] = $uids;
		$a['mytype'] = $mytype;


		/*入库*/
		$sql = 'select count(*) from `'.sh.'_myuser` where 1';
		$sql .= ' and mytype="'.$mytype.'" ';
		$sql .= ' and uid='.$a['uid'];

		$mycount = $this->main->execount($sql);

		if( $mycount>0 ){
			$this->main->pdo->update( sh.'_myuser', $a, ' uid='.$a['uid'] ); 
		}else{
			$id = $this->main->pdo->insert( sh.'_myuser', $a );
		}

	
		/*提示*/
		ajaxerr('保存成功');		
	} 
}

$myclass = new myclass();