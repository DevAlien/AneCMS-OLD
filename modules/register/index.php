<?php
/*
+--------------------------------------------------------------------------
|   Project: Dev-Site - Module: Gallery
|   ========================================
|   Copyright: 2006-2008 http://www.Dev-House.Com
|   ========================================
|   Licence Info:  GPL
|   ========================================
|   Author: Gon�alo Margalho <gsky89@gmail.com>
|   ========================================
|   File Name: index.php
|   ========================================
|   Last Modify: 06.02.2008 08:43
+--------------------------------------------------------------------------
*/
include 'register.class.php';
global $lang;
if(isset($_GET['next'])){
	$errors = '';
	if(!register::checkUser($_POST['username'])){
		if(Tools::checkEmail($_POST['email'])){
			if(Tools::checkIfEquals($_POST['password'], $_POST['rpassword'])){
				if(register::registerUser($_POST['username'], $_POST['email'], md5($_POST['password']), $_POST['language'], $qgeneral['skin'],1)){
					$tpl->assign('title_notify', $lang['register']);
					$tpl->assign('message_notify', $lang['finishreg']);
					$tpl->burn('notify', 'tpl');
				}
				else
					$errors .= $lang['errordis'];
			}
			else
				$errors .= $lang['passnotmatch'];
		}
		else
			$errors .= $lang['emailinvalid'];
	}
	else
		$errors .= $lang['userexist'];
	if($errors != ''){
		$tpl->assign('errors', $errors);
		$tpl->burn('reg', 'tpl');
	}
}
else
{
	$errors = '';
	$tpl->assign('errors', $errors);
	$tpl->burn('reg', 'tpl');
}
?>