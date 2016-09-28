<?php
/**
 * Short description.
 * 
 * @author  YilinSun
 * @version 1.0
 * @package cls_login.php
 */

class Cls_login{
	public $errmsg = '';
	
	function __construct()
	{
		$this->main =& $GLOBALS['main'];
	} // end func
	/**
	 * 登录
	 */
	function chklogin(){
		$main =& $GLOBALS['main'];

		/*检测验证码*/
		if (FALSE === $GLOBALS['main']->codeistrue()) {
			ajaxerr('验证码错误!');
		}

		/*接收参数*/
		$u_name = $main->request('用户名/手机/邮箱', 'u_name', 'post', 'char', 5, 50, 'invalid');
		$u_pass = $main->request('密码', 'u_pass', 'post', 'char', 5, 20);

		ajaxerr();

		$savecookie = $main->rqid('savecookie');

		/*检测用户名密码是否正确*/
		if ($this->chkuserlogin($u_name, $u_pass, $savecookie)) {

			$main->getuserinfo();

			$sucmsg = '<li><a href="/">返回首页</a></li>'.PHP_EOL;


			/*商家,用户进入各自的控制面板*/
			switch ($main->u_gic) {

				default :
					break;
			}


			/*返回来时的网址*/
			if ( isset($_SESSION['comefrom']) ) {

				autolocate( $_SESSION("comeform"), 1000);

				$sucmsg .= '<li><a href="'.$_SESSION("comeform").'">返回来时的网址</a></li>'.PHP_EOL;
			}

                       	/*进入任务首页*/
			$sucmsg .= '<li><a href="'.webdir.'task/">进入任务首页</a></li>'.PHP_EOL;
			
                        

			/*管理员显示进入管理中心的链接*/
			if ( $this->main->ins('admin,supperadmin',  $main->user['u_gic'] ) ) {
				$sucmsg .= '<li><a href="'.admindir.'admin_index.php">进入网站管理中心</a></li>'.PHP_EOL;
			}

			
			ajaxinfo ($sucmsg);    
		}
		else {
			ajaxerr('用户名或密码错误');
		}

	} // end func



	function chkloginajax(){
		$we =& $GLOBALS['main'];

		/*检测验证码*/
		if (FALSE === $we->codeistrue()) {
			ajaxerr('验证码错误!');
		}

		/*接收参数*/
		$u_name = $we->request('用户名', 'u_name', 'post', 'char', 5, 50, 'invalid');
		$u_pass = $we->request('密码', 'u_pass', 'post', 'char', 5, 20);

		ajaxerr();

		$savecookie = $we->rqid('savecookie');

		/*检测用户名密码是否正确*/
		if ($we->chkuserlogin($u_name, $u_pass, $savecookie)) {

			$we->getuserinfo();

			//$sucmsg = '<li><a href="/">返回首页</a></li>'.PHP_EOL;



			
			jsucclose();    
		}
		else {
			ajaxerr();
		}	
	}



	function hasname( $v, $myid=null ){
		$sql = 'select count(*) from `'.sh.'_user` where u_name=:u_name';

		if ( $myid !== null ) {
			$sql .= ' and id<>'.$myid;
		}

		$para['u_name'] = $v;

		if ( $GLOBALS['main']->rscount( $sql, $para )>0 ) {
			return TRUE;
		} 
		else {
			return FALSE;
		}
	} // end func

	function hasmobile( $v, $myid=null ){
		if ( ''==$v ) {
			return false;
		}

		$sql = 'select count(*) from `'.sh.'_user` where u_mobile=:u_mobile';

		if ( $myid !== null ) {
			$sql .= ' and id<>'.$myid;
		}

		$para['u_mobile'] = $v;

		if ( $GLOBALS['main']->rscount( $sql, $para )>0 ) {
			return TRUE;
		} 
		else {
			return FALSE;
		}
	} // end func

	function hasmail( $v, $myid=null ){
		$sql = 'select count(*) from `'.sh.'_user` where u_mail=:u_mail';

		if ( $myid !== null ) {
			$sql .= ' and id<>'.$myid;
		}

		$para['u_mail'] = $v;

		if ( $GLOBALS['main']->rscount( $sql, $para )>0 ) {
			return TRUE;
		} 
		else {
			return FALSE;
		}
	} // end func


    function loginout() {
        setcookie(CacheName . "user", "", time() - 3600);
        unset($_SESSION[CacheName . 'user']);
    }
	 
	 
	 
	  /*
     * u_pass 是加密后的
     * $mysource : form=来自表单输入,密码是输入的密码, cookie=来自cookie,密码是加密后的
     */

    function chkuserlogin($u_name, $u_pass = '', $savecookie, $u_id = 0, $mysource = 'form') {
        $result = false;
        $arr = null;

        //得到用户IP
        $u_ip = $GLOBALS['main']->getip();
        $crandcode = $GLOBALS['main']->generate_randchar(10); //随机码,每次登录设一个, 这样老的cookie就不管用了


        /* 提取用户信息 */
        if (!empty($u_name)) { //按用户名提取
            $sql = 'select * from `' . sh . '_user` where ';

            if (is_email($u_name)) {
                $sql .= ' u_mail=:u_mail ';
                $arr['u_mail'] = $u_name;
            } elseif (is_mobile($u_name)) {
                $sql .= ' u_mobile=:u_mobile ';
                $arr['u_mobile'] = $u_name;
            } else {
                $sql .= ' u_name=:u_name ';
                $arr['u_name'] = $u_name;
            }
            $sql .= ' limit 1';
        } else if ($u_id > 0) { //按用户ID提取
            $sql = 'select * from `' . sh . '_user` where id=:u_id limit 1';
            $arr['u_id'] = $u_id;
        } else { //都不是的话, 那就是非法操作了
            /* 清空cookie */

            setcookie(CacheName . "user", "", time() - 3600);

            showerr(1022);
            //$arr = null;
        }

        $rs = $GLOBALS['main']->exeone($sql, $arr);

        /* 没有这个用户 */
        if (false == $rs) {
            //清除coodie, 
            setcookie(CacheName . "user", "", time() - 3600);

            //加入错误信息提示
            $this->errmsg .= '用户名或密码错误'; //实际是用户名或ID错误
            //返回
            return FALSE;
        }


        /* if u_lastlogintime 不是日期 then 给这个字段填上日期, 错误数为0 这种情况只在第一次登录时出现 */
        if ((strlen($rs['u_lastlogintime']) < 5)) { //日期恳定多于今为5位,随便写的这个数
            $sql = 'update `' . sh . '_user` set u_err=0, u_lastlogintime=' . time() . ' where id=' . $rs['id'];
            $this->main->execute($sql);
        } else { //是日期, 处理错误数
            //if数据库里存的最后登录日期是今天
            if (0 == $this->main->datediff('d', time(), $rs['u_lastlogintime'])) {
                $TodayFirstLogin = FALSE;
                //实际错误数比较规定错误数
                if ($rs['u_err'] > $GLOBALS['config']['LoginErr']) {
                    $this->errmsg = '您在今天错误登录次数已经超过' . $GLOBALS['config']['LoginErr'] . '次,请明天再试';
                    return false;
                }
            } else { //今天第一次登录
                $TodayFirstLogin = TRUE;

                //更新数据库中最后登录日期为今天, 错误数为0
                //2013/1/1 改为放在最后写入
                //$sql = 'update `'.sh.'_user` set u_err=0, u_lastlogintime=now() where id='.$rs['id'];
                //$this->execute($sql);
            }
        }

        /* 检测密码,不同then 错误数加 1 */
        $passistrue = FALSE;

        if ('form' == $mysource) {
            if ($rs['u_pass'] == md5($u_pass . $rs['randcode'])) {
                $passistrue = TRUE;
            }
        } else if ('f' == $mysource) {
            //stop ( $u_pass == $rs['u_pass'] );
            if ($rs['u_pass'] == $u_pass) {
                $passistrue = TRUE;
            }
        } else { //从cookie来的密码,和再次和随机码计算的结果
            if (md5($rs['u_pass'] . $crandcode) == $u_pass) {
                $passistrue = TRUE;
            }
        }

        if (!$passistrue) {
            //清除coodie, 
            setcookie(CacheName . 'user', '', time() - 3600);

            //生成错误信息并返回
            //错误数加一
            $sql = 'update `' . sh . '_user` set u_err=u_err+1 where id=' . $rs['id'];

            $this->main->execute($sql);

            $this->errmsg .= '登录密码错误,今天还可以尝试次数:' . ($GLOBALS['config']['LoginErr'] - $rs['u_err'] - 1);
            return false;
        } else {
            /* 答案正确,错误数归0 */
            $this->main->execute('update `' . sh . '_user` set u_err=0 where id=' . $rs['id']);
        }

        /* 检测审核 */
        if ('0' === $rs['ispass'] . '') {
            $this->errmsg.='您还没通过审核,请稍后登录';
            return FALSE;
        }

        /* 检测锁定 */
        if ('1' === $rs['islock'] . '') {
            $this->errmsg.='您已经被管理员锁定,请联系管理员解锁';
            return FALSE;
        }

        /* 检测过期 */
        if ($this->main->datediff('d', date('Y-m-d'), $rs['u_endtime']) < 0) {
            $this->errmsg.='您的会员有效时间已到期,不能登录';
            return FALSE;
        }

        /* 增加积分 */

        /* 保存登录记录 */

        $d['u_id'] = $rs['id'];
        $d['u_name'] = $rs['u_name'];
        $d['u_nick'] = $rs['u_nick'];
        $d['u_ip'] = $u_ip;
        $d['stime'] = time();
        $d['mysource'] = $mysource;

        $this->main->pdo->insert(sh . '_login', $d);

        /* 个人信息存进session */

        /* 更新状态为已登录, 更新数据库中最后登录日期为今天, 错误数为0, 分配个随机码 */
        $upuser['u_err'] = 0;
        $upuser['u_lastlogintime'] = time();
        $upuser['crandcode'] = $crandcode;
        $upuser['u_online'] = 1;

        $this->main->pdo->update(sh . '_user', $upuser, ' id=' . $rs['id']);


        /* 保存cookie用于自动登录,防掉线 */
        $u['id'] = $this->main->strcode($rs['id']); //id存的是加密后的id
        $u['pass'] = md5($u_pass . $crandcode); //cookie里存的是加密后的pass
        $u['savecookie'] = $savecookie;
        if (1 == $savecookie) {
            $mytime = time() + 3600 * 24 * 7; //保留一周
        } else {
            $mytime = time() + 3600; //保留一小时
        }
        setcookie(CacheName . "user", serialize($u), $mytime);


        /* 存进session */
        $user['id'] = $rs['id'];
        $user['u_name'] = $rs['u_name'];
        $user['u_nick'] = $rs['u_nick'];
        $user['u_gic'] = $rs['u_gic'];
        $user['u_gname'] = $rs['u_gname'];
        $user['u_dname'] = $rs['u_dname'];
        $user['u_fullname'] = $rs['u_fullname'];
        $user['u_ismaster'] = $rs['u_ismaster'];
        $user['u_face'] = $rs['u_face'];



        //提取用户组类型
        unset($rs);
        $user['u_iswebmaster'] = 0; //默认不是管理员
        $user['u_issupmaster'] = 0; //默认不是超级管理员
        $sql = 'select typeid from `' . sh . '_group` where ic="' . $user['u_gic'] . '"';
        $rs = $this->main->exeone($sql);
        if (false != $rs) {
            $typeid = $rs['typeid'];

            /* 提取管理员列表里有没有这个人 */
            $sql = 'select count(*)  from `' . sh . '_admin` where u_id = ' . $user['id'];
            if ($this->main->execount($sql) > 0) {
                $user['u_iswebmaster'] = 1;
            }
            if (100 == $user['u_gic']) {
                $user['u_issupmaster'] = 1;
            }
        }



        $_SESSION[CacheName . 'user'] = $user;

        /* 清除验证码 */
        unset($_SESSION['codestr']);

        return TRUE;
    }

	
	
}

