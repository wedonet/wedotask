<?php
/**
 * 广告模块分类管理
 *
 * @YilinSun
 * @version 1.0
 */

require_once('../../global.php');
require_once('../../_inc/cls_class.php');



$c = new Cls_Class();

$c->cid = 31;
$c->main();
unset($c);

san();


/**
 * 删除这个栏目和当前分类相关的内容.
 */
function moduledelclass($cid, $idpath){
	/*此分类下的文章分类归0*/
	$sql = 'update `'.sh.'_advert` set classid=0 where 1=1 ';
	$sql .= ' and classid in (select id from `'.sh.'class` where idpath like "'.$idpath.'%")';

	$GLOBALS['main']->execute($sql);
} // end func
