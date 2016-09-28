<?php

class ClsLi {

    function getli($para) {

        $para = explode(',', $para);

        if (count($para) < 1) {
            return '标签参数错误' . $para;
        }

        switch ($para[0]) {
            case 'channel':
                return $this->getchannel($para);
                break;
            case 'style':
                return $this->getstyle($para);
                break;

            case 'document':
                return $this->getdocument($para);
                break;

            case 'class' :
                return $this->getclass($para);
                break;
            
            case 'item' :
                return $this->getitem($para);
                break;

            default:
                return;
                break;

            /* 可能还有其它自定议标签,在其它函数替换 */
            //default:
            //    return '{$' . join(',', $para) . '}参数错误';
            //    break;
        }
    }

    /*
     * para[1] : 页名
     * para[2] : 代码名
     * para[3] : 显示数量
     */

    function getstyle($para) {
        $tli = $GLOBALS['main']->htm($para[2], $para[1]);

        if (count($para) < 2) {
            return '标签参数错误' . $this->paratotag($para);
        }

        if (!array_key_exists(3, $para)) {
            $para[3] = 1;
        }

        if (1 == $para[3]) {
            return $tli;
        } else {
            $li = '';
            for ($i = 0; $i < $para[3]; $i++) {
                $li .= $tli;
            }
            return $li;
        }
    }

    function getdocument($para) {
        // {$li(document,news,class,special,good,10,_li,title)} 

        if (8 != count($para)) {
            return '标签参数错误' . $this->paratotag($para);
        }

        $cic = $para[1];
        $classic = $para[2];
        $specialic = $para[3];
        $showtype = $para[4]; //最新,推荐
        $showcount = $para[5];
        $mypage = $para[6];
        $myname = $para[7];

        if ('class' == $classic) {
            $class = '';
        }
        if ('special' == $specialic) {
            $specialic = '';
        }
        //默认按最新显示
        if ('type' == $showtype) {
            $showtype = 'new';
        }

        $a_channel = $GLOBALS['main']->getarr("channel", null, $cic);

        if (false === $a_channel) {
            return '标签参数错误' . $this->paratotag($para);
        }

        if ('self' == $mypage) {
            $mypage = sp;
        }

        $tli = $GLOBALS['main']->htm($myname, $mypage);

        /* $tli = str_replace('{$href}', webdir.'document/detail.php?cid={$cid}&amp;classid={$classid}&amp;id={$id}', $tli); */
        $tli = str_replace('{$href}', webdir . 'document/detail.php?id={$id}', $tli);

        $sql = 'select * from `' . sh . '_document` where 1 ';
        $sql .= ' and cid=' . $a_channel['id'];
        $sql .= ' and isdel=0 ';
        $sql .= ' and isshow=1 ';

        if ('' != $classic and 'class') {

            $class = $GLOBALS['main']->getclass($a_channel['id'], null, null, $classic);

            //提取这个classic的下级classid
            //暂时提取直接等于这个分类的
            if (false != $class) {
                $sql .= ' and classid=' . $class['id'];
            }
        }





        switch ($showtype) {
            //推荐
            case 'good' :
                $sql .= ' and isgood=1 ';

                $sql .= ' order by cls asc, id desc';

                break;
            //最新	
            case 'new' :
                //下一步改为随机提取
                $sql .= ' order by cls asc, id desc';

                break;
        }


        $sql .= ' limit ' . $showcount;

        /* stop( $GLOBALS['we']->repm( $sql, $tli ) ); */
        return $GLOBALS['main']->repm($sql, $tli);
    }

    /* {$li(class,news,classic,module,type,_li,title)} */

    function getclass($para) {
        $err = '分类标签错误:' . $this->paratotag($para);

        if (6 != count($para)) {
            return $err . '参数个数错误';
        }
        /* 接收 */
        $a_channelic = $para[1];
        $classic = $para[2];
        //$module = $para[3];
        $showtype = $para[3];
        $mypage = $para[4];
        $myname = $para[5];

        /* 检测 */
        if ('self' == $mypage) {
            $mypage = sp;
        }

        $tli = $GLOBALS['main']->htm($myname, $mypage);


        $sql = 'select * from `' . sh . '_class` where 1 ';


        /* 执行 */
        //频道
        //使用当前频道做为频道
        if ('current' == $a_channelic) {
            $a_channel = $GLOBALS['html']->a_channel;
        } else {
            $a_channel = $GLOBALS['main']->getarr('channel', null, $a_channelic);
        }
        if (false == $a_channel) {
            return $err . '没找到这个频道';
        }

        $sql .= ' and cid=' . $a_channel['id'];


        //跟据频道确定分类链接
        switch ($a_channel['cha_module']) {
            case 'document':
                $tli = str_replace('{$href}', webdir . 'document/list.php?cid={$cid}&amp;classid={$id}', $tli);
                break;
        }

        //分类
        if ('' != $classic)
            $class = $GLOBALS['main']->getclass($a_channel['id'], null, null, $classic);

        //显示类型
        if ('' != $showtype) {
            switch ($showtype) {
                case 'classone':
                    $sql .= ' and pid=0 ';
                    break;
                case 'all':
                    break;
                case 'next':
                    $sql .= ' and pid=' . $class['id'];
                    break;
                case 'current':
                    $sql .= ' and pid=' . $class['id'];
                    break;
                default:
                    break;
            }
        }

        $sql .= ' order by treeid ';

        $li = $GLOBALS['main']->repm($sql, $tli);

        return $li;
    }

    /*
     * type
     * page :可以省略
     * nameul :可以省略
     * nameli :可以省略
     */

    function getchannel($para) {
        $li = '';
        /* $err = '分类标签错误:' . $this->paratotag($para); */

        /* 没有的补齐 */
        for ($i = 0; $i < 5; $i++) {
            if (!array_key_exists($i, $para)) {
                $para[$i] = '';
            }
        }

        /* 接收 */
        $type = $para[1];
        $page = $para[2];
        $nameul = $para[3];
        $nameli = $para[4];


        /* 检测 */
        if ('self' == $page) {
            $mypage = sp;
        }

        if ('' == $page) {
            $page = '_main';
        }

        if ('' == $nameul) {
            $nameul = 'menu';
        }

        if ('' == $nameli) {
            $nameli = 'menuli';
        }

        $s = $GLOBALS['main']->htm($nameul, $page);
        $tli = $GLOBALS['main']->htm($nameli, $page);


        $a_channel = $GLOBALS['main']->getarr('channel');

        foreach ($a_channel as $v) {

            if (1 == $v['cha_show']) {
                /* 系统和内部频道 */

                /* 按类型显示频道时, 如果类型不对,则进行下一个 */
                if ('' != $type AND $v['mytype'] != $type) {
                    continue;
                }

                $t = $tli;

                /* 如果是首页,then跳转到根目录 */


                switch ($v['cha_type']) {
                    case 0:

                    case 10: //系统或内部频道
                        if ('index' == $v['ic']) {
                            $t = str_replace('{$href}', webdir, $t);
                        }
                        $t = str_replace('{$href}', webdir . $v['cha_module'] . '/index.php?cid=' . $v['id'], $t);
						
                        break;

                    case 20: //外部
                        $t = str_replace('{$href}', $v['cha_url'], $t);
                        break;

                }
				
				$t = str_replace('{$mytip}', $v['mytip'], $t);

                /* 打开方式 */
                if (0 == $v['cha_opentype']) {
                    $t = str_replace('{$target}', '', $t);
                } else {
                    $t = str_replace('{$target}', 'target="_blank"', $t);
                }

                $t = str_replace('{$title}', $v['title'], $t);
                $li .= $t;
            }
        }

        $s = str_replace('{$li}', $li, $s);

        return $s;
    }

	/*调用单条记录的标签*/
   function getitem($para) {
        // {$li(item,,_li,title)} 

        if (8 != count($para)) {
            return '标签参数错误' . $this->paratotag($para);
        }

        $cic = $para[1];
        $classic = $para[2];
        $specialic = $para[3];
        $showtype = $para[4]; //最新,推荐
        $showcount = $para[5];
        $mypage = $para[6];
        $myname = $para[7];

        if ('class' == $classic) {
            $class = '';
        }
        if ('special' == $specialic) {
            $specialic = '';
        }
        //默认按最新显示
        if ('type' == $showtype) {
            $showtype = 'new';
        }

        $a_channel = $GLOBALS['main']->getarr("channel", null, $cic);

        if (false === $a_channel) {
            return '标签参数错误' . $this->paratotag($para);
        }

        if ('self' == $mypage) {
            $mypage = sp;
        }

        $tli = $GLOBALS['main']->htm($myname, $mypage);

        /* $tli = str_replace('{$href}', webdir.'document/detail.php?cid={$cid}&amp;classid={$classid}&amp;id={$id}', $tli); */
        $tli = str_replace('{$href}', webdir . 'document/detail.php?id={$id}', $tli);

        $sql = 'select * from `' . sh . '_document` where 1 ';
        $sql .= ' and cid=' . $a_channel['id'];
        $sql .= ' and isdel=0 ';
        $sql .= ' and isshow=1 ';

        if ('' != $classic and 'class') {

            $class = $GLOBALS['main']->getclass($a_channel['id'], null, null, $classic);

            //提取这个classic的下级classid
            //暂时提取直接等于这个分类的
            if (false != $class) {
                $sql .= ' and classid=' . $class['id'];
            }
        }





        switch ($showtype) {
            //推荐
            case 'good' :
                $sql .= ' and isgood=1 ';

                $sql .= ' order by cls asc, id desc';

                break;
            //最新	
            case 'new' :
                //下一步改为随机提取
                $sql .= ' order by cls asc, id desc';

                break;
        }


        $sql .= ' limit ' . $showcount;

        /* stop( $GLOBALS['we']->repm( $sql, $tli ) ); */
        return $GLOBALS['main']->repm($sql, $tli);
    }



	/*标签参数 数组变成标签*/
    function paratotag($para) {
        return '{$li(' . join(',', $para) . ')}';
    }





}

// end class






