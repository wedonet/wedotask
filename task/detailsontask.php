<?php

/*查看子任务*/

require '../global.php';
require (sysdir . 'task/cls_task.php' );

class Myclass extends cls_task {

    function __construct() {
        parent::__construct();

        define('sp', 'task/_detailsontask');

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
        $result = $this->getmytask($id, $ispre);

        if (false == $result) {
            showerr(1018);
        }

		/*添加父面包屑*/
		$this->addparentcrumb($result['pid']);
		/*添加自已的面包屑*/
		crumb( $result['title'] );

        /* 如果是草稿,做提示 */
        if (0 == $result['isshow']) {
            $isshow_str = '(稿)';
        } else {
            $isshow_str = '';
        }
        $h = str_replace('{$isshow}', $isshow_str, $h);

        foreach ($result as $k => $v) {
            if (false !== stripos($h, '{$' . $k . '}')) {
                $h = str_replace('{$' . $k . '}', $v, $h);
            }
        }

		/*如果是我执行的，且已读人里没有我，则更新为已读*/
		if ( $this->main->ins($result['duids'],  $this->main->user['id'])  and !$this->main->ins($result['rduids'],  $this->main->user['id'])  )  {
			$this->updaterduids($result);
		}


        /* reply */
        $h = str_replace('{$reply}', $this->reply($id), $h);


		/*====操作控制*/
		/*草稿显示发布*/
		if ( 0 == $result['isshow'] ) {
		    $js .= '$("#j_publish").show();'.PHP_EOL;
		}

		/*管理员和作者可以修改*/
		if ( $this->icanedittask( $result['suid'] ) ) {
		   $js .= '$("#j_edit").show();'.PHP_EOL;
		}

		/*我是执行人时，显示正在执行*/
		if ( $this->main->ins( $result['duids'], $this->main->user['id'] ) ) {
		    $js .= '$("#j_doing").show();'.PHP_EOL;
		}

		/*完成 */
		if ( $this->main->ins( $result['duids'], $this->main->user['id'] ) ) {
		    $js .= '$("#j_done").show();'.PHP_EOL;
		}

		/*返工*/


		/* 检测通过 */
		if ( $this->main->ins( $result['cuids'], $this->main->user['id'] ) ) {
		    $js .= '$("#j_check").show();'.PHP_EOL;
		}

		/* 结束 */


		/* 日志 */


		/* 删除 */
		if ( $this->icanedittask( $result['suid'] ) ) {
		   $js .= '$("#j_del").show();'.PHP_EOL;
		}

		/*取消 我能编辑 and 还未结束 */
		if ( $this->icanedittask( $result['suid'] ) And 'over' !== $result['mystatus'] And 'cancel' !== $result['mystatus'] ) {
		   $js .= '$("#j_cancel").show();'.PHP_EOL;
		}


        crumb('详细信息');
        
        $h = str_replace('{$js}', $js, $h);


        $this->html->addjs(webdir . 'ckeditor/ckeditor.js');
        $this->dohtml($h);
    }

    function reply($taskid) {
        $tli = $this->main->htm('li');

        $sql = 'select * from `' . sh . '_retask` where 1';
        $sql .= ' and taskid=' . $taskid;
        $sql .= ' and isdel=0';
		$sql .= ' order by ';
		$sql .= '( case mytype when "info" then 1 else 2 end ), '; //任务信息排前面
        $sql .= ' id asc  ';

        $li = $this->main->repm($sql, $tli);

        return $li;
    }

	function updaterduids($result){
		if ( '' == $result['rduids'].''){
			$rduids = ','.$this->main->user['id'].',';
		}
		else{
			$rduids = $result['rduids'].$this->main->user['id'].',';
		}

		$sql = 'update `'.sh.'_task` set rduids="'.$rduids.'" where 1 ' ;
		$sql .= ' and id='.$result['id'];

		$this->main->execute($sql);
	}

	
	/*提取任务
	* id: 任务id
	* ispre : 是否预览
	*/
	function getmytask($id, $ispre)
	{
		 $sql = 'select * from `' . sh . '_task` where 1 ';


        /* 非预览情况下, 显示正式发布的和我发的 */
        if (1 != $ispre) {
            //$sql .= ' or isshow=0 ';

            $sql .= ' and (isshow=1 or suid=' . $this->main->user['id'] . ')';
        }

        $sql .= ' and isdel=0 ';

        $sql .= ' and id=' . $id;

        $result = $this->main->exeone($sql);	

		return $result;
	}

	/*在面包屑上添加父级*/
	function addparentcrumb($id)
	{
		$sql = 'select title from `'.sh.'_task` where 1 ';
		$sql .= ' and id='.$id;

		$result = $this->main->exeone($sql);

		if ( false === $result ) {
			showerr(1018);
		}
		else{
			crumb ('<a href="detail.php?id='.$id.'">'. $result['title'] .'</a>');
		}

	} // end func

}

$Myclass = new Myclass();
unset($Myclass);

