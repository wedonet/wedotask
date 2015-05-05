<?php

require('../../../global.php');

require(sysdir.'_module/m_money.php');
require(sysdir.'_user/main.php');

define('sp', 'user/member/money/_account');

class Myclass extends ClsMain {	
	private $m_money;
	
	function __construct() {
		parent::__construct();
            
            
		
		$this->m_money = new M_money();
		
		$this->html->mytitle = '财务统计';
		
		$act = $this->ract();
		
		switch ($act){
			case '':
				$this->Htmlmain();
				break;			
		}
	}
	
	
	function Htmlmain(){
		$h = $this->style( sp, 'main');
	
		$this->html->crumb('财务统计');
		
		$sql = $this->m_money->showaccount( $this->user['id'] );
		
            $h = $this->repm($sql, $h);
            
		wrapmain( $h );	
	}
	
	
	
}
$myclass = new Myclass();
