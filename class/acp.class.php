<?php
/**
 * Class to manage ACP
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anecms.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * Class to manage ACP
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anecms.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class acp {

    /**
     * Use this method to get Languges
     *
     * @return array
     **/
    public static function getLanguage() {
        global $qgeneral;
        $option = '';
        if ($handle = opendir('../lang')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
                    if($file == $qgeneral['language'])
                        $option .= '<option value="'.$file.'" SELECTED>'.$file.'</option>';
                    else
                        $option .= '<option value="'.$file.'">'.$file.'</option>';
            }
        }
        closedir($handle);
        return $option;
    }
    /**
     * Save admin notes and update the log
     *
     * @global Database $db
     * @global array $database
     * @global array $lang
     * @param String $txt The text of the note in ACP Dashboard
     */
    public static function saveNote($txt) {
        global $db, $database, $lang;
        $db->query('UPDATE '.$database['tbl_prefix'].'dev_general SET notes = ? WHERE id = ?', DBDriver::QUERY, array($txt, 0));
        ACP::addLog($lang['updatenote']);
    }

    /**
     * Add log on the database
     *
     * @global Database $db
     * @global array $database
     * @global User $user
     * @param String $txt The text of the log to add
     */
    public static function addLog($txt) {
        global $db, $user, $database;
        $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_adminlog (user ,date ,text ,ip) VALUES (?,?,?,?)', DBDriver::QUERY, array($user->getValues('id'), time(), $txt, $_SERVER['REMOTE_ADDR']));
    }

    /**
     * Move up the position of one link on the menu
     *
     * @global Database $db
     * @global array $database
     * @param int $id Id of the link
     */
    public static function setMenuUpPosition($id) {
        global $db, $database;
        $linktodown = $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus WHERE id = ?', DBDriver::AARRAY, array($id));
        $position1 = $linktodown['position'] - 1;
        $link = $db->query('SELECT id FROM '.$database['tbl_prefix'].'dev_menus WHERE type = ? AND position = ?', DBDriver::AARRAY, array($linktodown['type'], $position1));
        $db->query('UPDATE '.$database['tbl_prefix'].'dev_menus SET position = ? WHERE id = ?', DBDriver::QUERY, array($linktodown['position'], $link['id']));
        $db->query('UPDATE '.$database['tbl_prefix'].'dev_menus SET position = ? WHERE id = ?', DBDriver::QUERY, array($position1, $id));
    }

    /**
     * Move downl the position of one link on the menu
     *
     * @global Database $db
     * @global array $database
     * @param int $id Id of the link
     */
    public static function setMenuDownPosition($id) {
        global $db, $database;

		$linktodown = $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_menus WHERE id = ?', DBDriver::AARRAY, array($id));
        $position1 = $linktodown['position'] + 1;
        $link = $db->query('SELECT id FROM '.$database['tbl_prefix'].'dev_menus WHERE type = ? AND position = ?', DBDriver::AARRAY, array($linktodown['type'], $position1));
        $db->query('UPDATE '.$database['tbl_prefix'].'dev_menus SET position = ? WHERE id = ?', DBDriver::QUERY, array($linktodown['position'], $link['id']));
        $db->query('UPDATE '.$database['tbl_prefix'].'dev_menus SET position = ? WHERE id = ?', DBDriver::QUERY, array($position1, $id));
    }

    /**
     * Get next position available in a menu
     * 
     * @global Database $db
     * @global array $database
     * @param int $type Type of the link
     * @return int
     */
    public static function getNextPosition($type) {
        global $db, $database;
        $position = $db->query('SELECT MAX( position ) as maxposition FROM '.$database['tbl_prefix'].'dev_menus WHERE type = ?', DBDriver::QUERY, array($type));
        return $position['maxposition']+1;
    }

    public static function getCachedSQL(){
        $c = 0;
        if ($handle = opendir('../cache/sql')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
                    $c++;
            }
        }
        closedir($handle);
        return $c;
    }

        public static function deleteCachedSQL(){
        if ($handle = opendir('../cache/sql')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
                    unlink($file);
            }
        }
        closedir($handle);
        return $c;
    }

    public static function deleteCompiledFiles($name){
        if ($handle = opendir('../skins/'.$name.'/Compiled/')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..")
                    unlink($file);
            }
        }
        closedir($handle);
        return $c;
    }

}
?>
