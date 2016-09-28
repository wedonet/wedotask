<?php
require( tpath . 'inc/main.php');

require( tpath . 'task/public/_head.php' );
require( tpath . 'task/public/_top.php' );
?>

<div style="margin:-20px 0 30px 0">
	<div class="fright">
		<ul>
			<li> <a href="form.php?act=creat" style="border:1px solid #bbb;background:#eee;padding:5px;font-weight:bold;">添加任务</a></li>
		</ul>
	</div>
</div>
<div class="clear"></div>

<div>
	<div class="searchbar fleft">
		<form method="get" action="?">
			<input type="hidden" name="keywords" value="<?php echo $j['v']['keywords'] ?>" />
			<select name="taskstatus" id="taskstatus">
				<option value="">任务状态</option>
				<option value="alive">活动任务</option>
				<option value="new">新任务</option>
				<option value="doing">正在执行</option>
				<option value="redo">返工</option>
				<option value="done">已完成</option>
				<option value="over">已结束</option>
			</select>
			<select name="tasktype" id="tasktype">
				<option value="">任务类型</option>
				<option value="normal">常规任务</option>
				<option value="bug">Bug修改</option>
				<option value="suggest">建议</option>
				<option value="willdo">需求</option>
			</select>
			<select name="showtype" id="showtype">
				<option value="">显示全部任务</option>
				<option value="release">我发布的</option>
				<option value="receive">我执行的</option>
				<option value="check">我验收的</option>
				<option value="noshow">草稿</option>
			</select>
			&nbsp;
			计划时间：
			<input type="text" name="dtime1" id="dtime1" size="10" value="<?php echo $j['v']['dtime1'] ?>" />
			至
			<input type="text" name="dtime2" id="dtime2" size="10" value="<?php echo $j['v']['dtime2'] ?>" /> 
			<input type="submit" value="submit" />
		</form>
	</div>

	<div class="searchbar fright">
		跳转至：
		<form method="get" action="detail.php" style="display:inline">
			<input type="text" name="id" value="" size="3" /> 
			<input type="submit" value="go" />
		</form>
	</div>

	<div class="clear"></div>
	<table class="table1 j_list tasklist" cellspacing="0">
		<tr>
			<th>ID</th>
			<th style="width:320px">&nbsp;</th>
			<th>分类</th>
			<th>发布人</th>
			<th>执行人</th>
			<th>验收人/已验收</th>
			<th>重</th>
			<th>急</th>
			<th>计划/实际</th>
			<th>最后回复</th>
			<th width="50">子任务</th>
			<th width="50">状态</th>
		</tr>


		<?php
		foreach ($j['list'] as $v) {
			echo '<tr>' . PHP_EOL;
			echo '<td>' . $v['id'] . '</td>' . PHP_EOL;
			echo '<td>' . PHP_EOL;
			echo '	<a href="detail.php?id=' . $v['id'] . '" target="_blank">' . $v['title'] . '</a> ' . PHP_EOL;
			echo '	<span class="gray">[' . $v['mystatusname'] . ']</span>' . PHP_EOL;
			echo '	<span class="j_isshow">' . $v['isshow'] . '</span>' . PHP_EOL;
			echo '	<span class="j_new">' . $v['duids'] . '|' . $v['rduids'] . '</span>' . PHP_EOL;
			echo '</td>' . PHP_EOL;
			echo '<td>' . $v['classname'] . '</td>' . PHP_EOL;

			echo '<td>' . $v['sname'] . '<br />' . $v['ptime'] . '</td>' . PHP_EOL;

			echo '<td>' . $v['dname'] . '<br />' . $v['dunames'] . '</td>' . PHP_EOL;
			echo '<td>' . $v['cunames'] . ' <br />' . $v['actualcnames'] . ' </td>' . PHP_EOL;

			echo '<td class="j_tdright' . $v['zhongyao'] . '">&nbsp;</td>' . PHP_EOL;
			echo '<td class="j_tdright' . $v['jinji'] . '">&nbsp;</td>' . PHP_EOL;

			echo '<td>' . $v['plantime'] . ' <br />' . $v['actualtime'] . ' </td>' . PHP_EOL;
			echo '<td>' . $v['lastuname'] . '<br />' . $v['lasttime'] . '</td>' . PHP_EOL;
			echo '<td>' . $v['mysonover'] . '/' . $v['myson'] . '</td>' . PHP_EOL;
			echo '<td>' . $v['mystatusname'] . '</td>' . PHP_EOL;
			echo '</tr>' . PHP_EOL;
		}
		?>
	</table>
	<?php echo $j['pagelist'] ?>
</div>


<script type="text/javascript">
<!--
	$(document).ready(function() {

		/*草稿显示为 稿*/
		$(".j_isshow").html(function(index, v) {
			if ("0" == v)
			{
				return "(稿)";
			}
			else {
				return "";
			}

		})


		$("#dtime1,#dtime2").datepicker();

		formatnew('j_new', <?php echo $j['user']['id'] ?>); //我的未读任务，显示新

		$("#taskstatus").val("<?php echo $j['v']['taskstatus'] ?>");
		$("#tasktype").val("<?php echo $j['v']['tasktype'] ?>");
		$("#showtype").val("<?php echo $j['v']['showtype'] ?>");


		/*点击当前行变色*/
		$('.j_list tr').on('click', function(){
			$('.currentline').removeClass('currentline');
			$(this).addClass('currentline');
			
		})


	})
//-->
</script>


<?php
require(tpath . 'task/public/_foot.php');


