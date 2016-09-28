<?php

require '../global.php';
require sysdir . 'task/cls_task.php';

/*
 * 任务状态
 * new = 新任务
 * doing = 正在执行
 * done = 完成
 * redo = 返工
 * ok = 检测通过,所有人检测通过后,任务状态自动变为完成
 * over = 结束
 * cancel = 取消
 *
 * 2. 完成后可以跟贴
 */

class Myclass extends cls_task {

    function __construct() {
        parent::__construct();
        define('sp', 'task/_formson');

		crumb('任务管理');

        $act = $this->main->ract();

        switch ($act) {
            case 'creat':
                $this->myform(false);
                break;
            case 'nsave':
                $this->saveform(false);
                break;
            case 'edit':
                $this->myform(true);
                break;
            case 'esave':
                $this->saveform(true);
                break;
        }

        san();
    }

    function myform($isedit) {

        $h = $this->main->htm('main');

        /* ====request */
		$pid = $this->main->rqid('pid');
        $id = $this->main->rqid();
        $classid = $this->main->rqid("classid");

        title('子任务');
        
        $a_channel = $this->main->getarr( 'channel', null, $this->cic );

        $h = str_replace('{$optiondepartment}', $this->getoptiondepartment(), $h);
        $h = str_replace('{$checkboxduid}', $this->checkboxuser('duids[]'), $h);
        $h = str_replace('{$checkboxcuid}', $this->checkboxuser('cuids[]'), $h);
        $h = str_replace('{$optionclass}', $this->html->getoptionclassbychannel( $a_channel['id'] ), $h);
        $h = str_replace('{$classid}', $classid, $h);


		/* ==== 提取原任务 */
		$a_task = $this->gettask($pid);
		if ( false === $a_task ) {
			showerr(1018);
		}

		
		/*添加面包屑*/
		crumb('<a href="detail.php?id='.$pid.'">'.$a_task['title'].'</a>');


        /* ==== */

        if (true == $isedit) {
            crumb('修改子任务');

			/*提取原任务*/
            $sql = 'select * from `' . sh . '_task` where 1';
            $sql .= ' and id=' . $id;

            $result = $this->main->exeone($sql);

            if (false == $result) {
                showerr(1018);
            }

            /* 检测修改权限 */
            /* 管理员和作者才能修改 */
            if (!$this->icanedittask($result['suid'])) {
                showerr('管理员和作者才可以编辑！');
            }


            $h = str_replace('{$action}', '?act=esave&amp;pid='.$pid.'&amp;id=' . $id, $h);

            /* 替换记录内容 */
            $h = str_replace('{$mycontent_htmlencode}', htmlencode($result['mycontent']), $h);
            $h = $this->main->reprscolumn($result, sh . '_task', $h);
        } else {
			/*把原任务追加到面包屑*/
            crumb('添加子任务');

            $h = str_replace('{$action}', '?act=nsave&amp;pid='.$pid, $h);
            $h = str_replace('{$isshow}', '1', $h);

            $h = $this->main->removemdbfield($h, sh . '_task');
        }

        $this->html->addjs(webdir . 'ckeditor/ckeditor.js');

        $this->dohtml($h);
    }

    function saveform($isedit) {
		$pid = $this->main->rqid('pid');

        $rs['title'] = $this->main->request('任务名', 'title', 'post', 'char', 1, 255, 'encode');
        $rs['classid'] = $this->main->rfid('classid');

        $rs['duids'] = $this->main->ridlist('duids');
        $rs['cuids'] = $this->main->ridlist('cuids');

        $rs['zhongyao'] = $this->main->rfid('zhongyao');
        $rs['jinji'] = $this->main->rfid('jinji');

        $rs['plantime'] = $this->main->request('计划完成时间', 'plantime', 'post', 'date', 1, 20, '', false);
        $rs['isshow'] = $this->main->rfid('isshow');

        $rs['mycontent'] = $this->main->request('内容', 'mycontent', 'post', 'char', 1, 65535);

        //$rs['mytype'] = $this->main->request('类型', 'mytype', 'post', 'char', 1, 25500, 'invalid');

        ajaxerr();

		if ( $pid<0 ) {
			ajaxerr(1018);
		}


        /* ====deal */
        if ($rs['classid'] > 0) {
            $rs['classname'] = $this->getclassname($rs['classid']);
        } else {
            $rs['classname'] = '';
        }
        //$rs['dname'] = $this->getdepartmentname($rs['dic']);
        $rs['dunames'] = $this->getusernamelist($rs['duids']);
        $rs['cunames'] = $this->getusernamelist($rs['cuids']);

        if ('' !== $rs['plantime']) {
            $rs['plantimeint'] = strtotime($rs['plantime']);
        }
        /*$rs['mytypename'] = $this->getmytypename($rs['mytype']);*/

        if ('' != $rs['duids']) {
            $rs['duids'] = ',' . $rs['duids'] . ',';
        }

        if ('' != $rs['cuids']) {
            $rs['cuids'] = ',' . $rs['cuids'] . ',';
        }

        $success = '<li class="h1">保存成功！</li>' . PHP_EOL;

        if ($isedit) {
            $id = $this->main->rqid('id');

            $a_task = $this->gettask($id);

            $title = '修改任务';

            /* if 由草稿改成发布 */
            if (0 == $a_task['isshow'] And 1 == $rs['isshow']) {
                $title .= '，并设置为发布';

                /* 更新任务状态 */
                $rs['ptimeint'] = time();
                $rs['ptime'] = date('Y-m-d H:i:s', $rs['ptimeint']);
            }

            $this->main->pdo->update(sh . '_task', $rs, ' id=' . $id);

			$success .= '<li><a href="detail.php?id='.$pid.'">返回上级</a></li>';
            $success .= '<li><a href="index.php">返回任务列表</a></li>';

            /*$success .= '<li><a href="detail.php?id=' . $id . '&amp;ispre=1">预览任务</a></li>';*/

			/*更新子任务数，完成任务数*/
			$this->updatetaskcount($pid);

            ajaxinfo($success);
        } else { //保存新记录
			$rs['pid'] = $pid;

            $rs['suid'] = $this->main->user['id'];
            $rs['sname'] = $this->main->user['u_fullname'];

            $rs['stimeint'] = time();
            $rs['stime'] = date('Y-m-d H:i:s', $rs['stimeint']);


            if (1 == $rs['isshow']) {
                $rs['ptimeint'] = time();
                $rs['ptime'] = date('Y-m-d H:i:s', $rs['ptimeint']);
            }

            $rs['mystatus'] = 'new';
            $rs['mystatusname'] = '新任务';

            $id = $this->main->pdo->insert(sh . '_task', $rs);

			$success .= '<li><a href="detail.php?id='.$pid.'">返回上级</a></li>';
            $success .= '<li><a href="index.php">返回任务列表</a></li>';

            /*$success .= '<li><a href="detail.php?id=' . $id . '&amp;ispre=1">预览任务</a></li>';*/

			/*更新子任务数，完成任务数*/
			$this->updatetaskcount($pid);

            ajaxinfo($success);
        }
    }


    function getoptiondepartment() {
        $tli = '<option value="{$ic}">{$title}</option>' . PHP_EOL;

        $sql = 'select * from `' . sh . '_department` where 1 order by cls asc';

        $li = $this->main->repm($sql, $tli);

        return $li;
    }


    function checkboxuser($name) {
        $tli = '<input type="checkbox" name="' . $name . '" value="{$id}" class="vmiddle" /> {$u_fullname} &nbsp; &nbsp;  ' . PHP_EOL;

        $sql = 'select * from `' . sh . '_user` where 1 ';
        $sql .= ' and isdel=0 ';
        $sql .= ' and ispass=1 ';

        $li = $this->main->repm($sql, $tli);

        return $li;
    }

    /* 跟据部门ic,取部门名称 */
    function getdepartmentname($ic) {
        if ('' == $ic) {
            return '';
        }

        $sql = 'select title from `' . sh . '_department` where 1 and ic="' . $ic . '" ';

        $result = $this->main->exeone($sql);

        if (false == $result) {
            ajaxerr('没找到这个部门');
        } else {
            return $result['title'];
        }
    }

    /* 跟据用户idlist,取得用户名idlist */
    function getusernamelist($idlist) {
        if ('' == $idlist) {
            return '';
        }

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

    function getmytypename($str) {
        switch ($str) {
            case 'normal':
                $s = '常规任务';
                break;
            case 'bug':
                $s = 'Bug修改';
                break;
            case 'suggest':
                $s = '功能建议';
                break;
        }
        return $s;
    }

    function getclassname($classid) {
        $sql = 'select * from `' . sh . '_class` where id=' . $classid;

        $result = $this->main->exeone($sql);

        if (false == $result) {
            return '';
        } else {
            return $result['title'];
        }
        unset($result);
    }

// end func
}

$Myclass = new Myclass();
unset($Myclass);

