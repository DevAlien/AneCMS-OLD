<?php
if(isset($_GET['error']) && $_GET['error'] == 404){
include("class/modrewrite.class.php");
$ModRewrite = new ModRewrite();

$ModRewrite->htaccess = "./htaccess.rew";

$todo = $ModRewrite->rewrite();

/**
 * outside the class to keep globals [+]
 **/ 
if ($todo["include"]) {

  header("HTTP/1.0 200 OK");
  ob_end_clean();
  $_REQUEST = array_merge($todo["vars"],$_REQUEST);
  $_GET = array_merge($todo["vars"],$_GET);
  include($todo["include"]);
  exit;
}
}
include './system/pages/essential.php';

$tpl = new Template('./skins/'.$skin);
$tpl->assign('typeerror', $lang['err_'.$_GET['t'].'']);
$tpl->assign('descrerror', $lang['derr_'.$_GET['t'].'']);
$tpl->burn('error1', 'tpl');
?>