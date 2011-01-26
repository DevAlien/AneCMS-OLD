<?php
define('ANECMS', true);
define('XMLRPC', true);
include './system/pages/essential.php';
include './class/iXR_library.inc.php';


if(isset($_GET['module'])) {
    $module = str_replace("../", '', $_GET['module']);
    if(file_exists('./modules/'.$module.'/xmlrpc.php'))
        include './modules/'.$module.'/xmlrpc.php';
    else {
        echo 'There is not an xmlrpc file in the '.$_GET['module'].'';
        die();
    }
}
else {
  
  function check() {
      return true;
  }
  
  function login($args){
    global $db, $database;
    $username = $args[0];
    $password = $args[1];

    $login = $db->query_array('SELECT id FROM '.$database['tbl_prefix'].'dev_users where username = \''.$username.'\' AND password = \''.md5($password).'\'');
    if(is_array($login) && is_numeric($login['id']))
      return createSessionId($login['id']);
    else
      return false;
  }
  
  function getModulesWS($sessionId){
    global $db, $database;
    
    if(checkSessionId($sessionId))
      return $db->query_list('Select name from '.$database['tbl_prefix'].'dev_modules');
    else
      return false;
  }
  
  function checkSessionId($sessionId){
    global $db, $database;
    
    $session = $db->query_array('Select userId from '.$database['tbl_prefix'].'dev_xmlrpcsessions where ip = \''.$_SERVER['REMOTE_ADDR'].'\' AND id = '.$sessionId);
    if(is_array($session) && is_numeric($session['userId']))
      return $session['userId'];
    else
      return -1;
  }
  
  function createSessionId($userId){
    global $db, $database;
    $t = $db->query_list('Select * from '.$database['tbl_prefix'].'dev_xmlrpcsessions where ip = \''.$_SERVER['REMOTE_ADDR'].'\' AND userId = '.$userId);
    if(is_array($t) && count($t) == 1)
      return $t[0]['id'];
    else if(is_array($t) && count($t) == 0){
      return $db->query_id('INSERT INTO '.$database['tbl_prefix'].'dev_xmlrpcsessions (ip, userId) VALUES (\''.$_SERVER['REMOTE_ADDR'].'\', '.$userId.')');
  }
  }
  $server = new IXR_Server(array(
              'AneCMS.check' => 'check',
              'AneCMS.login' => 'login',
              'AneCMS.getModulesWS' => 'getModulesWS'));
}
?>