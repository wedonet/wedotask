<?php

require '../global.php';
require sysdir . 'task/cls_task.php';
require sysdir . 'task/main.php';

class Myclass extends Cls_task {

	function __construct() {
		parent::__construct();

		define('sp', 'task/_list');

		$GLOBALS['j']['crumb'] = '<li>全部任务</li>';

		if (!$this->main->ins('admin,supperadmin', $this->main->user['u_gic'])) {
			showerr('管理员才可以查看全部任务!');
		}

		$this->htmlmain();

		san();
	}

	function htmlmain() {
		$js = '';

		$j = & $GLOBALS['j'];

		$h = $this->main->htm('main');
		$tli = $this->main->htm('li');

		$j['headtitle'] = '任务';

		/* 接收参数 */
		$keywords = $this->main->request('关键词', 'keywords', 'get', 'char', 1, 50, '', false);
		$taskstatus = $this->main->request('任务状态', 'taskstatus', 'get', 'char', 1, 50, 'encode', false);
		$tasktype = $this->main->request('任务类型', 'tasktype', 'get', 'char', 1, 50, 'encode', false);
		$showtype = $this->main->request('显示类型', 'showtype', 'get', 'char', 1, 50, 'encode', false);

		$taskrange = $this->main->request('显示范围', 'taskrange', 'get', 'char', 1, 50, 'encode', false);


		$dtime1 = $this->main->request('计划时间起始时间', 'dtime1', 'get', 'date', 6, 50, '', false);
		$dtime2 = $this->main->request('计划时间结止时间', 'dtime2', 'get', 'date', 6, 50, '', false);

		$dic = $this->main->request('部门', 'dic', 'get', 'char', 1, 20, '', false);
		$taskuid = $this->main->rqid('taskuid');

		$outtype = $this->main->request('显示方式', 'outtype', 'get', 'char', 2, 50, '', false); //emport时做导出;

		$showcancel = $this->main->rqid('showcancel');
		$showdel = $this->main->rqid('showdel');

		showerr();

		/* replace */
		$j['v']['optiondepartment'] = $this->getoptiondepartment(); //部门
		$j['v']['optionuser'] = $this->getoptionuser(); //用户选项


		/* 没选任务状态,then列出所有进行中的任务 */
		if ('' == $taskstatus) {
			$taskstatus = 'alive';
		}
		$j['v']['taskstatus'] = $taskstatus;




		$sql = 'select * from `' . sh . '_task` where 1 ';

		/*显示取消的任务*/
		if ( 1 == $showcancel ) {
			$sql .= ' and mystatus="cancel" ';
			$sql .= ' and isdel=0';

			$GLOBALS['j']['crumb'] .= '<li>取消的任务</li>';

		}

		/*删除的任务*/
		if ( 1 == $showdel ) {
			$sql .= ' and isdel=1 ';
			$GLOBALS['j']['crumb'] .= '<li>删除的任务</li>';
		}

//		/* 任务状态 */
//		switch ($taskstatus) {
//			/* 所有活动任务,不包括结束的 */
//			case 'alive':
//				$sql .= ' and mystatus<>"over" and mystatus<>"cancel" ';
//				break;
//			default:
//				$sql .= ' and mystatus="' . $taskstatus . '" ';
//				break;
//		}
//
//		/* 任务类型 */
//		if ('' != $tasktype) {
//			$sql .= ' and mytype="' . $tasktype . '" ';
//		}
//		$j['v']['tasktype'] = $tasktype;
//
//		/* 显示类型 */
//		if ('' != $showtype And $taskuid > 0) {
//			switch ($showtype) {
//				case 'receive':
//					$sql .= ' and duids like "%,' . $taskuid . ',%"';
//					break;
//				case 'release':
//					$sql .= ' and suid=' . $taskuid;
//					break;
//				case 'check':
//					$sql .= ' and cuids like "%,' . $taskuid . ',%"';
//					break;
//				default :
//					$sql .= ' and (suid=' . $taskuid . '
//						or duids like "%,' . $taskuid . ',%" 
//						or cuids like "%,' . $taskuid . ',%")';
//					break;
//			}
//		}
//
//		$j['v']['showtype'] = $showtype;
//		$j['v']['taskuid'] = $taskuid;
//
//
//		/* 部门 */
//		if ('' !== $dic) {
//			$sql .= ' and dic="' . $dic . '" ';
//		}
//		$j['v']['dic'] = $dic;
//
//		/* 显示范围 */
//		$j['v']['taskrange'] = $taskrange;
//		switch ($taskrange) {
//			case '' :
//			case 'normal': //正常任务
//				$sql .= ' and myrange<>"adjust" and myrange<>"discuss" ';
//				break;
//			case 'adjust':
//				$sql .= ' and myrange="adjust" ';
//				break;
//			case 'discuss':
//				$sql .= ' and myrange="discuss" ';
//				break;
//		}
//
//
//
//
//		$sql .= ' and isshow=1 ';
//
//
//
//		/* 计划时间段 */
//		if ('' != $dtime1) {
//			$sql .= ' and dtimesint>=' . strtotime($dtime1);
//		}
//
//		if ('' != $dtime1) {
//			$sql .= ' and dtimesint<=' . strtotime($dtime2);
//		}
//
//		$sql .= ' and isdel=0 ';
		$sql .= ' order by id desc ';

//stop($sql);



		/* 导出到execel */
		if ('emport' == $outtype) {
			$liemport = $this->main->htm('liemport');
			$li = $this->main->repm($sql, $liemport, null, 0);


			$data = '<table border="1">' . $li . '</table>';
			$this->main->exportxls('log', $data);
			die;
		}


		$result = $this->main->exers($sql);


		$j['list'] = $result['rs'];
		$j['pagelist'] = $this->main->pagelist();



		/**/
		$j['v']['keywords'] = $keywords;
		$j['v']['dtime1'] = $dtime1;
		$j['v']['dtime2'] = $dtime2;

		$j['v']['pagelist'] = $this->main->pagelist();

		require( tpath . 'task/_others.php');
	}

	function getoptiondepartment() {
		$tli = '<option value="{$ic}">{$title}</option>' . PHP_EOL;

		$sql = 'select * from `' . sh . '_department` where 1 ';
		$sql .= ' and isuse=1 ';

		$li = $this->main->repm($sql, $tli);

		return $li;
	}

	function getoptionuser() {
		$tli = '<option value="{$id}">{$u_fullname}</option>' . PHP_EOL;

		$sql = 'select * from `' . sh . '_user` where 1 ';
		$sql .= ' and ispass=1 ';
		$sql .= ' and isdel=0 ';

		$li = $this->main->repm($sql, $tli);

		return $li;
	}

}

$Myclass = new Myclass();
unset($Myclass);

