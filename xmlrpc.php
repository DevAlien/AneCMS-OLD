<?php
define('ANECMS', true);
define('XMLRPC', true);
//TODO: create a preg_replace_callback
$a = explode('<methodName>',$HTTP_RAW_POST_DATA);
$b = explode('.', $a[1]);
$_GET['mode'] = strtolower(str_replace('AneCMS','',$b[0]));
//ENDTODO

include './system/pages/essential.php';
include './class/iXR_library.inc.php';
include './class/xmlrpctools.class.php';

if(isset($_GET['mode']) && $_GET['mode'] != '') {
    $module = str_replace("../", '', $_GET['mode']);
    if(file_exists('./modules/'.$module.'/xmlrpc.php'))
        include './modules/'.$module.'/xmlrpc.php';
    else {
        echo 'There is not an xmlrpc file in the '.$_GET['mode'].'';
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
		$login = $db->query('SELECT id FROM '.$database['tbl_prefix'].'dev_users where username = ? AND password = ?', DBDriver::AARRAY, array($username, $password));
		if(is_array($login) && is_numeric($login['id']))
			return XmlrpcTools::createSessionId($login['id']);
		else
			return -1;
	}
	
	function getSiteTitle(){
		global $db, $database;
		
		return $db->query('Select title from '.$database['tbl_prefix'].'dev_general LIMIT 1', DBDriver::AARRAY);
	}

	function getModulesWS($sessionId){
		global $db, $database;
		//TODO: just the ones with xmlrpc service
		if(XmlrpcTools::checkSessionId($sessionId))
			return $db->query('Select name from '.$database['tbl_prefix'].'dev_modules', DBDriver::ALIST);
		else
			return false;
	}

	$server = new IXR_Server(array(
			'AneCMS.check' => 'check',
			'AneCMS.login' => 'login',
			'AneCMS.getModulesWS' => 'getModulesWS',
			'AneCMS.getSiteTitle' => 'getSiteTitle'));
}
?>