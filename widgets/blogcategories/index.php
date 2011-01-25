<?php
if(file_exists('./skins/'.$skin.'/widgets/blogcategories/index.tpl'))
    $t = new Template('./skins/'.$skin.'/widgets/blogcategories', false);
else
  $t = new Template('./widgets/blogcategories', false);
$t->assign('categories', $db->query_list('select count(*) as totale, name from '.$database['tbl_prefix'].'blog_categories group by name'));
$t->burn('index', 'tpl', false);
?>
