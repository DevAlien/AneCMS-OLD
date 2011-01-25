<?php

/**
 * This page must be included in all pages
 *
 * @package Dev-Site
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright Dev-House.Com (C) 2006-2008
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
session_start();
include '../../config.php';
include '../../class/init.class.php';
include '../../class/user.class.php';

$init = new init();
$db = $init->selectTypeDatabase($database['type']);

$qgeneral = $db->query_array( 'Select language From '.$database['tbl_prefix'].'dev_general LIMIT 1', true);

if(isset($_SESSION['logged']))
    $user = unserialize($_SESSION['logged']);
else
    $user = $init->checkCookie();

if (is_object($user))
            include '../../lang/'.$user->getValues('language').'/main.php';

        else
            include '../../lang/'.$qgeneral['language'].'/main.php';

?>