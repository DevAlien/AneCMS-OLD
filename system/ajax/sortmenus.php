<?php
if($user!==false && ($user->isOnGroup('Administrator') OR $user->isOnGroup('CustomerAdmin'))){
	foreach ($_GET['listItem'] as $position => $item)
		$db->query('UPDATE '.$database['tbl_prefix'].'dev_users set position = ? $position WHERE id = ?', DBDriver::QUERY, array($position, $item));
}
die();
?>