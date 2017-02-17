<?php

/**
 * 任务模块项目管理
 *
 * @YilinSun
 * @version 1.0
 */
require('../../global.php');
require( sysdirad . 'inc/Cls_ad.php');


class Myclass extends Cls_ad {

	function __construct() {
		parent::__construct();

		define('sp', 'admin/_admin_project');


		crumb('分类管理');

		$act = $this->main->ract();

		switch ($act) {
			case '':
				$this->main();
				break;
			case 'creat':
				$this->Myform(false);
				break;
			case 'edit':
				$this->Myform(true);
				break;
			case 'nsave':
				$this->Saveform(false);
				break;
			case 'esave':
				$this->Saveform(true);
				break;
			case 'del':
				$this->fundel();
				break;
			default :
				showerr('act错误');
				break;
		}

		san();
	}

	function main() {
		$h = $this->main->htm("main");
		$tli = $this->main->htm("li");

		$sql = 'select * from `' . sh . '_project` where 1 ';

		$sql .= ' order by id asc';

		$li = $GLOBALS['main']->repm($sql, $tli);

		$h = str_replace('{$li}', $li, $h);

		$this->dohtml($h);
	}

	function Myform($isedit) {
		$h = $this->main->htm("myform");

		$id = $GLOBALS['main']->rqid('id');

		

		if ($isedit) {
			crumb('编辑项目');

			$sql = 'select * from `' . sh . '_project` where id=' . $id;
			$h = str_replace('{$action}', '?act=esave&amp;id=' . $id, $h);

			$h = str_replace('{$th}', '编辑项目', $h);

			

			$h = $GLOBALS['main']->repm($sql, $h);
		} else {
			crumb('新建项目');

			$h = str_replace('{$mystatus}', 'New');

			$h = str_replace('{$action}', '?act=nsave', $h);



			$h = $GLOBALS['main']->removemdbfield($h, sh . '_project');
		}

		$this->dohtml($h);
	}

	function Saveform($isedit) {
		
		$rs['title'] = $this->main->request('项目名称', 'title', 'post', 'char', 1, 255, 'encode');
		$rs['mystatus'] = $this->main->request('状态', 'mystatus', 'post', 'char', 1, 20);


		ajaxerr();


		if($isedit){

			$id = $this->main->rqid('id');

			$this->main->pdo->update(sh . '_project', $rs, 'id=' . $id);
		}else{
			$rs['stimeint'] = time();
			$rs['stime'] = date('Y-m-d H:i:s', time());

			$id = $this->main->pdo->insert(sh . '_project', $rs);



		}
	

		$sucmsg = '<li>保存成功</li>' . PHP_EOL;
		$sucmsg = '<li><a href="?">返回任务管理</a></li>' . PHP_EOL;



		ajaxinfo($sucmsg);
	}

	/* 保存排序 */

	function Savecls() {
		$this->c_class->Savecls();

		jsucok();
	}

// end func

	/**
	 * 删除这个栏目和当前分类相关的内容.
	 */
	function moduledelclass($cid, $idpath) {
		/* 此分类下的文章分类归0 */
		$sql = 'update `' . sh . '_task` set classid=0 where 1=1 ';
		$sql .= ' and cid=' . $cid;
		$sql .= ' and classid in (select id from `' . sh . 'class` where idpath like "' . $idpath . '%")';

		$GLOBALS['we']->execute($sql);
	}

	/* 编辑分类内容 */

	function mycontent() {
		$h = $this->main->htm('content');

		crumb('描述');

		$cid = $this->c_class->cid;
		$id = $this->main->rqid('id');

		$h = str_replace('{$action}', '?act=savecontent&amp;cid=' . $cid . '&amp;id=' . $id, $h);

		$sql = 'select * from `' . sh . '_class` where cid=' . $cid . ' and id=' . $id;

		$h = $this->main->repm($sql, $h);

		$this->addjs(webdir . 'ckeditor/ckeditor.js');

		$this->dohtml($h);
	}

	/* 保存分类内容 */

	function savecontent() {
		$cid = $this->c_class->cid;
		$id = $this->main->rqid("id");

		$mycontent = $this->main->request('描述', 'mycontent', 'post', 'char', 1, 99999, '', FALSE);

		ajaxerr();

		
		$rs['mycontent'] = $mycontent;

		/* 更新 */
		$this->main->pdo->update(sh . '_class', $rs, ' cid=' . $cid . ' and id= ' . $id);

		/* 成功提示并自动关闭 */
		jsucclose();
	}

	/*删除分类*/
	function fundel(){
		$id = $this->main->rqid();


		/*提取这个分类和他的下级分类*/
		$sql = 'select count(*) from `'.sh.'_task` where projectid='.$id; 

		
		$result = $this->main->execount($sql);
		if ($result>0){
			showerr('这个项目下还有任务不能删除');
		}


		/* 删除此分类 */
        $sql = 'delete from `' . sh . '_project` where id=' . $id;

        $GLOBALS['main']->execute($sql);

		htmlok();

	}

}




$Myclass = new Myclass();
unset($Myclass);






