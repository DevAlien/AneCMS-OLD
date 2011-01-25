<?php
$adm = 1;
include './inc/essential.php';

$tpl->addJavascript('system/js/jquery-1.3.2.min.js');
$tpl->addJavascript('system/js/jquery.jgrowl_minimized.js');
$tpl->addCSSFile('system/js/jquery.jgrowl.css');

if(isset($user) && $user->isOnGroup('CustomerAdmin')){
$_GET['p'] = 'mod';
$tpl->assign('top_menu', $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_menus where type = 3 AND link = \'?p=mod\' order by position ASC'));
}else
$tpl->assign('top_menu', $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_menus where type = 3 order by position ASC'));

if(!isset($_GET['p']))
    $_GET['p'] = 'dash';
switch ($_GET['p']) {
    case 'cfg':
        $type = 101;
        break;

    case 'tpl':
        $type = 102;
        break;

    case 'mod':
        $type = 103;
        break;

    default:
        $type = 100;
        break;
}
$tpl->assign('typepage', $type);

if($type == 103){
  $tpl->assign('sidenavmodules', $db->query_list('SELECT a.id as aid, a.name as aname, b.name, IFNULL(b.link, \'\') link FROM '.$database['tbl_prefix'].'dev_menus a inner join '.$database['tbl_prefix'].'dev_menus b on a.id = b.parent WHERE a.type = 104 AND a.parent = 0 ORDER BY aid, b.position'));
  $tpl->assign('countm', -1);
}
$tpl->assign('sidenav', $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_menus where type = '.$type.' order by position ASC'));
if(isset($_GET['p']))
    include './pages/'.$_GET['p'].'.php';
else
    include './pages/dash.php';

?>
