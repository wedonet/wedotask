<?php

ob_start();
header('Content-Type:text/html; charset=UTF-8');
//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Shanghai');
ini_set('date.timezone', 'Asia/Shanghai');

session_start();

unset($LANG, $_REQUEST, $HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);

$j=array();

/*$$$$默认参数*/
$config['webdir'] = '/';
$config['adminfoldername'] = '_adminxxx1';

$config['Dbms'] = 'mysql'; //数据库类型 oracle 用ODI,对于开发者来说，使用不同的数据库，只要改这个，不用记住那么多的函数了
$config['DbHost'] = '127.0.0.1';//数据库主机名
$config['Dbname'] = 'wedonet';//使用的数据库
$config['Dbuser'] = 'root';//数据库连接用户名
$config['Dbpass'] = '123456'; //对应的密码
$config['CurStyle'] = 'default'; //应用模板名称
$config['CacheName'] = 'wetask'; //缓存前缀,防止冲突

$config['t'] = '1'; //防css,js缓存，客户端缓存清不掉时，改这个
$config['CacheType'] = 'wincache'; //缓存介质. ''=不用缓存; text=文本; apc=apc缓存;wincache = wincache
$config['webname'] = 'WeDoNetCms';

$config['MaxPage'] = 18; //每页记录数
$config['timestamp'] = '1';
$config['supperlogin'] = 0; //超管是否需要双重登录
$config['LoginErr'] =5; //每天允许输入密码错误次数,一旦正确后清零

$config['templatename'] = '_template'; //模板文件夹名称
$config['apiname'] = 'api';

/*$$$$参数设置
 * 覆盖默认参数
 */
require ('config.php');

define('webdir', $config['webdir']);
define('admindir', webdir.$config['adminfoldername'].'/');
define('sysdir', str_replace("\\", "/", dirname(__FILE__).'/'));
define('sysdirad', sysdir.$config['adminfoldername'].'/');
define('sh', 'we'); //数据库中表的前缀
define('CacheName', $config['CacheName']);
define('CacheType', $config['CacheType']); 
define('CurStyle', $config['CurStyle']);

define('t', $config['t']);
define('pagestarttime', microtime(true));
define('webname', $config['webname']);
define('MaxPage', $config['MaxPage']);

define('timestamp', $config['timestamp']);


define( 'tpath', sysdir.$config['templatename'] .'/' );
define( 'tdir', webdir . $config['templatename']. '/' );

define('apipath', sysdir.$config['apiname']);

/*定义些全局变量*/
$errmsg = '';
$sucmsg = '';






require ( sysdir.'_inc/cls_main.php');
require ( sysdir.'_inc/cls_html.php');

require ( sysdir.'_inc/mess.php');
require ( sysdir.'_inc/cache/Cache.php');
require ( sysdir.'_inc/help.php');

$main = new Cls_main();
$html = new Cls_html();

cachestart();
$cache = new ClsCache();













/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');




function is_really_writable($file) {
    // If we're on a Unix server with safe_mode off we call is_writable

    if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE) {
        return is_writable($file);
    }

    // For windows servers and safe_mode "on" installations we'll actually
    // write a file then read it.  Bah...
    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/' . md5(mt_rand(1, 100) . mt_rand(1, 100));

        if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE) {
            return FALSE;
        }

        fclose($fp);
        @chmod($file, DIR_WRITE_MODE);
        @unlink($file);
        return TRUE;
    } elseif (!is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE) {
        return FALSE;
    }

    fclose($fp);
    return TRUE;
}

/* 向面包屑追加li */

function crumb($s) {
    $GLOBALS['html']->crumb .= ('<li>' . $s . '</li>' . PHP_EOL);
}

function title($s){
	$GLOBALS['html']->title = $s;
}
/* 向全局变量errmsg追加 */

function werr($s) {
    $GLOBALS['errmsg'] .= ('<li>' . $s . '</li>' . PHP_EOL);
}

/*
 * 建立类的实例. loadclass (load class)
 * name = 实例名 
 * classname = 类名
 */

function loadclass($name, $classname, $mypath = null) {
    if (!isset($GLOBALS[$name])) {

        if (null !== $mypath) {

            $mypath = sysdir . '_inc/' . $mypath;

            require_once $mypath;
        }

        $GLOBALS[$name] = new $classname();
    }

	//return &$GLOBALS[$name];
}

function getfaultname($s) {
    $a[1018] = '没找到相应记录';
    $a[2004] = '验证码错误';
    $a[1022] = '非法操作';

    return $a[$s];
}

// end func

/**
 * 设断点
 */
function stop($s = '') {
    echo $s;
    echo '<br />==================';
    die;
}


function san(){
 unset ($main);
 unset ($html);
}








