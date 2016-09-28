<?php

/*
 * 模板管理首页
 */
require('../../global.php');
require( 'cls_style.php' ); //模板main

class Myclass extends Cls_style {

    function __construct() {
        parent::__construct();

        $act = $this->main->ract();

        switch ($act) {
            case 'savenewpart' : $this->savenewpart();
                break;
            case 'savepart' : $this->savepart();
                break;
            case 'delpart' : $this->DelPart();
                break;
            case 'edithelp' : $this->EditHelp();
                break;
            case 'savehelp' : $this->SaveHelp();
                break;

            default : $this->main();
                break;
        }
    }

    function main() {
        $filename = trim($_GET['filename']);
        $psyfile = sysdir . $filename;


        $this->c_ad->plusfun('updatepart();hotkeysave();');

        crumb('编辑页面');
        crumb($this->formatfilepath($filename) . ' &nbsp; <a href="' . $filename . '_.txt" class="j_load"></a>');
        title($this->html->title . '-'. $this->truename($filename));
		  
		  $this->c_ad->head();
        $this->c_ad->crumb();

        echo '<div class="templateselect">' . PHP_EOL;
        echo '<div class="selectpage" id="selectpage">' . PHP_EOL;
        echo '	<dl>' . PHP_EOL;
        echo '		<dt>选择页面</dt>' . PHP_EOL;
        echo '		<dd><ul>' . $this->listofpage($filename) . '</ul></dd>' . PHP_EOL;
        echo '	</dl>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        //'	echo '<div class="operatereadme">'.PHP_EOL;
        //'	echo '	<a href="?act=gettags&pagecid={$cid}" onclick='return showinnew(this,600,450)'>标签生成器</a>'.PHP_EOL;
        //'	echo '</div>'.PHP_EOL;
        echo '<div class="clear"></div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;

        /* 打开或新建xml */
        $xml = @simplexml_load_file($psyfile);
        if ($xml === false) {
            $xml = simplexml_load_string('<?xml version="1.0" encoding="utf-8"?><style />');
        }

        /* 循环样式 */
        $i = 0;
        foreach ($xml->children() as $node) {
            $title = $node->getName();

            $i++;

            echo '<table class="table2 strlist" cellspacing="0" id="j_str' . $i . '">' . PHP_EOL;
            echo '<tbody>' . PHP_EOL;
            echo '<tr valign="top">' . PHP_EOL;
            echo '<td width="138" style="line-height:24px">' . PHP_EOL;
            echo '	<div class="title">' . $i . '. <span id="title_' . $i . '">' . $title . '</span></div>' . PHP_EOL;
            echo '	<div class="readme" id="readme_' . $i . '">' . $node->attributes()->readme . '</div>' . PHP_EOL;
            echo '	<div class="center">' . PHP_EOL;
            echo '		<a href="?act=savepart&amp;filename=' . $filename . '&amp;title=' . $title . '" rel="' . $i . '" class="j_updatetemplate" id="sstr_' . $i . '">' . PHP_EOL;
            echo '		<img src="' . admindir . 'images/submit.gif" alt="" /></a>' . PHP_EOL; //保存局部代码
            echo '		&nbsp;&nbsp;<a href="javascript:admin_Size(-5,\'str_' . $i . '\')"><img src="' . admindir . 'images/minus.gif" alt="" /></a>' . PHP_EOL;
            echo '		<a href="javascript:admin_Size(5,\'str_' . $i . '\')"><img src="' . admindir . 'images/plus.gif" alt="" /></a>' . PHP_EOL;
            echo '		<div class="other">' . PHP_EOL;
            echo '		<a href="?act=edithelp&amp;filename=' . $filename . '&amp;title=' . $title . '&amp;inum=' . $i . '" class="j_open">修改名称</a> &nbsp; ' . PHP_EOL;
            //echo '		<a href="?act=view&amp;filename=' .$filename. '" target="blank">查看</a> &nbsp; '.PHP_EOL;
            echo '		<a href="?act=delpart&amp;filename=' . $filename . '&amp;title=' . $title . '&amp;inum=' . $i . '" title="删除' . $title . '" class="j_del alarm">删除</a>&nbsp;&nbsp;' . PHP_EOL;
            echo '		</div>' . PHP_EOL;
            echo '	</div>' . PHP_EOL;
            echo '</td>' . PHP_EOL;
            echo '<td width="*"><textarea id="str_' . $i . '" rows="7" cols="80" style="width:99%" class="vtextarea">' . htmlencode($node) . '</textarea></td>' . PHP_EOL;
            echo '</tr>' . PHP_EOL;
            echo '</tbody>' . PHP_EOL;
            echo '</table>' . PHP_EOL;
        }
        $xml = null;

        /* 添加新样式 */
        echo '<p></p>' . PHP_EOL;
        echo '<form method="post" action="?act=savenewpart&amp;filename=' . $filename . '">' . PHP_EOL;
        echo '<table class="table2" cellspacing="0" id="editpage">' . PHP_EOL;
        echo '<tr>' . PHP_EOL;
        echo '<th>添加新样式</th>' . PHP_EOL;
        echo '</tr>' . PHP_EOL;
        echo '<tr>' . PHP_EOL;
        echo '<td>' . PHP_EOL;
        echo '<p><textarea name="content" rows="5" cols="80" class="textarea" style="width:99%"></textarea></p>' . PHP_EOL;
        echo '代码标识: <input type="text" id="title" name="title" value="" size="20" maxlength="20" /> &nbsp;' . PHP_EOL;
        echo '代码说明: <input type="text" id="readme" name="readme" value="" size="60" maxlength="250" /> &nbsp;' . PHP_EOL;
        echo '<input type="submit" value="提交" />' . PHP_EOL;
        echo '</td>' . PHP_EOL;
        echo '</tr>' . PHP_EOL;
        echo '</table>' . PHP_EOL;
        echo '</form>' . PHP_EOL;

        echo '<div class="tip1">' . PHP_EOL;
        echo '	<dl>' . PHP_EOL;
        echo '		<dt>操作说明</dt>' . PHP_EOL;
        echo '		<dd>点击提交按钮,<img src="../_images/submit.gif" alt="" align="middle" /> 自动保存.按钮恢复原状时表示保存成功!</dd>' . PHP_EOL;
        echo '	</dl>' . PHP_EOL;
        echo '</div>' . PHP_EOL;

        $this->c_ad->foot();
    }

// end func

    /**
     * 保存新建的模板项
     */
    function savenewpart() {
        $filename = Trim($_GET['filename']);
        $psyfile = sysdir . '/' . $filename;

        $title = $this->main->request('标识', 'title', 'post', 'char', 1, 50, 'invalid');
        $readme = $this->main->request('说明', 'readme', 'post', 'char', 1, 50, 'encode');
        $content = $this->main->request('代码', 'content', 'post', 'char', 1, 500000, '', false);

        if (is_numeric($title)) {
            showerr('标识不能是纯数字!');
        }

        showerr();

        /* 打开或新建xml */
        $xml = @simplexml_load_file($psyfile);
        if ($xml === false) {
            $xml = simplexml_load_string('<?xml version="1.0" encoding="utf-8"?><xml />');
        }

        /* 检测这个标识的结点是否存在 */
        if (isset($xml->$title)) {
            showerr('已经有这个标识的代码了');
        } else {
            $xml->$title = $content;
            $xml->$title->addAttribute('readme', $readme);
        }

        $xml->asXML($psyfile);

        $xml = null;

        $this->removecache($filename);

        htmlok();
    }

// end func*/

    /* 删除部分模板 */



// end func


    Function formatfilepath($filename) {
        $s = '';
        $a = explode('/', $filename);
        for ($i = 2; $i < (count($a) - 1); $i++) {
            if (0 == $i) {
                $s = $a[0];
            } else {
                $s .= $a[$i] . '/';
                $a[$i] = '<a href="list.php?dir=' . substr($s, 0, strlen($s) - 1) . '">' . $a[$i] . '</a>' . PHP_EOL;
            }
        }
        return join('/', $a);
    }

    /* 同目录下网页列表 */

    function listofpage($filename) {
        $dir = $this->getupdir($filename);

        $psypath = sysdir . '/' . $dir;

        $dir_list = scandir($psypath);

        $j = 1;
        $li = '';
        foreach ($dir_list as $file) {
            $ext = $this->getext($file);

            if (strpos($file, '.php') !== false && strpos($file, '.txt') === false) {
                $li .= '<li><a href="?act=edit&amp;filename=' . $dir . '/' . $file . '">' . $file . '</a></li>' . PHP_EOL;
                $j++;
            }
        }
        return $li;
    }

    function removecache($filename) {
        $s = str_replace('/_style/', '', $filename);
        $s = str_replace('.php', '', $s);
        $this->main->cache->delete($s);
    }

    /* 删除部分模板 */

    function DelPart() {
        $filename = Trim($_GET['filename']);
        $title = trim($_GET['title']);

        $psyfile = sysdir . $filename;

        $xml = @simplexml_load_file($psyfile);

        if ($xml === false) {
            showerr(1018);
        }

        $node = $xml->$title;

        unset($xml->$title);

        $xml->asXML($psyfile);

        htmlok();
    }

    /* 保存部分模板 */

    function SavePart() {
        $filename = Trim($_GET['filename']);
        $title = Trim($_GET['title']);
        $templatestr = Trim($_POST['templatestr']);

        //格式化
        $psyfile = sysdir . $filename;

        //保存
        $xml = @simplexml_load_file($psyfile);

        $xml->$title = $templatestr;

        $xml->asXML($psyfile);

        $xml = null;

        //删除缓存
        $this->removecache($filename);
    }

// end func

    /**
     * 编辑模板说明
     */
    function EditHelp() {
        $title = Trim($_GET['title']);
        $filename = Trim($_GET['filename']);
        $inum = $this->main->rqid('inum');

        $psyfile = sysdir . '/' . $filename;

        $xml = @simplexml_load_file($psyfile);

        if ($xml === false) {
            showerr(1018);
        } else {
            $readme = $xml->$title->attributes()->readme;
        }
        $xml = null;

        echo '<div class="pxsmall">' . PHP_EOL;
        echo '<div class="th">修改代码名称和说明</div>' . PHP_EOL;
        echo '<div class="ac">' . PHP_EOL;
        echo '<form id="formreadme" action="?act=savehelp&amp;filename=' . $filename . '&amp;title=' . $title . '&amp;inum=' . $inum . '" method="post">' . PHP_EOL;
        echo '<p>' . PHP_EOL;
        echo '名称:<input type="text" value=' . $title . ' maxlength="40" size="40" name="title_new">' . PHP_EOL;
        echo '</p>' . PHP_EOL;
        echo '说明:<input type="text" value="' . $readme . '" maxlength="255" size="40" name="readme_new">' . PHP_EOL;
        echo '<div class="operate"><input type="submit" onclick="j_repost(\'formreadme\')" value="保 存"></div>' . PHP_EOL;
        //echo '<div class="operate"><input type="submit" value="保 存"></div>'.PHP_EOL;
        echo '</form>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
    }

// end func

    /**
     * .
     */
    function SaveHelp() {
        $title = Trim($_GET['title']); //原标识
        $filename = Trim($_GET['filename']);
        $inum = $this->main->rqid('inum');

        $title_new = $this->main->request('标识', 'title_new', 'post', 'char', 1, 50, 'invalid'); //新标识
        $readme_new = $this->main->request('说明', 'readme_new', 'post', 'char', 1, 50, 'encode');

        showerr();

        if (is_numeric($title)) {
            showerr('标识不能是纯数字!');
        }


        $psyfile = sysdir . $filename;

        $xml = simplexml_load_file($psyfile);
        
        /* 检查有没有这个标识存在 */
        if ( $title != $title_new ){
            if ( '' != $xml->$title_new ){
                ajaxerr('已经有这个名称了！');                
            }
        }        

        //提取原结点内容
        $content = $xml->$title;

        /*生成个新的xml*/
        $newxml = simplexml_load_string('<?xml version="1.0" encoding="utf-8"?><xml />');
        /* 循环原xml的结点, 碰到一样的名子,更新成新的内容,最后保存新的xml */
        foreach ($xml->children() as $node) {
            if ($node->getName() == $title) {
                $newxml->$title_new = $content;
                $newxml->$title_new->addAttribute('readme', $readme_new);
            }
            else { //保留原值不变
                $t = $node->getName();
                $newxml->$t = $node;
                $newxml->$t->addAttribute('readme', $node->attributes()->readme);
            }
            //echo $node->attributes()['readme'];
        }
        $newxml->asXML($psyfile);
        unset($xml);
        unset($newxml);

        jsucok();
    }
	 


// end func
}

$myclass = new Myclass();