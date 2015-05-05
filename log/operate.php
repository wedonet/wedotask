<?php

require '../global.php';
require sysdir . 'task/cls_task.php';

class Myclass extends Cls_task {

    function __construct() {
        parent::__construct();

        define('sp', 'log/_operate');

        $act = $this->main->ract();

        switch ($act) {
            case 'publish':
                $this->funpublish();
                break;
            case 'doing' :
                $this->fundoing();
                break;
            case 'done':
                $this->fundone();
                break;
            case 'redo':
                $this->funredo();
                break;
            case 'checked':
                $this->funchecked();
                break;
            case 'ok':
                $this->funok();
                break;
			case 'cancel':
				$this->funcancel();
				break;
            case 'del':
                $this->deltask();
                break;
        }

        san();
    }

    function funpublish() {
        $id = $this->main->rqid();

        $a_task = $this->gettask($id);

        /* 检测是不是我自已的任务 */
        if ($a_task['suid'] !== $this->main->user['id']) {
            ajaxerr('您不是任务执行人');
        }

        /* 检测任务状态是否允许改为正式发布 */
        if ('0' !== $a_task['isshow'] . '') {
            ajaxerr('草稿才能发布');
        }

        $rs["isshow"] = 1;


        /* 更新任务状态 */
        $rs['ptimeint'] = time();
        $rs['ptime'] = date('Y-m-d H:i:s', $rs['ptimeint']);

        $this->main->pdo->update(sh . '_task', $rs, ' id=' . $id);

        /* lgo */
        $title = $this->main->user['u_fullname'] . '发布任务';
        $this->log($id, $title);

        /*一秒后转向任务首页*/
        autolocate('index.php', 500);
        
        $sucmsg = '<li class="h1">发布成功！</li>'.PHP_EOL;
        $sucmsg .= '<li>一秒后转向任务列表</li>'.PHP_EOL;
        
        ajaxinfo( $sucmsg );
    }

    function fundoing() {
        $id = $this->main->rqid();

        $a_task = $this->gettask($id);

        /* 检测是不是我自已的任务 */
        if (!$this->main->ins($a_task['duids'], $this->main->user['id'])) {
            ajaxerr('您不是任务执行人');
        }

        /* 检测任务状态是否允许改为正在执行 */
        if ('new' !== $a_task['mystatus']) {
            ajaxerr('新任务才能执行');
        }

        /* 检测草稿不允许执行 */
        if ('1' !== $a_task['isshow']) {
            ajaxerr('草稿不能执行');
        }



        /* 更新任务状态 */
        $dtimesint = time();
        $dtimes = date('Y-m-d H:i:s', $dtimesint);

        $rs['mystatus'] = 'doing';
        $rs['mystatusname'] = 'Doing';
        $rs['dtimesint'] = $dtimesint;
        $rs['dtimes'] = $dtimes;


        $this->main->pdo->update(sh . '_task', $rs, ' id=' . $id);

        /* lgo */
        $title = $this->main->user['u_fullname'] . '更新任务为开始执行';
        $this->log($id, $title);

        jsucok();
    }

    function fundone() {
        $id = $this->main->rqid();

        $a_task = $this->gettask($id);

        /* 检测是不是我自已的任务 */
        if (!$this->main->ins($a_task['duids'], $this->main->user['id'])) {
            ajaxerr('您不是任务执行人');
        }

        /* 检测任务状态是否允许改为完成 */
        if ('doing' !== $a_task['mystatus'] And 'redo' !== $a_task['mystatus']) {
            ajaxerr('新任务和返工任务才能完成');
        }


        /* 更新任务状态 */
        $sql = 'update `' . sh . '_task` set mystatus="done",mystatusname="完成" where id=' . $id;


        $this->main->execute($sql);

        /* lgo */
        $title = $this->main->user['u_fullname'] . '更新任务为完成';
        $this->log($id, $title);

        jsucok();
    }

    function funredo() {
        $id = $this->main->rqid();

        /* 提取这个任务 */

        /* 检测我是不是检测人 */

        /* 检测我是不是已经审核过了 */

        /* 检测任务状态是否允许改为正在执行 */



        /* 更新任务状态 */
        $sql = 'update `' . sh . '_task` set mystatus="redo",mystatusname="返工" where id=' . $id;

        $this->main->execute($sql);

        jsucok();
    }

    /* 删除任务 */

    function deltask() {
        $id = $this->main->rqid('id');

        /* 只有管理员能删除 */
        if (!$this->main->ins('supperadmin,admin', $this->main->user['u_gic'])) {
            showerr('您没有删除权限,请联系管理员删除!');
        }

        /* 更新为删除状态 */
        $sql = 'update `' . sh . '_updatelog` set isdel=1 where id=' . $id;

        $this->main->execute($sql);

        jsucclose();
    }

    /* 检测通过 */

    function funok() {
        $id = $this->main->rqid();

        $a_task = $this->gettask($id);

        /* 检测是不是我自已的任务 */
        if (!$this->main->ins($a_task['cuids'], $this->main->user['id'])) {
            ajaxerr('您不是任务验收人');
        }

        /* 检测任务状态是否允许改为正在执行 */
        if ('done' !== $a_task['mystatus']) {
            ajaxerr('已完成的任务才能检测!');
        }

        /* 检测 已验收人里有没有我 */
        if ($this->main->ins($a_task['actualcuids'], $this->main->user['id'])) {
            ajaxerr('您已经验收过了,不需要重复验收');
        }


        /* 追加进已验收人 */
        if ('' == $a_task['actualcuids']) {
            $a_task['actualcuids'] = ',';
            $a_task['actualcnames'] = '';
        }
        $rs['actualcuids'] = $a_task['actualcuids'] . $this->main->user['id'] . ',';
        $rs['actualcnames'] = $this->getusernamelist($rs['actualcuids']);

        $title = $this->main->user['u_fullname'] . '完成检测';

        /* if 都检测完了 then 更新为结贴 */
        $a_task['actualcuids'] = $rs['actualcuids'];
        $a_task['actualcnames'] = $rs['actualcnames'];

        if (strlen($a_task['cuids']) == strlen($a_task['actualcuids'])) {
            $rs['mystatus'] = "over";
            $rs['mystatusname'] = "结束";

            $rs['actualtimeint'] = time();
            $rs['actualtime'] = date('Y-m-d H:i:s', $rs['actualtimeint']);

            $title .= '最后一个验收人已通过验证,更新为结束';
        }


        try {
            $this->main->pdo->begintrans();

            $this->main->pdo->update(sh . '_task', $rs, ' id=' . $id);

            /* lgo */
            $this->log($id, $title);

            $this->main->pdo->submittrans();
        } catch (PDOException $e) {
            ajaxerr($e);
            $this->main->pdo->rollbacktrans();
        }


        jsucok();
    }

    /* temp */

    function ismytask() {
        return true;
    }



    function ischeckover($cuids, $actualcuids) {
        
    }


	
	function funcancel()
	{
        $id = $this->main->rqid();

        $a_task = $this->gettask($id);

        if (!$this->main->ins('supperadmin,admin', $this->main->user['u_gic'])) {
            showerr('您没有取消权限');
        }

		/*检测结束和取消的单子, 不能取消*/
		if ( 'over'==$a_task['mystatus'] Or 'cancel'==$a_task['mystatus'] ) {
			ajaxerr('这个任务已取消或结束不能取消');
		}



        $rs['mystatus'] = "cancel";
        $rs['mystatusname'] = "取消";

        $title = $this->main->user['u_fullname'].'取消了这个任务';
  


        try {
            $this->main->pdo->begintrans();

            $this->main->pdo->update(sh . '_task', $rs, ' id=' . $id);

            /* lgo */
            $this->log($id, $title);

            $this->main->pdo->submittrans();
        } catch (PDOException $e) {
            ajaxerr($e);
            $this->main->pdo->rollbacktrans();
        }


        jsucok();		
	} 

}

$Myclass = new Myclass();
unset($Myclass);

