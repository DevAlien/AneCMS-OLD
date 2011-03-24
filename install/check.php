<?php
/*-------------------------------------------------------+
| AneCMS
| Copyright (C) 2010
| http://anecms.com
+--------------------------------------------------------+
| Filename: check.php
| Author: Gonçalo Margalho
+--------------------------------------------------------+
| Removal of this copyright header is strictly 
| prohibited without written permission from 
| Gonçalo Margalho.
+--------------------------------------------------------*/
session_start();
include '../class/db/mysql.class.php';
include 'install.class.php';
if($_GET['check'] == 3){
  $install = unserialize($_SESSION['install']);
  $install->createFolders();
  $_SESSION['install'] = serialize($install);
}
else if($_GET['check'] == 4){
  $install = unserialize($_SESSION['install']);
  $install->writeDB($_POST['title'], $_POST['description'], $_POST['baseurl']);
  $_SESSION['install'] = serialize($install);
}
else if($_GET['check'] == 5){
  $install = unserialize($_SESSION['install']);
      $install->writeConfig();
      $_SESSION['install'] = serialize($install);
}

else if($_GET['check'] == 6){
  $install = unserialize($_SESSION['install']);
  $c = $install->writeHtaccess();
$_SESSION['install'] = serialize($install);
	
  
}
else if($_GET['check'] == 7){
  $install = unserialize($_SESSION['install']);
  echo $install->getFiles();
  
}

else if($_GET['check'] == 2){
    $install = new Install($_POST['prefix'], $_POST['lang']);
    $install->setDB($_POST['dbhostname'], $_POST['dbusername'], $_POST['dbpassword'], $_POST['dbdatabase']);
    if($install->checkDBConnection()){
      echo 'OK';
      $_SESSION['install'] = serialize($install);
    }
    else
      echo 'NO';
}
?>
