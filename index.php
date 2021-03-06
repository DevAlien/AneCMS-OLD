<?php
/*-------------------------------------------------------+
| AneCMS
| Copyright (C) 2010
| http://anecms.com
+--------------------------------------------------------+
| Filename: index.php
| Author: Gonçalo Margalho
+--------------------------------------------------------+
| Removal of this copyright header is strictly 
| prohibited without written permission from 
| Gonçalo Margalho.
+--------------------------------------------------------*/
define('ANECMS', true);
include './system/pages/essential.php';

Modules::loadBackgroundModules();
if (isset($closed)) {
    $tpl->burn('closed', 'tpl', false);
    die();
}

$tpl->assign('site_title', $qgeneral['title']);
$tpl->assign('sub_site_title', $qgeneral['descr']);
if (is_object($user) && ($user->isOnGroup('Administrator') OR $user->isOnGroup('JuniorAdmin')))
    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? ORDER BY position', DBDriver::ALIST, array(1, 1), true));
else if (is_object($user) && !$user->isOnGroup('JuniorAdmin') && !$user->isOnGroup('Administrator'))
    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? AND view < ? ORDER BY position', DBDriver::ALIST, array(1, 1, 3), true));
else
    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view <= ? ORDER BY position', DBDriver::ALIST, array(1, 1), true));

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