<?php

class Cls_log {

    function __construct() {
        $this->main = & $GLOBALS['main'];
        $this->html = & $GLOBALS['html'];

        /* 检测权限 */
        if ('guest' == $this->main->user['u_gic']) {
            header('location:/service/login.php');
            die;
        }

        /*频道标识*/
        $this->cic = 'updatelog';
    }

  
    function dohtml(&$h) {
        /* 工具栏 */
        $h = str_replace('{$tasktoolbar}', $this->toolbar(), $h);

        $h = $this->html->dohtml($h);

        echo $h;
    }

    function toolbar() {
        $s = $this->main->htm('toolbar', 'log/_main');

        /* 统计 */
        /*
          $sql = 'select mystatus,count(*) as mycount from `'.sh.'_task` where 1';
          $sql .= ' and isdel=0';
         */

        return $s;
    }


}