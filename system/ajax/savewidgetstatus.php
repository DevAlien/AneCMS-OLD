<?php

if($user->isOnGroup('Administrator') && isset($_POST['json']) && $_POST['json'] != ''){
    $idtheme = $db->query('SELECT id,widgetarea FROM '.$database['tbl_prefix'].'dev_themes WHERE name = \''.$skin.'\'', DBDriver::QUERY);
    $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_themewidgets WHERE idtheme = '. $idtheme['id']);

    $aWidgets = json_decode(stripslashes($_POST['json']), true);

    foreach($aWidgets as $widgetarea => $aWithWidgets){
        $c = 0;
            foreach($aWithWidgets as $aWithWidget){
				$c++;
				$db->query('INSERT INTO '.$database['tbl_prefix'].'dev_themewidgets (idtheme, widgetname, widgetarea, position) VALUES ('.$idtheme['id'].', \''.$aWithWidget.'\', \''.$widgetarea.'\', '.$c.')');
            }
    }

    if($file = glob( './tmp/cache/skins/'.$skin.'/*.php' ))
		foreach( $file as $delfile){
			unlink($delfile);
		}
        
		$tpl->assign('link', 'this');
		$tpl->assign('compli', $lang['savewidgets_ok']);
		$tpl->assign('error', $lang['savewidgets_ok']);
		$tpl->assign('redirect', $lang['redirect_yes']);
		
		$tpl->burn('error', 'tpl', false);
}
?>
