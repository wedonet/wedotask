<?php

require_once('mail/class.phpmailer.php');

class Cls_Mail{
	function smtp_mail( $sendto_email, $subject, $body){    
		$mail = new PHPMailer();    
		$mail->IsSMTP();                  // send via SMTP    

		$mail->SMTPAuth = true;           // turn on SMTP authentication    
		$mail->Host = 'smtp.qq.com';   // SMTP servers    
		$mail->Username = '16216077';     // SMTP username  注意：普通邮件认证不需要加 @域名    
		$mail->Password = 'yy0405'; // SMTP password    
		$mail->From = '16216077@qq.com';      // 发件人邮箱    
		$mail->FromName =  '16216077';  // 发件人    
	  
		$mail->CharSet = 'UTF-8';   // 这里指定字符集！    
		$mail->Encoding = 'base64';    
		$mail->AddAddress($sendto_email, "tousername");  // 收件人邮箱和姓名    
		$mail->IsHTML(false);  // send as HTML    
		// 邮件主题    
		$mail->Subject = $subject;    
		// 邮件内容    
		$mail->Body = $body;                                                                          
		//$mail->AltBody ="text/html";    
		if(!$mail->Send())    
		{   
			return FALSE;
			//echo '邮件发送有误 <p>';    
			//echo '邮件错误信息: ' . $mail->ErrorInfo;    
			//exit;    
		}    
		else {    
			//echo '邮件发送成功!<br />';    
			return TRUE;
		}    
	}

}

