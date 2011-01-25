<?php
include '../modules/users/users.class.php';


//Search User
if(isset($_GET['t']) && $_GET['t'] == 'search'){
    $foundedusers = Users::searchUsers(Tools::string_escape($_POST['name']));
    if($foundedusers == false){
        $tpl->assign('resultmessage', $lang['users_notfoundusers']);
        $tpl->assign('color', 'red');
        $tpl->assign('users', Users::getAllUsers());
    }
    else{
        $tpl->assign('resultmessage', $lang['users_foundusers']);
        $tpl->assign('color', 'green');
        $tpl->assign('users', $foundedusers);
    }
    $tpl->burn('users', 'tpl');
}
//Delete User
else if(isset($_GET['m']) && $_GET['m'] == 'users' && isset($_GET['t']) && $_GET['t'] == 'delete' && isset($_GET['id'])){
    Users::removeUser(Tools::string_escape($_GET['id']));
    $tpl->assign('resultmessage', $lang['users_userdeleted']);
    $tpl->assign('color', 'green');
    $tpl->assign('users', Users::getAllUsers());
    $tpl->burn('users', 'tpl');
}
//Modify User
else if(isset($_GET['m']) && $_GET['m'] == 'users' && isset($_GET['t']) && $_GET['t'] == 'modify' && isset($_GET['id'])){
    $tpl->assign('user', Users::getUser($_GET['id']));
    $tpl->assign('usergroups', Users::getUserGroups($_GET['id']));
    $tpl->assign('remainedusergroups', Users::getRemainedUserGroups($_GET['id']));
    $tpl->assign('iduser', $_GET['id']);
    $tpl->burn('users_modify', 'tpl');
}
//Update user
else if(isset($_GET['m']) && $_GET['m'] == 'users' && isset($_GET['t']) && $_GET['t'] == 'update' && isset($_GET['id'])){
    Users::updateUser($_GET['id'], $_POST['username'], $_POST['email'], $_POST['web']);

    $tpl->assign('resultmessage', $lang['users_userupdated']);
    $tpl->assign('color', 'green');
    $tpl->assign('users', Users::getAllUsers());
    $tpl->burn('users', 'tpl');
}
//Add Group
else if(isset($_GET['m']) && $_GET['m'] == 'groups' && isset($_GET['t']) && $_GET['t'] == 'add' && isset($_POST['name'])){
    if (Users::addGroup(Tools::string_escape($_POST['name']), Tools::string_escape($_POST['description']))) {
        $tpl->assign('resultmessage', $lang['users_groupadded']);
        $tpl->assign('color', 'green');
    }
    else{
        $tpl->assign('resultmessage', $lang['users_groupexist']);
        $tpl->assign('color', 'red');
    }
    $tpl->assign('groups', Users::getAllGroups());
    $tpl->burn('users_groups', 'tpl');
}
//Delete Group
else if(isset($_GET['m']) && $_GET['m'] == 'groups' && isset($_GET['t']) && $_GET['t'] == 'delete' && isset($_GET['id'])){
    Users::removeGroup(Tools::string_escape($_GET['id']));
    $tpl->assign('resultmessage', $lang['users_groupdeleted']);
    $tpl->assign('color', 'green');
    $tpl->assign('groups', Users::getAllGroups());
    $tpl->burn('users_groups', 'tpl');
}
//Groups List
else if(isset($_GET['m']) && $_GET['m'] == 'groups'){
    $tpl->assign('groups', Users::getAllGroups());
    $tpl->burn('users_groups', 'tpl');
}
//Users List
else{
    $tpl->assign('users', Users::getAllUsers());
    $tpl->burn('users', 'tpl');
}
?>
