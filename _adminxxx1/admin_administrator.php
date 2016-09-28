<?php

/**
 * 管理员管理.
 *
 * @author  syl
 * @version 1.0
 */
require('../global.php');
require (sysdirad.'inc/cls_ad.php');
crumb('管理员');

title('管理员');

define('sp', 'admin/_admin_administrator');

class Myclass extends Cls_ad {

    function __construct() {
        parent :: __construct();
        
        $act = $this->main->ract();

        switch ($act) {
            case '' : $this->Htmlmain();
                Break;
            case 'creat' : $this->MyForm(FALSE);
                break;
            case 'nsave' : $this->SaveForm(False);
                break;

            case 'del' : $this->DoDel();
                break;

            case 'edit' : $this->MyForm(TRUE);
                break; //修改管理员
            case 'esave' : $this->SaveForm(True);
                break;
            default : showerr(1022);
                break;
        }
        san();
    }


    function Htmlmain() {
        $h = $this->main->htm("main");
        $tli = $this->main->htm("li");

        $sql = 'select * from `' . sh . '_admin`';

        $li = $this->main->repm($sql, $tli);

        $h = str_replace('{$li}', $li, $h);

        $this->dohtml($h);
    }

// end func

    function MyForm($isedit) {
        $h = $this->main->htm('form');

        $h = str_replace('{$optiongroupadmin}', $this->GetOptionGroupAdmin(), $h);

        if ($isedit) {
            $id = $this->main->rqid();

            $h = str_replace('{$action}', '?act=esave&amp;id=' . $id, $h);

            $sql = 'select * from `' . sh . '_admin` where id=' . $id;

            $h = str_replace('{$th}', '修改管理员', $h);

            $h = $this->main->repm($sql, $h);
        } else {
            $h = str_replace('{$th}', '添加管理员', $h);

            $h = str_replace('{$action}', '?act=nsave', $h);
            $h = str_replace('{$cls}', '100', $h);

            $h = $this->main->removemdbfield($h, sh . '_admin');
        }

        echo $h;
    }

// end func

    function SaveForm($isedit) {
        $id = $this->main->rqid('id');

        $rs['u_name'] = $this->main->request('用户名', 'u_name', 'post', 'char', 5, 20, 'invalid'); //管理员和前台用户的用户名相同
        $rs['a_gic'] = $this->main->request('类型', 'a_gic', 'post', 'char', 2, 50); //管理员的等级

        $u_pass = $this->main->request('密码', 'u_pass', 'post', 'char', 5, 20, '', FALSE);
        $u_pass2 = $this->main->request('确认密码', 'u_pass2', 'post', 'char', 5, 20, '', FALSE);

        ajaxerr();


        //提取管理员用户组名称
        $sql = 'select title from `' . sh . '_group` where ic="' . $rs['a_gic'] . '" ';
        $at = $this->main->exeone($sql);
        $rs['a_gname'] = $at['title'];

        //检测两次输入密码一致
        if ($u_pass != $u_pass2) {
            ajaxerr('两次输入的密码不一致,请重新输入!');
        }


        //检测是否有这个用户, 有则取称呼, else 提示错误
        //	提取用户信息
        $rsuser = $this->GetUser($rs['u_name']);
        if ($rsuser === FALSE) {
            ajaxerr('用户' . $rs['u_name'] . '不存在, 请先添加用户, 再升级为管理员!');
        }

        $rs['u_id'] = $rsuser['id'];
        $rs['u_nick'] = $rsuser['u_nick'];
        $rs['u_gic'] = $rsuser['u_gic'];
        $rs['u_gname'] = $rsuser['u_gname'];


        //最后一次修改人信息
        $rs['euid'] = $this->main->u_id;
        $rs['enick'] = $this->main->u_nick;
        $rs['etime'] = time();


        if ($isedit) {
            if ('' != $u_pass) {
                //处理密码
                $rs['randcode'] = $this->main->generate_randchar();

                //密码 = md5(输入的密码 + 随机码)
                $rs['u_pass'] = md5($u_pass . $rs['randcode']);
            }

            $this->main->pdo->update(sh . '_admin', $rs, 'id=' . $id);
        } else {
            if ('' == $u_pass) {
                ajaxerr('请输入密码!');
            }

            //处理密码
            $rs['randcode'] = $this->main->generate_randchar();

            //密码 = md5(输入的密码 + 随机码)
            $rs['u_pass'] = md5($u_pass . $rs['randcode']);



            //检测管理组里是不是已经有这个管理员了
            $sql = 'select count(*) from `' . sh . '_admin` where u_name=:u_name limit 1';
            $sqlrs['u_name'] = $rs['u_name'];
            if ($this->main->rscount($sql, $sqlrs) > 0) {
                ajaxerr('已经有这个管理员了!');
            }

            $rs['stime'] = time();
            $id = $this->main->pdo->insert(sh . '_admin', $rs);
        }

        //更改这个人为管理员
        $sql = 'update `' . sh . '_user` set u_ismaster=1 where id=' . $id;
        $this->main->execute($sql);

        jsucok();
    }

    function DoDel() {
        $id = $this->main->rqid('id');

        //提取管理员信息
        $sql = 'select * from `' . sh . '_admin` where id=' . $id;

        $rsadmin = $this->main->exeone($sql);

        if ($rsadmin == FALSE) {
            ajaxerr(1018);
        }

        //更新这个用户为非管理员
        $sql = 'update `' . sh . '_user` set u_ismaster=0 where id=' . $rsadmin['u_id'];

        $this->main->execute($sql);

        //从管理员组删除这个管理员
        $sql = 'delete from `' . sh . '_admin` where id=' . $id;
        $this->main->execute($sql);

        htmlok();
    }

    /* ========================================================== */

    function GetOptionGroupAdmin() {
        $tli = '<option value="{$ic}">{$title}</option>' . PHP_EOL;

        $sql = 'select * from `' . sh . '_group` where typeid=1 order by cls asc, id asc';

        return $this->main->repm($sql, $tli);
    }

    function GetUser($u_name) {
        if (strlen($u_name) < 1) {
            return FALSE;
        }

        $sql = 'select * from `' . sh . '_user` where u_name=:u_name';

        $rssql['u_name'] = $u_name;

        $result = $this->main->exeone($sql, $rssql);

        if (count($result) < 1) {
            return FALSE;
        } else {
            return $result;
        }
    }

}


$Myclass = new Myclass();
unset ($Myclass);