<?php
/**
 * This class contain users information
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * This class contain users information
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class User {

    /**
     * All values of user
     *
     * @var array
     */
    private $allinfo;

    /**
     * All groups of the user
     *
     * @var array
     */
    private $groups = array();

    /**
     * Parse array in a private variable
     *
     * @param array $arrayPersonalValues array of user
     */
    public function __construct($arrayPersonalValues) {
        $this->allinfo = $arrayPersonalValues;
        $this->setArrayGroups();
    }

    /**
     * Get array of the user
     *
     * @return array
     */
    public function getAllValues() {
        return $this->allinfo;
    }

    /**
     * get single value of the user
     *
     * @param mixed $name name of value
     * @return mixed
     */
    public function getValues($name) {
        return $this->allinfo[$name];
    }

    /**
     * Set the array called roups
     * @global Database $db
     * @global array $database
     */
    public function setArrayGroups() {
        global $db, $database;
        $this->groups = array();
        
        $groupslist = $db->query('SELECT '.$database['tbl_prefix'].'dev_groups.name FROM '.$database['tbl_prefix'].'dev_usersgroups inner join '.$database['tbl_prefix'].'dev_groups on '.$database['tbl_prefix'].'dev_groups.id = '.$database['tbl_prefix'].'dev_usersgroups.idgroup where iduser = ?', DBDriver::ALIST, array($this->getValues('id')));

        foreach ($groupslist as $key => $value)
            $this->groups[] = $value['name'];
    }

    /**
     * Check if the user is on a group
     * 
     * @param string $groupname String of the group that you want to check
     * @return boolean
     */
    public function isOnGroup($groupname) {
        return in_array($groupname, $this->groups);
    }
}
?>
