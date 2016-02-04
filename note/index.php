<?php

require '../global.php';

require(apipath . '/note/index_.php'); //接口


$j['headtitle'] = '便签';
$j['crumb'] = '<li>便签</li>';


require( sysdir . '/note/public/_head.php' );
require( sysdir . '/note/public/_top.php' );

?>

<div style="margin:-20px 0 35px 0">
	<div class="fright">
		<ul>
			<li> <a href="form.php?act=creat" style="border:1px solid #bbb;background:#eee;padding:5px;font-weight:bold;">添加便签</a></li>
		</ul>
	</div>
</div>
<div class="clear"></div>

<div>
	<div class="searchbar">
		<form method="get" action="?">
			<input type="checkbox" name="taskstatus[]" value="New"> New &nbsp;
			<input type="checkbox" name="taskstatus[]" value="Plan"> Plan &nbsp;
			<input type="checkbox" name="taskstatus[]" value="Doing"> Doing &nbsp;
			<input type="checkbox" name="taskstatus[]" value="Done"> Done &nbsp;
			<input type="checkbox" name="taskstatus[]" value="Delay"> Delay &nbsp;
			<input type="checkbox" name="taskstatus[]" value="Cancel"> Cancel &nbsp;
			<input type="checkbox" name="taskstatus[]" value="Over"> Over &nbsp;
			
			<input type="text" id="u_fullname" name="u_fullname" value="<?php echo $j['search']['u_fullname'] ?>" size="7" placeholder="姓名" class="vmiddle" />
		
			&nbsp;

			<select name="showtype" id="showtype" class="vmiddle">
				<option value="">All</option>
				<option value="release">发送的</option>
				<option value="receive">接收的</option>
			</select>


			<input type="submit" value="submit" />
		</form>
	</div>



	<div class="clear"></div>



		<?php
		foreach ($j['list'] as $v ) {
			echo '<div class="linote '.$v['mystatus'].'">';

			if('New'==$v['mystatus']){
				echo '<div class="statusNew"></div>';
			}

			echo '	<div class="title">';
			echo '	['.$v['id']. '] ';
			echo		$v['sname'] .'@'.$v['dname'].' &nbsp; ';

			echo		$v['mystatus'].' &nbsp; ';

			echo '	重(:'.$v['zhongyao']. ') 急:('. $v['jinji'] . ') &nbsp; &nbsp; ';
	
			echo		$v['stime'];

			echo		' - '.$v['dtime'];

			echo '	&nbsp; 回复('.$v['countreply'].')';
			
			echo '	</div>';

			echo '	<div class="content">';
			echo			$v['mycontent'];
			echo '	</div>';

			echo '<div class="operate">';

			/*只要没关闭和删除就可以回复*/
			if(!strpos('over,delete', $v['mystatus'])) {
				echo '<a href="form.php?act=reply&amp;fid='.$v['id'].'" class="j_open">Reply</a>';
			}


			/*没删除的都可以显示这些操作*/
			if(!strpos('delete', $v['mystatus'])) {
				echo '&nbsp; &nbsp; ';
				echo ' <a href="form.php?act=Plan&amp;id='.$v['id'].'" title="改为Plan状态" class="j_open">Plan</a> &nbsp; ';
				echo ' <a href="form.php?act=Doing&amp;id='.$v['id'].'" title="改为Doing状态" class="j_open">Doing</a> &nbsp; ';
				echo ' <a href="form.php?act=Done&amp;id='.$v['id'].'" title="改为Done状态" class="j_open">Done</a> &nbsp; ';
				echo ' <a href="form.php?act=Delay&amp;id='.$v['id'].'" title="改为Delay状态" class="j_open">Delay</a> &nbsp; ';
				echo ' <a href="form.php?act=Cancel&amp;id='.$v['id'].'" title="改为Cancel状态" class="j_open">Cancel</a> &nbsp; ';
				echo ' <a href="form.php?act=Over&amp;id='.$v['id'].'" title="改为Over状态" class="j_open">Over</a> &nbsp; ';
			}

			/*作者才可以删除*/
			if( $v['suid'] == $j['user']['id']){
				echo ' <a href="form.php?act=Delete&amp;id='.$v['id'].'" title="删除"  class="j_open">Delete</a> ';
			}
			echo '</div>';

			

			echo '</div>';

			/*显示回复*/
			showreply($j['reply'], $v['id'], $v['mystatus']);

			


			echo '<hr />';
		}

		?>


	<?php echo $j['pagelist'] ?>
</div>

<p style="height:200px"></p>
<script type="text/javascript">
<!--
	$(document).ready(function() {
		/*静态更新复选框*/
		var mystatus = "<?php echo $j['search']['mystatus'] ?>";
		var showtype = "<?php echo $j['search']['showtype'] ?>";

		if('' != mystatus){
			var a = mystatus.split(',');

			for(var i=0; i<a.length; i++){

				$(':input[name="taskstatus[]"][value="'+a[i]+'"]').attr('checked', 'checked');
			}
		}

		$('#showtype').val(showtype);
		

	})
//-->
</script>


<?php
require(tpath . 'task/public/_foot.php');




function showreply(&$a, $fid, $mystatus)
{
	$s = '';

	foreach ($a as $v ) {
		if( $v['fid'] == $fid){
			echo '<div class="lireply '.$mystatus.'">';
			echo '	<div class="fleft" style="width:80%">'.$v['sname'].' &nbsp; ';
			echo			$v['mycontent'];
			echo '	</div>'.PHP_EOL;	


			echo '	<div class="fright" style="width:25px">';
			/*作者可以删除*/
			if( $v['suid'] == $GLOBALS['j']['user']['id']){
				echo '	<a href="form.php?act=delreply&amp;id='.$v['id'].'" title="删除" class="j_open">删除</a>';
			}else{
				echo '&nbsp;';
			}
			echo '	</div>';

			echo '<div class="fright" style="margin:0 8px 0 0">'.$v['stime'].'</div>';
					
			echo '<div class="clear"></div>';
			echo '</div>';
		}
	}


}
