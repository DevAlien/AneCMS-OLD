<?php
if(is_object($user) && ($user->isOnGroup('Administrator') OR $user->isOnGroup('CustomerAdmin'))){
	foreach ($_GET['listItem'] as $position => $item)
		$db->query('UPDATE '.$database['tbl_prefix'].'dev_menus set position = ? WHERE id = ?', DBDriver::QUERY, array($position, $item));
}
die();
?>