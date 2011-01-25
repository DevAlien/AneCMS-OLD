<?php
/**
 * This page must be included in all pages
 *
 * @package Dev-Site
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright Dev-House.Com (C) 2006-2008
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
ob_start();
session_start();
define('ANECMS', true);
define('ACP', true);
header('content-type: text/html; charset: utf-8');

if(!file_exists('../config.php')){
    ob_end_clean();

    header( "Location: ../install/index.php" );
}

include '../config.php';
include '../class/acp.class.php';
include '../class/tple/template.class.php';
include '../class/init.class.php';
include '../class/modules.class.php';
include '../class/tools.class.php';
include '../class/user.class.php';
include '../class/templates.class.php';
include '../class/widget.class.php';

$init = new init();
$db = init::selectTypeDatabase($database['type']);

$qgeneral = $db->query_array( 'Select * From '.$database['tbl_prefix'].'dev_general LIMIT 1');

if(isset($_SESSION['logged']))
    $user = unserialize($_SESSION['logged']);

init::loadACPPreferences();

if(!isset($user) || !$user->isOnGroup('Administrator')){
    ob_end_clean();
    header( "Location: ../index.php?t=noaccess" );
    exit();
}
else{
    if(!isset($_SESSION['admin'])){
        $_SESSION['admin'] = $user->getValues('username');
        acp::addLog($lang['admacc']);
    }
}

$tpl = new Template($skin);
?>