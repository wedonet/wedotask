<?php

require('../global.php');
require( sysdirad . 'inc/cls_ad.php');
define('sp', 'admin/_admin_cache');

crumb('<a href="?">缓存管理</a>');

class Myclass extends Cls_ad {

    function __construct() {
        parent::__construct();
        $act = $this->main->ract();

        switch ($act) {
            case '' : $this->Htmlmain();
                break;
            case 'clear' : $this->DoClear();
                break;
        }

        san();
    }

//============================================

    function Htmlmain() {
        $h = $this->main->htm('main');
        $this->dohtml($h);
    }

    function DoClear() {
        $cachetype = $GLOBALS['main']->request('缓存类型', 'cachetype', 'cb', 'char', 1, 50, 'invalid', FALSE);

        $a = explode(',', $cachetype);

        /* 如果有包含字段缓存, then 清除字段缓存 */
        if (in_array('field', $a)) {

            switch (CacheType) {
                case 'text':
                    $this->main->cache->clean();
                    break;
                case '';

                    $rs = $GLOBALS['main']->cache->getrs();

                    foreach ($rs as $v) {
                        $key = $v['key_name'];

                        if (stripos($key, CacheName . 'table_') === 0) {
                            /* 清除table的字段缓存 */
                            $this->main->cache->delete($key);
                        }
                    }
                    break;
                case 'wincache':
                    $this->main->cache->clean();
                    break;
                default :
                    showerr('不支持' . CacheType . '的缓存');
                    break;
            }
        }

        jsucclose();
    }

// end func
}

$myclass = new Myclass();
unset($myclass);