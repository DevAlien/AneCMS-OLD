<?php

class XmlrpcTools{

	public static function checkSessionId($sessionId){
		global $db, $database;

		$session = $db->query('Select userId from '.$database['tbl_prefix'].'dev_xmlrpcsessions where ip = ? AND id = ?', DBDriver::AARRAY, array($_SERVER['REMOTE_ADDR'], $sessionId));
		if(is_array($session) && is_numeric($session['userId']))
			return $session['userId'];
		else
			return false;
	}

	public static function createSessionId($userId){
		global $db, $database;

		$t = $db->query('Select * from '.$database['tbl_prefix'].'dev_xmlrpcsessions where ip = ? AND userId = ?', DBDriver::ALIST, array($_SERVER['REMOTE_ADDR'], $userId));
		if(is_array($t) && count($t) == 1)
			return $t[0]['id'];
		else if(is_array($t) && count($t) == 0){
			return $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_xmlrpcsessions (ip, userId) VALUES (?, ?)', DBDriver::LASTID, array($_SERVER['REMOTE_ADDR'], $userId));
		}
	}
}
?>