<?php
require('../global.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>管理中心</title>
        <script type="text/javascript">var webdir = "";</script>
        <script src="../_js/base.js" type="text/javascript"></script>
        <script src="../_js/main.js" type="text/javascript"></script>

        <link href="css/main.css" rel="stylesheet" type="text/css" />
        <link href="css/index.css" rel="stylesheet" type="text/css" />
        <base target="mainindex" />
        <script type="text/javascript" src="js/admin_left.js"></script>
    </head>
    <body>

        <div class="top">管理中心</div>

        <div class="userinfo">
            <?php
            echo $main->u_gname;
            echo '(' . $main->u_nick . ')';
            ?>
        </div>

        <?php
        main();
        ?>

        <!-- E区 -->
        <div class='sidebar' style="background:url(../images/adminbg.gif) no-repeat -880px 3px;">
            <ul style="display:block;">
                <li><a href="http://www.wedonet.com" target="_blank">访问官方网站</a></li>
                <li><a href="javascript:window.top.location='../index.php'">返回首页</a></li>
                <li><a href="javascript:window.top.location='/service/login.php?act=loginout'" title="退出登录状态,清除管理缓存">注销</a></li>
            </ul>
        </div>

        <script type="text/javascript">
            <!--
            function refreshsession() {
                var href = <?php echo webdir?>."_inc/session.php?timetamp=" + new Date().getTime();
                alert(href);
                $.get(href);
            }

            $(function() {
                setInterval("refreshsession()", 2000);//２秒刷一下这个页，防止掉session //待测，alert出个东西
            })

            //-->
        </script>
    </body>
</html>

<?php
/* * */

function main() {
    $i = 0;
    
    $sql = 'select * from `' . sh . '_menu` order by cls asc, id asc';

    $result = $GLOBALS['main']->executers($sql);

    foreach ($result as $v) {

        //权限检测

		if ( 0 == $v['pid'] &&  haspower($v['power']) ) {
			echo '<div class="sidebar div' . ($i) . '">' . PHP_EOL;

			getmenu1($result, $v['id']);

			echo '</div>' . PHP_EOL;		
		}
        $i++;
    }
}

// end func
function getmenu1( &$result, $pid) {
    $s = '';
    foreach ($result as $v) {
		if ( $pid == $v['pid'] &&  haspower($v['power']) ) {

			$s .= '<h1 class="menuh1">' . $v['title'] . '</h1>' . PHP_EOL;
			$s .= '<ul>' . PHP_EOL;
			$s .= getmenu2($result, $v['id']);
			$s .= '</ul>' . PHP_EOL;

		}
        //if ($rs[$i]['cid'] != '') {
        //     $s = replacechannelinfo($s, $rs[$i]['cid']);
        // }

        /* 权限检测 */
        //if (haspower())
    }
    echo $s;
}

// end func

function getmenu2( &$result, $pid ) {
	$s = '';
	foreach ( $result as $v ) {
		if ( $pid == $v['pid'] &&  haspower($v['power']) ) {
                $t = '<li><a href="' . $v['url'] . '">' . $v['title'] . '</a></li>' . PHP_EOL;
                $t = str_replace('{$channelid}', $v['cid'], $t);
                $s .= $t;			
		}
	}
	return $s;
}

// end func

function replacechannelinfo($s, $cid) {
    return $s;
    $s = WeDoNet . RepXml(sh & "_channel", Application(CacheName & "_channel"), s, "li[@id='" & mycid & "']");
    return $s;
}

// end func
//======================================================================

/*strpower = */
function haspower($strpower) {
	return true;
    //return true; //暂时的
    if ( 'supperadmin' == $GLOBALS['main']->user['u_gic'] ) {
        return true;
    }

    if ($GLOBALS['main']->ins($strpower, $GLOBALS['main']->user['u_gic'])) {
        return true;
    } else {
        return false;
    }
}

// end func

function adurlencode($s) {
    return str_replace('&', '&amp;', $s);
}

// end func

function getmenuc($rs, $pid) {
    $mycount = count($rs);

    $s = '';

    for ($i = 0; $i < $mycount; $i++) {
        if ($rs[$i]['pid'] == $pid) {
            if (haspower($rs[$i])) {
                $s .= '<h1 class="menuh1">' . $rs[$i]['title'] . '</h1>' . PHP_EOL;
                $s .= '<ul>' . PHP_EOL;
                $s .= getmenu2($rs, $rs[$i]['id']);
                $s .= '</ul>' . PHP_EOL;

                if ($rs[$i]['cid'] != '') {
                    $s = replacechannelinfo($s, $rs[$i]['cid']);
                }
            }
        }
    }
    echo $s;
}