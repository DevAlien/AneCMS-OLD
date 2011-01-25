<?php
session_start();
include '../../lang/'.$_SESSION['language'].'/main.php';
include '../../lang/'.$_SESSION['language'].'/admin.php';
require '../../class/GzOutput.class.php';
GzOutput::createFromFileBoostrap('text/javascript');
?>
