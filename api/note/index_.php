<?php

require_once('cls_note.php');

$j['user'] = $main->user;

class Myclass extends Cls_note {

	function __construct() {
		parent::__construct();



		$this->j = & $GLOBALS['j'];

		$this->j['crumb'] = '<li>便签</li>' . PHP_EOL;


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
		$u_fullname = $this->main->request('姓名', 'u_fullname', 'get', 'char', 1, 255, '', false);

		$u_id = $this->main->user['id']; //默认显示我自已的

		showerr();

		/* 检测真实姓名是否正确 */
		if ('' != $u_fullname) {
			if (preg_match("/^[a-zA-Z\s]+$/", $u_fullname)) {
				$sql = 'select id,u_fullname from `' . sh . '_user` where u_nick="' . $u_fullname . '"';
			} else {
				/* 检测责任人是否正确,并返回责任人用户id */
				$sql = 'select id,u_fullname from `' . sh . '_user` where u_fullname="' . $u_fullname . '"';
			}
			$result = $this->main->exeone($sql);
			if (false == $result) {
				showerr('姓名错误');
			} else {
				$u_fullname = $result['u_fullname'];
				$u_id = $result['id'];
			}
		}


		if ('' == $taskstatus) {
			$taskstatus = 'New,Plan,Doing,Done,Delay,Cancel,Over';
		}

		$this->j['search']['mystatus'] = $taskstatus;
		$this->j['search']['showtype'] = $showtype;
		$this->j['search']['u_fullname'] = $u_fullname;

		if ('' != $taskstatus) {
			$a = explode(',', $taskstatus);
			for ($i = 0; $i < count($a); $i++) {
				$a[$i] = '"' . $a[$i] . '"';
			}
			$taskstatus = join(',', $a);
		}

		$sql = 'select * from `' . sh . '_note` where 1 ';
		$sql .= ' and (showtype=0 or (showtype=1 and duid=' . $this->main->user['id'] . '))';
		$sql .= ' and mystatus in (' . $taskstatus . ') ';

		/* 没填姓名显示所有人的 */
		if ('' == $u_fullname) {
			
		} else {
			switch ($showtype) {
				case 'release':
					$sql .= ' and suid=' . $u_id;
					break;
				case 'receive':
					$sql .= ' and duid=' . $u_id;
					break;
				default :
					$sql .= ' and (suid='.$u_id.' or duid='.$u_id.') ';
			}
		}



		$sql .= ' and mystatus<>"Delete" ';
		$sql .= ' order by id  desc,rtimeint desc ';



		$result = $this->main->exers($sql);

		$this->j['list'] = $result['rs'];

		/* 提取id */
		$a = [];
		foreach ($result['rs'] as $v) {
			$a[] = $v['id'];
		}
		if (count($a) > 0) {
			/* 提取回复 */
			$sql = 'select * from `' . sh . '_notereply` where 1 ';
			$sql .= ' and fid in(' . join(',', $a) . ')';
			$sql .= ' order by id asc ';

			$result = $this->main->executers($sql);

			$this->j['reply'] = $result;
		} else {
			$this->j['reply'] = [];
		}

		$this->j['pagelist'] = $this->main->pagelist();
	}

}

$Myclass = new Myclass();
unset($Myclass);