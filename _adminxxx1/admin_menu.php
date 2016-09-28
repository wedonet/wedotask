<?php

require('../global.php');
require( sysdirad . 'inc/cls_ad.php' ); //管理文件夹的main

define('sp', 'admin/_admin_menu');

crumb('功能和权限');

class Myclass extends Cls_ad {

    function __construct() {
        parent :: __construct();
        $this->main = & $GLOBALS['main'];

        $act = $this->main->ract();

        switch ($act) {
            case '' : $this->Main();
                break;
            case 'creat' : $this->Myform(false);
                break;
            case 'nsave' : $this->SaveForm(false);
                break;

            case 'edit' : $this->Myform(true);
                break;
            case 'esave' : $this->SaveForm(true);
                break;

            case 'del' : $this->DoDel();
                break;

            case 'savepower' : $this->SavePower();
                break;
        }
        san();
    }

// end func

    function main() {
        $h = $this->main->htm('main');
        $tli = $this->main->htm('li');

        $sql = 'select * from `' . sh . '_menu` order by cls asc, id asc';
        $rsmenu = $this->main->executers($sql);

        /* get 管理员用户组 */
        $sql = 'select * from `' . sh . '_group` where typeid=1 and id>1 order by cls asc, id asc';
        $rsgroup = $this->main->executers($sql);

        $li = $this->getlist($rsmenu, $rsgroup, $tli);

        $h = str_replace('{$li}', $li, $h);


        $this->dohtml($h);
    }

    function myform($isedit) {
        $js = '';

        $h = $this->main->htm('form');
        $cid = $this->main->rqid('cid');
        $plusid = $this->main->request('插件ID', 'plusid', 'get', 'char', 1, 50, 'invalid', FALSE);

        if ($isedit) {
            $id = $this->main->rqid('id');
            //$pid = $this->main->rqid('pid');	
            $sql = 'select * from `' . sh . '_menu` where id=' . $id;

            $result = $this->main->exeone($sql);

            if (false === $result) {
                ajaxerr(1018);
            }

            //$a = $this->main->replacemdb($sql, $h, null, 0, false, 'pid');

            $h = str_replace('{$id}', $id, $h);

            $h = str_replace('{$cid}', $result['cid'], $h); //cid要放在titlecode,urlcode前面，因为title里如果有cid,不能被替换
            $h = str_replace('{$title}', $result['title'], $h);
            $h = str_replace('{$titlecode}', $result['titlecode'], $h);
            $h = str_replace('{$urlcode}', $result['urlcode'], $h);
            $h = str_replace('{$url}', $result['url'], $h);

            $h = str_replace('{$cls}', $result['cls'], $h);

            $h = str_replace('{$plusid}', $result['plusid'], $h);
            $h = str_replace('{$para}', $result['para'], $h);

            $pid = $result['pid'];

            $h = str_replace('{$action}', '?act=esave&amp;id=' . $id . '&amp;pid=' . $pid, $h);
        } else {
            $pid = $this->main->rqid("pid");
            $h = str_replace('{$action}', '?act=nsave', $h);
            $h = str_replace('{$cls}', '100', $h);
            /* 有频道id时子菜单默认继承频道ID */
            if ($cid > 0) {
                $h = str_replace('{$cid}', $cid, $h);
            }
            /* 有插件ID时子菜单默认继承插件ID */
            if (strlen($plusid) > 0) {
                $h = str_replace('{$plusid}', $plusid, $h);
            }

            $h = $this->main->removemdbfield($h, sh . '_menu');
        }

        $b = $this->getoptionpid($pid, $js);

        $h = str_replace('{$optionpid}', $b['li'], $h);
        $h = str_replace('{$js}', $b['js'], $h);
        echo $h;
    }

// end func

    function saveform($isedit) {
        $we = & $this->main;

        $id = $we->rqid('id');
        $pid = $we->rfid('pid');

        $titlecode = $we->request('名称', 'titlecode', 'post', 'char', 2, 50, 'encode');
        $urlcode = $we->request('地址', 'urlcode', 'post', 'char', 2, 50, '', false);
        $para = $we->request('参数', 'para', 'post', 'char', 2, 255, '', false);
        $cls = $we->request('排序', 'cls', 'post', 'num', 1, 9999, '', false);

        $mycid = $we->rfid('mycid', 0);
        $plusid = $we->request('插件ID', 'plusid', 'post', 'char', 1, 255, 'invalid', FALSE);

        ajaxerr();

        $title = $titlecode;
        $url = $urlcode.$para;

        /* 如果titlecode里有频道信息, then生成格式化后的title */
        if ($mycid > 0) {
            $a_channel = $this->main->getarr('channel', $mycid);

            if (false === $a_channel) {
                ajaxerr('频道号错误!');
            }

            //格式化
            $title = str_replace('{$cid}', $mycid, $title);
            $title = str_replace('{$channelname}', $a_channel['title'], $title);
            $title = str_replace('{$channelunit}', $a_channel['cha_unit'] . '', $title);

            $url = str_replace('{$cid}', $mycid, $url);
        }



        $rs['title'] = $title;
        $rs['titlecode'] = $titlecode;
        $rs['url'] = $url;
        $rs['urlcode'] = $urlcode;
        $rs['para'] = $para;
        $rs['cls'] = $cls;

        $rs['cid'] = $mycid;
        $rs['plusid'] = $plusid;


        $rs['pid'] = $pid;

        try {
            $we->pdo->begintrans();

            if ($isedit) {
                /* 提取pid, idpath */
                $sql = 'select pid,idpath from `' . sh . '_menu` where id=' . $id;
                $t_ = $we->executers($sql);
                $t = $t_[0];

                $sourcepid = $t['pid'];
                $sourceidpath = $t['idpath'];

                $we->pdo->update(sh . '_menu', $rs, 'id=' . $id);
            } else {
                $sourcepid = $pid;
                $sourceidpath = null;

                $id = $we->pdo->insert(sh . '_menu', $rs);
            }

            /* 更新idpath */
            $this->updateidpath($isedit, $sourcepid, $pid, $sourceidpath, $id);
            $we->pdo->submittrans();
        } catch (PDOException $e) {
            $we->pdo->rollbacktrans();
            showerr($e);
        }
        /* 提示信息 */
        //$suc = '<li>操作成功!</li>'.PHP_EOL;
        //$suc .= '<li><a href=''?''>刷新网页</a></li>'.PHP_EOL;
        jsucok();
    }

    // end func
    //删除功能菜单
    function DoDel() {
        $id = $this->main->rqid('id');

        /* getidpath */
        $sql = 'select idpath from ' . sh . '_menu where id=' . $id;
        $rs_ = $this->main->executers($sql);
        $rs = $rs_[0];

        if (0 == count($rs)) {
            showerr(1018);
        } else {
            $idpath = $rs['idpath'];
        }

        $sql = 'delete from ' . sh . '_menu where idpath like "' . $idpath . '%"';

        $mycount = $this->main->execute($sql);

        htmlok();
    }

// end func


    /* 保存权限 */

    function SavePower() {
        $sql = 'select id from ' . sh . '_menu';

        $rs = $this->main->executers($sql);

        for ($i = 0; $i < count($rs); $i++) {
            $myid = $rs[$i]['id'];

            $mypower = $this->main->request('', 'power_' . $myid, 'cb', 'char', 0, 255, '', false);

            $sql = 'update `' . sh . '_menu` set power="' . $mypower . '" where id=' . $rs[$i]['id'];

            $this->main->execute($sql);
        }

        jsucclose();
    }

// end func







    /* ================================================================== */
    /* 递规实现 */

    function getlist($rsmenu, $rsgroup, $tli, $pid = 0, $depth = 0) {
        $countmenu = count($rsmenu);

        $li = '';
        //$channel = $this->main->getarr('channel');

        /* 循环管理菜单 */
        if ($countmenu > 0) {
            for ($i = 0; $i < $countmenu; $i++) {
                if ($pid == $rsmenu[$i]['pid']) {
                    $s = $tli;
                    $s = str_replace('{$id}', $rsmenu[$i]['id'], $s);
                    $s = str_replace('{$cid}', $rsmenu[$i]['cid'], $s);
                    $s = str_replace('{$plusid}', $rsmenu[$i]['plusid'], $s);
                    $s = str_replace('{$title}', $rsmenu[$i]['title'], $s);
                    $s = str_replace('{$cls}', $rsmenu[$i]['cls'], $s);
                    $s = str_replace('{$depth}', $depth, $s);

                    $s = str_replace('{$url}', $rsmenu[$i]['url'], $s);
					$s = str_replace('{$urlcode}', $rsmenu[$i]['urlcode'], $s);
                    $s = str_replace('{$para}', $rsmenu[$i]['para'], $s);

                    $s = str_replace('{$depth}', $depth, $s);
                    $s = str_replace('{$grouppower}', $this->formatgroup($rsgroup, $rsmenu[$i]), $s);

                    /* 递归下去 */
                    $s .= $this->getlist($rsmenu, $rsgroup, $tli, $rsmenu[$i]['id'], $depth + 1);



                    /* 替换频道信息 */
                    //				if (strlen() {
                    //				
                    //				}
                    //							If len(node.getAttribute("cid"))>0 Then 
                    //				If node.getAttribute("cid")>0 Then 
                    //					s = ReplaceChannelInfo(s, node.getAttribute("cid"))
                    //				End If 
                    //			End If 

                    $li.=$s;
                }
            }
        }
        return $li;
    }

// end func getlist

    function updateidpath($isedit, $sourcepid, $currentpid, $sourceidpath, $myid) {
        if ($isedit) {
            if ($sourcepid != $currentpid) {
                /* 取新的父id的idpath */
                $sql = 'select idpath from ' . sh . "_menu where id=" . $currentpid;
                $rs = $this->main->exeone($sql);
                //stop($sql);
                //print_r(false == $rs);
                //die;
                //	  ['rs']['idpath'];
                $newidpath = $rs['idpath'];

                $idpath = $newidpath . $myid . ',';

                /* 更新我的idpath */
                $sql = 'update ' . sh . '_menu set idpath="' . $idpath . '" where id=' . $myid;
                $this->main->execute($sql);

                /* 更新以前我的子记录 */
                $sql = 'select id,idpath from ' . sh . '_menu where idpath like "' . $sourceidpath . '%"';
                $rs = $this->main->executers($sql);

                if (count($rs) > 0) {
                    for ($i = 0; $i < count($rs); $i++) {
                        $currentidpath = str_replace($sourceidpath, $idpath, $rs[$i]['idpath']);
                        $sql = 'update `' . sh . '_menu` set idpath="' . $currentidpath . '" where id=' . $rs[$i]['id'];
                        $this->main->execute($sql);
                    }
                }
            }
        } else {
            if ('0' === $currentpid) {
                $idpath = $myid . ',';
            } else { //idpath = 父id的idpath + 自已
                $sql = 'select idpath from ' . sh . '_menu where id=' . $currentpid;
                $result = $this->main->exeone($sql);
                $idpath = $result['idpath'] . $myid . ',';
            }

            $sqlstr = 'update `' . sh . '_menu` set `idpath`="' . $idpath . '" where id=' . $myid;

            $this->main->execute($sqlstr);
        }
    }

    function getoptionpid($pid, $js) {
        $tli = '<option value="{$id}">{$title}</option>' . PHP_EOL;

        if (0 == $pid) {
            $li = $tli;
            $li = str_replace('{$id}', '0', $li);
            $li = str_replace('{$title}', '', $li);
            $js = '$("#linepid").hide();' . PHP_EOL;
        } else {
            $sql = 'select * from `' . sh . '_menu` where pid=(Select pid from ' . sh . '_menu where id=' . $pid . ')';
            $li = $this->main->repm($sql, $tli);
            //$js .= '$("#pid").val("'.$pid.'");';		
        }

        $b['li'] = $li;
        $b['js'] = $js;

        return $b;
    }

// end func

    function formatgroup($rsgroup, $amenu) {
        //循环用户组
        $mycount = count($rsgroup);

        $s = '';

        for ($i = 0; $i < $mycount; $i++) {
            if ($this->main->ins($amenu['power'], $rsgroup[$i]['ic'])) {
                $checked = ' checked="checked"';
            } else {
                $checked = '';
            }

            $s .= '<input type="checkbox" name="power_' . $amenu['id'] . '[]"  value="' . $rsgroup[$i]['ic'] . '" ' . $checked . ' class="vmiddle" /> ' . $rsgroup[$i]['title'] . ' &nbsp;&nbsp;&nbsp; ' . PHP_EOL;
        }

        return $s;
    }

// end func
}

// end class


$Myclass = new Myclass;
unset($Myclass);