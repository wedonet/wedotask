<?php

/**
 * 频道内容管理
 *
 * @YilinSun
 * @version 1.0
 */
require('../../global.php');
require( sysdirad . 'inc/cls_ad.php');

define('sp', 'admin/document/_channelcontent');

Class Myclass extends Cls_ad {

    function __construct() {
        parent::__construct();
        
        $this->cid = $this->main->rqid("cid");

        $this->a_channel = $this->main->getarr('channel', $this->cid);

        if (FALSE == $this->a_channel) {
            showerr(1022);
        }

        crumb($this->a_channel['title']);

        $act = $this->main->ract();

        switch ($act) {
            case '' : $this->Main();
                break;
            case 'save' : $this->SaveForm();
                break;
        }
        san();
    }

    function Main() {
        $h = $this->main->htm( 'main');

        $h = str_replace('{$action}', '?act=save&amp;cid=' . $this->cid, $h);

        $sql = 'select * from `' . sh . '_channel` where id=' . $this->cid;

        $h = $this->main->repm($sql, $h);

        $this->addjs(webdir . 'ckeditor/ckeditor.js');

        $this->dohtml($h);
    }



    function SaveForm() {
        $id = $this->main->rqid("cid");

        $readme = $this->main->request('简介', 'readme', 'post', 'char', 1, 500, '', FALSE);
        $content = $this->main->request('描述', 'content', 'post', 'char', 1, 99999, '', FALSE);

        ajaxerr();

        $rs['readme'] = $readme;
        $rs['content'] = $content;

        /* 更新 */
        $this->main->pdo->update(sh . '_channel', $rs, ' id= ' . $id);

        /* 成功提示并自动关闭 */
        jsucclose();
    }

// end func
}

$Myclass = new Myclass();
unset($Myclass);