<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of usersclass
 *
 * @author Gonçalo
 */
class Users {

    public static function addGroup($name, $description) {
        global $db, $database;

        $qNameGroups = $db->query_array('SELECT name FROM '.$database['tbl_prefix'].'dev_groups where name = \''.$name.'\'');
        if(is_array($qNameGroups))
            return false;
        $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_groups (name, description) values (\''.$name.'\', \''.$description.'\')');

        return true;
    }

    public static function setGroupToUser($iduser, $idgroup) {
        global $db, $database;

        $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_usersgroups (iduser, idgroup) values (\''.$iduser.'\', \''.$idgroup.'\')');

        return true;
    }
    
    public static function removeGroupFromUser($iduser, $idgroup) {
        global $db, $database;

        $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_usersgroups where iduser = \''.$iduser.'\' AND idgroup = \''.$idgroup.'\'');

        return true;
    }
    
    public static function searchUsers($nickpart) {
        global $db, $database;

        $qUsers = $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_users where username LIKE \'%'.$nickpart.'%\'');
        if(is_array($qUsers))
            return $qUsers;
        return false;
    }

    public static function removeUser($id) {
        global $db, $database;
        $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_users where id = '.$id);

        return true;
    }

    public static function removeGroup($id) {
        global $db, $database;
        $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_groups where id = '.$id);

        return true;
    }

    public static function getAllUsers(){
        global $db, $database;

        return $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_users');

    }

    public static function getAllGroups(){
        global $db, $database;

        return $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_groups');

    }

    public static function getUser($user){
        global $db, $database;

        return $db->query_list('SELECT * FROM '.$database['tbl_prefix'].'dev_users where id = '.$user);

    }

public static function getUserGroups($user){
        global $db, $database;

        return $db->query_list('SELECT g.* FROM '.$database['tbl_prefix'].'dev_usersgroups ug inner join '.$database['tbl_prefix'].'dev_groups g on g.id = ug.idgroup where iduser = '.$user);

    }

public static function getRemainedUserGroups($user){
        global $db, $database;
        return $db->query_list('Select * from '.$database['tbl_prefix'].'dev_groups where id NOT IN (SELECT idgroup from '.$database['tbl_prefix'].'dev_usersgroups where iduser = '.$user.')');
	
    }
    public static function updateUser($id, $username, $email, $web){
        global $db, $database;

        return $db->query('UPDATE '.$database['tbl_prefix'].'dev_users set username = \''.$username.'\', email = \''.$email.'\', web = \''.$web.'\' WHERE id = '.$id);

    }
}
?>
