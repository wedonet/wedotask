<?php

require(sysdir . '/_inc/getli.php');

class Cls_html {

    public $title = '';
    public $keywords;
    public $description;
    public $topplus;
    public $crumb;
    public $a_li;

    /* 添加topplus */

    function __construct() {
        $this->main = & $GLOBALS['main'];
    }

    /* 添加topplus */

    function addcss($filename) {
        $this->topplus .= '<link rel="stylesheet" type="text/css" href="' . $filename . '" />' . PHP_EOL;
    }

    function addjs($filename) {
        $this->topplus .= '<script type="text/javascript" src="' . $filename . '"></script>' . PHP_EOL;
    }

// end func



    function dohtml($s) {
		$s = $this->gethead() . $s . $this->getfoot();
		
        return $this->replaceallflag($s);
    }



    function gethead() {
        $headplus = $GLOBALS['main']->htm('css');
        $headplus .= $this->topplus;

        $s = $GLOBALS['main']->htm('head', '_main');

        $s = str_replace('{$title}', $this->title, $s);
        $s = str_replace('{$keywords', $this->keywords, $s);
        $s = str_replace('{$description}', $this->description, $s);

        $s = str_replace('{$headplus}', $headplus, $s);

        $s = str_replace('{$timestamp}', timestamp, $s);

        return $s;
    }

// end func

    /**
     * 生成上传图片的链接地址.
     * @param   type    $varname    description
     * @return  type    description
     * @access  public or private
     * @static  makes the class property accessible without needing an instantiation of the class
     */
    function selimg($obj, $preid = null) {
        $s = webdir . 'tools/myfiles.php?ftype=1';
        $s .= '&amp;obj=' . $obj;

        if (null !== $preid) {
            $s .= '&amp;preid=' . $preid;
        }
        return $s;
    }

// end func

    function replaceallflag($s) {
         if (stripos($s, '{$li(') != FALSE) {
            $s = $this->readli($s);
        }    
	
		//大块标签放上面，里面可能还有小块标签
        if (stripos($s, '{$top}') != false)
            $s = str_replace('{$top}', $this->main->htm('top', '_main'), $s);

        if (stripos($s, '{$menu}') != false)
            $s = str_replace('{$menu}', $this->getmenu(), $s);

        if (stripos($s, '{$crumb}') != false)
            $s = str_replace('{$crumb}', $this->getcrumb(), $s);

        if (stripos($s, '{$bottom}') != false)
            $s = str_replace('{$bottom}', $this->main->htm('bottom', '_main'), $s);






        if (stripos($s, '{$webdir}') != false)
            $s = str_replace('{$webdir}', webdir, $s);

        if (stripos($s, '{$webname}') != false)
            $s = str_replace('{$webname}', webname, $s);

        if (stripos($s, '{$styledir}') != false)
            $s = str_replace('{$styledir}', '/_style/' . CurStyle . '/', $s);



        if (stripos($s, '{$debuginfo}') != false) {
            $s = str_replace('{$debuginfo}', $this->getdebuginfo(), $s);
        }

        if (stripos($s, '{$cid}') != false) {
            if (isset($this->channel)) {
                $cid = $this->channel['id'];
            } else {

                $cid = 0;
            }
            $s = str_replace('{$cid}', $cid, $s);
        }

        if (stripos($s, '{$cic}') != false) {
            if (isset($this->channel)) {
                $cic = $this->channel['ic'];
            } else {

                $cic = '';
            }
            $s = str_replace('{$cic}', $cic, $s);
        }



        //频道名称
        if (false != stripos($s, '{$channelname}')) {
            if (isset($this->channel)) {
                $t = $this->channel['title'];
            } else {

                $t = '';
            }
            $s = str_replace('{$channelname}', $t, $s);
        }

        //频道信息
        if (false != stripos($s, '{$channeltip}')) {
            if (isset($this->channel)) {
                $t = $this->channel['mytip'];
            } else {

                $t = '';
            }
            $s = str_replace('{$channeltip}', $t, $s);
        }
        
        if (false != stripos($s, '{$u_dname}')) {
            $s = str_replace('{$u_dname}', $this->main->user['u_dname'], $s);
        }
  
        if (false != stripos($s, '{$u_gname}')) {
            $s = str_replace('{$u_gname}', $this->main->user['u_gname'], $s);
        }
        
        if (false != stripos($s, '{$u_fullname}')) {
            $s = str_replace('{$u_fullname}', $this->main->user['u_fullname'], $s);
        }
        
        return $s;
    }

    /* readli */

    //require(sysdir . '/_inc/getli.php');
  

    /* 替换 li标签 */

    function readli(&$str) {
        $clsli = new ClsLi;

        if (!is_array($this->a_li)) {
            $this->findli($str);
        }

        if ($this->a_li == FALSE) {
            return $str;
        }

        /* 选换style，因为style里可能包含其它的 */


        /* 换其它的 */
        /* 循环每组参数 */
        for ($i = 0; $i < count($this->a_li[0]); $i++) {
            //只保留参数
            $para = $this->a_li[2][$i];

            $str = str_replace($this->a_li[0][$i], $clsli->getli($para), $str);
        }

        unset($clsli);

        return $str;
    }



    /* 把html中的标签存进a_li */
    function findli($str) {
        if ( strlen($str) == 0 ) {
            $this->a_li = false;
            return;
        }

        $regex = '/(' . $this->CorrectPattern('{$li(') . ')(.+)(' . $this->CorrectPattern(')}') . ')/';

        $matches = array();

        if (preg_match_all($regex, $str, $matches)) {
            $this->a_li = $matches;
        } else {
            $this->a_li = false;
        }
    }

// end func


    /* 从标签数组中提取list数组 
     * 返回 数组 
     * para : array 参数
     * tag : str 标签
     */
    

    function getparalist() {
        if (false == $this->a_li) {
            return false;
        }
//print_r($this->a_li);
//die;
        for ($i = 0; $i < count($this->a_li[0]); $i++) {
            if (false !== stripos($this->a_li[0][$i], '{$li(list,')) {
                //print_r($this->a_li[2][$i]);
                //die;
                $t['tag'] = $this->a_li[0][$i];
                
                $t['para'] = $this->a_li[2][$i];
                $t['para'] = explode(',', $t['para']);
                
                return $t;
            }
        }
    }

// end func


    /* 函数名：CutMatchContent
     * 作  用：截取相匹配的内容
     * 参  数：Str   ----原字符串
     *        PatStr   ----符合条件字符
     * 返回数组
     */

    function CutMatchContent($str) {
        if (strlen($str) == 0) {
            return FALSE;
        }

        $regex = '/(' . $this->CorrectPattern('{$li(') . ')(.+)(' . $this->CorrectPattern(')}') . ')/';

        $matches = array();

        if (preg_match_all($regex, $str, $matches)) {
            return $matches[0];
        } else {
            return FALSE;
        }
    }

    public function CorrectPattern($str) {
        $str = str_replace('\\', '\\\\', $str);
        $str = str_replace('!', '\!', $str);
        $str = str_replace('@', '\@', $str);
        $str = str_replace('#', '\#', $str);
        $str = str_replace('%', '\%', $str);
        $str = str_replace('^', '\^', $str);
        $str = str_replace('&', '\&', $str);
        $str = str_replace('*', '\*', $str);
        $str = str_replace('(', '\(', $str);
        $str = str_replace(')', '\)', $str);
        $str = str_replace('-', '\-', $str);
        $str = str_replace('+', '\+', $str);
        $str = str_replace('[', '\[', $str);
        $str = str_replace(']', '\]', $str);
        $str = str_replace('<', '\<', $str);
        $str = str_replace('>', '\>', $str);
        $str = str_replace('.', '\.', $str);
        $str = str_replace('/', '\/', $str);
        $str = str_replace('?', '\?', $str);
        $str = str_replace('=', '\=', $str);
        $str = str_replace('|', '\|', $str);
        $str = str_replace('$', '\$', $str);

        return $str;
    }

// end func

    public function sqloption($sql, $v = 'id') {
        $tli = '<option value="{$' . $v . '}">{$title}</option>' . PHP_EOL;
        $li = $GLOBALS['we']->repm($sql, $tli);
        return $li;
    }

// end func

    public function sqlcheckbox($sql, $name, $v = 'id') {
        $tli = '<input type="checkbox" name="' . $name . '" value="{$' . $v . '}" class="vmiddle" /> {$title} &nbsp; ' . PHP_EOL;

        return $GLOBALS['main']->repm($sql, $tli);
    }

// end func

    public function getnamelist($sql, $myfield, $idlist) {
        $s = '';

        if (strlen($idlist) < 1) {
            return true;
        } else {
            //判断idlist有没有非法字符
            $a = explode(',', $idlist);
            for ($i = 0; $i < count($a); $i++) {
                if (!is_numeric($a[$i])) {
                    return '';
                }
            }

            $sql = str_replace('{$idlist}', $idlist, $sql);
        }

        $rs = $GLOBALS['main']->execute($sql);

        if (FALSE !== $rs) {
            foreach ($rs['rs'] as $v) {
                $s .= ($v[$myfield] . ',');
            }
        }

        if ('' != $s) {
            $s = substr($s, 0, strlen($s) - 1);
        }

        return $s;
    }



    function getoptionclassbychannel($cid) {
        $tli = '<option value="{$id}" >{$title}</option>' . PHP_EOL;
        $s = '';

        $a = $GLOBALS['main']->getclass($cid);

        foreach ($a as $v) {
            $li = $tli;

            if ($v['depth'] * 1 > 0) {

                $v['title'] = '|' . str_repeat('-', $v['depth'] * 2) . $v['title'];
            }

            $li = str_replace('{$title}', $v['title'], $li);
            $li = str_replace('{$id}', $v['id'], $li);

            $s.=$li;
        }

        return $s;
    }

    function getmenu() {
        $li = '';

        $s = $this->main->htm('menu', '_main');
        $tli = $this->main->htm('menuli', '_main');

        $arrchannel = $this->main->getarr('channel');

        foreach ($arrchannel as $item) {

            if (1 == $item['cha_show']) {
                //系统和内部频道

                $t = $tli;
                $t = str_replace('{$href}', $this->gethref($item), $t);
                $t = str_replace('{$title}', $item['title'], $t);
                $li .= $t;
            }
        }

        $s = str_replace('{$li}', $li, $s);

        return $s;
    }

    //$arr = 当前频道数组
    function gethref($arr) {
        $t = '';

        //外部频道
        if ($arr['cha_type'] > 10) {
            $t = $arr['cha_url'];
        } else {
            //系统和内部频道
            if ('index' == $arr['cha_module']) {
                $t = '/';
            } else {

                $t = '/' . $arr['cha_dir'] . '/index.php?cid=' . $arr['id'];
            }
        }
        return $t;
    }

    //转{$li(style,...}为实际代码
    function getstyleli($s) {
        $s = str_replace('{$li(style,', '', $s);

        $s = str_replace(')}', '', $s);

        $arr = explode(',', $s);

        return $GLOBALS['main']->style($arr[0], $arr[1]);
    }

    function getcrumb($str = null) {
        if ($str === null) {
            $str = $this->crumb;
        }

        $s = $this->main->htm('crumb', '_main');

        $s = str_replace('{$li}', $str, $s);

        return $s;
    }

    function getfoot() {
        return $GLOBALS['main']->htm('foot', '_main');
    }

    function getdebuginfo() {
        return '<span class="runtime">&nbsp;&nbsp;Run Time:' . round((microtime(true) - pagestarttime), 4) . ' 秒</span>,	<span>查询:' . $GLOBALS['main']->sqlquerynum . '次</span>';
    }

}