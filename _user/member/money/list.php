<?php

require('../../../global.php');

require(sysdir . '_module/m_money.php');

require(sysdir . '_user/main.php'); // wrap

define('sp', 'user/member/money/_list');

class Myclass extends ClsMain {

   private $m_money;

   function __construct() {
      parent::__construct();

      $this->m_money = new M_money();


      $this->html->mytitle = '财务明细';

      $this->html->crumb('财务明细');

      $act = $this->ract();

      switch ($act) {
         case '':
            $this->htmlmain();
            break;
      }
   }

   function Htmlmain() {
      $h = $this->style(sp, 'main');
      $tli = $this->style(sp, 'li');
      
      $sql = $this->m_money->moneylist( $this->user['id'] );
      
      $li = $this->repm($sql, $tli, null, 18, true);
      
      $h = str_replace('{$li}', $li, $h);
      $h = str_replace('{$pagelist}', $this->pagelist(), $h);

      wrapmain($h);
   }

}

$myclass = new Myclass();


