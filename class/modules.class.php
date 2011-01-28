<?php
/**
 * This class manages the modules of the cms
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * This class manages the modules of the cms
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class Modules {

    /**
     * Load one Module
     *
     * @global Database $db
     * @global Template $tpl
     * @global array $qgeneral
     * @global array $database
     * @global User $user
     * @global String $skin
     * @global array $lang
     * @param string $name The name of the module to load
     */
    public static function loadModule($name) {
        global $db, $tpl, $qgeneral, $database, $user, $skin, $lang;
        if($name == 'DEFAULT' && file_exists('./modules/'.$qgeneral['default_module'].'/index.php'))
            include './modules/'.$qgeneral['default_module'].'/index.php';
        else if(isset($name) && $db->query('SELECT id FROM '.$database['tbl_prefix'].'dev_modules WHERE name = ? AND type = ? AND status = ?', DBDriver::COUNT, array($name, 1, 1)) != 0 && file_exists('./modules/'.$name.'/index.php'))
            include './modules/'.$name.'/index.php';
        else {
            $tpl->assign('typeerror', $lang['err_nomod']);
            $tpl->assign('descrerror', $lang['derr_nomod']);
            $tpl->burn('error1', 'tpl');
        }
    }

    /**
     * Load one Module for the acp
     *
     * @global Database $db
     * @global Template $tpl
     * @global array $qgeneral
     * @global array $database
     * @global User $user
     * @global String $skin
     * @global array $lang
     * @param string $name The name of the module to load
     */
    public static function loadAdminModule($name) {
        global $db, $tpl, $qgeneral, $database, $user, $skin, $lang;
        if($name == 'DEFAULT')
            include '../modules/'.$qgeneral['default_module'].'/index.php';
        else if(isset($name) && $db->query('SELECT id FROM '.$database['tbl_prefix'].'dev_modules WHERE name = ? AND type = ?', DBDriver::COUNT, array($name, 1)) != 0)
            include '../modules/'.$name.'/admin/index.php';
        else {
            $tpl->assign('typeerror', $lang['err_nomod']);
            $tpl->assign('descrerror', $lang['derr_nomod']);
            $tpl->burn('error1', 'tpl');
        }
    }

    /**
     * Load mini ACP situate in top of all pages
     *
     * @global Database $db
     * @global Template $tpl
     * @global array $qgeneral
     * @global array $database
     * @param String $name the name of the module
     * @return boolean
     */
    public static function loadMiniACPModule($name) {
        global $db, $tpl, $qgeneral, $database;
        if($name == 'DEFAULT') {
            if(file_exists('./modules/'.$qgeneral['default_module'].'/miniACP/index.php')){
                include './modules/'.$qgeneral['default_module'].'/miniACP/index.php';
                return true;
            }
            else
                return false;
        }
        else if(isset($name) && $db->query('SELECT id FROM '.$database['tbl_prefix'].'dev_modules WHERE name = ? AND type = ? AND status = ?', DBDriver::COUNT, array($name, 1, 1)) != 0 && file_exists('./modules/'.$name.'/miniACP/index.php')) {
            include './modules/'.$name.'/miniACP/index.php';
            return true;
        }
        else
            return false;
    }

    /**
     * Load all module that work in Background
     *
     * @global Database $db
     * @global Template $tpl
     * @global array $qgeneral
     */
    public static function loadBackgroundModules() {
        global $db, $tpl, $qgeneral, $database, $user, $skin, $lang;
        foreach($db->query('SELECT name FROM '.$database['tbl_prefix'].'dev_modules WHERE status = ? AND type = ?', DBDriver::ALIST, array(1, 3)) as $key => $module)
            include './modules/'.$module['name'].'/index.php';
    }

    /**
     * Get the list of all modules, installed or not
     *
     * @global Database $db
     * @return array
     */
    public static function getListModules() {
        global $db;
        return $db->query('Select * From '.$database['tbl_prefix'].'modules ', DBDriver::ALIST);
    }

    /**
     * Use this method for disable one module
     *
     * @global Database $db
     * @global array $database
     * @param integer $id id of module to disable
     * @return array
     */
    public static function disableModule($id) {
        global $db, $database;
        return $db->query('Update '.$database['tbl_prefix'].'dev_modules set status = ? where id = ?', DBDriver::QUERY, array(0, $id));
    }

    /**
     * Use this method for activate one module
     *
     * @global Database $db
     * @global array $database
     * @param integer $id id of module to activate
     * @return boolean
     */
    public static function activeModule($id) {
        global $db, $database;
        return $db->query('Update '.$database['tbl_prefix'].'dev_modules set status = ? where id = ?', DBDriver::QUERY, array(1, $id));
    }

    public static function isAModule($name) {
        global $db, $database;

        if(isset($name) && $db->query('SELECT id FROM '.$database['tbl_prefix'].'dev_modules WHERE name = ? AND status = ?', DBDriver::COUNT, array($name, 1)) != 0)
            return true;
        else
            return false;
    }
}
?>