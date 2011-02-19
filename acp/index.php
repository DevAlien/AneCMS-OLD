<?php
$adm = 1;
define('ANECMSACP', true);
include '../system/pages/essential.php';

$tpl->addJavascript('system/js/jquery-1.4.2.min.js');
$tpl->addJavascript('system/js/jquery.jgrowl_minimized.js');
$tpl->addCSSFile('system/js/jquery.jgrowl.css');

if(isset($user) && $user->isOnGroup('CustomerAdmin')){
	$_GET['cia'];
$_GET['p'] = 'mod';
$tpl->assign('top_menu', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus where type = ? AND link = ? order by position ASC', DBDriver::ALIST, array(3, '?p=mod')));
}else
$tpl->assign('top_menu', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus where type = ? order by position ASC', DBDriver::ALIST, array(3)));

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
  $tpl->assign('sidenavmodules', $db->query('SELECT a.id as aid, a.name as aname, b.name, IFNULL(b.link, \'\') link FROM '.$database['tbl_prefix'].'dev_menus a inner join '.$database['tbl_prefix'].'dev_menus b on a.name = b.parentstr WHERE a.type = ? AND a.parent = ? ORDER BY aid, b.position', DBDriver::ALIST, array(104, 0)));
  $tpl->assign('countm', -1);
}
$tpl->assign('sidenav', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus where type = ? order by position ASC', DBDriver::ALIST, array($type)));
if(isset($_GET['p']))
    include './pages/'.$_GET['p'].'.php';
else
    include './pages/dash.php';

?>
