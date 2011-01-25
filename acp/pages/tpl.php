<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_GET['m']) && $_GET['m'] == 'widgets' && isset($_GET['t']) && $_GET['t'] == 'ajax'){
	$widgets = $db->query_list('Select * From '.$database['tbl_prefix'].'dev_themewidgets Inner Join '.$database['tbl_prefix'].'dev_themes On '.$database['tbl_prefix'].'dev_themewidgets.idtheme = '.$database['tbl_prefix'].'dev_themes.id WHERE '.$database['tbl_prefix'].'dev_themes.name = \''.$_POST['tplname'].'\'ORDER BY '.$database['tbl_prefix'].'dev_themewidgets.widgetname asc, '.$database['tbl_prefix'].'dev_themewidgets.position asc');
	$tpl->assign('wid', $widgets);
	$tpl->burn('tpl_widgets_ajax', 'tpl', false);

}
else if(isset($_GET['m']) && $_GET['m'] == 'save' && isset($_GET['t']) && $_GET['t'] == 'ajax'){
	file_put_contents($_POST['filelink'], stripcslashes($_POST['notes']));
	$tpl->assign('filecontent', file_get_contents($_POST['filelink']));
	$tpl->assign('filename', $_POST['fname']);
        $tpl->assign('tpl', $_POST['filelink']);
	$tpl->burn('tpl_modify_file', 'tpl', false);

}
else if(isset($_GET['m']) && $_GET['m'] == 'modify' && isset($_GET['t']) && $_GET['t'] == 'ajax'){
	$tpl->assign('filecontent', file_get_contents($_POST['filelink']));
	$tpl->assign('filename', $_POST['fname']);
        $tpl->assign('tpl', $_POST['filelink']);
	$tpl->burn('tpl_modify_file', 'tpl', false);

}
else if(isset($_GET['m']) && $_GET['m'] == 'widgets'){
	$tpl->addJavascript('system/js/admin.js');

	$tpl->assign('templates', $db->query_list('SELECT name FROM dev_themes'));
	$tpl->burn('tpl_widgets', 'tpl');
}
else if(isset($_GET['m']) && $_GET['m'] == 'modify'){
	include '../class/php_file_tree.php';
	$tpl->addJavascript('system/js/admin.js');
	$tpl->addJavascript('system/js/php_file_tree_jquery.js');
	$tpl->addCSSFile('system/js/default.css');
                
        $tpl->addCSSFile('system/js/markitup/skins/markitup/style.css');
        $tpl->addCSSFile('system/js/markitup/sets/default/style.css');
        $tpl->addCSSFile('system/js/markitup/sets/css/style.css');
        $tpl->addJavascript('system/js/markitup/jquery.markitup.pack.js');
        $tpl->addJavascript('system/js/markitup/sets/default/set.js');
        $tpl->addJavascript('system/js/markitup/sets/css/set.js');
	$tpl->burn('tpl_modify', 'tpl');


}

else{
	$tpl->addJavascript('system/js/admin.js');

	$tpl->assign('templates', $db->query_list('SELECT name FROM dev_themes'));
	$tpl->burn('tpl_widgets', 'tpl');
}
?>
