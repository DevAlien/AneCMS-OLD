<?php

class Errors{

    public static function saveError($text, $type){
        global $db, $database, $user;
        $db->query('INSERT INTO ' . $database['tbl_prefix'] . 'dev_errors ( type, url, logged, who, ip, text, date ) values (?, ?, ?, ?, ?, ?, ?)', DBDriver::QUERY, array($type, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], ((isset($_SESSION['logged'])) ? true : false),((isset($_SESSION['logged'])) ? $user->getValues('id') : '0'), $_SERVER["REMOTE_ADDR"], $text, time()));
    }

    public function getTypes(){
        global $db, $database;

        return $db->query('SELECT DISTINCT(type) FROM ' . $database['tbl_prefix'] . 'dev_errors', DBDriver::ALIST);
    }

    public function getErrors($type = false, $date = false){
        global $db, $database;
        if(!$type && !$date)
        if($type && !$date)
            return $db->query('SELECT * FROM ' . $database['tbl_prefix'] . 'dev_errors WHERE type = ?', DBDriver::ALIST, array($type));
        else
            return $db->query('SELECT * FROM ' . $database['tbl_prefix'] . 'dev_errors', DBDriver::ALIST);
    }
}
?>
