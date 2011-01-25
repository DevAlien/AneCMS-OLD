<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
$tpl->assign('message', '0');
if(isset($_GET['m']) && $_GET['m'] != 'search' && !isset($_SESSION['rserver']) && !isset($_GET['mod'])){
  ob_end_clean();

    header( "Location: ?p=mod&m=search" );
}
if(isset($_GET['mod'])) {

    Modules::loadAdminModule($_GET['mod']);
}
else if(isset($_GET['m']) && $_GET['m'] == 'installmodule' && isset($_GET['name'])) {
    include '../class/installmodule.class.php';
    $im = new InstallModule($_GET['name']);
    $im->install();
    $tpl->assign('installed', true);
    $tpl->assign('name', $_GET['name']);
    echo $tpl->burn( 'mod_minstall', 'tpl' );

}
else if(isset($_GET['m']) && $_GET['m'] == 'install' && isset($_GET['name'])) {
    include '../class/iXR_library.inc.php';
    
    $client = new IXR_Client($_SESSION['rserver']);
$tpl->assign('name', $_GET['name']);

    $client->query('AneRepo.getPackageByName', array($_GET['name'], $_GET['t']));
    $response = $client->getResponse();
    if($response != false) {
        file_put_contents('../tmp/toinstall/'.$_GET['name'].'.php', $response);
        if(file_exists('../tmp/toinstall/'.$_GET['name'].'.php'))
          $tpl->assign('result', true);
        else
          $tpl->assign('result', false);
    }
    else
        $tpl->assign('result', false);
    echo $tpl->burn( 'mod_install', 'tpl' );
}
else if(isset($_GET['m']) && $_GET['m'] == 'more' && isset($_GET['id'])) {
    include '../class/iXR_library.inc.php';
    $client = new IXR_Client($_SESSION['rserver']);

    $client->query('AneRepo.getModuleFromId',$_GET['id']);
    $moduleGetted = $client->getResponse();
    $tpl->assign('moduleGetted', $moduleGetted);
    $count = is_array(unserialize($moduleGetted['deps']));
    $tpl->assign('countDepends', $count ? count(unserialize($moduleGetted['deps'])) : 0);

    if($count && count(unserialize($moduleGetted['deps'])) > 0) {
        $client->query('AneRepo.getModulesFromArrayName', unserialize($moduleGetted['deps']));
        
        $dependsGetted = $client->getResponse();
        $tpl->assign('dependsGetted', $dependsGetted);
    }

    echo $tpl->burn( 'mod_more', 'tpl' );
}
else if(isset($_GET['m']) && $_GET['m'] == 'search') {

    $tpl->assign('selectsrv', $db->query_list('SELECT url FROM '.$database['tbl_prefix'].'dev_servers'));
    if(isset($_POST['word'])) {
        include '../class/iXR_library.inc.php';
        $_SESSION['rserver'] = $_POST['urlserver'];
        $client = new IXR_Client($_SESSION['rserver']);
        $client->query('AneRepo.getPackagesLikeName', array($_POST['word']));
        print_r( $client->getResponse());
        $tpl->assign('results', $client->getResponse());
    }
    else
    if(isset($_SESSION['rserver']))
        unset($_SESSION['rserver']);
    echo $tpl->burn( 'mod_add', 'tpl' );
}
else if(isset($_GET['active'])){
    $db->query('Update '.$database['tbl_prefix'].'dev_modules set status = 1 where id = '. Tools::parseGetPost($_GET['active']));
    $tpl->assign('modules', $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_modules'));
    $tpl->assign('message', 'the module has been activated');
    $tpl->assign('message_title', 'Module Activation');
    echo $tpl->burn( 'mod', 'tpl' );
}
else if(isset($_GET['deactive'])){
    $db->query('Update '.$database['tbl_prefix'].'dev_modules set status = 0 where id = '. Tools::parseGetPost($_GET['deactive']));
    $tpl->assign('modules', $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_modules'));
        $tpl->assign('message', 'The module has been deactivated');
    $tpl->assign('message_title', 'Module Deactivation');
    echo $tpl->burn( 'mod', 'tpl' );
}
else {
    $tpl->assign('modules', $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_modules'));
    echo $tpl->burn( 'mod', 'tpl' );
}
?>
