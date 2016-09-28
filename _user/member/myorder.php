<?php
/**
 * 商家控制面板.
 * 
 * @author  YiLinSun 
 * @version 1.0
 * @package main
 */
require_once('../../global.php');
require_once('../main.php');
require_once('../../_inc/cls_bll_hotel.php');


/*检测权限, 普通会员才能进*/
$we->chkuserpanel(300);

/*定义模板位置*/
define('sp', 'user/member/_myorder');

$html->cssinfo = $we->style(sp, 'css');

/*设置title*/
$html->mytitle = '我的酒店定单';

crumb('订单管理');


$act = $GLOBALS['we']->ract();

switch ($act) {
	case ''						: Main(); break;
	case 'edit'					: MyForm(); break;
	case 'esave'				: SaveOrder(); break;
	case 'cancel'				: DoCancel(); break;

	case 'view'					: OrderDetail(); break; //显示订单详细信息
}
san();


function Main(){
	$li = '';
	
	$h = $GLOBALS['main']->style(sp, 'main');
	$tli = $GLOBALS['main']->style(sp, 'li');

	$bll = new Cls_Bll_Hotel;

	/*提取我的定单*/
	$sql = 'select o.id as id,';
	$sql .= ' o.roomname, '; 
	$sql .= ' o.mydate1, ';
	$sql .= ' o.mydate2, ';
	$sql .= ' o.roomcount, ';
	$sql .= ' o.allprice, ';
	$sql .= ' o.mystatus, ';
	$sql .= ' h.title as hotelname from `'.sh.'hotelorder` as o ';

	$sql .= ' left join `'.sh.'hotel` as h on o.hotelid=h.id' ;
	$sql .= ' where o.uid='.$GLOBALS['main']->u_id;
	$sql .= ' and isdel=0 ' ;
	$sql .= ' order by o.id desc ';

	$rs = $GLOBALS['main']->exers( $sql )['rs'];

	foreach ($rs as $v ) {
		$s = $tli;
		$s = str_replace('{$id}', $v['id'], $s);
		$s = str_replace('{$酒店名称}', $v['hotelname'], $s);
		$s = str_replace('{$房态}', $v['roomname'], $s);

		$s = str_replace('{$mydate1}', date('Y-m-d ', $v['mydate1']), $s);
		$s = str_replace('{$mydate2}', date('Y-m-d ', $v['mydate2']), $s);

		$s = str_replace('{$roomcount}', $v['roomcount'], $s);
		$s = str_replace('{$allprice}', $v['allprice'], $s);



		$s = str_replace('{$定单状态}', $bll->hotelordername[$v['mystatus']], $s);
		$s = str_replace('{$mystatus}', $v['mystatus'], $s); //定单操作

		$operate = '';
		switch ($v['mystatus']) {
			case 'new':
				$operate .= '';
				break;
		
		}
		//$s = str_replace('{$}', $v[''], $s);
		//$s = str_replace('{$}', $v[''], $s);
		//$s = str_replace('{$}', $v[''], $s);
		$li .= $s;
	}


	$h = str_replace('{$li}', $li, $h);
	$h = str_replace('{$pagelist}', $GLOBALS['main']->pagelist(), $h);

	$h = wrapmain($h); //包上一层

	$h = dohtml($h); //替换标签

	echo $h;
} // end func



function MyForm(){
	$h = $GLOBALS['main']->style(sp, 'form');

	$id = $GLOBALS['main']->rqid('id');

	$h = str_replace('{$action}', '?act=esave&amp;id='.$id, $h);

	$h = str_replace('{$mydate1}', '{$mydate1_dateformat1}', $h);
	$h = str_replace('{$mydate2}', '{$mydate2_dateformat1}', $h);

	$sql = 'select * from `'.sh.'hotelorder` where 1';
	$sql .= ' and uid='.$GLOBALS['main']->u_id;
	$sql .= ' and id='.$id;

	$h = $GLOBALS['main']->repm( $sql ,$h);


	crumb('修改订单');

	$h = wrapmain($h); //包上一层

	$h = dohtml($h); //替换标签

	echo $h;
} // end func


function DoCancel(){
	$bll = new Cls_Bll_Hotel;

	$id = $GLOBALS['main']->rqid('id');

	/*提到订单信息*/
	$sql = 'select * from `'.sh.'hotelorder` where 1';
	$sql .= ' and uid='.$GLOBALS['main']->u_id;
	$sql .= ' and id='.$id;

	$o = $GLOBALS['main']->exeone( $sql );

	if ( FALSE == $o ) {
		showerr(1018);
	}

	//检测是否能取消
	if ( ! $GLOBALS['main']->ins('new', $o['mystatus']) ) {
		showerr(1022);
	}

	//发通知给酒店

	//执行取消
	$sql = 'update `'.sh.'hotelorder` set mystatus="cancel",mystatusname="'.$bll->hotelordername['cancel'].'" ';
	$sql .= ' where id='.$id ;
	$sql .= ' and uid='.$GLOBALS['main']->u_id;

	$GLOBALS['main']->execute( $sql );

	//循环还原每一天的房量
	//不需要还原了

	//还原这一天的空房数量
	//$sql = 'update `'.sh.'roomlist set roomorder=roomorder-'.$o['roomcount'].', roomremain=roomremain+'.$o['roomcount'];
	//$sql .= '

	htmlok();
} // end func


function SaveOrder()
{

} // end func



function OrderDetail(){
	$h = $GLOBALS['main']->style(sp, 'detailorder');

	$id = $GLOBALS['main']->rqid('id');

	$sql = 'select * from `'.sh.'hotelorder` where 1 ';
	$sql .= ' and isdel=0 ';
	$sql .= ' and id='.$id;
	$sql .= ' and uid='.$GLOBALS['main']->user['id'];

	$h = $GLOBALS['main']->repm( $sql, $h);

	$h = wrapmain($h); //包上一层
	$h = dohtml($h); //替换标签
	echo $h;
} // end func