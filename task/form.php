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
        define('sp', 'task/_form');

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
			case 'more':
				$this->findmore();
				break;
			case 'savemore':
				$this->savemore();
				break;
        }

        san();
    }

    function myform($isedit) {
		$js = '';
		$cuids = '';
		$duids = '';

		$a_user = array(); //向后台传递的用户信息

        $h = $this->main->htm('main');

        /* ====request */
        $id = $this->main->rqid();
        $classid = $this->main->rqid("classid");

        title('任务');
        
        $a_channel = $this->main->getarr( 'channel', null, $this->cic );

        $h = str_replace('{$optiondepartment}', $this->getoptiondepartment(), $h);
        $h = str_replace('{$checkboxduid}', $this->checkboxuser('duids[]', 'd'), $h);
        $h = str_replace('{$checkboxcuid}', $this->checkboxuser('cuids[]', 'c'), $h);
        $h = str_replace('{$optionclass}', $this->html->getoptionclassbychannel( $a_channel['id'] ), $h);
        $h = str_replace('{$classid}', $classid, $h);

		
		


		$a_user['myuser'] = $this->getmyuser();//显示出我的常用执行人，验收人


        /* ==== */

        if (true == $isedit) {
            crumb('修改任务');

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


			$a_user['c_uids'] = $result['cuids'];
			$a_user['d_uids'] = $result['duids'];

            $h = str_replace('{$action}', '?act=esave&amp;id=' . $id, $h);

            /* 替换记录内容 */
            $h = str_replace('{$mycontent_htmlencode}', htmlencode($result['mycontent']), $h);
            $h = $this->main->reprscolumn($result, sh . '_task', $h);
        } else {
            crumb('添加任务');

            $h = str_replace('{$action}', '?act=nsave', $h);
            $h = str_replace('{$isshow}', '1', $h);

            $h = $this->main->removemdbfield($h, sh . '_task');
        }


		$h = str_replace('{$js}', $js, $h);

		$h = str_replace('{$json_user}', json_encode($a_user), $h); //常用联系人
		//已选择的执行人
		//已选择的检测人

        $this->html->addjs(webdir . 'ckeditor/ckeditor.js');

        $this->dohtml($h);
    }

    function saveform($isedit) {
        $rs['title'] = $this->main->request('任务名', 'title', 'post', 'char', 1, 255, 'encode');
        $rs['classid'] = $this->main->rfid('classid');
        $rs['dic'] = $this->main->request('部门', 'dic', 'post', 'char', 1, 50, 'invalid');
        //$rs['duids'] = $this->main->request('执行人', 'duids[]', 'cb', 'char', 1, 255, 'envalid', false);
        //$rs['cuids'] = $this->main->request('验收人', 'cuids[]', 'cb', 'char', 1, 255, 'envalid', false);
        $rs['duids'] = $this->main->ridlist('duids');
        $rs['cuids'] = $this->main->ridlist('cuids');

        $rs['zhongyao'] = $this->main->rfid('zhongyao');
        $rs['jinji'] = $this->main->rfid('jinji');

        $rs['plantime'] = $this->main->request('计划完成时间', 'plantime', 'post', 'date', 1, 20, '', false);
        $rs['isshow'] = $this->main->rfid('isshow');

        $rs['mycontent'] = $this->main->request('内容', 'mycontent', 'post', 'char', 1, 65535);

        $rs['mytype'] = $this->main->request('类型', 'mytype', 'post', 'char', 1, 25500, 'invalid');

        ajaxerr();


        /* ====deal */
        if ($rs['classid'] > 0) {
            $rs['classname'] = $this->getclassname($rs['classid']);
        } else {
            $rs['classname'] = '';
        }
        $rs['dname'] = $this->getdepartmentname($rs['dic']);
        $rs['dunames'] = $this->getusernamelist($rs['duids']);
        $rs['cunames'] = $this->getusernamelist($rs['cuids']);

        if ('' !== $rs['plantime']) {
            $rs['plantimeint'] = strtotime($rs['plantime']);
        }
        $rs['mytypename'] = $this->getmytypename($rs['mytype']);

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

            $success .= '<li><a href="index.php">返回任务列表</a></li>';

            $success .= '<li><a href="detail.php?id=' . $id . '&amp;ispre=1">预览任务</a></li>';

            ajaxinfo($success);
        } else {
			$rs['myrange'] = '';

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

            $success .= '<li><a href="index.php">返回任务列表</a></li>';

            $success .= '<li><a href="detail.php?id=' . $id . '&amp;ispre=1">预览任务</a></li>';

            ajaxinfo($success);
        }
    }


    function getoptiondepartment() {
        $tli = '<option value="{$ic}">{$title}</option>' . PHP_EOL;

        $sql = 'select * from `' . sh . '_department` where 1 order by cls asc';

        $li = $this->main->repm($sql, $tli);

        return $li;
    }

	/*name:字段名
	* mytype: 
	* dealuidlist = 处理人idlist, 用d表示
	* checkuidlist = 检测人idlist， 用c表示
	*/
    function checkboxuser_($name, $mytype) {
        $tli = '<input type="checkbox" name="'.$name.'" value="{$id}" class="vmiddle" /> {$u_fullname} &nbsp; &nbsp;  ' . PHP_EOL;

		/*取我的常用人id*/
		$sql = 'Select myidlist from `'.sh.'_myuser` where 1 ';
		$sql .= ' and mytype="'.$mytype.'"';
		$sql .= ' and uid='.$this->main->user['id'];

		$a = $this->main->exeone($sql);

		if ( false !== $a ) {
			$sql = 'select * from `' . sh . '_user` where 1 ';
			$sql .= ' and isdel=0 ';
			$sql .= ' and ispass=1 ';
			$sql .= ' and id in('.$a['myidlist'].')';

			$li = $this->main->repm($sql, $tli);
		}
		else{
			$li = '';
		}


        return $li;
    }

    function checkboxuser($name, $mytype) {
        $tli = '<span style="display:none" id="j_'.$mytype.'_{$id}"><input type="checkbox" name="'.$name.'" value="{$id}" class="vmiddle"  /> {$u_fullname} &nbsp; &nbsp;  </span>' . PHP_EOL;


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

	
	function findmore()
	{
		$h = $this->main->htm("formmore");
		$tli = $this->main->htm("formmoreli");

		$mytype = $this->main->request('类型', 'mytype', 'get', 'char', 1, 20);

		/*提取已选的人*/
		$sql = 'select myidlist from `'.sh.'_myuser` where 1';
		$sql .= ' and mytype="'.$mytype.'"';
		$sql .= ' and uid='. $this->main->user['id'];

		$a = $this->main->exeone($sql);

		if ( false !== $a ) {
			$myidlist = $a['myidlist'];
		}
		else{
			$myidlist = '';
		}



	    $sql = 'select * from `' . sh . '_user` where 1 ';
        $sql .= ' and isdel=0 ';
        $sql .= ' and ispass=1 ';
		/*并且不在常用联系人*/
		$sql .= ' and id not in('.$myidlist.')';
		

		$li = $this->main->repm($sql, $tli);

		$h = str_replace('{$mytype}', $mytype, $h);
		$h = str_replace('{$li}', $li, $h);
		$h = str_replace('{$action}', 'form.php?act=savemore&amp;mytype='.$mytype, $h);



		echo $h;
	} 

	
	function getmyuser(){

		$sql = 'select * from `'.sh.'_myuser` where uid='.$this->main->user['id'];

		$a = $this->main->executers($sql);		

		return $a;	
	} 
	
	
}

$Myclass = new Myclass();
unset($Myclass);

