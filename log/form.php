<?php

require '../global.php';
require sysdir . 'log/cls_log.php';

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

class Myclass extends Cls_log {

    function __construct() {
        parent::__construct();
        define('sp', 'log/_form');

		crumb('<a href="/log/">更新日志</a>');

        $act = $this->main->ract();

        switch ($act) {
            case 'creat':
                $this->myform(false);
                break;
            case 'nsave':
                $this->saveform(false);
                break;
        }

        san();
    }

    function myform($isedit) {

        $h = $this->main->htm('main');

        /* ====request */
        $id = $this->main->rqid();
        $classid = $this->main->rqid("classid");

        title('日志');
        
        $a_channel = $this->main->getarr( 'channel', null, $this->cic );


        $h = str_replace('{$optionclass}', $this->html->getoptionclassbychannel( $a_channel['id'] ), $h);
        $h = str_replace('{$classid}', $classid, $h);


        /* ==== */

      
		crumb('添加日志');

		$h = str_replace('{$action}', '?act=nsave', $h);
		$h = str_replace('{$isshow}', '1', $h);

		$h = $this->main->removemdbfield($h, sh . '_task');
 

        $this->html->addjs(webdir . 'ckeditor/ckeditor.js');

        $this->dohtml($h);
    }

    function saveform($isedit) {
        $rs['title'] = $this->main->request('Title', 'title', 'post', 'char', 1, 255, 'encode', true);
        $rs['classid'] = $this->main->rfid('classid');
    
		$rs['importantint'] = $this->main->rfid('importantint');      

        $rs['mycontent'] = $this->main->request('内容', 'mycontent', 'post', 'char', 1, 65535);

    

        ajaxerr();


        /* ====deal */
		if ($rs['classid']<0) {
			ajaxerr('请选择分类!');
		}

        $rs['classname'] = $this->getclassname($rs['classid']);

		if ( '' == $rs['mycontent']) {
			$rs['mycontent'] = $rs['title'];
		}

        $success = '<li class="h1">保存成功！</li>' . PHP_EOL;


		$rs['uid'] = $this->main->user['id'];
		$rs['unick'] = $this->main->user['u_fullname'];

		$rs['stimeint'] = time();
		$rs['stime'] = date('Y-m-d H:i:s', $rs['stimeint']);   



		$id = $this->main->pdo->insert(sh . '_updatelog', $rs);

		$success .= '<li><a href="index.php">返回日志列表</a></li>';

		ajaxinfo($success);
        
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

