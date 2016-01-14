<?php

require(sysdir . '/_inc/security.php');
require(sysdir . '/_inc/pdo.php');

class Cls_main {

    public $sqlquerynum = 0;
    public $errmsg;
    public $back = '';
    public $currentpage; //当前页数
    public $mymaxpage; //当前sql每页记录数
    public $totalrs; //当前sql查询返回的记录数

    function __construct() {
        //$this->errmsg = & $GLOBALS['errmsg'];
        $this->cache = & $GLOBALS['cache'];
        $this->pdo = new ClsPdo();
        $this->config = $GLOBALS['config'];


        $this->mystyle = & $this->config['CurStyle'];

        $this->ismember = false;
        $this->ismaster = false; //前台登录后的管理员
        $this->istruemaster = false; //后台登录后
        //$this->errmsg = & $GLOBALS['errmsg'];

        $this->GetSetup();
        $this->GetUserInfo();
    }

    function __destruct() {
        
    }

    function GetSetup() {
        if (isset($_REQUEST['GLOBALS']) OR isset($_FILES['GLOBALS'])) {
            exit('Request tainting attempted.');
        }
        /* 检测站外提交 */
        //chkpost(); $this->scriptname

        $t = explode('/', $_SERVER['PHP_SELF']);
        $this->scriptname = end($t);
    }

// end func

    function ract($s = 'act') {
        if (isset($_GET[$s])) {
            $s = substr(trim($_GET[$s]), 0, 20);
        } else {
            $s = null;
        }
        return $s;
    }

    /**
     * 接收数字
     */
    function rqid($s = 'id', $v = -1) {
        if (isset($_GET[$s])) {
            $x = Trim($_GET[$s]);
        } else {
            $x = $v;
        }

        if (strlen($x) > 20) {
            showerr(1022);
        }
        if (!is_numeric($x)) {
            return $v;
        } else {
            return floor($x);
        }
    }

    function rfid($s, $v = -1) {
        if (isset($_POST[$s])) {
            $x = Trim($_POST[$s]);
        } else {
            $x = $v;
        }

        if (strlen($x) > 20) {
            showerr(1022);
        }
        if (!is_numeric($x)) {
            return $v;
        } else {
            return floor($x);
        }
    }

    /* title=模板名 */
    /* sp = 页名,默认当前页 */

    function htm($title, $sp = null) {
        /* 没给页名子就用默认的 */
        if (null == $sp) {
            $sp = sp;
        }

        $mycachename = $this->mystyle . '/' . $sp;

        $data = $this->cache->get($mycachename);

        /* 还没缓存 */
        if (false === $data) {
            $data = $this->getstyle($sp);

            if (false === $data) {
                return '<span class="red">模板文件名错误:' . $sp . '</span>';
            }
            $this->cache->save($mycachename, $data);
        }

        if (!array_key_exists($title, $data)) {
            /* 提未没找到 */
            return '模板标识错误: ' . $sp . ':' . $title;
        }

        return $data[$title];
    }

    /* 从模板生成数组 
     * return false时,没找到这个页
     */

    function getstyle($filename) {
        $f = webdir . '_style/' . $this->mystyle . '/' . $filename . '.php';

        $psyfile = sysdir . $f;

        @$xml = simplexml_load_file($psyfile);

        if ($xml === false) {
            //return '模板文件名错误:' . $filename;
            return false;
            /* showerr('模板文件名错误:' . $filename); */
        } else {
            $a = array();
            foreach ($xml->children() as $node) {
                $a[$node->getName()] = (string) $node;
            }
            $xml = null;
            return $a;
        }
    }

    function getRealSize($size) {
        $kb = 1024; // Kilobyte
        $mb = 1024 * $kb; // Megabyte
        $gb = 1024 * $mb; // Gigabyte
        $tb = 1024 * $gb; // Terabyte

        if ($size < $kb) {
            return $size . " B";
        } else if ($size < $mb) {
            return round($size / $kb, 2) . " KB";
        } else if ($size < $gb) {
            return round($size / $mb, 2) . " MB";
        } else if ($size < $tb) {
            return round($size / $gb, 2) . " GB";
        } else {
            return round($size / $tb, 2) . " TB";
        }
    }

    /* 移除数据字段标签 */

    function removemdbfield($s, $sheetname) {
        $myfield = $this->getfieldnamelist($sheetname);

        foreach ($myfield as $key => $value) {
            if (strpos($s, '{$' . $value) != FALSE) {
                $s = preg_replace('/{\$' . $value . '[^}]*}/', '', $s);
            }
        }
        return $s;
    }

    /* 提取数据表字段数组 */

    function getfieldnamelist($sheetname) {
        //这里有问题

        $myfield = $this->cache->get(CacheName . 'table_' . $sheetname);

        if (FALSE === $myfield) {
            $myfield = $this->pdo->getFields($sheetname);
            $this->cache->save(CacheName . 'table_' . $sheetname, $myfield);
        }

        return $myfield;
    }

    /**
      接收并检测input
      检测是否数字时必须设为必填项,否则检测是也当必填项处理
      1.title				: 名称
      2.myname			: input name
      3.mytype			: get还是post,或cb(checkbox by post)
      4.inputtype		: 类型(char = 字符, num=数字, int=int, phone, mail, mobile, date)
      5.mix				: 最小字符,=0时不作限制
      6.max				: 最大字符,=0是不作限制
      7.myfilter		: folder, invalid, encode, phone, mail, mobile, date
     */
    function request($mytitle, $myname, $mytype, $inputtype, $mix = 0, $max = 0, $myfilter = '', $mustfill = true) {
        $s = '';
        $tempbool = FALSE;

        $this->security = new CI_Security();

        /* 接收数据 */
        switch ($mytype) {
            case 'get':
                if (isset($_GET[$myname])) {
                    $s = trim($_GET[$myname]);
                } else {
                    $s = '';
                }
                break;
            case 'post':
                if (isset($_POST[$myname])) {
                    $s = trim($_POST[$myname]);
                } else {
                    $s = '';
                }
                break;
            case 'cb': //post checkbox
                if (isset($_POST[$myname])) {
                    $s = $_POST[$myname];
                } else {
                    $s = '';
                }
                if (is_array($s)) {
                    $s = join(',', $s);
                }
                break;
            default :
                stop('非法method!' . $mytitle);
                break;
        }


        /* 检测是否必填 */
        if ('' == $s) {
            /* 必填时 */
            if ($mustfill) {

                $this->errmsg .= ('<li>请填写 ' . $mytitle . '</li>');
                $this->back .= ($myname . ',');

                return '';
            }
            /* 不必填直接返回空值 */ else {
                return '';
            }
        }

        /* 过滤 */
        /* 提交的是文件夹 */
        if (strpos($myfilter, 'folder') !== false) {
            $s = $this->security->sanitize_filename($s);
            $myfilter = str_replace('folder', '', $myfilter);
        }

        /* 过滤非法字符, 只允许中,英文,数字 */
        if (strpos($myfilter, 'invalid') !== false) {
            if (invalidreg($s)) {
                $this->errmsg .= ('<li>' . $mytitle . '含有非法字符</li>');
                $this->back .= ($myname . ',');
            }
            $myfilter = str_replace('invalid', '', $myfilter);
        }

        /* htmlencode */
        if (strpos($myfilter, 'encode') !== false) {
            $s = htmlencode($s);
            $myfilter = str_replace('encode', '', $myfilter);
        }


        /* 如果myfilter里还有其它字符,恳定是写错了 */
        $myfilter = str_replace(',', '', $myfilter);
        if (!empty($myfilter)) {
            showerr('request:' . $mytitle . '的过滤条件有问题' . $myfilter);
        }


        /* 检测字符类型 */
        switch ($inputtype) {
            case 'num':
                if (!is_numeric($s)) {
                    $this->errmsg .= ('<li>' . $mytitle . '格式错误</li>');
                    $this->back .= ($myname . ',');
                }
                break;
            case 'int':
                $tempbool = FALSE;

                if (is_numeric($s)) {
                    if (is_int($s * 1)) {
                        $tempbool = TRUE;
                    } else {
                        $tempbool = FALSE;
                    }
                } else {
                    $tempbool = FALSE;
                }

                if (FALSE == $tempbool) {
                    $this->errmsg .= ('<li>' . $mytitle . '必须是整数</li>');
                    $this->back .= ($myname . ',');
                }

                break;
            case 'char':
                //字符就不用检测了
                break;
            case 'date':
                if (!strtotime($s)) {
                    $this->errmsg .= ('<li>' . $mytitle . '格式错误</li>');
                    $this->back .= ($myname . ',');
                }
                break;
            case 'phone':
                if (!is_phone($s)) {
                    $this->errmsg .= ('<li>' . $mytitle . '格式错误</li>');
                    $this->back .= ($myname . ',');
                }
                break;
            case 'mobile':
                if (!is_mobile($s)) {
                    $this->errmsg .= ('<li>' . $mytitle . '格式错误</li>');
                    $this->back .= ($myname . ',');
                }
                break;
            case 'mail':
                if (!is_email($s)) {
                    $this->errmsg .= ('<li>' . $mytitle . '格式错误</li>');
                    $this->back .= ($myname . ',');
                }
                break;
            default:
                showerr($mytitle . '的类型限制错误!');
                break;
        }

        /* 检测字符范围 */
        /* 检测字符必须大于多少,1.如果必填,不满足最小字符时提示错误, 必填的情况已经被''==$s排除了 */
        if ('num' == $inputtype Or 'int' == $inputtype) {
            if ($s * 1 < $mix) {
                $this->errmsg .= ('<li>' . $mytitle . '必须大于' . $mix . '</li>');
                $this->back .= ($myname . ',');
            }
            if ($s * 1 > $max) {
                $this->errmsg .= ('<li>' . $mytitle . '必须小于' . $max . '</li>');
                $this->back .= ($myname . ',');
            }
        }
        /* 除了数字就是字符了 */ else {
            if ($mix > 0) {
                if ($this->strlen($s) < $mix) {
                    $this->errmsg .= ('<li>' . $mytitle . '的字符数必须多于' . $mix . '</li>');
                    $this->back .= ($myname . ',');
                }
            }
            /* 检测字符必须小于多少 */
            if ($max > 0) {
                if ($this->strlen($s) > $max) {
                    $this->errmsg .= ('<li>' . $mytitle . '的字符数必须少于' . $max . '</li>');
                    $this->back .= ($myname . ',');
                }
            }
        }


        return $s;
    }

    /**
     * 接收idlist. 接收传过来的数组变字符串
     */
    function ridlist($name, $method = 'post') {
        if ('post' == $method And isset($_POST[$name])) {
            $s = $_POST[$name];
        } else if ('get' == $method And isset($_GET[$name])) {
            $s = $_GET[$name];
        } else {
            return '';
        }



        if (is_array($s)) {
            for ($i = 0; $i < count($s); $i++) {
                if (!is_numeric($s[$i])) {
                    return '';
                }
            }
            $s = join(',', $s);
        } else {
            $s = '';
        }
        return $s;
    }

//接收传过来的字符串列表
    function rqidlist($name, $method = 'get') {
        $s = '';
        $b = array();


        if ('get' == $method) {
            if (isset($_GET[$name])) {
                $s = $_GET[$name];
            }
        } else {
            if (isset($_POST[$name])) {
                $s = $_POST[$name];
            }
        }

        if ('' != $s) {
            $a = explode(',', $s);


            for ($i = 0; $i < count($a); $i++) {
                if (is_numeric($a[$i])) {
                    $b[] = $a[$i];
                }
            }
            return implode(',', $b);
        } else {
            return '';
        }
    }

    function getstring($name = null) {
        if (null === $name) {
            return '';
        } else {
            if (isset($name)) {
                return $_GET[$name];
            } else {
                return '';
            }
        }
    }

    function ric($name, $method = 'get') {
        $s = '';

        if ('get' == $method) {
            if (isset($_GET[$name])) {
                $s = $_GET[$name];
            }
        } else {
            if (isset($_POST[$name])) {
                $s = $_POST[$name];
            }
        }



        if (invalidreg($s)) {
            showerr($name . '含有非法字符:' . $s);
        } else {
            return $s;
        }
    }

    /* execute */

    function execute($sql, $para = null, $haspage = false) {

        $this->sqlquerynum++;

        try {
            $t = $this->pdo->execute($sql, $para, $haspage);
        } catch (PDOException $e) {
            showerr('sql语句错误' . $sql . ' <br />errinfo:' . $e . '<br />');
        }
        return $t;
    }

    /* 直接返回result */

    function executers($sql, $para = null) {

        $this->sqlquerynum++;
        try {
            $t = $this->pdo->execute($sql, $para);
        } catch (PDOException $e) {
            showerr('sql语句错误' . $sql . '<br />' . $e);
        }
        return $t['rs'];
    }

    /**
     * 执行SQL,返回查询到的数据.
     * @param   type    sql string
     * @return  FALSE OR ARRAY
     */
    function exeone($sql, $para = null) {

        $this->sqlquerynum++;
        try {
            $t = $this->pdo->execute($sql, $para);
        } catch (PDOException $e) {
            showerr('sql语句错误' . $sql);
        }

        if ($t !== FALSE) {
            if ($t['total'] > 0) {
                $t = $t['rs'][0];
            } else {
                $t = FALSE;
            }
        }
        return $t;
    }

    /* 计算查询到的结果 */

    function rscount($sql, $para = null) {
        $this->sqlquerynum++;
        try {
            $t = $this->pdo->execute($sql, $para);
        } catch (PDOException $e) {
            showerr('sql语句错误' . $sql);
        }

        return $t['rs'][0]['count(*)'];
    }

    /**
     * 执行SQL,返回查询到的数量统计.
     * @param   type    sql string
     * @return  int
     */
    function execount($sql, $para = null) {
        $this->sqlquerynum++;
        try {
            $t = $this->pdo->execute($sql, $para, FALSE);
        } catch (PDOException $e) {
            showerr('sql语句错误' . $sql);
        }

        return $t['rs'][0]['count(*)'];
    }

    /* 执行sql,返回数组,自动处理翻页 */

    function exers($sql, $maxpage = 0, $para = null) {
        $this->getcurrentpage();

        if (0 == $maxpage) {
            $maxpage = MaxPage;
        }
        $this->mymaxpage = $maxpage;

        if (1 === $this->currentpage) {
            $startitem = 0;
        } else {
            $startitem = ($this->currentpage - 1) * $maxpage - 1;
        }

        $sql .= ' limit ' . $startitem . ',' . $maxpage;

        $rs = $this->execute($sql, $para, true);

        //向类传递总记录数
        $this->totalrs = $rs['total'];

        return $rs;
    }

    /*
      $arr = sql要绑定的数据
      repm 不返回数据,只有替换后的字符串 replacemdb返回数据
     */

    function repm($sql, $tli, $arr = null, $maxpage = 0, $haspage = false) {
        $r = $this->replacemdb($sql, $tli, $arr, $maxpage, $haspage);
        return $r['str'];
    }

    /*  $arr = sql要绑定的数据  */

    function replacemdb($sql, $tli, $arr = null, $maxpage = 0, $haspage = false, $backfield = null) {
        $bfv = array(); /* 返回的值 */

        $mytablename = $this->gettablename($sql);

        /* 检测这个表是不是做了更新, 更新了重新算, 否则从缓存提, going to do */

        $myfield = $this->getmdbfield($mytablename, $tli, $backfield);

        $sql = str_replace('*', $myfield, $sql);

        if ($haspage) {
            //求出limit的开始和结束记录
            $this->getcurrentpage();

            if (0 == $maxpage) {
                $maxpage = MaxPage;
            }

            $this->mymaxpage = $maxpage;

            if (1 === $this->currentpage) {
                $startitem = 0;
            } else {
                $startitem = ($this->currentpage - 1) * $maxpage - 1;
            }

            $sql .= ' limit ' . $startitem . ',' . $maxpage;

            $arrs = $this->execute($sql, $arr, $haspage);
        } else {
            if ($arr == null) {
                $arrs = $this->execute($sql);
            } else {
                $arrs = $this->execute($sql, $arr);
            }
        }

        $rs = $arrs['rs'];

        //向类传递总记录数
        $this->totalrs = $arrs['total'];


        $s = array();

        $countrs = count($rs);

        //向类返回查询到的记录总数,供翻页代码用
        //$this->countrs = $countrs;

        $afield = explode(',', $myfield);
        $countfield = count($afield);
        if ($countrs > 0) {
            for ($i = 0; $i < $countrs; $i++) {
                $id = $rs[$i]['id'];

                $s[$i] = $tli;

                /* 替换序号 */
                //if (stripos($s[$i], '{$i}') !== false) $s[$i] = str_replace('{$i}', $i+1, $s[$i]);
                //循环字段
                for ($j = 0; $j < $countfield; $j++) {
                    $t = $rs[$i][$afield[$j]] . ''; //值
                    $f = & $afield[$j]; //字段名

                    if (stripos($s[$i], '{$' . $f . '}') != false) {
                        $s[$i] = str_replace('{$' . $f . '}', $t, $s[$i]);
                    }

                    /* encode */
                    if (stripos($s[$i], '{$' . $f . '_htmlencode}') != false) {
                        $s[$i] = str_replace('{$' . $f . '_htmlencode}', htmlencode($t), $s[$i]);
                    }

                    /* formattime */
                    if (stripos($s[$i], '{$' . $f . '_dateformat') !== FALSE) {

                        if (stripos($s[$i], '{$' . $f . '_dateformat') !== FALSE) {
                            if (FALSE !== stripos($s[$i], '{$' . $f . '_dateformat1}')) {
                                if (0 == strlen($t)) {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat1}', '', $s[$i]);
                                } else {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat1}', date('Y-m-d', $t), $s[$i]);
                                }
                            }
                            if (FALSE !== stripos($s[$i], '{$' . $f . '_dateformat2}')) {
                                if (0 == strlen($t)) {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat2}', '', $s[$i]);
                                } else {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat2}', date('Y-m-d H:i:s', $t), $s[$i]);
                                }
                            }

                            if (FALSE !== stripos($s[$i], '{$' . $f . '_dateformat3}')) {
                                if (0 == strlen($t)) {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat3}', '', $s[$i]);
                                } else {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat3}', date('y-m-d ', $t), $s[$i]);
                                }
                            }

                            if (FALSE !== stripos($s[$i], '{$' . $f . '_dateformat4}')) {
                                if (0 == strlen($t)) {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat4}', '', $s[$i]);
                                } else {
                                    $s[$i] = str_replace('{$' . $f . '_dateformat4}', date('m-d ', $t), $s[$i]);
                                }
                            }
                        }
                    }

                    /*
                      if (stripos($s[$i], '{$' . $f . '_no0') !== FALSE) {
                      if (0 == $t) {
                      $s[$i] = str_replace('{$' . $f . '_no0}', '', $s[$i]);
                      } else {
                      $s[$i] = str_replace('{$' . $f . '_no0}', $t, $s[$i]);
                      }
                      }
                     */


                    /* format money */
                    //if (stripos($s[$i], '{$'.$f.'_money') !== FALSE ){
                    //	$s[$i] = str_replace('{$'.$f.'_dateformat4}', date('m-d ', $t), $s[$i]);
                    //}

                    /* 返回信息, 目前提取单条记录时有用 */
                    if ($backfield != null) {
                        if (stripos($backfield, $afield[$j]) !== false) {
                            $bfv[$afield[$j]][] = $t;
                        }
                    }
                }
            }
        }

        $a['str'] = join('', $s);
        $a['bfv'] = $bfv;

        return $a;
    }

    /*
     * 替换单行的rs
     */

    function reprscolumn($myrs, $mytablename, $myli) {
        $li = $myli;

        $myfield = $this->getmdbfield($mytablename, $myli . '{$id}');

        $a = explode(',', $myfield);

        $mycount = count($a);

        if ($mycount > 0) {
            for ($i = 0; $i < $mycount; $i++) {
                if (stripos($li, '{$' . $a[$i] . '}') != False) {
                    $li = str_replace('{$' . $a[$i] . '}', $myrs[$a[$i]], $li);
                }
            }
        }

        return $li;
    }

    function reprs($rs, $mytablename, $tli) {
        $myfield = $this->getmdbfield($mytablename, $tli);

        $s = array();
        $i = 0;

        foreach ($rs as $v) {
            $s[$i] = $tli;
            //替字列值
            $afield = explode(',', $myfield);
            $countfield = count($afield);
            //循环字段
            for ($j = 0; $j < $countfield; $j++) {
                //把这行,这列的值,临时给一个变量
                $t = $v[$afield[$j]] . '';

                if (strpos($s[$i], '{$' . $afield[$j] . '}') != false) {
                    $s[$i] = str_replace('{$' . $afield[$j] . '}', $t, $s[$i]);
                }

                if (strpos($s[$i], '{$' . $afield[$j] . '_htmlencode}') !== false) {
                    $s[$i] = str_replace('{$' . $afield[$j] . '_htmlencode}', htmlencode($t), $s[$i]);
                }
            }
            $i++;
        }
        return join('', $s);
    }

    function getcurrentpage() {
        //取传过来的页数
        $currentpage = $this->rqid('page');

        if ($currentpage < 1) {
            $currentpage = 1;
        }

        $this->currentpage = $currentpage;
    }

    /**
     * 生成翻页字符串.
     */
    function pagelist($filename = null, $total = 0, $showtype = null) {

        $currentpage = $this->currentpage;

        if (0 === $total) {
            $total = $this->totalrs;
        }

        /* 取文件名 */
        if (null === $filename) {
            $a = explode('\\', __FILE__);
            $filename = end($a);
        }

        //这里没对$_GET[]进行检测
        //$_GET['page'] = '{$page}';
        $tget = $_GET;


        /* 如果有page这个参数 then 删之 */
        if (array_key_exists('page', $tget)) {
            unset($tget['page']);
        }




        $url = '?' . $this->arrtopara($tget);


        /* 计算总页数 */
        if (0 === $total % $this->mymaxpage) {
            //$pagecount 在repm时生成
            $pagecount = $total / $this->mymaxpage;
        } else {
            $pagecount = floor($total / $this->mymaxpage) + 1;
        }

        /* 校正currentpage */
        if ($currentpage > $pagecount) {
            $currentpage = $pagecount;
        }

        /* 求pagelong */
        if ($currentpage < 6) {
            $pagelong = 11 - $currentpage;
        } else if (($pagecount - $currentpage) < 6) {
            $pagelong = 10 - ($pagecount - $currentpage);
        } else {
            $pagelong = 5;
        }

        //生成page字符串
        /* 只有一页时,只显示页数 */
        if ($pagecount < 2) {
            $s = '<li class="current">&nbsp;1&nbsp;</li>' . PHP_EOL;
        } else {
            for ($i = 1; $i < ($pagecount + 1); $i++) {
                /* 第一页不带参数 */
                if (1 == $i) {
                    $a[0] = $url;

                    if (1 == $currentpage) {
                        $p[0] = '<li class="current">&nbsp;1&nbsp;</li>' . PHP_EOL;
                    } else {
                        $p[0] = '<li><a href="' . $a[0] . '">&nbsp;1&nbsp;</a></li>' . PHP_EOL;
                    }
                } else {
                    if (($i < ($currentpage + $pagelong) AND $i > ($currentpage - $pagelong)) OR $i == $pagecount) {
                        $a[$i - 1] = $url;

                        //检测有没有?
                        if (FALSE !== stripos($a[$i - 1], '?')) { //没有时用? 有时则用&amp;
                            $a[$i - 1] .= '?page={$page}';
                        } else {
                            $a[$i - 1] .= '&amp;page={$page}';
                        }

                        if ($currentpage == $i) {
                            $p[$i - 1] = '<li class="current">&nbsp;' . $i . '&nbsp;</li>' . PHP_EOL; //给当前页加标记
                        } else {
                            $p[$i - 1] = '<li><a href="' . $this->addpara($url, 'page=' . ($i)) . '">&nbsp;' . $i . '&nbsp;</a></li>' . PHP_EOL;
                        }
                    }
                }
            }

            $s = join('', $p);
        }

        if (null === $showtype) {
            $strpage = $this->htm('page', '_main');
        } else {
            $strpage = '<div class="page"><div class="count">共有记录:{$totalput}条&nbsp;&nbsp;页次:{$pageser}</div> <ul>{$prev} {$pagelist}{$next}</ul></div>' . PHP_EOL;
        }
        $strpage = str_replace('{$pagelist}', $s, $strpage); //替换翻页字符串

        /* Get 上一页和下一页链 */
        /* 上一页 */
        if ($currentpage > 1) {
            if (2 == $currentpage) { //第二页的上一页, 也就是第一页,不带page参数
                $prepage = '<li><a href="' . $url . '">上一页</a>&nbsp;</li>' . PHP_EOL;
            } else {
                $prepage = '<li><a href="' . $this->addpara($url, 'page=' . ($currentpage - 1)) . '">上一页</a>&nbsp;</li>' . PHP_EOL;
            }
        } else {
            //当前页就是第一页, 上一页没有链接了
            $prepage = '<li>上一页</li>' . PHP_EOL;
        }
        $strpage = str_replace('{$pre}', $prepage, $strpage);


        /* 下一页 */
        if ($currentpage < $pagecount) {
            $nextpage = '<li>&nbsp;<a href="' . $this->addpara($url, 'page=' . ($currentpage + 1)) . '">下一页</a></li>' . PHP_EOL;
        } else {
            $nextpage = '<li class="pagenext">下一页</li>' . PHP_EOL;
        }
        $strpage = str_replace('{$next}', $nextpage, $strpage);


        return $strpage;
    }

    function mappath($path) {
        return str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT'] . $path);
    }

    function repnode($mdbname, $node, $m_tr) {
        $myfield = $this->getmdbfield($mdbname, $m_tr);
        $a = split($myfield, ',');

        $mycount = count($a);

//	$s = $m_tr;
//
//	for ($i=0; $i<($mycount+1); $i++) { /*最后一个是空值,所以不计算*/
//		$s = str_replace($s, '{$' .$a[$i]. '}', );
//	}
//	For i=0 To jinfangfield '<syl>最后一个是空值,所以不计算<by syl>
//			s = Replace(s,"{$"& a(i) &"}", node.getAttribute(a(i))&"")
//	Next
//
//	return $s;
    }

// end func

    function read_file($file) {
        if (!file_exists($file)) {
            return FALSE;
        }

        if (function_exists('file_get_contents')) {
            return file_get_contents($file);
        }

        if (!$fp = @fopen($file, FOPEN_READ)) {
            return FALSE;
        }

        flock($fp, LOCK_SH);

        $data = '';
        if (filesize($file) > 0) {
            $data = fread($fp, filesize($file));
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return $data;
    }

    function write_file($path, $data, $mode = FOPEN_WRITE_CREATE_DESTRUCTIVE) {
        if (!$fp = @fopen($path, $mode)) {
            return FALSE;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $data);
        flock($fp, LOCK_UN);
        fclose($fp);

        return TRUE;
    }

    /* 从SQL语句截取表名 */

    function gettablename($str) {
        $str = chop($str);
        $a = explode(' from ', $str);
        $str = $a[1];

        $str = explode(' ', $str);

        $str = $str[0];

        $str = str_replace('`', '', $str);

        return $str;
    }

// end func


    /* 从html里提取有什么字段 */

    function getmdbfield($tablename, $str, $strback = null) {
        //取出这个表的字段列表
        $a = $this->getfieldnamelist($tablename);

        $mycount = count($a);

        $str .= '{$id}{$uid}{$classid}'; //何时都加上字段id

        $myfield = '';

        for ($i = 0; $i < $mycount; $i++) {
            if (stripos($str, '{$' . $a[$i]) !== false) {
                $myfield .= $a[$i] . ',';
            }
        }

        /* 看看返回字段里有没有 */
        if ($strback != null) {
            $a = explode(',', $strback);
            $mycount = count($a);

            for ($i = 0; $i < $mycount; $i++) {
                if (stripos($myfield, $a[$i]) === false) {
                    $myfield .= $a[$i] . ',';
                }
            }
        }

        return substr($myfield, 0, strlen($myfield) - 1);
    }

// end func


    /* 判断是否包含某字符 */

//$s1:大字符
//$s2:小字符
    function ins($s1 = '', $s2 = '') {
        if ('' == $s1 || '' == $s2) {
            return false;
        }

        $s2 = ',' . $s2 . ',';
        $s1 = ',' . $s1 . ',';

        if (strpos($s1, $s2) !== false) {
            return true;
        } else {
            return false;
        }
    }

// end func
//删除目录及目录下的文件
//循环删除目录和文件函数  
    function delDirAndFile($dirName) {
        if ($handle = opendir("$dirName")) {
            while (false !== ( $item = readdir($handle) )) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$dirName/$item")) {
                        delDirAndFile("$dirName/$item");
                    } else {
                        if (unlink("$dirName/$item"))
                            echo "成功删除文件： $dirName/$item<br />\n";
                    }
                }
            }
            closedir($handle);
            if (rmdir($dirName))
                echo "成功删除目录： $dirName<br />\n";
        }
    }

    /**
      检测验证码是否正确
     */
    function codeistrue() {
        $codestr = $this->request('验证码', 'codestr', 'post', 'char', 0, 50, 0);

        if ($codestr == '' OR !isset($_SESSION['codestr'])) {
            return FALSE;
        }

        if ($_SESSION['codestr'] != $codestr) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 检测信息来源.
     * @param   type    $varname    description
     * @return  type    description
     * @access  public or private
     * @static  makes the class property accessible without needing an instantiation of the class
     */
    function chkpost() {
        $method = $_SERVER['PHP_SELF'];
        if ($_POST) {
            $a = $_SERVER['HTTP_REFERER'];
            $b = "http://{$_SERVER['SCRIPT_NAME']}" . $method;
            if (strcmp($b, $a) == 0) {
                //echo '允许';
                return TRUE;
            } else {
                //die('不许站外提交');
                return FALSE;
            }
        }
    }

    /**
     * Short description.
     * @param   type    $varname    description
     * @return  type    description
     * @access  public 
     * @static  makes the class property accessible without needing an instantiation of the class
     */
    function getarrvalue($myname, $myid, $mytitle, $mytype = 'byid') {
        $arr = $this->getarr($myname);

        if (FALSE === $arr) {
            return FALSE;
        }

        switch ($mytype) {
            case 'byid':
                return $arr[$myid][$mytitle];
        }
    }


    /**
     * 从数据库生成数组缓存.
     * @return  type    TRUE OR FALSE
     */
    function getarr($myname, $myid = null, $myic = null) {
        switch ($myname) {
            case 'group' :
                $t = $this->cache->get(CacheName . $myname);

                if (FALSE == $t) {

                    $sql = 'select * from `' . sh . '_group` order by cls asc,id asc';

                    $t = $this->pdo->execute($sql);
                    $t = $t['rs'];
                    $t = $this->rstoarr($t, 'ic');

                    $this->cache->save(CacheName . $myname, $t);
                }
                break;
            case 'department' :
                $t = $this->cache->get(CacheName . $myname);

                if (FALSE == $t) {

                    $sql = 'select * from `' . sh . '_department` order by cls asc,id asc';

                    $t = $this->pdo->execute($sql);
                    $t = $t['rs'];
                    $t = $this->rstoarr($t, 'ic');

                    $this->cache->save(CacheName . $myname, $t);
                }
                break;
            case 'channel' :
                $t = $this->cache->get(CacheName . $myname);

                if (FALSE == $t) {

                    $sql = 'select * from `' . sh . '_channel` where isuse=1 order by cls asc, id asc';
                    $at = $this->pdo->execute($sql);
                    $t = $this->rstoarr($at['rs']);

                    $this->cache->save(CacheName . $myname, $t);
                }

                break;
            case 'class' :
                $t = $this->cache->get(CacheName . $myname);

                if (FALSE == $t) {

                    $sql = 'select * from `' . sh . '_class` where 1 order by treeid asc';
                    $at = $this->executers($sql);
                    $t = $this->rstoarr($at);

                    $this->cache->save(CacheName . $myname, $t);
                }

                break;

            case 'special' :
                $t = $this->cache->get(CacheName . $myname);

                if (FALSE == $t) {
                    $sql = 'select * from `' . sh . '_special` order by cls asc, id asc';

                    $at = $this->pdo->execute($sql);
                    $t = $this->rstoarr($at['rs']);

                    $this->cache->save(CacheName . $myname, $t);
                }
                break;
        }

        if ($myid !== null) {
            $myid .='';

            if (array_key_exists($myid, $t)) {
                return $t[$myid];
            } else {
                return FALSE;
            }
        }

        $a = null;

        if ($myic != null) {
            foreach ($t as $v) {
                if ($v['ic'] == $myic) {
                    $a = $v;
                }
            }

            if (null !== $a) {
                return $a;
            } else {
                return false;
            }
        } else {
            return $t;
        }
    }

// end func

    function ictoid($myid, $mysheetname) {
        $t = $this->cache->get(CacheName . $mysheetname . 'id');

        if (false == $t) {
            $sql = 'select id,ic from ' . sh . $mysheetname;

            $rs = $this->execute($sql);

            $t = array();

            foreach ($rs['rs'] as $v) {
                $t[(string) ($v['ic'])] = $v['id'];
            }

            $this->cache->save(CacheName . $mysheetname . 'id', $t);
        }

        if (array_key_exists($myid, $t)) {
            return $t[$myid];
        } else {
            return false;
        }
    }

// end func

    function getidfromic($myic, $mysheetname) {

        $rs = $this->getarr($mysheetname);

        foreach ($rs as $v) {
            if ($myic == $v['ic']) {
                return $v['id'];
            }
        }

        return false;
    }

// end func

    function loadchannel() {

        $sql = 'select * from `' . sh . '_channel` where isuse=1 order by cls asc, id asc';
    }

// end func

    function readchannel($x, $myfield = 'ic') {
        $sql = 'select * from `' . sh . '_channel` where 1=1';
        $sql .= ' and isuse=1 ';

        switch ($myfield) {
            case 'ic' :
                $sql .= ' and ic="' . $x . '"';
                break;
            case '':
                $sql .= ' and id=' . $x;
                break;
        }

        $sql .= ' order by cls asc, id asc';


        $result = $this->exeone($sql);

        return $result;
    }

// end func


    /* 清除缓存 */

    function deletecache($myname) {
        $this->cache->delete(CacheName . $myname);
        $this->cache->delete(CacheName . $myname . 'id');
    }

// end func

    /**
     * 取得某个模块的分类缓存.
     */
    function getclass($cid = null, $module = null, $myid = null, $myic = null) {
        /* 没有cid和模块是返回false */
        if ($cid == null AND $module == null) {
            return FALSE;
        }


        $myname = CacheName . 'class_' . ($cid . '_' . $module);

        $t = $this->cache->get($myname);


        if (FALSE == $t) {
            $sql = 'select * from `' . sh . '_class` where 1=1 ';
            if ($cid != null) {
                $sql .= ' and cid=' . $cid;
            } else {
                $sql .= ' and module="' . $module . '"';
            }
            $sql .= ' order by treeid asc ';

            $rs = $this->pdo->execute($sql);

            $t = $this->rstoarr($rs['rs']);

            $this->cache->delete($myname);
            $this->cache->save($myname, $t);
        }


        if ($myid != null) {
            $myid .='';
            if (array_key_exists($myid, $t)) {
                return $t[$myid];
            } else {
                return FALSE;
            }
        }

        //跟据ic返回
        $a = null;

        if ($myic != null) {
            foreach ($t as $v) {
                if ($v['ic'] == $myic) {
                    $a = $v;
                }
            }

            if (null !== $a) {
                return $a;
            } else {
                return false;
            }
        } else {
            return $t;
        }

        return $t;
    }

// end func

    function delclass() {
        
    }

    /**
     * 由rs变为数组.
     * keyfield: 用哪个字段做为键值
     */
    function rstoarr($rs, $keyfield = 'id') {
        $mycount = count($rs);

        if (0 == $mycount) {
            return $rs;
        }

        $a = array();


        for ($i = 0; $i < $mycount; $i++) {
            foreach ($rs[$i] as $k => $v) {
                $a[(string) ($rs[$i][$keyfield])][$k] = $v;
            }
        }

        return $a;
    }

// end func

    /* 向url追加参数 */

    function addpara($str, $para) {
        /* 没问号 */
        if (FALSE === stripos($str, '?')) {
            return $str . '?' . $para;
        } else {
            return $str . '&amp;' . $para;
        }
    }

// end func
// end func

    /**
     * 得到用户基本资料.
     */
    function GetUserInfo() {
        /* if 没有session then 生成一个session */
        if (!isset($_SESSION[CacheName . 'user'])) {
            //echo 'a';
            /* 没有cookie时直接写入游客信息 */
            if (!isset($_COOKIE[CacheName . 'user'])) {
                $this->GetGuestInfo(); //写入游客信息
                //echo 'b';
            } else {
                /* 有cookie时, 从cookie提取用户ID和密码, => 检测是否正确 => 不正确写入游客信息 */
                $user = unserialize($_COOKIE[CacheName . 'user']);

                $user['id'] = $this->strcode($user['id'], 'DECODE');

                /* 检测从cookie提取的用户名和密码是否正确, 不正确then写入游客信息 */

                loadclass('c_login', 'cls_login', 'cls_login');

                if (!$this->chkuserlogin('', $user['pass'], $user['savecookie'], $user['id'], $mysource = 'cookie')) {
                    $this->GetGuestInfo();
                }
            }
        }

        /* 从Session提取用户信息 */
        $this->user = $_SESSION[CacheName . 'user'];

        $u = & $_SESSION[CacheName . 'user'];



        //下面这部分准备去掉

        $this->u_id = $u['id'];
        $this->u_name = $u['u_name'];
        $this->u_nick = $u['u_nick'];
        $this->u_gic = $u['u_gic'];
        $this->u_gname = $u['u_gname'];
        $this->u_face = $u['u_face'];
        //$this->u_hotelid = $u['u_hotelid'];

        if ($this->u_id > 0) {
            $this->ismember = TRUE;
        }


        $this->ismaster = ( 1 == $u['u_ismaster'] );


        //提取是不是真的管理员
        if (!isset($_SESSION[CacheName . 'ismaster'])) {
            $this->istruemaster = FALSE;
        } else {
            $this->istruemaster = TRUE;
        }
    }

// end func


    /*
     * 写入游客信息
     */

    function GetGuestInfo() {
        $user['id'] = 0;
        $user['u_name'] = 'Guest';
        $user['u_nick'] = 'Guest';
        $user['u_gic'] = 'guest';
        $user['u_dname'] = '游客';
        $user['u_gname'] = '游客';
        $user['u_fullname'] = 'Guest';
        $user['u_face'] = '/_images/noface.png';
        $user['u_gtypeid'] = 0;
        $user['u_ismaster'] = 0;

        $user['u_hotelid'] = 0;

        $user['u_iswebmaster'] = 0;

        $_SESSION[CacheName . 'user'] = $user;
    }

// end func

    /**
     * 检测用户控制面版使用权限.
     */
    function chkuserpanel($paneltype) {
        $icanuse = FALSE;

        switch ($paneltype) {
            //检测是会员就能进
            case 'member' :

                if ('guest' == $this->user['u_gic']) {
                    $icanuse = false;
                } else {
                    $icanuse = true;
                }
                break;
            case 300:
                if ($this->u_gic == 300) {
                    $icanuse = TRUE;
                }
                break;
        }

        //没有权限时跳转到登录页
        if (!$icanuse) {
            $href = '/service/login.php';
            header('Location:' . $href);
            die;
        }
    }

// end func

    /* 检测管理中心使用权限 */

    function chkadmin() {
        /* 不需要管理员二次登录,then直接返回 */
        if (1 !== $GLOBALS['config']['supperlogin']) {
            return;
        }

        /* 不是管理员转入登录页 */
        if ($this->user['u_gic'] >= 'admin') {
            $href = '/service/login.php';
            header('Location:' . $href);
            die;
        }

        //session 有这个管理员,直接返回
        if ($this->istruemaster) {
            return true;
        }


        /* 判断有没有cookie */
        if (isset($_COOKIE[CacheName . 'admin'])) {
            $adminpass = $_COOKIE[CacheName . 'admin'];


            //判断是不是和管理员密码一致, 不一致进入后台登录页
            $sql = 'select u_pass from `' . sh . '_admin` where u_id=' . $this->user['id'];
            $rs = $this->exeone($sql);

            if (FALSE == $rs) {
                //密码不对, 转入登录页
                header('Location:' . admindir . 'admin_login.php');
            }

            /* 一致, 存进session */
            if ($adminpass == $rs['u_pass']) {
                $_SESSION['istruemaster'] = 1;
            }
            /* 不一致, 进入后台登录页 */ else {
                header('Location:' . admindir . 'admin_login.php');
            }
        } else {
            /* 没有cookie转入后台登录页 */
            header('Location:' . admindir . 'admin_login.php');
        }
    }

// end func

    function chkuser() {
        //不是管理员转入登录页
        if (!$this->ismember) {
            $href = '/service/login.php';
            autolocate($href, 0);
        }
    }

// end func

    /**
     * 当前时间.
     * @return  type    datetime
     */
    function now() {
        return date('Y-m-d H:i:s');
    }

// end func
// +----------------------------------------------------------------------+
// | PHP version 4.0                                                       |
// +----------------------------------------------------------------------+
// | Copyright (c)   2003 The individual                                    |
// +----------------------------------------------------------------------+
// |It agrees without being passing through the very person and it is      |
// |conceited secretly using the after result.                             |
// +----------------------------------------------------------------------+
// | Authors: Original Author   Allan Kent                                  |
// |           Editing           Dandelion                                   |
// +----------------------------------------------------------------------+

    /**
     * @Purpose:
     * It returns to the time interval during two dates.
     * @Method Name: DateDiff().
     * @Parameter: string $interval -->The time interval character string numerical    formula.
     *                                   w -->Weekday
     *                                   d -->Day
     *                                   h -->Hour
     *                                   n -->Minute
     *                                   s -->Second
     *            string $date1     -->It represents as time() a form in the time of the first date.
     *            string $date2     -->It represents as time() a form in the time of the second date.
     * @Return: string $retval    -->Return a new as time() a form in the time of the date.
     * @See: string bcdiv(string left operand,string right operand, int [scale]).
     */
    function datediff($interval, $date1, $date2) {
        // @See: It gets the number of the seconds in the one of the 2nd period day interval.
        $time_difference = $date2 - $date1;
        switch ($interval) {

            case "w": $retval = ceil($time_difference / 604800);
                break;
            case "d": $retval = ceil($time_difference / 86400);
                break;
            case "h": $retval = ceil($time_difference / 3600);
                break;
            case "n": $retval = ceil($time_difference / 60);
                break;
            case "s": $retval = $time_difference;
                break;
        }

        return $retval;
    }

    function DateAdd($part, $number, $date, $format = 'Y-m-d H:i:s') {
        $date_array = getdate(strtotime($date));

        $hor = $date_array["hours"];
        $min = $date_array["minutes"];
        $sec = $date_array["seconds"];
        $mon = $date_array["mon"];
        $day = $date_array["mday"];
        $yar = $date_array["year"];

        switch ($part) {
            case "year": $yar += $number;
                break;
            case "q": $mon += ($number * 3);
                break;
            case "mon": $mon += $number;
                break;
            case "week": $day += ($number * 7);
                break;
            case "day": $day += $number;
                break;
            case "hour": $hor += $number;
                break;
            case "minute": $min += $number;
                break;
            case "setond": $sec += $number;
                break;
        }
        return date($format, mktime($hor, $min, $sec, $mon, $day, $yar));
    }

    //变成unix时间
    function dateunix($interval, $date) {
        $v = '';

        $t = strtotime($date);

        switch ($interval) {
            case 'w' : $v = bcdiv($t, '604800');
            case 'd' : $v = bcdiv($t, '86400');
            case 'h' : $v = bcdiv($t, '3600');
            case 'n' : $v = bcdiv($t, '60');
            case 's' : $v = $t;
        }

        return $t;
    }

// end func

    function getip() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (!empty($_SERVER["REMOTE_ADDR"])) {
            $cip = $_SERVER["REMOTE_ADDR"];
        } else {
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }

    /**
     * Validate the syntax of the given IP adress
     *
     * This function splits the IP address in 4 pieces
     * (separated by ".") and checks for each piece
     * if it's an integer value between 0 and 255.
     * If all 4 parameters pass this test, the function
     * returns true.
     *
     * @param  string $ip IP adress
     * @return bool       true if syntax is valid, otherwise false
     */
    function check_ip($ip) {
        $oct = explode('.', $ip);
        if (count($oct) != 4) {
            return false;
        }

        for ($i = 0; $i < 4; $i++) {
            if (!preg_match("/^[0-9]+$/", $oct[$i])) {
                return false;
            }

            if ($oct[$i] < 0 || $oct[$i] > 255) {
                return false;
            }
        }

        return true;
    }

    /**
     * 加密、解密字符串
     *
     * @global string $db_hash
     * @global array $pwServer
     * @param $string 待处理字符串
     * @param $action 操作，ENCODE|DECODE
     * @return string
     */
    function strcode($string, $action = 'ENCODE') {
        $action != 'ENCODE' && $string = base64_decode($string);
        $code = '';
        $key = substr(md5('temp'), 8, 18);
        $keyLen = strlen($key);
        $strLen = strlen($string);
        for ($i = 0; $i < $strLen; $i++) {
            $k = $i % $keyLen;
            $code .= $string[$i] ^ $key[$k];
        }
        return ($action != 'DECODE' ? base64_encode($code) : $code);
    }

    /* 原目录，复制到的目录 */

    function recurse_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($src . '/' . $file)) {
                    recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /* 生成随机数 */

    function generate_randchar($length = 10) {
        // 密码字符集，可任意添加你需要的字符  
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $mychar = '';
        for ($i = 0; $i < $length; $i++) {
            $mychar .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $mychar;
    }

// end func


    /* 计算字符数 */

    function strlen($str) {
        $i = 0;
        $count = 0;
        $len = strlen($str);
        while ($i < $len) {
            $chr = ord($str[$i]);
            $count++;
            $i++;
            if ($i >= $len)
                break;
            if ($chr & 0x80) {
                $chr <<= 1;
                while ($chr & 0x80) {
                    $i++;
                    $chr <<= 1;
                }
            }
        }
        return $count;
    }

// end func



    /* 数组变参数 */

    function arrtopara($para) {
        $s = '';

        if (!is_array($para)) {
            return '';
        }

        foreach ($para as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $vv) {
                    $s.= '&amp;' . $k . '[]=' . $vv;
                    //$t[$k][] = $vv;
                }
            } else {
                $s .= '&amp;' . $k . '=' . $v;
            }
        }

        //不要开头的&amp;
        $s = substr($s, 5);

        return $s;
    }



		/**
	 * 导出execel
	 */
	function exportxls($filename, $data) {
		$h = $this->htm('execel', '_plus');
		$h = str_replace('{$main}', $data, $h);


		header('Content-Disposition: filename=' . $filename . '.xls');
		header('Content-Type:application/ms-excel');
		header('Content-Transfer-Encoding: binary');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');

		header('Charset:UTF-8');


		echo ($h);
	}

}