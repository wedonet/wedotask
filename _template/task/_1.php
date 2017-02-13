<?php
require( tpath . 'inc/main.php');

require( tpath . 'task/public/_head.php' );




function formattime($timeint){
    if(strlen(''.$timeint )>2){
        return date('Y-m-d', $timeint);
    }else{
        return '-';
    }    
}





?>



<div>
    <div class="searchbar fleft">
        <form method="get" action="?">
            


            &nbsp;
            时间：
            <input type="text" name="dtime1" id="dtime1" size="10" value="<?php echo $j['v']['dtime1'] ?>" />
            至
            <input type="text" name="dtime2" id="dtime2" size="10" value="<?php echo $j['v']['dtime2'] ?>" /> 
            <input type="submit" value="submit" />
        </form>
    </div>

    

    <div class="clear"></div>


	
    <table class="table1 j_list tasklist" cellspacing="0">

		<?php
		
		foreach ($this->j['l'] as $w ) {
		
		 ?>
		<tr>
			<th colspan="17"><?php echo $w['title'] ?></th>
		</tr>
        <tr>
            <th>ID</th>
			<th>类型</th>
            <th>任务</th>

            <th>发布人</th>

			<th>执行部门</th>
            <th>执行人</th>
            <th>验收人</th>
			<th>已验收</th>
            <th>重</th>
            <th>急</th>
			<th>发布时间</th>
            <th>开始时间</th>
			<th>计划完成</th>
			<th>实际完成</th>
            <th>最后回复</th>
            <th>子任务</th>
            <th>状态</th>
        </tr>


        <?php
        foreach ($w['list'] as $v) {
            echo '<tr>' . PHP_EOL;
            echo '<td>' . $v['id'] . '</td>' . PHP_EOL;
			echo '<td>'.$v['classname'].'</td>' . PHP_EOL;
            echo '<td>' . PHP_EOL;
            echo  $v['title'] . PHP_EOL;
            //echo '	<span class="gray">[' . $v['mystatusname'] . ']</span>' . PHP_EOL;
            //echo '	<span class="j_isshow">' . $v['isshow'] . '</span>' . PHP_EOL;
            //echo '	<span class="j_new">' . $v['duids'] . '|' . $v['rduids'] . '</span>' . PHP_EOL;
            echo '</td>' . PHP_EOL;

            echo '<td>' . $v['sname'] . '</td>' . PHP_EOL;

			echo '<td>' . $v['dname'] . '</td>' .PHP_EOL;

            echo '<td>' . $v['dunames'] . '</td>' . PHP_EOL;



            echo '<td>' . $v['cunames'] . ' </td>' . PHP_EOL;
			echo '<td>' . $v['actualcnames'] . ' </td>' . PHP_EOL;




            echo '<td>'.$v['zhongyao'].'</td>' . PHP_EOL;
            echo '<td>' .$v['jinji']. '</td>' . PHP_EOL;


			echo '<td>' . $v['ptime'] .'</td>'. PHP_EOL;
            echo '<td>' . formattime($v['dtimesint']) . '</td>' .PHP_EOL;
			echo '<td>' . formattime($v['plantimeint']) . ' </td />' . PHP_EOL;
			echo '<td>' . formattime($v['actualtimeint']) . ' </td>' . PHP_EOL;
            echo '<td>' . $v['lastuname'] . '<br />' . $v['lasttime'] . '</td>' . PHP_EOL;
            echo '<td>' . $v['mysonover'] . '/' . $v['myson'] . '</td>' . PHP_EOL;
            echo '<td>' . $v['mystatusname'] . '</td>' . PHP_EOL;
            echo '</tr>' . PHP_EOL;
        }



		}
        ?>
    </table>
  

</div>


<script type="text/javascript">
<!--
    $(document).ready(function () {




        $("#dtime1,#dtime2").datepicker();

        

    })
//-->
</script>


<?php
require(tpath . 'task/public/_foot.php');


