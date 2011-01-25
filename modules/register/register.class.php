<?php




class register{
    
    /**
     * Check if exist the user
     *
     * @param string $username username of the user you want to check
     * @return boolean
     */
    public static function checkUser($username){
        global $db, $database;
        return $db->query_array('Select * From dev_users where username = "'.$username.'"');
    }
    
    /**
     * Insert a new user into the database
     *
     * @param string $username Username of the new user
     * @param string $email E-mail of the new user
     * @param string $password Password in MD5 of the new user
     * @param string $language Default language to view the site for the new user
     * @param string $skin Default skin for view the site for the new user
     * @param integer $status Status of the user, active, banned, etc.
     * @return boolean
     */
    public static function registerUser($username, $email, $password, $language, $skin, $status){
        global $db, $database;
        return $db->query('Insert Into '.$database['tbl_prefix'].'dev_users (username, email, password, language, skin, groups, status) values ("'.$username.'", "'.$email.'", "'.$password.'", "'.$language.'", "'.$skin.'", 1, "'.$status.'")');
    }
    
    /**
     * View informations of one user
     *
     * @param integer $id Id of user
     * @param string $informations String with the informations requests, separated by ","
     * @return boolean
     */
    static public function getInformation($id, $informations){
        global $db, $database;
        return $db->query('Select '.$informations.' From '.$database['tbl_prefix'].'dev_users where id = '.$id);
    }
    
    /**
     * Change status of the user
     *
     * @param integer $id Id of the user
     * @param integer $status New status
     * @return boolean
     */
    public static function setStatus($id, $status){
        global $db, $database;
        return $db->query('Update '.$database['tbl_prefix'].'dev_users SET status = '.$status.' where id ='.$id);
    }
    
    /**
     * Change group of the user
     *
     * @param integer $id Id of the user
     * @param integer $group Id of new group
     * @return boolean
     */
    public static function setGroup($id, $group){
        global $db, $database;
        return $db->query('Update '.$database['tbl_prefix'].'dev_users SET groups = '.$group.' where id ='.$id);
    }
    /**
     * Change Default skin of the user
     *
     * @param integer $id Id of the user
     * @param integer $skin Name of new default skin
     * @return boolean
     */
    
    public static function setSkin($id, $skin){
        global $db, $database;
        return $db->query('Update '.$database['tbl_prefix'].'dev_users SET skin = '.$skin.' where id ='.$id);
    }
    
    /**
     * Change password of the user
     *
     * @param integer $id Id of the user
     * @param integer $password New Password in MD5
     * @return boolean
     */
    public static function setPassword($id, $password){
        global $db, $database;
        return $db->query('Update '.$database['tbl_prefix'].'dev_users SET password = '.$password.' where id ='.$id);
    }
    
    /**
     * If the user have forget the password we send a new password in your E-Mail
     *
     * @param integer $id Id of the user
     * @return boolean
     */
    public static function needPassword($id){
        global $db, $database;
        $db->query('Update '.$database['tbl_prefix'].'dev_users SET skin = '.$skin.' where id ='.$id);
    }
}
?>