<?php
define('ANECMS', true);
include './system/pages/essential.php';

Modules::loadBackgroundModules();
if (isset($closed)) {
    $tpl->burn('closed', 'tpl', false);
    die();
}

$tpl->assign('site_title', $qgeneral['title']);
$tpl->assign('sub_site_title', $qgeneral['descr']);
if (is_object($user) && $user->getValues('groups') == 3)
    $tpl->assign('top_menu', $db->query_list('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = 1 AND view >= 1 ORDER BY position', true));
else if (is_object($user) && $user->getValues('groups') < 3)
    $tpl->assign('top_menu', $db->query_list('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = 1 AND view >= 1 AND view <3 ORDER BY position', true));
else
    $tpl->assign('top_menu', $db->query_list('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = 1 AND view <= 1 ORDER BY position', true));

if (!isset($_GET['mode']) && isset($_GET['t'])) {
    $tpl->assign('typeerror', $lang['err_' . $_GET['t'] . '']);
    $tpl->assign('descrerror', $lang['derr_' . $_GET['t'] . '']);
    $tpl->burn('error1', 'tpl');
}
else if (isset($_GET['ajax']) && isset($_GET['mode'])) {
    if (Modules::isAModule($_GET['mode'])) {
              $ajax = str_replace("../", "", $_GET['ajax']);
        include './modules/' . $_GET['mode'] . '/ajax/' . $ajax . '.php';
    }
else{echo '"'.$_GET['mode'].'"Is not a module';}
}
else if (isset($_GET['ajax'])) {
    $ajax = str_replace("../", "", $_GET['ajax']);
    include './system/ajax/' . $ajax . '.php';
}
else {
    if (isset($_GET['mode']))
        Modules::loadModule($_GET['mode']);
    else
        Modules::loadModule('DEFAULT');
}
if (!isset($_GET['ajax']))
  echo ($debug == true) ? $init->infos() : false;
?>
