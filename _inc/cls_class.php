<?php

/**
 * 频道分类管理
 *
 * @YilinSun
 * @version 1.0
 */
//define('sp', 'admin/_admin_class');

class Cls_class {

    Public $cid = 0;
    Public $module = ''; //模块,用于在一个频道下的多种分类方式
    public $channel;
    
    function __construct() {
        $this->main = & $GLOBALS['main'];
    }

    function Main() {
        
        
        //传过来的是编码,转成id
//	if ( '' != $this->cic ) {
//		$this->channel = $GLOBALS['we']->getarr('channel', null, $this->cic);
//		$this->cid = $this->channel['id'];
//	}
//	elseif ( $this->cid > 0 ) {
//		$this->channel = $GLOBALS['we']->getarr('channel', $this->cid);
//		$this->cic = $this->channel['ic'];
//	}
//
//
//	if ( is_array($this->channel) ) {
//		crumb($this->channel['title']);
//		crumb('<a href="?cid='.$this->cid.'">分类管理</a>');	
//	}





        $act = $GLOBALS['we']->ract();

        switch ($act) {
            case '' : $this->ShowList();
                break;
            case 'creat' : $this->MyForm(FALSE);
                break;
            case 'nsave' : $this->SaveForm(FALSE);
                break;
            case 'del' : $this->DoDel();
                break;
            case 'edit' : $this->MyForm(TRUE);
                break;
            case 'esave' : $this->SaveForm(TRUE);
                break;

            case 'savecls' : $this->SaveCls();
                break;

            default:
                showerr('Error act');
                break;
        }
    }

    function ShowList() {
        $h = $GLOBALS['we']->style(sp, "main");
        $tli = $GLOBALS['we']->style(sp, "li");

        $sql = 'select * from `' . sh . '_class` where 1';

        $sql .= ' and cid=' . $this->cid;
        $sql .= ' and module ="' . $this->module . '" ';
        $sql .= ' order by treeid asc';

        $li = $GLOBALS['main']->repm($sql, $tli);

        $h = str_replace('{$cid}', $this->cid, $h);
        $h = str_replace('{$li}', $li, $h);


        $this->html->adhead();
        $this->html->crumbad();
        echo $h;
        $this->html->adfoot();
    }

// end func

    function MyForm($isedit) {
        $h = $GLOBALS['main']->style(sp, "form");

        $id = $GLOBALS['main']->rqid('id');

        $h = str_replace('{$optionclass}', $this->GetOptionClass($this->cid, $id), $h);
        $h = str_replace('{$selimg}', $GLOBALS['html']->selimg('preimg'), $h);

        if ($isedit) {
            crumb('编辑分类');

            $sql = 'select * from `' . sh . '_class` where id=' . $id;
            $h = str_replace('{$action}', '?act=esave&amp;cid=' . $this->cid . '&amp;id=' . $id, $h);
            $h = str_replace('{$th}', '编辑分类', $h);

            $h = $GLOBALS['main']->repm($sql, $h);
        } else {
            crumb('添加分类');

            $h = str_replace('{$action}', '?act=nsave&amp;cid=' . $this->cid, $h);
            $h = str_replace('{$cls}', '100', $h);
            $h = str_replace('{$mypercent}', '100', $h);
            $h = str_replace('{$isgood}', '0', $h);

            $h = $GLOBALS['main']->removemdbfield($h, sh . '_class');
        }

        $GLOBALS['html']->dohtmlad($h);
    }

    // end func

    function Saveform($isedit) {
        /* 接收 */
        $id = $GLOBALS['main']->rqid('id'); //本条记录id
        $rs['ic'] = $GLOBALS['main']->request('编码', 'ic', 'post', 'char', 1, 255, 'invalid', FALSE);

        $rs['title'] = $GLOBALS['main']->request('名称', 'title', 'post', 'char', 1, 255);
        $rs['readme'] = $GLOBALS['main']->request('描述', 'readme', 'post', 'char', 1, 500, '', FALSE);
        $rs['preimg'] = $GLOBALS['main']->request('预览图', 'preimg', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['tags'] = $GLOBALS['main']->request('标签', 'tags', 'post', 'char', 1, 50, '', FALSE);
        $rs['sdir'] = $GLOBALS['main']->request('目录', 'sdir', 'post', 'char', 1, 50, 'folder', FALSE);
        $rs['tip'] = $GLOBALS['main']->request('提示', 'tip', 'post', 'char', 1, 255, 'encode', FALSE);

        $rs['mystyle'] = $GLOBALS['main']->request('模板', 'mystyle', 'post', 'char', 1, 255, '', FALSE);
        $rs['mykeywords'] = $GLOBALS['main']->request('Keywords', 'mykeywords', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['mydescription'] = $GLOBALS['main']->request('Description', 'mydescription', 'post', 'char', 1, 255, 'encode', FALSE);

        $rs['isgood'] = $GLOBALS['main']->rfid('isgood', 0);
        $rs['isshow'] = $GLOBALS['main']->rfid('isshow', 1);

        $rs['pid'] = $GLOBALS['main']->rfid('pid', 0);
        $rs['cls'] = $GLOBALS['main']->rfid('cls', 100);
        $rs['mypercent'] = $GLOBALS['main']->rfid('mypercent', 100);

        ajaxerr();

        $rs['ispass'] = 1; //目前都是通过审核的

        $pid = $rs['pid'];

        /* 有父分类时, 提取父分类信息 */
        if ($rs['pid'] > 0) {
            $sql = 'select * from `' . sh . '_class` where id=' . $rs['pid'];
            $rsparent = $GLOBALS['main']->exeone($sql);
        }


        //开始事务处理
        try {
            $GLOBALS['main']->pdo->begintrans();


            /* 检测===================================== */
            /* 编辑时接收id, 编辑时提取原来的分类信息, 并检测PID不能是自己, 也不能是自已的下级 */
            if ($isedit) {

                /* 编辑时提取原来的分类信息 */
                $sql = 'select * from `' . sh . '_class` where id=' . $id;
                $rssource = $GLOBALS['main']->exeone($sql);

                /* 检测父分类不能是自已或自已的下级 */
                if ($pid > 0) {
                    if (stripos($rsparent['idpath'], $rssource['idpath'])) {
                        ajaxerr('父分类不能是自已或自已的下级');
                    }
                }

                /* 检查同名目录 */
                $sql = 'select count(*) from `' . sh . '_class` where  sdir = "' . $rs['sdir'] . '" ';
                $sql .= ' and id <> ' . $id; /* 不是自已 */
                $sql .= ' and pid=' . $pid; /* 同级下 */

                if ($GLOBALS['main']->execount($sql) > 0) {
                    ajaxerr('有同名目录, 请重新填写');
                }

                /* 父路径改变时, 更新路径信息和深度 */
                if ($rssource['pid'] != $pid) {

                    //if 新的pid=0
                    if (0 == $pid) {
                        $rs['depth'] = 0;
                        $rs['idpath'] = $id . ',';
                    } else {
                        $rs['depth'] = $rsparent['depth'] * 1 + 1;
                        $rs['idpath'] = $rsparent['idpath'] . $id . ',';
                    }
                }


                /* 保存 */
                $GLOBALS['main']->pdo->update(sh . '_class', $rs, ' id=' . $id);

                /* 更新idpath, depth */
                if ($rssource['pid'] != $pid) {
                    /* 更新下级的 */
                    $sql = 'select id,idpath from `' . sh . '_class` where idpath like "' . $rssource['idpath'] . '%"';
                    $rs = $GLOBALS['main']->executers($sql);

                    $mycount = count($rs);
                    if ($mycount > 0) {
                        /* 循环原来的下级分类 */
                        for ($i = 0; $i < $mycount; $i++) {
                            $idpathson = $this->getidpathson($rssource['idpath'], $rsparent['idpath'] . $id . ',', $rs[$i]['idpath']);
                            $sql = 'update `' . sh . '_class` set idpath="' . $idpathson . '"';
                            $sql .= ',depth=' . (substr_count($idpathson, ',') - 1);
                            $sql .= ' where id=' . $rs[$i]['id'];
                            //echo $sql;
                            //echo '<br />';
                            $GLOBALS['main']->execute($sql);
                        }
                    }
                }
            } else {
                $rs['cid'] = $this->cid;
                $rs['module'] = $this->module;


                /* 检查同名目录 */
                $sql = 'select count(*) from `' . sh . '_class` where  sdir = "' . $rs['sdir'] . '" ';
                $sql .= ' and pid=' . $pid; /* 同级下 */
                if ($GLOBALS['main']->execount($sql) > 0) {
                    ajaxerr('有同名目录, 请重新填写');
                }

                /* 保存 */
                $id = $GLOBALS['main']->pdo->insert(sh . '_class', $rs);

                //没有sdir时,用id做为sdir
                if ($rs['sdir'] == '') {
                    $sql = 'update `' . sh . '_class` set sdir="' . $id . '" where id=' . $id;
                    $GLOBALS['main']->execute($sql);
                }

                /* 更新idpath, depth */
                if ($pid == 0) {
                    $idpath = $id . ',';
                    $depth = 0;
                } else {
                    $idpath = $rsparent['idpath'] . $id . ',';
                    $depth = $rsparent['depth'] + 1;
                }

                $sql = 'update `' . sh . '_class` set idpath = "' . $idpath . '", depth=' . $depth . ' where id=' . $id;

                $GLOBALS['main']->execute($sql);
            }

            unset($rs);


            /* 排序 */
            $this->doset(0);

            /* 清除分类缓存 */
            $this->deletecacheclass($this->cid, $this->module);

            $GLOBALS['main']->pdo->submittrans();
        } catch (PDOException $e) {
            showerr($e);
            $GLOBALS['main']->pdo->rollbacktrans();
        }
        //autolocate('?cid='.$this->cid);
    }

// end func

    function DoDel() {
        $id = $GLOBALS['main']->rqid('id');

        /* 提取idpath */
        $sql = 'select idpath from `' . sh . '_class` where id=' . $id;
        $idpath = $GLOBALS['main']->exeone($sql)['idpath'];


        /* 删除此分类 */
        $sql = 'delete from `' . sh . '_class` where cid=' . $this->cid;
        $sql .= ' and idpath like "' . $idpath . '%"';
        $GLOBALS['main']->execute($sql);

        //本频道处理这个分类下的记录
        if (function_exists('moduledelclass')) {
            moduledelclass($this->cid, $idpath);
        }

        htmlok();
    }

    /**
     * 批量保存分类cls
     */
    function Savecls() {
        $sql = '';

        $idlist = $GLOBALS['main']->ridlist('id');
        $cls = $GLOBALS['main']->ridlist('cls');

        if ($idlist != '') {
            $idlist = explode(',', $idlist);
            $cls = explode(',', $cls);


            for ($i = 0; $i < count($idlist); $i++) {
                $sql .= 'update `' . sh . '_class` set cls=' . $cls[$i] . ' where cid=' . $this->cid . ' and id=' . $idlist[$i] . ';';
            }

            if (isset($sql)) {
                $GLOBALS['main']->execute($sql);
            }
            /* 重新排序 */
            $this->doset(0);
        }
    }

// end func
////////////////////////////////////////////////////////////////////////////

    /**
     * Short 跟据频道ID,返回本频道分类Option.
     * @param   type    $cid    频道ID
     * @return  classid = 原分类
     */
    function GetOptionClass($classid = -1) {
        $tli = '<option value="{$id}" class="odepth{$depth}">{$title}</option>' . PHP_EOL;

        $sql = 'select * from `' . sh . '_class` where 1 ';
        $sql .= ' and cid=' . $this->cid;
        $sql .= ' and module = "' . $this->module . '"';

        //不显示原分类的下级
        if ($classid > 0) {
            $result = $GLOBALS['main']->exeone('select idpath from `' . sh . '_class` where id=' . $classid);

            $sql .= ' and idpath not like "' . $result['idpath'] . '%"';
        }

        $sql .= ' order by treeid asc ';


        $li = $GLOBALS['main']->repm($sql, $tli);

        return $li;
    }

// end func

    function doset($pid) {
        static $rs;
        static $rstree;
        static $treeid;



        if (strlen($treeid) == 0) {
            $treeid = 1;
        }

        if (!is_array($rs)) {
            $sql = 'select id,pid from `' . sh . '_class` where 1 ';
            $sql .= ' and cid=' . $this->cid;
            $sql .= ' order by cls asc, id asc ';

            $rs = $GLOBALS['main']->executers($sql);
        }

        $mycount = count($rs);
        unset($sql);

        if ($mycount > 0) {
            for ($i = 0; $i < $mycount; $i++) {
                if ($rs[$i]['pid'] == $pid) {
                    $sql = 'update `' . sh . '_class` set treeid=' . $treeid . ' where id=' . $rs[$i]['id'];
                    $GLOBALS['main']->execute($sql);

                    $treeid++;

                    $this->doset($rs[$i]['id']);
                }
            }
        }
    }

// end func

    /**
     * 生成新的idpath.
     * $sourcepidpath = 原来的父分类的idpath
     * $newidpath = 新的父分类idpath
     * $myidpath = 我原来的idpath
     */
    function getidpathson($sourcepidpath, $newpidpath, $myidpath) {
        //echo '$sourcepidpath='.$sourcepidpath;
        //echo '$newpidpath='.$newpidpath;
        //echo '$myidpath='.$myidpath;
        //echo '<br />';
        /* 计算原来的父idpath长度,在我的idpath中截取掉 */
        $i = strlen($sourcepidpath);

        $s = substr($myidpath, $i);

        /* 新的idpath加上截取后的idpath就是现在的idpath */
        $s = $newpidpath . $s;
        ;
        return $s;
    }

// end func

    /**
     */
    function deletecacheclass($cid = null, $module = null) {
		$t = CacheName . 'class_' . ($cid . '_' . $module);
        $GLOBALS['cache']->delete($t);

		$t = CacheName . 'class';
        $GLOBALS['cache']->delete($t);
    }

   

// end func
}

// end class


