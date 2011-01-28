<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_GET['m']) && $_GET['m'] == 'mod') {
    $tpl->assign('cfg', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_general', DBDriver::ALIST));
    $tpl->assign('dmodule', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_modules WHERE status = ? AND type = ? ORDER By name', DBDriver::ALIST, array(1,1)));
    $tpl->assign('langpd', acp::getLanguage());

    echo $tpl->burn( 'cfg_mod', 'tpl' );
}
else if(isset($_GET['m']) && $_GET['m'] == 'links') {
        $tpl->assign('update', 0);
        if(isset($_GET['a']) && $_GET['a'] == 'modify'){
            $tpl->assign('update', $_GET['id']);
            $toModify = $db->query('SELECT name, link FROM '.$database['tbl_prefix'].'dev_menus WHERE id = ?', DBDriver::AARRAY, array($_GET['id']));
            $tpl->assign('nam', $toModify['name']);
            $tpl->assign('lin', $toModify['link']);
        }
        else{
            $tpl->assign('nam', '');
            $tpl->assign('link', '');
        }
        if(isset($_GET['a']) && $_GET['a'] == 'delete')
            $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_menus WHERE id = ?', DBDriver::QUERY, array($_GET['id']));
        else if(isset($_GET['a']) && $_GET['a'] == 'move')
            if($_GET['type'] == 'up')
                ACP::setMenuUpPosition($_GET['id']);
            else if($_GET['type'] == 'down')
                ACP::setMenuDownPosition($_GET['id']);
        if(isset($_POST['link'])&& isset($_GET['id']) && $_GET['id'] > 0)
            $db->query('UPDATE '.$database['tbl_prefix'].'dev_menus SET type = \''.$_POST['type'].'\', name = \''.$_POST['name'].'\', view = \''.$_POST['view'].'\', link = \''.$_POST['link'].'\' WHERE '.$database['tbl_prefix'].'dev_menus.id ='.$_GET['id'].' LIMIT 1');
        else if(isset($_POST['link']))
            $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_menus (type, name, view, link, position) VALUES ('.$_POST['type'].', \''.$_POST['name'].'\', \''.$_POST['view'].'\', \''.$_POST['link'].'\', '.ACP::getNextPosition($_POST['type']).')');
        $db->delete_cache();
        $tpl->assign('linksbar', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus WHERE TYPE = ? ORDER BY position', DBDriver::ALIST, array(1)));
        $tpl->assign('countlinksbar',$db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus WHERE TYPE = ? ORDER BY position', DBDriver::COUNT, array(1)));
        $tpl->assign('linksmenu', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus WHERE TYPE = ? ORDER BY position', DBDriver::ALIST, array(2)));
        $tpl->assign('countlinksmenu', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus WHERE TYPE = ? ORDER BY position', DBDriver::COUNT, array(2)));
        echo $tpl->burn( 'cfg_links', 'tpl' );
}
else if(isset($_GET['m']) && $_GET['m'] == 'smod') {
        $db->query('UPDATE '.$database['tbl_prefix'].'dev_general SET language = \''.$_POST['language'].'\', descr = \''.$_POST['descr'].'\', title = \''.$_POST['title'].'\', url_base = \''.$_POST['url_base'].'\', default_module = \''.$_POST['defaultmodule'].'\', twitter_user = \''.$_POST['tusername'].'\', twitter_password = \''.$_POST['tpassword'].'\', akismetkey = \''.$_POST['akismetkey'].'\', status = '.((isset($_POST['status'])) ? 1 : 0).', infoclosed = \''.$_POST['infoclosed'].'\'  WHERE '.$database['tbl_prefix'].'dev_general.id =0 LIMIT 1');
        $db->delete_cache();
        $tpl->assign('langpd', acp::addLog($lang['updatecfg']));
        $tpl->assign('cfg', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_general', DBDriver::ALIST));
        echo $tpl->burn( 'cfg', 'tpl' );
}
else if(isset($_GET['m']) && $_GET['m'] == 'reposerver') {

    if (isset($_POST['url']))
        $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_servers VALUES (?, ?)', DBDriver::QUERY, array(null, $_POST['url']));

    if(isset($_GET['d']))
        $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_servers WHERE id = ?', DBDriver::QUERY, array($_GET['id']));

    $tpl->assign('reposervers', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_servers', DBDriver::ALIST));
    echo $tpl->burn( 'mod_insert', 'tpl' );
}
else {
    $tpl->assign('cfg', $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_general', DBDriver::ALIST));
    echo $tpl->burn( 'cfg', 'tpl' );
}
?>
