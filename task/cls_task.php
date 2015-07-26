<?php

class Cls_task {

    function __construct() {
        $this->main = & $GLOBALS['main'];
        $this->html = & $GLOBALS['html'];

        /* 检测权限 */
        if ('guest' == $this->main->user['u_gic']) {
            header('location:/service/login.php');
            die;
        }

        /*频道标识*/
        $this->cic = 'task';
    }

    function log($taskid, $title) {
        $rs['title'] = $title;
        $rs['stimeint'] = time();
        $rs['stime'] = date('Y-m-d H:i:s', $rs['stimeint']);

        $rs['suid'] = $this->main->user['id'];
        $rs['snick'] = $this->main->user['u_nick'];
        $rs['sname'] = $this->main->user['u_name'];

        $rs['taskid'] = $taskid;

        $id = $this->main->pdo->insert(sh . '_tasklog', $rs);
    }

    function gettask($taskid) {
        $sql = 'select * from `' . sh . '_task` where 1 ';
        $sql .= ' and id=' . $taskid;

        return $this->main->exeone($sql);
    }

    function dohtml(&$h) {
        /* 工具栏 */
        $h = str_replace('{$tasktoolbar}', $this->toolbar(), $h);

        $h = $this->html->dohtml($h);

        echo $h;
    }

    function toolbar() {
        $s = $this->main->htm('toolbar', 'task/_main');

        /* 统计 */
        /*
          $sql = 'select mystatus,count(*) as mycount from `'.sh.'_task` where 1';
          $sql .= ' and isdel=0';
         */

        return $s;
    }

    /* 跟据用户idlist,取得用户名idlist */

    function getusernamelist($idlist) {
        if ('' == $idlist) {
            return '';
        }

        /* 去掉开头和结尾的逗号 */
        $t = array();
        $a = explode(',', $idlist);
        foreach ($a as $v) {
            if ('' !== $v . '') {
                $t[] = $v;
            }
        }
        $idlist = implode(',', $t);

        $sql = 'select u_fullname from `' . sh . '_user` where 1 and id in (' . $idlist . ') ';

        $result = $this->main->executers($sql);

        if (false == $result) {
            ajaxerr('没找到这个部门');
        } else {
            $a = array();

            foreach ($result as $v) {
                $a[] .= $v['u_fullname'];
            }

            return implode(',', $a);
        }
    }

    function icanedittask($suid) {
        if ($this->main->user['id'] == $suid Or $this->main->ins('admin,supperadmin', $this->main->user['u_gic'])) {
            return true;
        } else {
            return false;
        }
    }

	/*更新子任务数，完成的子任务数，任务状态
	* taskid : 任务ID
	* 成功后返回 true
	*/
	function updatetaskcount($taskid)
	{
		/*提取总子任务数和已完成的子任务数*/
		$sql = 'select count(*) from `'.sh.'_task` where 1 and isdel=0 and pid='.$taskid;
		$myson = $this->main->execount($sql);

		$sql = 'select count(*) from `'.sh.'_task` where 1 and isdel=0 and pid='.$taskid.' and mystatus="over" ';
		$mysonover = $this->main->execount($sql);
		
	
		/*更新数量*/
		$sql = 'update `'.sh.'_task` set myson='.$myson.', mysonover='.$mysonover.' where 1 ';
		$sql .= ' and isdel=0 ';
		$sql .= ' and id='.$taskid;
		$this->main->execute($sql);

		return true;
	} // end func

}