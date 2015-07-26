<?php

header('location:/task/');
die;
require 'global.php';

class Myclass {

    function __construct() {
        define('sp', '_index');

        $this->ini();

        $this->htmlmain();

        san();
    }

    function htmlmain() {

        $h = $this->main->htm('main');

        title($this->a_channel['title']);

        echo ( $this->html->dohtml($h) );
    }

    function ini() {
        $cid;

        $this->main = $GLOBALS['main'];
        $this->html = $GLOBALS['html'];

        $cid = $this->main->rqid('cid');
        if ($cid < 1) {
            $a_channel = $this->main->getarr('channel', null, 'index');
        } else {
            $a_channel = $this->main->getarr('channel', $cid);
        }

        if (false == $a_channel) {
            showerr(1018);
        }

        $this->cid = $a_channel['id'];
        $this->a_channel = & $a_channel;
    }

}

$Myclass = new Myclass();
unset($Myclass);

