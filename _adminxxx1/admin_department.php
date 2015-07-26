<?php

require('../global.php');
require( sysdirad .'inc/cls_ad.php' ); //管理文件夹的main

define('sp', 'admin/_admin_department');



class Myclass extends Cls_ad{

    function __construct() {
        parent::__construct();

        crumb('部门');

        $act = $this->main->ract();

        switch ($act) {
            case '' : $this->Main();
                break;
            case 'creat' : $this->MyForm(false);
                break;
            case 'nsave' : $this->SaveForm(false);
                break;

            case 'edit' : $this->MyForm(true);
                break;
            case 'esave' : $this->SaveForm(true);
                break;
            case 'del' : $this->DoDel();
                break;
        }
        san();
    }

    /* =========================================================== */

    function Main() {
        $h = $this->main->htm( 'main');
        $tli = $this->main->htm( 'li');

        title('部门');

        $sql = 'select * from `' . sh . '_department` where 1 ';
        $sql .= ' order by cls asc,id asc';

        $li = $this->main->repm($sql, $tli);

        $h = str_replace('{$li}', $li, $h);

        $this->dohtml($h);  
    }

    function MyForm($isedit) {
        $h = $this->main->htm('form');

        if ($isedit) {
            $id = $this->main->rqid('id');

            $sql = 'select * from `' . sh . '_department` where id=:id';
            $para[':id'] = $id;

            $h = str_replace('{$th}', '编辑部门', $h);
            $h = str_replace('{$action}', '?act=esave&amp;id=' . $id, $h);
            $h = $this->main->repm($sql, $h, $para);
        } else {
            $h = str_replace('{$th}', '添加部门', $h);
            $h = str_replace('{$action}', '?act=nsave', $h);
            $h = str_replace('{$cls}', '100', $h);

            $h = $this->main->removemdbfield($h, sh . '_department');
        }

        echo $h;
    }

    function SaveForm( $isedit ) {
        $id = $this->main->rqid('id');

        $rs['title'] = $this->main->request('名称', 'title', 'post', 'char', 1, 50, 'encode');
        $rs['ic'] = $this->main->request('编码', 'ic', 'post', 'char', 1, 20, 'invalid');
        $rs['cls'] = $this->main->rfid('cls', 100);
        $rs['isuse'] = $this->main->rfid('isuse', 1);

        ajaxerr();

        /* 检测编号有重复 */
        if ($this->main->rscount('select count(*) from `' . sh . '_department` where id <> ' . $id . ' and ic="' . $rs['ic'] . '"') > 0) {
            ajaxerr('编号重复请重新输入');
        }


        if ($isedit) {
            $t = $this->main->pdo->update(sh . '_department', $rs, 'id=' . $id);
        } else {
            $this->main->pdo->insert(sh . '_department', $rs);
        }

        $this->main->deletecache('department');

        jsucok();
    }

    function DoDel() {
        /* 检查是否系统部门 */
        $id = $this->main->rqid('id');
        
        /*提取这个部门*/
        $sql = 'select ic from `'.sh.'_department` where id='.$id;
        $result = $this->main->exeone($sql);
        if (false === $result ){
            showerr('没找到这个部门！');
        }

   

        /* 检测还有没有这个部门的会员 */
        if ( $this->hasuseroftherdepartment($result['ic']) ){
            showerr('这个部门下面还有会员了, 请先删除相应会员或转移到其它部门!'); 
        }
       

        /* 执行删除 */
        $sql = 'delete from `' . sh . '_department` where id=' . $id;

        $t = $this->main->execute($sql);

        $this->main->deletecache('group');

        htmlok();
    }
    
    /*return bool 
     * 有这个组的用户时返回true,否则返回false
     */
    function hasuseroftherdepartment( $dic ){
        $sql = 'select count(*) from `' . sh . '_user` where u_dic ="'.$dic.'" ';
 
        $result = $this->main->execount($sql);

        if ( $result > 0 ) {
            return true;
        }
        else{
            return false;
        }
    }

}

$myclass = new Myclass();