<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_GET['m']) && $_GET['m'] == 'errors'){
    include '../class/errors.class.php';
    $errors = new Errors();
    $tpl->assign('errors', $errors->getErrors());
    echo $tpl->burn( 'dash_errors', 'tpl' );
}
else{

if(isset($_GET['m']) && $_GET['m'] == 'enote')
    acp::saveNote($_POST['notes']);

	include '../class/iXR_library.inc.php';
        
        $client = new IXR_Client('http://repo.anecms.com/server.php');
	$client->query('cmsIsUpdated', $qgeneral['version']);
	
	if($client->getResponse() == 1)
		$tpl->assign('isUpdated', $lang['updated']);
	else
		$tpl->assign('isUpdated', $lang['notupdated']);

$tpl->assign('log', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_adminlog , '.$database['tbl_prefix'].'dev_users WHERE '.$database['tbl_prefix'].'dev_users.id = '.$database['tbl_prefix'].'dev_adminlog.user ORDER BY '.$database['tbl_prefix'].'dev_adminlog.id DESC', DBDriver::ALIST));

$qgeneral = $db->query( 'Select * From '.$database['tbl_prefix'].'dev_general', DBDriver::AARRAY,,array(1), true);
$tpl->assign('notes', $qgeneral['notes']);

//RSS
include '../class/rssreader.class.php';

  $xml = new RssReader();


  $xml->Load('http://devalien.com/rss.php?module=blog&cat=python');

  // Get ALL
  $all = $xml->GetItems();
  if (is_array($all) and count($all)>0)
  {

    $tpl->assign('rss', $all);
  }
echo $tpl->burn( 'dash', 'tpl' );

}
?>
