<?php

require '../global.php';
require_once('cls_note.php'); //接口

require(apipath . '/note/form_.php'); //接口





class Myclass extends Cls_note{
    function __construct() {
		parent::__construct();

        $act = $this->main->ract();

        switch ($act) {
            case 'creat':
                $this->myform(false);
                break;
            case 'nsave':
                $this->saveform(false);
                break;
            case 'edit':
                $this->myform(true);
                break;
            case 'esave':
                $this->saveform(true);
                break;
				case 'more':
					$this->findmore();
					break;
				case 'savemore':
					$this->savemore();
					break;

				
				case 'reply': /*回复表单*/
					$this->formreply();
					break;


				case 'savereply':					
					break;
        }

        san();
    }

    function myform($isedit) {
		$j =& $GLOBALS['j'];

		$j['headtitle'] = '便签';
		$j['crumb'] = '<li>便签</li><li>添加</li>';


		
		function headcode()
		{
			echo '<script type="text/javascript" src="'.webdir.'ckeditor/ckeditor.js"></script>';
		}

		require( sysdir . '/note/public/_head.php' );
		require( sysdir . '/note/public/_top.php' );

		?>
		<form method="post" action="?act=nsave" id="myform">
		
	
		<table class="table1" cellspacing="0">
			<tr>
				<td>责任人：</td>
				<td><input type="text" name="u_fullname" size="10" value="" /></td>
			</tr>



			<tr>
				<td>级别:</td>
					<td>重要程度：<select name="zhongyao" id="zhongyao">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select> &nbsp; 
					紧极程度：

					<select name="jinji" id="jinji">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select> &nbsp; 
				</td>
			</tr>



			<tr>
				<td>其它：</td>
				<td>
					<input type="radio" name="showtype" value="0" class="vmiddle" checked="checked" /> 全部可见
					<input type="radio" name="showtype" value="1" class="vmiddle" />  只有接收人可见 					
				</td>
			</tr>

			<tr>
				<td>描述:</td>
				<td>
				<textarea name="mycontent" id="mycontent" rows="4" cols="60"></textarea>
				</td>
			</tr>

	
			<tr>
				<td>&nbsp;</td>
				<td>
				<input type="submit" value="Submit" style="font-weight:bold;font-size:14px;padding:4px 8px;" onclick="j_post('myform')" />
				</td>
			</tr>
			
		</table>
		</form>


		<?php
		require( sysdir . '/note/public/_foot.php' );
    }

	 
	 function saveform() {
	 
	 }

	 
	 function formreply() {
	 ?>
	 <div class="pxsmall">
		<div class="th">回复</div>
		<div class="ac">	
		<form method="post" action="form.php?act=savereply&amp;fid=<?php echo $this->main->rqid('fid') ?>" id="formreply">
				
			<textarea name="mycontent" rows="4" cols="20" style="width:99%"></textarea>
						
			<p><input type="submit" name="submit" value="提交" class="submit1" onclick="j_repost('formreply')"></p>
					
		</form>
		</div>
		</div>
	 <?php
	 }
}

$Myclass = new Myclass();
unset($Myclass);