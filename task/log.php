<?php

require '../global.php';
require (sysdir . 'task/cls_task.php' );

class Myclass extends cls_task {

    function __construct() {
        parent::__construct();

        define('sp', 'task/_log');

        crumb('<a href="index.php">任务管理</a>');
        crumb('日志');

        $this->htmlmain();

        san();
    }

    function htmlmain() {
        $h = $this->main->htm('main');        
        $tli = $this->main->htm('li');

        title('日志');

        /* 接收参数 */
        $id = $this->main->rqid('id');
        
        /*提取并替换任务*/
        $sql = 'select * from `'.sh.'_task` where 1 ';
        $sql .= ' and id='.$id;
        $h = $this->main->repm($sql, $h);

        /* 提取日志内容 */
        $sql = 'select * from `' . sh . '_tasklog` where 1 ';
        $sql .= ' and taskid='.$id;  
        $sql .= ' order by id asc ';
        
        $li = $this->main->repm($sql, $tli);
        
        $h = str_replace('{$li}', $li, $h);

        crumb('详细信息');
 
        $this->dohtml($h);
    }

}

$Myclass = new Myclass();
unset($Myclass);

