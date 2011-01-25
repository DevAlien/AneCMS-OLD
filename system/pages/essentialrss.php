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
header('content-type: application/rss+xml; charset: utf-8');


include './config.php';
include './class/tple/template.class.php';
include './class/init.class.php';
include './class/modules.class.php';
include './class/tools.class.php';

$init = new init();
$db = $init->selectTypeDatabase($database['type']);

$qgeneral = $db->query_array( 'Select * From '.$database['tbl_prefix'].'dev_general LIMIT 1', true);

init::loadBasicPreferences();
?>