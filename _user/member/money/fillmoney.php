<?php

require('../../../global.php');

require(sysdir.'_module/m_money.php');
require(sysdir.'_module/m_user.php');
require(sysdir.'_user/main.php');

define('sp', 'user/member/money/_fillmoney');

class Myclass extends ClsMain {
	private $m_money;
	private $m_user;
	
	function __construct() {
		parent::__construct();     
 		
		$this->m_money = new M_money();
		$this->m_user= new M_user();
		
		$this->html->mytitle = '在线充值';
		
		$act = $this->ract();
		
		switch ($act){
			case '':
				$this->Htmlmain();
				break;		
                  case 'formpay':
                     $this->formpay();
                     break;
                  case 'pay':
                     $this->dopay();
                     break;
                  
                  
		}
	}
	
	
	function Htmlmain(){
		$h = $this->style( sp, 'main');
	
		$this->html->crumb('在线充值');
            
            $h = str_replace('{$hrefpay}', '?act=formpay', $h);
            
            $sql = $this->m_money->showaccount( $this->user['id'] );

            $h = $this->repm( $sql, $h );            

		wrapmain( $h );	
	}
      
      function formpay(){
         $h = $this->style(sp, 'htmlpay');
         
         $h = str_replace('{$action}', '?act=pay', $h);
         
         echo ($h);
         
      }
      
      function dopay(){
         $myvalue = $this->request('金额', 'myvalue', 'post', 'int', 1, 9999);
         
         ajaxerr();
			
			
         
         $user = $this->m_user->getuserbyid( $this->user['id'] );
    
	      $this->m_money->otherpay( $myvalue, $user );
         
         ajaxinfo('入款成功!');
      }
	
	
	
}
$myclass = new Myclass();
