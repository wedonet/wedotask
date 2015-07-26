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



<div class="searchbar">
	<div class="fleft">
		<form method="get" action="?" id="myform">
			<input type="hidden" name="keywords" value="<?php echo $j['v']['keywords'] ?>" />
			<input type="hidden" name="outtype" value="view" id="outtype" />
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



			&nbsp;
			计划时间：<input type="text" name="dtime1" id="dtime1" size="10" value="<?php echo $j['v']['dtime1'] ?>" /> 至
			<input type="text" name="dtime2" id="dtime2" size="10" value="<?php echo $j['v']['dtime2'] ?>" />

	
			<select name="dic" id="dic">		
				<option value="">部门</option> 
				<?php echo $j['v']['optiondepartment'] ?>
			</select>
			
			<select name="taskuid" id="taskuid">		
				<option>姓名</option> 
				<?php echo $j['v']['optionuser'] ?>
			</select>

			<select name="showtype" id="showtype">
				<option value="">显示全部任务</option>
				<option value="release">发布的</option>
				<option value="receive">执行的</option>				
				<option value="check">验收的</option>	
			</select>
			
			
			<!--任务是否是待调整-->
			<select name="taskrange" id="taskrange">
				<option value="normal" selected="selected">只显示正常任务</option>
				<option value="adjust">待调整的任务</option>
				<option value="discuss">待讨论的任务</option>		
			</select>				
			
			&nbsp;
			<input type="submit" value="submit" onclick="show()"/> &nbsp; &nbsp; &nbsp;
			<input type="button" value="导出" onclick="emport()" />
		</form>

	</div>

	<div class="fright">
		跳转至：
		<form method="get" action="detail.php" style="display:inline">
			<input type="text" name="id" value="" size="3" /> 
			<input type="submit" value="go" />
		</form>
	</div>
	<div class="clear"></div>
</div>

<table class="table1 j_list" cellspacing="0">
	<tr>
		<th>ID</th>
		<th style="width:320px">&nbsp;</th>
		<th>任务类型</th>
		<th>发布人</th>


		<th>执行人</th>
		<th>验收人/已验收</th>

		<th>重要</th>
		<th>紧急</th>

		<th>计划/实际 时间</th>

		<th>最后回复</th>
		<th>状态</th>
	</tr>


	<?php
	foreach ($j['list'] as $v) {
		echo '<tr>' . PHP_EOL;
		echo '<td>' . $v['id'] . '</td>' . PHP_EOL;
		echo '<td>' . PHP_EOL;
		echo '	<a href="detail.php?id=' . $v['id'] . '" target="_blank">' . $v['title'] . '</a> ' . PHP_EOL;
		echo '</td>' . PHP_EOL;
		echo '<td>' . $v['mytypename'] . '</td>' . PHP_EOL;
		echo '<td>' . $v['sname'] . '<br />' . $v['ptime'] . '</td>' . PHP_EOL;

		echo '<td>' . $v['dname'] . '<br />' . $v['dunames'] . '</td>' . PHP_EOL;
		echo '<td>' . $v['cunames'] . ' <br />' . $v['actualcnames'] . ' </td>' . PHP_EOL;

		echo '<td class="j_tdright' . $v['zhongyao'] . '">&nbsp;</td>' . PHP_EOL;
		echo '<td class="j_tdright' . $v['jinji'] . '">&nbsp;</td>' . PHP_EOL;

		echo '<td>' . $v['plantime'] . ' <br />' . $v['actualtime'] . ' </td>' . PHP_EOL;
		echo '<td>' . $v['lastuname'] . '<br />' . $v['lasttime'] . '</td>' . PHP_EOL;
		echo '<td>' . $v['mystatusname'] . '</td>' . PHP_EOL;
		echo '</tr>' . PHP_EOL;
	}
	?>
</table>

<div class="page">
	<?php echo $j['pagelist'] ?>
</div>


</div>
<script type="text/javascript">
				<!--
	$(document).ready(function() {

					$("#taskstatus").val("<?php echo $j['v']['taskstatus'] ?>");
					$("#tasktype").val("<?php echo $j['v']['tasktype'] ?>");
					$("#showtype").val("<?php echo $j['v']['showtype'] ?>");
					
					$('#dic').val('<?php echo $j['v']['dic'] ?>');
					$("#taskuid").val("<?php echo $j['v']['taskuid'] ?>");
					
					$("#taskrange").val("<?php echo $j['v']['taskrange'] ?>");


					


					var href = "ajax/message.php";
					$.getScript(href, function() {
						if ("0" != $("#c_new").text() && !$("#c_new").hasClass("havetask")) {
							$("#c_new").addClass("havetask");
						}
					});

					/*菜单选中*/
					$("#j_navtask").addClass("on");

					$("#dtime1,#dtime2").datepicker();
					//-->
				})

				function show() {
					/*更新显示类型为显示*/
					$('#outtype').val('');
					/*提交表单*/
					$('#myform').submit();
				}

				function emport() {
					/*更新显示类型为导出*/
					$('#outtype').val('emport');
					/*提交表单*/
					$('#myform').submit();
				}
</script>

<?php
require(tpath . 'task/public/_foot.php');