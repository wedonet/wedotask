<?php

/**
 * 用户管理.
 *
 * @author  syl
 * @version 1.0
 */
require('../global.php');
require( sysdirad . 'inc/cls_ad.php');
require( sysdir . '_inc/cls_login.php');

title('用户管理');
crumb('<a href="?">用户管理</a>');

define('sp', 'admin/_admin_user');

class Myclass extends Cls_ad {

    function __construct() {
        parent::__construct();

        $this->c_login = new Cls_login();

        $act = $this->main->ract();
        switch ($act) {
            case '' : $this->Htmlmain();
                Break;
            case 'deluser' : $this->DoDelUser();
                break;

            case 'creat' : $this->myform(FALSE);
                break;
            case 'nsave' : $this->savenew(FALSE);
                break;

            case 'edit' : $this->myform(TRUE);
                break;
            case 'esave' : $this->saveedit();
                break;

            case 'ispass':
            case 'unpass':
            case 'islock':
            case 'unlock':
                $this->UpdateStatus($act);
                break;
            default :
                showerr(1022);
                break;
        }
        san();
    }

    function Htmlmain() {
        $h = $this->main->htm('main');
        $tli = $this->main->htm('li');

        $sql = 'select * from `' . sh . '_user` where isdel=0 ';
        $sql .= ' order by id desc';

        $li = $this->main->repm($sql, $tli, null, 0, true);

        $h = str_replace('{$li}', $li, $h);

        $h = str_replace('{$pagelist}', $this->main->pagelist(), $h);

        $this->dohtml($h);
    }

// end func

    /**
     * 删除用户.
     * @return  type    void
     */
    function DoDelUser() {
        /* 接收参数 */
        $id = $this->main->rqid('id');

        /* 不能删除wedonet */
        if (1 == $id) {
            showerr('不能删除这个管理员');
        }

        /* 不能删除管理员 */
//        $sql = 'select count(*) from `' . sh . '_admin` where u_id=' . $id;
//        if ($this->main->execount($sql) > 0) {
//            showerr("不能删除管理员");
//        }
//$sql = 'delete from `'.sh.'user` where id='.$id;
        $sql = 'update `' . sh . '_user` set isdel=1 where id=' . $id;
        $this->main->execute($sql);

        htmlok();
    }

    function myform($isedit) {
        $js = '';

        $h = $this->main->htm('myform');

        $h = str_replace('{$optiongroup}', $this->getoptiongroup(), $h);
        $h = str_replace('{$optiondepartment}', $this->getoptiondepartment(), $h);

        $h = str_replace('{$selface}', $this->html->selimg('u_face', 'u_face_show'), $h); //上传链接

        if ($isedit) {
            $id = $this->main->rqid('id');

            crumb('编辑用户');

            $h = str_replace('{$action}', '?act=esave&amp;id=' . $id, $h);

            $sql = 'select * from `' . sh . '_user` where id=' . $id;

            /* 编辑时禁止修改用户名 */
            $js .= '$("#u_name").attr("disabled", "disabled");' . PHP_EOL;

            $h = str_replace('{$js}', $js, $h);

            $h = $this->main->repm($sql, $h);
        } else {
            crumb('添加用户');

            $h = str_replace('{$action}', '?act=nsave', $h);

            $h = str_replace('{$u_face}', webdir . '_images/noface.png', $h);

            $h = $this->main->removemdbfield($h, sh . '_user');
        }

        $this->dohtml($h);
    }

// end func


    /* 2013-02-26 */

    function savenew() {
        $we = & $this->main;

        $rs['u_gic'] = $we->request('用户组', 'u_gic', 'post', 'char', 1, 20);
        $rs['u_name'] = $we->request('用户名', 'u_name', 'post', 'char', 5, 50, 'invalid');
        $rs['u_nick'] = $we->request('称呼', 'u_nick', 'post', 'char', 2, 20, 'invalid', FALSE);
        $rs['u_phone'] = $we->request('电话', 'u_phone', 'post', 'phone', 6, 20, '', false);
        $rs['u_mobile'] = $we->request('手机', 'u_mobile', 'post', 'mobile', 6, 20, '', false);
        $rs['u_mail'] = $we->request('邮箱', 'u_mail', 'post', 'mail', 6, 50);

        $rs['u_dic'] = $we->request('部门', 'u_dic', 'post', 'char', 1, 20);
        $rs['u_face'] = $we->request('头像', 'u_face', 'post', 'char', 6, 255, 'encode');
        $rs['u_fullname'] = $we->request('用户名', 'u_fullname', 'post', 'char', 2, 50, 'encode');


        $u_pass = $we->request('密码', 'u_pass', 'post', 'char', 5, 20, '', FALSE);
        $u_pass2 = $we->request('确认密码', 'u_pass2', 'post', 'char', 5, 20, '', FALSE);

        ajaxerr();

        if ($u_pass != $u_pass2) {
            ajaxerr('两次输入密码不同, 请重新输入', 'u_pass');
        }

        $rs['u_gname'] = $we->getarrvalue('group', $rs['u_gic'], 'title');
        $rs['u_dname'] = $we->getarrvalue('department', $rs['u_dic'], 'title');

        /* 检测用户名是否存在 */
        if ($this->c_login->hasname($rs['u_name'])) {
            ajaxerr('<li>您填写的用户名已经存在, 请重新填写</li>', 'u_name');
        }

        /* 检测手机是否存在 */
        if ($this->c_login->hasmobile($rs['u_mobile'])) {
            ajaxerr('<li>您填写的手机号已经存在, 请重新填写</li>', 'u_mobile');
        }

        /* 检测邮箱是否存在 */
        if ($this->c_login->hasmail($rs['u_mail'])) {
            ajaxerr('<li>您填写的邮箱已经存在, 请重新填写</li>', 'u_mail');
        }

        if ($rs['u_nick'] == '') {
            $rs['u_nick'] = substr($rs['u_mobile'], 0, 7) . $we->generate_randchar(4);
        }

//其它值
        /* $rs['u_face'] = '/_images/noface.png'; */

        $rs['u_err'] = 0;
        $rs['u_searchpasserr'] = 0;
        $rs['u_searchpasserrtime'] = time();


//最后一次修改人信息
        $rs['etime'] = time();
        $rs['euid'] = $this->main->u_id;
        $rs['enick'] = $this->main->u_nick;

//密码处理
        $rs['randcode'] = $we->generate_randchar(8);
        $rs['u_pass'] = md5($u_pass . $rs['randcode']);




//添加信息
        $rs['stime'] = time();
        $rs['suid'] = $this->main->u_id;
        $rs['snick'] = $this->main->u_nick;

//if 不需要审核
        $rs['ispass'] = 1;
        $rs['islock'] = 0;
        $rs['u_regtime'] = time();

        $id = $we->pdo->insert(sh . '_user', $rs);

        /* 更新这个用户组的会员数 */
        $sql = 'update `' . sh . '_group` set countuser= (select count(*) from ' . sh . '_user where u_gic="' . $rs['u_gic'] . '") where id=' . $id;
        $this->main->execute($sql);


        /* 成功提示 */
        autolocate(); //2秒后自动刷新

        $sucmsg = '<li class="h1"><a href="?">保存成功, 三秒后自动返回列表页</a></li>' . PHP_EOL;

        ajaxinfo($sucmsg);
    }

// end func

    function saveedit() {
        $we = & $this->main;

        $id = $this->main->rqid('id');

        $rs['u_gic'] = $we->request('用户组', 'u_gic', 'post', 'char', 1, 20);
        $rs['u_nick'] = $we->request('称呼', 'u_nick', 'post', 'char', 2, 20, 'invalid', FALSE);
        $rs['u_phone'] = $we->request('电话', 'u_phone', 'post', 'phone', 6, 20);
        $rs['u_mobile'] = $we->request('手机', 'u_mobile', 'post', 'mobile', 6, 20);
        $rs['u_mail'] = $we->request('邮箱', 'u_mail', 'post', 'mail', 6, 50);

        $rs['u_dic'] = $we->request('部门', 'u_dic', 'post', 'char', 1, 20);
        $rs['u_face'] = $we->request('头像', 'u_face', 'post', 'char', 6, 50, 'encode', FALSE);
        $rs['u_fullname'] = $we->request('姓名', 'u_fullname', 'post', 'char', 2, 50, 'encode');

        $u_pass = $we->request('密码', 'u_pass', 'post', 'char', 5, 20, '', FALSE);
        $u_pass2 = $we->request('确认密码', 'u_pass2', 'post', 'char', 5, 20, '', FALSE);

        ajaxerr();

        if ($u_pass != $u_pass2) {
            ajaxerr('两次输入密码不同, 请重新输入', 'u_pass');
        }


        /* 检测手机是否存在 */
        if ($this->c_login->hasmobile($rs['u_mobile'], $id)) {
            ajaxerr('<li>您填写的手机号已经存在, 请重新填写</li>', 'u_mobile');
        }

        /* 检测邮箱是否存在 */
        if ($this->c_login->hasmail($rs['u_mail'], $id)) {
            ajaxerr('<li>您填写的邮箱已经存在, 请重新填写</li>', 'u_mail');
        }

        if ($rs['u_nick'] == '') {
            $rs['u_nick'] = substr($rs['u_mobile'], 0, 7) . $we->generate_randchar(4);
        }

        if ($rs['u_face'] == '') {
            $rs['u_face'] = '/_images/noface.png';
        }


        $rs['u_err'] = 0;
        $rs['u_searchpasserr'] = 0;
        $rs['u_searchpasserrtime'] = time();


        /* 最后一次修改人信息 */
        $rs['etime'] = time();
        $rs['euid'] = $this->main->u_id;
        $rs['enick'] = $this->main->u_nick;

        /* 密码处理 */
        /* 检测两次输入密码是否一致 */
        /* 添加和密码不为空时重设密码 */
        if ($u_pass != '') {
            $rs['randcode'] = $we->generate_randchar(8);
            /* 对密码进行加密 */
            $rs['u_pass'] = md5($u_pass . $rs['randcode']);
        }

        $rs['u_gname'] = $we->getarrvalue('group', $rs['u_gic'], 'title');
        $rs['u_dname'] = $we->getarrvalue('department', $rs['u_dic'], 'title');


        $we->pdo->update(sh . '_user', $rs, ' id=' . $id);


        /* 更新这个用户组的会员数 */
        $sql = 'update `' . sh . '_group` set countuser= (select count(*) from ' . sh . '_user where u_gic="' . $rs['u_gic'] . '") where ic="' . $rs['u_gic'] . '"';
        $this->main->execute($sql);


        /* 成功提示 */
        autolocate(); //2秒后自动刷新

        $sucmsg = '<li class="h1"><a href="?">保存成功, 三秒后自动返回列表页</a></li>' . PHP_EOL;

        ajaxinfo($sucmsg);
    }

// end func

    function UpdateStatus($act) {
        $id = $this->main->rqid('id');

        $sql = 'update `' . sh . '_user` set ';
        switch ($act) {
            case 'ispass' :
                $sql .= 'ispass=1';
                break;
            case 'unpass':
                $sql .= 'ispass=0';
                break;
            case 'islock':
                $sql .= 'islock=1';
                break;
            case 'unlock':
                $sql .= 'islock=0';
                break;
        }

        $sql .= ' where id=' . $id;

        $this->main->execute($sql);

        htmlok();
    }

// end func


    /* ============================================================================= */

    function getoptiongroup() {
        $li = '';

        $tli = '<option value="{$ic}">{$title}</option>' . PHP_EOL;

        $rs = $this->main->getarr("group");

        foreach ($rs as $v) {
            if ($v['ic'] != 'guest') {
                $s = $tli;
                $s = str_replace('{$ic}', $v['ic'], $s);
                $s = str_replace('{$title}', $v['title'], $s);
                $li .= $s;
            }
        }
        return $li;
    }

    function getoptiondepartment() {
        $li = '';

        $tli = '<option value="{$ic}">{$title}</option>' . PHP_EOL;

        $rs = $this->main->getarr("department");

        foreach ($rs as $v) {
            if ($v['ic'] != 'guest') {
                $s = $tli;
                $s = str_replace('{$ic}', $v['ic'], $s);
                $s = str_replace('{$title}', $v['title'], $s);
                $li .= $s;
            }
        }
        return $li;
    }

// end func
}

$Myclass = new Myclass();
unset($Myclass);
