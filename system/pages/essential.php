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
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
define('ROOT_PATH', str_replace('system/pages','', str_replace('\\','/',dirname(__FILE__))));
if(!defined('ANECMS') && !defined('ANECMSACP')) die ('You can\'t see this page');
session_start();
if(!defined('RSS'))
    header('content-type: text/html; charset: utf-8');
else
header ("content-type: text/xml;  charset: utf-8");

if(!file_exists(ROOT_PATH.'config.php')) {
    ob_end_clean();
	if(defined('ANECMS'))
    		header( "Location: ./install/index.php" );
	else if(defined('ANECMSACP'))
    		header( "Location: ../install/index.php" );
	else
		echo 'You must install AneCMS before. You can find the installer in ROOTAneCMS/install/index.php';
	die();
}

include ROOT_PATH.'config.php';
include ROOT_PATH.'class/template.class.php';
include ROOT_PATH.'class/init.class.php';
include ROOT_PATH.'class/modules.class.php';
include ROOT_PATH.'class/tools.class.php';
include ROOT_PATH.'class/user.class.php';
include ROOT_PATH.'class/templates.class.php';
include ROOT_PATH.'class/widget.class.php';

if( get_magic_quotes_gpc() ) {
	$_GET    = array_map( array('Tools', 'sanitizeRequest'), $_GET);
	$_POST   = array_map( array('Tools', 'sanitizeRequest'), $_POST);
	$_COOKIE = array_map( array('Tools', 'sanitizeRequest'), $_COOKIE);
}

$init = new init();
$db = $init->selectTypeDatabase($database['type']);

$qgeneral = $db->query( 'Select * From '.$database['tbl_prefix'].'dev_general', DBDriver::AARRAY, array(),array(1), true);

if(!isset($_SESSION['language']))
    $_SESSION['language'] = $qgeneral['language'];

if(isset($_SESSION['logged']))
    $user = unserialize($_SESSION['logged']);
else
    $user = $init->checkCookie();
//Iflogged load the timezone of the user, else load the default timezone	
if(isset($user))
	date_default_timezone_set($user->getValues('timezone'));
else
	date_default_timezone_set($qgeneral['timezone']);
	
if(defined('ANECMS')){
if($qgeneral['status'] == 0  && !defined('ACCESS') && (!isset($user) || !$user->isOnGroup('Administrator')))
    $closed = true;

init::loadBasicPreferences();
if(!defined('RSS') || !defined('XMLRPC')){
  $tpl = new Template($skin);
  $tpl->addJavascript('system/js/jquery-1.4.2.min.js');
  $tpl->addJavascript('system/js/jquery.jgrowl_minimized.js');
  $tpl->addJavascript('system/js/jquery.dragsort-0.4.min.js');
  $tpl->addJavascript('system/js/main.js');
  $tpl->addCSSFile('system/js/obscure.css');
  $tpl->addOnLoadJS('<?php if(is_a($user, \'User\') && $user->isOnGroup(\'Administrator\')){?> $("#m").click(function(event) { event.preventDefault(); $("#toppanel").slideToggle();});<?php } ?>');
  $tpl->addOnLoadJS('<?php if(is_a($user, \'User\') && $user->isOnGroup(\'Administrator\')){?> $("#m1").click(function(event) { event.preventDefault(); $("#toppanel1").slideToggle();});<?php } ?>');
  $tpl->addSystemHTML('<?php if(is_a($user, \'User\') && $user->isOnGroup(\'Administrator\')){ ?> <div id="dash"><div id="toppanel"><?php if(isset($_GET[\'mode\'])) Modules::loadMiniACPModule($_GET[\'mode\']); else Modules::loadMiniACPModule(\'DEFAULT\'); ?></div><div id="dash2" style="left: 50%; margin: auto; cursor:pointer; top:0px; width:120px;"><div id="l" style=""></div><div id="m">Toppanel</div><div id="r" style=""></div></div></div><?php } ?><div id="oscura"></div><div id="notify"></div>');
  $tpl->addSystemHTML('<?php if(is_a($user, \'User\') && $user->isOnGroup(\'Administrator\') && isset($_GET[\'modifywidgets\'])){ ?> <div id="dash1"><div id="dash3" style="left: 50%; margin: auto; cursor:pointer; top:0px; width:120px;"><div id="l1" style=""></div><div id="m1">Widgets</div><div id="r1" style=""></div></div><div id="toppanel1"><input type="button" value="Press Me" name="foo" onClick="updateWidgets(\''.$qgeneral['url_base'].'\')"><br /><ul id="widgetselector"><?php $widgets = new widget(); $widgets->includeAllWidgets(); ?></ul></div></div><?php } ?>');
}
}
else if(defined('ANECMSACP')){
include ROOT_PATH.'class/acp.class.php';
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
}
?>