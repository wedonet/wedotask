<?php

require( '../global.php' );
require( sysdirad . 'inc/cls_ad.php');

define('sp', 'admin/_admin_channel');

crumb('<a href="?">频道管理</a>');

class Myclass extends Cls_ad {

    function __construct() {
        parent::__construct();

        $act = $this->main->ract();

        $this->act = & $act;

        switch ($act) {
            case '' : $this->Main();
                break;

            case 'creatin' : $this->ChaInfo(FALSE);
                break;
            case 'nsave' : $this->SaveInfo(FALSE);
                break;
            case 'editin' : $this->ChaInfo(True);
                break; //编辑内部频道
            case 'esave' : $this->SaveInfo(True);
                break;
            case 'delin' : $this->Delchannel();
                break;
            case 'delout' : $this->DoDelOut();
                break;

            case 'ghost' : $this->ChaInfo(FALSE);
                break;
            case 'saveghost' : $this->SaveInfo(FALSE);
                break;

            /* 外部频道 */
            case 'creatout' : $this->FormOut(FALSE);
                break; //添加外部频道	
            case 'nsaveout' : $this->SaveOut(FALSE);
                break;
            case 'editout' : $this->FormOut(TRUE);
                break;
            case 'esaveout' : $this->SaveOut(TRUE);
                break;


            /* 管理权限 */
            case 'power' : $this->setpower();
                break; //管理权限
        }

        san();
    }

    function Main() {
        $li = '';

        $we = & $this->main;

        $h = $we->htm('main');
        $tli = $we->htm('li');
        $opout = $we->htm('opout');
        $opin = $we->htm('opin');

        $this->addjs(admindir . 'js/admin_channel.js');

        title('频道管理');
        $this->head();
        $this->crumb();

        $sql = 'select * from `' . sh . '_channel` where 1 order by ';
        $sql .= 'isuse desc';
        $sql .= ',cha_show desc';
        $sql .= ',cls asc';
        $sql .= ',id asc';

        $result = $this->main->executers($sql);

        foreach ($result as $v) {
            $s = $tli;

            /* 循环外部频道 */
            if (20 == $v['cha_type']) {
                $s = str_replace('{$hrefbrowse}', '{$cha_url}', $s);
                $s = str_replace('{$op}', $opout, $s);
            }
            /* 循环内部频道 */ else {
                $s = str_replace('{$hrefbrowse}', webdir . '{$cha_dir}', $s);
                $s = str_replace('{$op}', $opin, $s);
            }
            $s = $this->main->reprscolumn($v, sh . '_channel', $s);

            $li .= $s;
        }

        $h = str_replace('{$li}', $li, $h);
        $h = str_replace('{$webdir}', webdir, $h);

        echo $h;

        $this->foot();
    }

    /**
     * 添加和编辑内部频道
     */
    function ChaInfo($isedit) {
        $js = '';
        $action = '';

        $h = $this->main->htm('formin');
        $h = str_replace('{$selimg}', $GLOBALS['html']->selimg('preimg'), $h);

        $js .= '$("#div_modulename").hide();' . PHP_EOL; //不允许修改模块

        if ($isedit) {
            $id = $this->main->rqid("id");

            $th = '编辑频道';

            $action = '?act=esave&amp;id=' . $id;

            $sql = 'select * from `' . sh . '_channel` where id=' . $id;

            $h = $this->main->repm($sql, $h);

            crumb('编辑频道');

            $js .= '$("#cha_dir").attr("readonly", "readonly")' . PHP_EOL;
            $js .= '$("#mycode").attr(""readonly"", "readonly")' . PHP_EOL;
        } else {
            /* 克隆 */
            if ($this->act == 'ghost') {
                $sourceid = $this->main->rqid('sourceid');
                $th = '克隆内部频道';
                $action = '?act=saveghost&amp;sourceid=' . $sourceid;

                $sql = 'select * from `' . sh . '_channel` where id=' . $sourceid;

                /* 克隆时显示复制模板 */
                $js .= '$("#linecopystyle").show();' . PHP_EOL;

                $h = str_replace('{$title}', '', $h);

                /* 目录和单位需要重写 */
                $h = str_replace('{$title}', '', $h); /* 清空名称 */
                $h = str_replace('{$cha_dir}', '', $h); /* 清空目录 */
                $h = str_replace('{$cha_unit}', '', $h); /* 清空单位 */
                $h = str_replace('{$ic}', '', $h); /* 清空编码 */

                $h = $this->main->repm($sql, $h);

                crumb('克隆内部频道');
            }
            /* 添加 */ else {
                $h = str_replace('{$cls}', '100', $h);
                $h = $this->main->removemdbfield($h, sh . '_channel');
                $th = '添加内部频道';
                $action = '?act=nsave';
                crumb('添加内部频道');
            }
        }


        $h = str_replace('{$action}', $action, $h);
        $h = str_replace('{$th}', $th, $h);
        $h = str_replace('{$js}', $js, $h);


        $this->dohtml($h);
    }

    /* 新添加内部频道,克隆的内部频道,编辑的系统和内部频道 */

    function SaveInfo($isedit) {
        $id = $this->main->rqid('id');
        $rs['ic'] = $this->main->request('编号', 'ic', 'post', 'char', 1, 20, 'invalid', FALSE);

        $rs['title'] = $this->main->request('频道名称', 'title', 'post', 'char', 1, 255, 'encode');
        $rs['cha_unit'] = $this->main->request('简称', 'cha_unit', 'post', 'char', 1, 50, 'encode', false);
        $rs['cha_dir'] = $this->main->request('目录', 'cha_dir', 'post', 'char', 0, 255, 'folder', FALSE);

        $rs['mytip'] = $this->main->request('提示', 'mytip', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['cha_style'] = $this->main->request('指定模板', 'cha_style', 'post', 'char', 1, 255, 'folder', FALSE);
        $rs['cha_stylepage'] = $this->main->request('指定模板页', 'cha_stylepage', 'post', 'char', 1, 500, '', FALSE);

        $rs['readme'] = $this->main->request('介绍', 'readme', 'post', 'char', 1, 25500, '', FALSE);
        $rs['preimg'] = $this->main->request('频道预览图', 'preimg', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['mytitle'] = $this->main->request('Title', 'mytitle', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['mykeywords'] = $this->main->request('关键词', 'mykeywords', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['mydescription'] = $this->main->request('描述', 'mydescription', 'post', 'char', 1, 255, 'encode', FALSE);

        $rs['mytype'] = $this->main->request('类型', 'mytype', 'post', 'char', 1, 255, 'encode', FALSE);
        //$rs['cha_mdb'] = $this->main->request('关联数据表', 'cha_mdb', 'post', 'char', 1, 255, 'encode', FALSE);

        $rs['cha_opentype'] = $this->main->rfid('cha_opentype', 0);
        $rs['cha_show'] = $this->main->rfid('cha_show', 1);
        $rs['cls'] = $this->main->rfid('cls', 100);
        $rs['cha_page'] = $this->main->rfid('cha_page', 18);
        $rs['isuse'] = $this->main->rfid('isuse', 1);


        $copystyle = $this->main->rfid('copystyle', 0);
        $sourceid = $this->main->rqid('sourceid');

        ajaxerr();

        /* 克隆模板时检测原模板路径和新的不能一样 */
        if ('saveghost' == $this->act AND $copystyle == 1) {
//if (strlen($rs['cha_dir']) == 0) {
//	ajaxerr('克隆频道目录不能为空');
//}

            if (hasthestyle($cha_dir)) {
                ajaxerr('克隆模板时, 模板中已经有这个目录了, 不需要克隆这个模板!');
            }
        }

        /* 有关联数据表时,检测表是不是存在 */
//		if ('' != $rs['cha_mdb']) {
//			$a = explode(',', $rs['cha_mdb']);
//			foreach ($a as $v) {
//				if (!$this->main->pdo->mdbexist(sh . $v)) {
//					ajaxerr('数据表' . $v . '不存在,请重新填写关联数据表');
//				}
//			}
//		}


        try {
            /* 开始事务处理 */
            $this->main->pdo->begintrans();

            if ($isedit) {
                $this->main->pdo->update(sh . '_channel', $rs, ' id=' . $id);
            } else {
                /* 添加新频道时，　检测目录不能为空 */
                if ($rs['cha_dir'] != '') {
//ajaxerr('请填写目录');
//if (HasSameDir($rs['cha_dir'])) {
//	ajaxerr('数据库或网站中有同名目录存在,请重新填写目录名称');
//}
                }




                $rs['cha_type'] = 10;
                $rs['cha_typename'] = '内部';

                /* 插入数据库, 并得到新插入的记录ID */
                $id = $this->main->pdo->insert(sh . '_channel', $rs);

                $resulttarget = $rs;
                $resulttarget['id'] = $id;
            }

            unset($rs);

            /* 克隆 */
            if ('saveghost' == $this->act) {
                /* 复制频道信息 */
                $sql = 'select * from ' . sh . '_channel where id=' . $sourceid;

                $sourcedata = $this->main->exeone($sql);

                unset($sql);

                /**/
                $rs['cha_type'] = 10;
                $rs['cha_typename'] = '内部';

                $rs['cha_set'] = $sourcedata['cha_set'];
                $rs['cha_module'] = $sourcedata['cha_module'];
                $rs['cha_modulename'] = $sourcedata['cha_modulename'];
                $rs['icanghost'] = $sourcedata['icanghost'];

                /* 进行更新 */
                $this->main->pdo->update(sh . '_channel', $rs, 'id=' . $id);

                /* 复制模板到新频道 */
//if ($copystyle == 1) {
///	if ($cha_style != $sourcedata['cha_style']) {
//		copytemplate($sourcedata['cha_style'], $cha_style);
//	}
//}

                /* 复制管理菜单 */

                $this->addmenu($sourceid, $resulttarget);

                /* 复制参数设置 */
//Call CopySetting(sourceid, id)
            }

            /* 重载缓存 */
            $this->main->deletecache('channel');

            $this->main->pdo->submittrans();
        } catch (PDOException $e) {
            $this->main->pdo->rollbacktrans();
            showerr($e);
        }

        $sucmsg = '<li>执行成功,两秒后自动返回列表页</li>' . PHP_EOL;

        ajaxinfo($sucmsg);
        autolocate('?');
    }

// end func


    /* 删除频道 */

    function Delchannel() {
        /* 功能:删除频道;删除模板,删除记录;删除图片 */
        /* 跟据ID判断系统频道 */
        /* -系统频道(cha_type=0)禁止删除 */
        /* 外部频道 - 直接删除 */

        $id = $this->main->rqid('id');

        /* 判断系统频道不允许删除 */

        $sql = 'select cha_type, cha_module, cha_mdb from `' . sh . '_channel` where id=' . $id;

        $rs = $this->main->exeone($sql);

        switch ($rs['cha_type']) {
            case 0 :
                showerr("系统频道禁止删除");
                break;
            case 10:
//每个模块单独制做删除功能
//require_once( $rs['cha_module'].'/delchannel.php');
//opdelchannel();

                try {
                    $this->main->pdo->begintrans();

                    /* 检测数据表里有没有这个频道ID */
//					if ('' != $rs['cha_mdb']) {
//						$a = explode(',', $rs['cha_mdb']);
//						foreach ($a as $v) {
//							if ($this->main->pdo->mdbexist(sh . $v)) {
//								$sql = 'select count(*) from `' . sh . $v . '` where cid=' . $id;
//								if ($this->main->rscount($sql) > 0) {
//									ajaxerr($v . '表还有这个频道的数据,请先删除或转移数据后再删除频道');
//								}
//							}
//						}
//					}


                    /* 删除内部频道,一般是克隆的 */
                    $sql = 'delete from `' . sh . '_channel` where id=' . $this->main->rqid("id");
                    $this->main->execute($sql);



//删除菜单
                    $sql = 'delete from `' . sh . '_menu` where cid=' . $id;
                    $this->main->execute($sql);

                    $this->main->pdo->submittrans();
                } catch (PDOException $e) {
                    $this->main->pdo->rollbacktrans();
                    showerr($e);
                }
                break;
        }
        /* 刷新缓存 */
        $this->main->deletecache('channel');

        /* 提示 */
        htmlok();
    }

// end func

    /* 添加编辑外部频道 */

    function FormOut($isedit) {
        $h = $this->main->htm('formout');
        $h = str_replace('{$selimg}', $this->html->selimg('preimg'), $h);

        if ($isedit) {
            $id = $this->main->rqid('id');

            $h = str_replace('{$action}', '?act=esaveout&amp;id=' . $id, $h);

            $sql = 'select * from `' . sh . '_channel` where id=' . $id;

            $h = $this->main->repm($sql, $h);
        } else {
            crumb('添加外部频道');
            $h = str_replace('{$action}', '?act=nsaveout', $h);

            $h = str_replace('{$cls}', '100', $h);

            /* 移除字段 */
            $h = $this->main->removemdbfield($h, sh . '_channel');
        }

        $this->head();
        $this->crumb();
        echo $h;
        $this->foot();
    }

// end func

    function SaveOut($isedit) {
        /* 外部频道 */
        define('cha_type', 20);

        $id = $this->main->rqid('id');
        $rs['ic'] = $this->main->request('编码', 'ic', 'post', 'char', 1, 20, 'invalid', FALSE);

        $rs['title'] = $this->main->request('频道名称', 'title', 'post', 'char', 1, 255, 'encode');
        $rs['preimg'] = $this->main->request('图标', 'preimg', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['cha_url'] = $this->main->request('链接地址', 'cha_url', 'post', 'char', 1, 255, 'encode', FALSE);

        $rs['mytip'] = $this->main->request('提示', 'mytip', 'post', 'char', 1, 255, 'encode', FALSE);
        $rs['readme'] = $this->main->request('介绍', 'readme', 'post', 'char', 1, 25500, '', FALSE);

        $rs['cha_opentype'] = $this->main->rfid('cha_opentype', 1);
        $rs['cha_show'] = $this->main->rfid('cha_show', 1);
        $rs['cls'] = $this->main->rfid('cls', 100);
        $rs['isuse'] = $this->main->rfid('isuse', 1);

        ajaxerr();

        $rs['cha_type'] = 20; //外部频道
        $rs['cha_typename'] = '外部';

        /* 检查编码不可重复 */
        if ('' != $rs['ic']) {
            if ($this->main->rscount('select count(*) from `' . sh . '_channel` where id <> ' . $id . ' and ic="' . $rs['ic'] . '"') > 0) {
                ajaxerr('编号重复请重新输入');
            }
        }

        if ($isedit) {
            /* 修改 */
            $this->main->pdo->update(sh . '_channel', $rs, ' id=' . $id);

            $sucmsg = '<li class="h1">修改成功</li>';
        } else {
            /* 添加 */
            $this->main->pdo->insert(sh . '_channel', $rs);

            $sucmsg = '<li class="h1">添加成功</li>';
            $sucmsg .= '<li><a href="?act=creatout&amp;cha_type=20">继续添加</a></li>';
        }

        $sucmsg .= '<li><a href="?">返回频道管理</a></li>';

        /* 刷新缓存 */
        $this->main->deletecache('channel');

        ajaxinfo($sucmsg);
    }

// end func

    function DoDelOut() {
        $id = $this->main->rqid('id');

        $sql = 'delete from `' . sh . '_channel` where id=' . $id;

        $this->main->execute($sql);

        htmlok();
    }

// end func
//======================================================

    function hasthestyle($mycha_dir) {
        return FALSE;
        /*
          Set Fso=Server.CreateObject(FsoObjName)

          sourcedir = "../_style/" & Application(CacheName & "_defaultstyle") & "/" & mycha_style
          sourcedir = server.mappath(sourcedir)

          If fso.FolderExists(sourcedir) Then
          hasthestyle = True
          Else
          hasthestyle = False
          End If
         */
    }

// end func

    /* 检测相同目录 */

    function HasSameDir($mydir) {
        $b = FALSE;

        /* 检测数据库里有没有同名目录 */
        $sql = 'select count(*) from ' . sh . '_channel where cha_dir="' . $mydir . '"';
        $mycount = $this->main->execount($sql);
        if ($mycount > 0) {
            $b = TRUE;
        }

        return $b;
    }

// end func

    /* 复制模板 */

    function copytemplate($sourcestyle, $targetstyle) {
        /* 检测原目录是否存在, 不存在退出 */
        $sdir = $this->main->mappath(webdir . '_style/' . $this->main->mystyle . '/' . $sourcestyle);  //原路径
        $tdir = $this->main->mappath(webdir . '_style/' . $this->main->mystyle . '/' . $targetstyle);  //目标路径

        /* 检测老目录是否存在, 不存在则提示错误 */
        if (!file_exists($sdir)) {
            ajaxerr('原模板目录不存在!');
            return;
        }

        /* 检测新目录是否存在, 不存在创建 */
        if (!file_exists($tdir)) {
            mkdir($tdir, 0777);

            /* 复制文件到新文件夹 */
            $this->main->recurse_copy($sdir, $tdir);
        }
    }

// end func



    function addmenu($sourceid, $resulttarget) {
        /* 提取原频道 */
        $sql = 'select * from `' . sh . '_channel` where id= ' . $sourceid;

        $resultsource = $this->main->exeone($sql);

        /* 提取这个频道的组菜单 */
        $sql = 'select * from `' . sh . '_menu` where 1 ';
        $sql .= ' and mytype="group" ';
        $sql .= ' and cid=' . $sourceid;
        $sql .= ' limit 1 ';

        $menugroupsource = $this->main->exeone($sql);


        /* 提取这个组的菜单 */
        $sql = 'select * from `' . sh . '_menu` where pid=' . $menugroupsource['id'];
        $at = $this->main->execute($sql);
        $menumenusource = $at['rs'];

        /* 插入新组 */
        $menugroupsource['cid'] = $resulttarget['id'];
        $menugroupsource['title'] = $resulttarget['title'];

        unset($menugroupsource['id']);
        /* 执行插入 */
        $insertid = $this->main->pdo->insert(sh . '_menu', $menugroupsource);

        $idpath = $menugroupsource['pid'] . ',' . $insertid . ',';

        /* 更新idpath */
        $sql = 'update `' . sh . '_menu` set idpath ="' . $idpath . '" ';
        $sql .= ' where id=' . $insertid;

        $this->main->execute($sql);

        /* 分别插入菜单 */
        $pid = $insertid;



        foreach ($menumenusource as $item) {

            $item['cid'] = $resulttarget['id'];
            $item['pid'] = $pid;


            $item['title'] = $item['titlecode'];
            $item['title'] = str_replace('{$channelname}', $resulttarget['title'], $item['title']);
            $item['title'] = str_replace('{$channelunit}', $resulttarget['cha_unit'], $item['title']);
       
            /* 重新生成链接地址 */
            $item['url'] = $item['urlcode'] . str_replace( '{$cid}', $item['cid'], $item['para']);
    

            unset($item['id']);
            $insertid = $this->main->pdo->insert(sh . '_menu', $item);

            /* 更新idpath */
            $sql = 'update `' . sh . '_menu` set idpath ="' . $idpath . $insertid . '," ';
            $sql .= ' where id=' . $insertid;
            $this->main->execute($sql);
        }
    }

}

$Myclass = new Myclass();
unset($Myclass);