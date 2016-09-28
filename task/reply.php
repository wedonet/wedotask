<?php

require '../global.php';
require sysdir . 'task/cls_task.php';

/*
 * 保存回复
 */

class Myclass extends Cls_task {

    function __construct() {
        parent::__construct();
        define('sp', 'task/_reply');

        $act = $this->main->ract();

        switch ($act) {
            case 'edit':
                $this->myform();
                break;
            case 'nsave':
                $this->saveform(false);
                break;
            case 'esave':
                $this->saveedit();
                break;
            case 'del':
                $this->delreply();
                break;
        }

        san();
    }

    function myform() {
        $js = '';
        
        $h = $this->main->htm('main');

        title('修改');

        $id = $this->main->rqid();

        /* 提取回复信息 */
        $sql = 'select * from `' . sh . '_retask` where id=' . $id;
        $a_retask = $this->main->exeone($sql);
        if (false == $a_retask) {
            showerr(1018);
        }
        $suid = $a_retask['suid'];


        /* 检查是否有编辑权限，管理员和作者可以编辑 */
        if (!$this->main->user['id'] == $suid Or !$this->main->ins('admin,supperadmin', $this->main->user['u_gic'])) {
            showerr('管理员和作者才可以编辑');
        }

        crumb('修改回复');

        $h = str_replace('{$action}', '?act=esave&amp;taskid=' . $a_retask['taskid'] . '&amp;id=' . $id, $h);


        $v = & $a_retask;
        $h = str_replace('{$id}', $v['id'], $h);
        $h = str_replace('{$js}', $js, $h);
        $h = str_replace('{$title}', $v['title'], $h);
        $h = str_replace('{$mytypename}', $v['mytypename'], $h);
        $h = str_replace('{$mycontent_htmlencode}', htmlencode($v['mycontent']), $h);

        $this->html->addjs(webdir . 'ckeditor/ckeditor.js');

        $this->dohtml($h);
    }

    function saveform($isedit) {
        $rs['taskid'] = $this->main->rqid('id');

        /* ==== 提取任务 */
        $a_task = $this->gettask($rs['taskid']);
        if (false == $a_task ){
            ajaxerr(1018);
        }
        

        /* 检测已完成的任务不能回复 */
        if ('over' == $a_task['mystatus']) {
            ajaxerr('这个任务已经完成了，不能回复');
        }

        $rs['title'] = $this->main->request('任务名', 'title', 'post', 'char', 1, 255, 'encode');

        $rs['mytype'] = $this->main->request('类型', 'mytype', 'post', 'char', 1, 25500, 'invalid');

        $rs['mycontent'] = $this->main->request('内容', 'mycontent', 'post', 'char', 1, 25500);


        ajaxerr();

        /* 暂存进mytype, 更新为返工贴时用 */
        $mytype = $rs['mytype'];

        /* 如果是返工状态,then不能再返工,只能留言 */
        if ('redo' == $mytype And 'redo' == $a_task['mystatus']) {
            ajaxerr('这个任务已经是返工状态了,不能再返工');
        }



        $rs['mytypename'] = $this->getmytypename($rs['mytype']);

        $success = '<li class="h1">保存成功！</li>' . PHP_EOL;

        if ($isedit) {
            
        } else {
            $rs['suid'] = $this->main->user['id'];
            $rs['sname'] = $this->main->user['u_fullname'];

            $rs['stimeint'] = time();
            $rs['stime'] = date('Y-m-d H:i:s', $rs['stimeint']);

            $replyid = $this->main->pdo->insert(sh . '_retask', $rs);

            unset($rs);

            /* 如果是返工回复,then更新为返工状态 */
            if ('redo' == $mytype) {
                $rs['mystatus'] = "redo";
                $rs['mystatusname'] = "返工";

                $this->main->pdo->update(sh . '_task', $rs, ' id=' . $a_task['id']);

                $title = $this->main->user['u_fullname'] . '设为返工';
                $this->log($a_task['id'], $title);
            }



            /* ====更新原贴最后回复人和最后回复时间 */
            unset($rs);
            $rs['lasttimeint'] = time();
            $rs['lasttime'] = date('Y-m-d H:i:s', $rs['lasttimeint']);
            $rs['lastuname'] = $this->main->user['u_fullname'];

            $this->main->pdo->update(sh . '_task', $rs, ' id=' . $a_task['id']);

            /* ==== */
            $success .= '<li><a href="?id=' . $a_task['id'] . '">刷新页面</a></li>';

            $success .= '<li><a href="index.php">返回任务列表</a></li>';

            $success .= '<li><a href="detail.php?id="' . $a_task['id'] . '">预览任务</a></li>';

            ajaxinfo($success);
        }
    }

    function saveedit() {

        /* request */
        $rs['taskid'] = $this->main->rqid('taskid');
        $id = $this->main->rqid('id');

        $rs['title'] = $this->main->request('任务名', 'title', 'post', 'char', 1, 255, 'encode');
        $rs['mycontent'] = $this->main->request('内容', 'mycontent', 'post', 'char', 1, 25500);

        ajaxerr();


        /* 提取任务 */
        $a_task = $this->gettask($rs['taskid']);
        if (false == $a_task) {
            ajaxerr(1018);
        }


        /* 检测已完成的任务不能回复 */
        if ('over' == $a_task['mystatus']) {
            ajaxerr('这个任务已经完成了，不能修改回复');
        }


        /* 保存 */
        $this->main->pdo->update(sh . '_retask', $rs, ' id=' . $id);



        $success = '<li class="h1">保存成功！</li>' . PHP_EOL;

        $success .= '<li><a href="detail.php?id=' . $a_task['id'] . '">返回任务</a></li>';
        $success .= '<li><a href="index.php">返回任务列表</a></li>';

        $title = $this->main->user['u_fullname'] . '修改了回复，回复id=' . $id;

        $this->log($a_task['id'], $title);

        ajaxinfo($success);
    }

    /* 删除回复 */

    function delreply() {
        $id = $this->main->rqid('id');

        /* 检测发贴权限
         * 是我发的回复
         * 超管可以删除所有回复
         */

        $sql = 'delete from `' . sh . '_retask` where 1 ';
        $sql .= ' and id=' . $id;

        $this->main->execute($sql);

        htmlok();
    }

// end func

    function getmytypename($str) {
        switch ($str) {
            case 'message':
                $s = '留言';
                break;
            case 'redo':
                $s = '返工';
                break;
			case 'info':
				$s = '验收信息';
				break;
        }
        return $s;
    }

// end func
}

$Myclass = new Myclass();
unset($Myclass);

