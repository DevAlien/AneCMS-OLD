<?php
if(file_exists('./skins/'.$skin.'/widgets/login/index.tpl'))
    $t = new Template('./skins/'.$skin.'/widgets/login', false);
else
    $t = new Template('./widgets/login', false);

$t->burn('index', 'tpl', false);
?>
