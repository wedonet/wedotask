<?php

class Cls_document {

    //public $cid = 0;
    //public $channel;

    public function __construct() {
        $this->main = & $GLOBALS['main'];
        $this->html = & $GLOBALS['html'];
    }



    function htmlindex() {
		/*=====提取频道信息*/
		$this->main->cid = $this->main->rqid('cid');
        $this->main->a_channel = $this->main->getarr('channel', $this->main->cid);


        if (false == $this->main->a_channel) {
            showerr('频道错误!');
        } 
        crumb($this->main->a_channel['title']);



		/*====提取模板,提取时可能会用到频道信息*/
        define('sp', $this->getsp('_index'));

        $h = $this->main->htm('main');


		/*如果有list标签*/
        if ( false !== stripos($h, '{$list(')) {      
            /*提取标签和参数*/
            $a_tag = $this->gettag($h);

            $tli = $this->main->htm( $a_tag['name'], $a_tag['page'] );
			$tli = str_replace( '{$href}', webdir.'document/detail.php?id={$id}', $tli );

            $sql = 'select * from `' . sh . '_document` where 1 ';
            $sql .= ' and isdel=0 ';
            $sql .= ' and cid =' . $this->main->a_channel['id'];
            $sql .= ' order by cls asc,id desc ';


            $li = $GLOBALS['main']->repm($sql, $tli, null, $this->main->a_channel['cha_page'], true);
           
            $h = str_replace($a_tag['tag'], $li, $h);
            
            if ( false !== stripos($h, '{$pagelist')){
                $h = str_replace('{$pagelist}', $this->main->pagelist(), $h);
            }
        }







        /* 生成标题 */
        title($this->main->a_channel['title']);









        echo ($this->html->dohtml($h));
    }


    function htmllist() {
        /* request */
		$cid = $this->main->rqid('cid'); //仍然需要接收频道id,因为有分类为0，或显示全部分类的情况
        $classid = $this->main->rqid('classid');

		
		/*====提取频道信息进缓存*/
		$this->main->a_channel = $this->main->getarr('channel', $cid);
		if ( false == $this->main->a_channel) {
			showerr(1022);
		}
		$a_channel =& $this->main->a_channel;


        /*==== 有分类时，提取这个分类 */
        if ($classid > 0) {
			$this->main->a_class = $this->main->getarr('class', $classid);

			$a_class =& $this->main->a_class; 

            if (false === $a_class) {
                showerr(1022);
            }


            $this->crumbclass($a_class['idpath']);
        }

        define('sp', $this->getsp('_list')); //提取使用的是哪个模板

        $h = $this->main->htm('main');


		/*如果有list标签*/
        if ( false !== stripos($h, '{$list(')) {      
            /*提取标签和参数*/
            $a_tag = $this->gettag($h);

            $tli = $this->main->htm( $a_tag['name'], $a_tag['page'] );
			$tli = str_replace( '{$href}', webdir.'document/detail.php?id={$id}', $tli );

            $sql = 'select * from `' . sh . '_document` where 1 ';
            $sql .= ' and isdel=0 ';
            $sql .= ' and cid =' . $this->main->a_channel['id'];
            $sql .= ' order by cls asc,id desc ';


            $li = $GLOBALS['main']->repm($sql, $tli, null, $this->main->a_channel['cha_page'], true);
           
            $h = str_replace($a_tag['tag'], $li, $h);
            
            if ( false !== stripos($h, '{$pagelist')){
                $h = str_replace('{$pagelist}', $this->main->pagelist(), $h);
            }
        }


//        $tli = str_replace('{$href}', webdir.'document/detail.php?id={$id}', $tli);
//
//        title($this->main->a_channel['title']);
//
//
//
//        $sql = 'select * from `' . sh . '_document` where 1 ';
//        $sql .= ' and isdel=0 ';
//        $sql .= ' and cid =' . $this->main->a_channel['id'];
//
//        if ($classid > 0) {
//            $sql .= ' and classid in (Select id from `' . sh . '_class` where idpath like "' . $a_class['idpath'] . '%") ';
//        }
//
//        $sql .= ' order by cls asc,id desc ';


//        $li = $GLOBALS['main']->repm($sql, $tli, null, $this->main->a_channel['cha_page'], true);


//        $h = str_replace('{$list}', $li, $h);
//        $h = str_replace('{$pagelist}', $GLOBALS['main']->pagelist(), $h);

        echo( $GLOBALS['html']->dohtml($h) );
    }



    function htmldetail() {		
		$id = $GLOBALS['main']->rqid('id');

		/*====提取记录*/
        $sql = 'select * from `' . sh . '_document` where 1 ';
        $sql .= ' and isdel=0 ';
        //$sql .= ' and cid=' . $this->cid;
        //$sql .= ' and classid=' . $classid;
        $sql .= ' and id=' . $id;


		$result = $this->main->exeone($sql);

		if ( false === $result ) {
			showerr(1018);
		}

		$cid = $result['cid'];
        $classid = $result['classid'];


		/*====提取频道信息进类*/
		$this->main->a_channel = $this->main->getarr('channel', $cid); 

		if (false == $this->main->a_channel) {
            showerr('频道错误!');
        } 


		/*频道名称加入面包屑*/
        crumb($this->main->a_channel['title']);




		/*分类加入面包屑*/
        if ($classid > 0) {
            $GLOBALS['html']->a_class = $GLOBALS['main']->getclass($cid, null, $classid, null);

			$idpath = $GLOBALS['html']->a_class['idpath'];

			$this->crumbclass($idpath);		
		}



		/*====提取模板*/
		define('sp', $this->getsp('_detail'));
        $h = $this->main->htm('main');





        crumb('正文.');

 
		/*====替换正文内容*/
		$h = $this->main->reprscolumn($result, sh.'_document', $h);


		title($this->main->a_channel['title']);

        echo ($this->html->dohtml($h));
    }

    function getsp($pagename) {
        $sp = '';


        //目录
        $cha_dir = $this->main->a_channel['cha_style'];

        if ('' == $cha_dir) {
            $cha_dir = 'document';
        }

        //页
        if ('' != $this->main->a_channel['cha_stylepage']) {
            //如果给这页设置了模板
            if (false !== strpos($this->a_channel['cha_stylepage'], $pagename)) {
                $arr = explode(',', $this->a_channel['cha_stylepage']);

                //循环每一页
                foreach ($arr as $item) {
                    $a = explode('=', $item);

                    if ($pagename == $a[0]) {

                        $pagename = $a[1];
                    }
                }
            }
        }

        $sp = $cha_dir . '/' . $pagename;



        //分类设了样式
        if (isset($this->main->a_class)) {

            if ('' != $this->main->a_class['mystyle'] . '') {
                $sp = $this->main->a_class['mystyle'];
            }
        }

        return $sp;
    }



    function rephref($mypage, $cid = null, $classid = null) {
        switch ($mypage) {
            case 'list':
                return webdir . 'document/list.php?classid={$classid}';
            case 'detail':
                return webdir . 'document/detail.php?id={$id}';
        }
    }


	function crumbclass($idpath) {
		$a = explode(',', $idpath);

		foreach ( $a as $v ) {
			if ('' != $v ) {
				$a_currentclass = $this->main->getclass($this->main->a_channel['id'], null, $v);
				crumb('<a href="' . webdir  . 'document/list.php?cid='.$this->main->a_channel['id'].'&amp;classid='.$v.'">' . $a_currentclass['title'] . '</a>');
			}
		}         
    }


    function gettli() {
        $tli = '';

        $a_para = $this->html->getparalist(); //提取list参数

        if (false !== $a_para) {
            $page = $a_para[1];
            if ('self' == $page) {
                $page = sp;
            }
            $tli = $this->main->htm($a_para[2], $page);
        }

        return $tli;
    }
    
    /*从模板中提取出list标签
     * 返回一个数组队
     * tag : list标签
     * page :
     * name :     * 
     */
    
    function gettag( $str ){
        
        $regex = '/(' . $this->html->CorrectPattern('{$list(') . ')(.+)(' . $this->html->CorrectPattern(')}') . ')/';

        $matches = array();

        
        if (preg_match_all($regex, $str, $matches)) {
            $a['tag'] = $matches[0][0];
            
            $para = $matches[2][0].',,'; //加两个逗号，后面就不用检测了
            
            $para = explode(',', $para);           
            
            
            $a['page'] = $para[0];
            if ('self' == $a['page']){
                $a['page'] = sp;
            }
            
            $a['name'] = $para[1];
     
            return  $a;
        } else {
            return false;
        }
    }

}