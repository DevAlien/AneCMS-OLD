<?php
if($user!==false && ($user->isOnGroup('Administrator') OR $user->isOnGroup('CustomerAdmin'))){
  include './modules/users/users.class.php';
  Users::removeGroupFromUser($_POST['iduser'], $_POST['idgroup']);
}
die();
?>