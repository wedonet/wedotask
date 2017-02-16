<?php

require '../global.php';
require (sysdir . 'task/cls_task.php' );

class Myclass extends cls_task {

    function __construct() {
        parent::__construct();

        define('sp', 'task/_plantime');

        crumb('<a href="index.php">任务管理</a>');

        $this->htmlmain();

        san();
    }

    function htmlmain() {
        $js = '';
        
        $h = $this->main->htm('main');

        $ispre = $this->main->rqid('ispre');

        title('任务');


        /* 接收参数 */
        $id = $this->main->rqid('id');

        /* 提取内容 */
        $sql = 'select * from `' . sh . '_task` where 1 ';


        /* 非预览情况下, 显示正式发布的和我发的 */
        if (1 != $ispre) {
            //$sql .= ' or isshow=0 ';

            $sql .= ' and (isshow=1 or suid=' . $this->main->user['id'] . ')';
        }

        $sql .= ' and isdel=0 ';

        $sql .= ' and id=' . $id;

        $result = $this->main->exeone($sql);

        if (false == $result) {
            showerr(1018);
        }


       






        crumb('详细信息');
        
        $h = str_replace('{$js}', $js, $h);


 
        $this->dohtml($h);
    }




	
	
}

$Myclass = new Myclass();
unset($Myclass);

