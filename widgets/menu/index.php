<?php
if(file_exists('./skins/'.$skin.'/widgets/menu/index.tpl'))
    $t = new Template('./skins/'.$skin.'/widgets/menu', false);
else
  $t = new Template('./widgets/menu', false);
if(is_object($user) && $user->getValues('groups') == 3)
    $t->assign('sidemenu', $db->query_list('Select * From '.$database['tbl_prefix'].'dev_menus where type = 2 AND view >= 1', true));
else if(is_object($user) && $user->getValues('groups') < 3)
    $t->assign('sidemenu', $db->query_list('Select * From '.$database['tbl_prefix'].'dev_menus where type = 2 AND view >= 1 AND view <3', true));
else
    $t->assign('sidemenu', $db->query_list('Select * From '.$database['tbl_prefix'].'dev_menus where type = 2 AND view <= 1', true));
$t->burn('index', 'tpl', false);
?>