<?php
require( tpath . 'inc/main.php');

require( tpath . 'task/public/_head.php' );


//print_r($this->j);die;

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


	
    <table class="" cellspacing="0" border="1" style="text-align:left">

		<?php
		
		foreach ($this->j['l'] as $w ) {
		
		 ?>
		<tr>
			<th colspan="19" style="height:28px;background:#bbb;font-weight:bold;"><?php echo $w['title'] ?></th>
		</tr>
        <tr style="height:28px;background:#eee;">
            <th style="width:30px">ID</th>
			<th style="width:120px">项目</th>
			<th style="width:50px">类型</th>
            <th style="width:300px">任务</th>

			<th style="width:300px">回复</th>

            <th style="width:50px">发布人</th>

			<th style="width:40px">执行部门</th>
            <th style="width:50px">执行人</th>
            <th style="width:50px">验收人</th>
			<th style="width:50px">已验收</th>
            <th style="width:30px">重</th>
            <th style="width:30px">急</th>
			<th style="width:100px">发布时间</th>
            <th style="width:100px">开始时间</th>
			<th style="width:120px">计划完成</th>
			<th style="width:120px">实际完成</th>
            <th style="width:50px">最后回复</th>
            <th style="width:50px">子任务</th>
            <th style="width:50px">状态</th>
        </tr>


        <?php
        foreach ($w['list'] as $v) {
            echo '<tr>' . PHP_EOL;
            echo '<td>' . $v['id'] . '</td>' . PHP_EOL;
			echo '<td>'.$v['projecttitle'].'</td>' . PHP_EOL;
			echo '<td>'.$v['classname'].'</td>' . PHP_EOL;
            echo '<td>' . PHP_EOL;
            echo  $v['title'] . PHP_EOL;
            //echo '	<span class="gray">[' . $v['mystatusname'] . ']</span>' . PHP_EOL;
            //echo '	<span class="j_isshow">' . $v['isshow'] . '</span>' . PHP_EOL;
            //echo '	<span class="j_new">' . $v['duids'] . '|' . $v['rduids'] . '</span>' . PHP_EOL;
            echo '</td>' . PHP_EOL;


			echo '<td>'.$v['mysonlist'].'</td>' . PHP_EOL;

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


            echo '<td>' . $v['lastuname'] . '-' . $v['lasttime'] . '</td>' . PHP_EOL;


            echo '<td>' . $v['mysonover'] . '/' . $v['myson'] . '</td>' . PHP_EOL;

            echo '<td>' . $v['mystatusname'] . '</td>' . PHP_EOL; //状态
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


