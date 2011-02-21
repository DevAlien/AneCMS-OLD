<?php
define('ANECMS', true);
define('ACCESS', true);
define('LOGIN', true);

include './system/pages/essential.php';

 
	
if(isset($_GET['logout'])) {
	$tpl->assign('site_title', $qgeneral['title']);
	$tpl->assign('sub_site_title', $qgeneral['descr']);
	if (is_object($user) && ($user->isOnGroup('Administrator') OR $user->isOnGroup('JuniorAdmin')))
	    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? ORDER BY position', DBDriver::ALIST, array(1, 1), true));
	else if (is_object($user) && !$user->isOnGroup('JuniorAdmin') && !$user->isOnGroup('Administrator'))
	    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? AND view < ? ORDER BY position', DBDriver::ALIST, array(1, 1, 3), true));
	else
	    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view <= ? ORDER BY position', DBDriver::ALIST, array(1, 1), true));
	    
		$tpl->assign('typeerror', $lang['logout']);
        $tpl->assign('descrerror', $lang['logout_yes']);
        $tpl->burn('error1', 'tpl');
	    setcookie('ANECMSUser', '', time() - 3600000);
	    session_destroy();
} else if( $init->checkCookie() || isset($_SESSION['logged']) ) {
	header( "Location: acp/index.php" );
	die();
}
	else if(isset($_POST['username'])) {
	$tpl->assign('site_title', $qgeneral['title']);
	$tpl->assign('sub_site_title', $qgeneral['descr']);
	if (is_object($user) && ($user->isOnGroup('Administrator') OR $user->isOnGroup('JuniorAdmin')))
	    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? ORDER BY position', DBDriver::ALIST, array(1, 1), true));
	else if (is_object($user) && !$user->isOnGroup('JuniorAdmin') && !$user->isOnGroup('Administrator'))
	    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? AND view < ? ORDER BY position', DBDriver::ALIST, array(1, 1, 3), true));
	else
	    $tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view <= ? ORDER BY position', DBDriver::ALIST, array(1, 1), true));
	    $qlogin = $db->query( 'SELECT * FROM '.$database['tbl_prefix'].'dev_users  WHERE username = ? AND password = ?', DBDriver::AARRAY, array($_POST['username'], md5($_POST['password'])));

    if(isset($qlogin)) {
        if($qlogin['status'] < 1) {
            if(isset($_GET['normal'])) {
                $tpl->assign('typeerror', $lang['login_no']);
                $tpl->assign('descrerror', $lang['login_err']);
                $tpl->burn('error1', 'tpl');
            }
            else {
                $tpl->assign('error', $lang['login_err']);
                $tpl->assign('redirect', $lang['redirect_no'].'<br /><a href="javascript:ChiudiOscura();">'.$lang['close'].'</a>');
                $tpl->burn('error', 'tpl', false);
            }
        }
        else {
            $user = new User($qlogin);
			if (is_object($user) && ($user->isOnGroup('Administrator') OR $user->isOnGroup('JuniorAdmin')))
	    		$tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? ORDER BY position', DBDriver::ALIST, array(1, 1), true));
			else if (is_object($user) && !$user->isOnGroup('JuniorAdmin') && !$user->isOnGroup('Administrator'))
	    		$tpl->assign('top_menu', $db->query('Select * From ' . $database['tbl_prefix'] . 'dev_menus where type = ? AND view >= ? AND view < ? ORDER BY position', DBDriver::ALIST, array(1, 1, 3), true));
			if( !empty($_POST['remember']) ) {
				if(is_object($user) && ($user->isOnGroup('Administrator') OR $user->isOnGroup('JuniorAdmin')))
					$_SESSION['admin'] = true;
					$_SESSION['token'] = Tools::getToken();
					$_SESSION['logged'] = serialize($user);

				setcookie('ANECMSUser', serialize($user), time() + 3600000);
			} else {
					$_SESSION['admin'] = true;
					$_SESSION['token'] = Tools::getToken();
					$_SESSION['logged'] = serialize($user);
			}
            if(isset($_GET['normal'])) {
                $tpl->assign('typeerror', $lang['compli']);
                $tpl->assign('descrerror', $lang['login_yes']);
                $tpl->burn('error1', 'tpl');
            }
            else {
                $tpl->assign('error', $lang['login_yes']);
                $tpl->assign('redirect', $lang['redirect_yes']);
                $tpl->assign('compli', $lang['compli']);

                if(isset($_POST['s']))
                    $tpl->assign('link', 'this');
                else
                    $tpl->assign('link', $_GET['req']);

                $tpl->burn('error', 'tpl', false);
            }

        }
    }
    else {
        if(isset($_GET['normal'])) {
            if(file_exists('./skins/'.$skin.'/login.tpl'))
                $tpl->burn('login', 'tpl', false);
            else {
                $tplogin = new Template('./system/pages', false);
                $tplogin->burn('login', 'tpl', false);
            }
        }
        else {
            $tpl->assign('redirect', $lang['redirect_no'].' <a href="'.$qgeneral['url_base'].'register">'.$lang['signup'].'<br /><a href="javascript:ChiudiOscura();">'.$lang['re'].'</a>');
            $tpl->assign('error', $lang['login_no']);
            $tpl->assign('link', 'login.php?mode=new');
            $tpl->burn('error', 'tpl', false);
        }
    }

}
else {
    if(file_exists('./skins/'.$skin.'/login.tpl'))
        $tpl->burn('login', 'tpl', false);
    else {
        $tplogin = new Template('./system/pages', false);
        $tplogin->burn('login', 'tpl', false);
    }
}

?>
