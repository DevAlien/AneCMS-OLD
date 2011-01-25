<?php
define('ANECMS', true);
define('ACCESS', true);
include './system/pages/essential.php';

if(isset($_POST['l'])) {
    $tpl->assign('link', 'this');
    $tpl->assign('error', $lang['logout_yes']);
    $tpl->assign('redirect', $lang['redirect_yes']);
    $tpl->assign('compli', $lang['compli']);
    $tpl->burn('error', 'tpl', false);
    setcookie('ANECMSUser', serialize($user), time() - 3600000);
    session_destroy();
}
else if(isset($_POST['username'])) {
    $qlogin = $db->query_array( 'SELECT * FROM '.$database['tbl_prefix'].'dev_users  WHERE username = \''.Tools::parseGetPost($_POST['username']).'\' AND password =\''.md5($_POST['password']).'\'');
    if(isset($qlogin)) {
        if($qlogin['status'] < 1) {
            if(isset($_GET['normal'])) {
                $tpl->assign('typeerror', $lang['login']);
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
            if($user->getValues('groups') == 3)
                $_SESSION['admin'] = true;
            $_SESSION['logged'] = serialize($user);

            setcookie('ANECMSUser', serialize($user), time() + 3600000);
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
