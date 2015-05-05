<?php



require '../global.php';





define('sp', 'user/_pass'); //定义当前页模板

$myclass = new myclass();

class myclass {

	function __construct() {
		$act = $GLOBALS['main']->ract();

		switch ($act) {
			case '' : $this->htmlmain();
				break;		

			case 'save':
			    $this->saveinfo();
			    break;
			default:
				showerr('非法事件');
				break;
		}
		san();
	}

	function htmlmain() {

		$h = $GLOBALS['main']->htm('main');

		$h = str_replace('{$action}', '/_user/pass.php?act=save', $h);

		echo $h;
	}

	
	

	function saveinfo(){
		
		$we = $GLOBALS['main'];

		$oldpass = $we->request('原密码', 'oldpass', 'post', 'char', 4, 20);

		$u_pass = $we->request('密码', 'pass1', 'post', 'char', 5, 20);
		$u_pass2 = $we->request('确认密码', 'pass2', 'post', 'char', 5, 20);

		ajaxerr();

		if ($u_pass !== $u_pass2) {
			ajaxerr('两次输入密码不同, 请重新输入', 'u_pass');
		}

		/*提取原密码*/
		$sql = 'select * from `'.sh.'_user` where 1 ';
		$sql .= ' and id='.$GLOBALS['main']->user['id'];
		
		$result = $GLOBALS['main']->exeone($sql);
		if (false === $result){
			ajaxerr(1022);		
		}
		if ( md5($oldpass . $result['randcode']) != $result['u_pass'] ){
			ajaxerr('原密码错误!');
		}
		
		/* 生成一个新的加密号 */
		$rs['randcode'] = $we->generate_randchar(8);
		$rs['u_pass'] = md5($u_pass . $rs['randcode']);
		
		$we->pdo->update(sh . '_user', $rs, ' id= ' . $we->user['id']);
		
		jsucclose();
	} // end func
}