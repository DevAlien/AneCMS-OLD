<?php
/**
 * This class manages the templates of the cms
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * This class manages the templates of the cms
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class Templates {

    /**
     * Get the installed Templates in an array
     *
     * @return array
     */
    public static function getInstalledTpl() {
        if ($handle = opendir('../skins')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
                    $array[] = $file;
            }
        }
        closedir($handle);
        return $array;
    }

    /**
     * Update the default Template
     * 
     * @global Database $db
     * @global array $database
     * @param String $selTPL Name of the tpl to update in dev_general
     * @return mixed
     */
    public static function updateDefaultTemplate($selTPL) {
        global $db, $database;
        return $db->query('Update '.$database['tbl_prefix'].'dev_general set skin = ? where id = ?', DBDriver::QUERY, array($selTPL, 0));

    }
}
?>
