<?php

/*
 * 模板管理首页
 */
require('../../global.php');
require( 'cls_style.php' ); //模板main

class Myclass extends Cls_style {

    function __construct() {
        parent::__construct();

        $act = $this->main->ract();

        switch ($act) {
            case 'use':
                $this->douse();
                break;
            default:
                $this->main();
                break;
        }
    }

    function main() {

        $this->c_ad->head();
        $this->c_ad->crumb();


        echo '<ul class="liststyle">' . PHP_EOL;

        $psypath = sysdir . $this->rootpath; //物理路径

        @$dir_handle = opendir($psypath) or die('Unable to open ' . $psypath);


        //只循环显示目录
        while ($file = readdir($dir_handle)) {
            if ($file != '.' && $file != '..') {
                if (!is_dir($psypath . $file)) {
                    continue;
                }
                $file = iconv("GB2312", "UTF-8", $file);

                if ($file == CurStyle) {
                    $stylestate = ' class="on"';
                } else {
                    $stylestate = '';
                }

                echo '<li' . $stylestate . '>' . PHP_EOL;
                echo '	<div class="pre">' . PHP_EOL;
                echo '		<div class="preimg fleft">' . PHP_EOL;
                echo '			<img src="/_style/' . $file . '/style.jpg" width="150" alt="" class="img1" />' . PHP_EOL;
                echo '		</div>' . PHP_EOL;
                echo '		<div>' . $file . '</div>' . PHP_EOL;
                echo '		<div><a href="list.php?dir=' . $file . '">编辑</a>' . PHP_EOL;
                /* echo '			| <a href="?act=use&amp;style=' . $file . '">应用</a>' . PHP_EOL; */
                echo '		</div>' . PHP_EOL;
                echo '	</div>' . PHP_EOL;
                echo '	<div class="info fleft">' . PHP_EOL;
                echo $this->getinfo($psypath . iconv("UTF-8", "GB2312", $file) . '/info.xml');
                echo '	</div>' . PHP_EOL;
                echo '</li>' . PHP_EOL;
            }
        } //结束循环目录	

        closedir($dir_handle);

        echo '</ul>' . "\n"; //end ul
        echo '<div class="clear"></div>';

        $this->c_ad->foot();
    }

    //取得模板相关信息
    function getinfo($mypath) {
        $s = '';
        $s .= '<ul>' . PHP_EOL;
        $s .= '<li>名称:{$title}</li>' . PHP_EOL;
        $s .= '<li>作者:{$author}</li>' . PHP_EOL;
        $s .= '<li>网址:{$url}</li>' . PHP_EOL;
        $s .= '<li>版本:{$ver}</li>' . PHP_EOL;
        $s .= '<li>适用:{$forver}</li>' . PHP_EOL;
        $s .= '</ul>' . PHP_EOL;

        $xml = simplexml_load_file($mypath);

        foreach ($xml->children() as $field) {
            $s = str_replace('{$' . $field->getName() . '}', $field, $s);
        }

        unset($xml);

        return $s;
    }

}

$Myclass = new Myclass();