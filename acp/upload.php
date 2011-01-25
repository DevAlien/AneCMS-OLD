<?php
include './inc/essential.php';

    $upload_dir = 'images/form';

    $file_name = time().'_'.$_FILES['file']['name'];

    if(@is_uploaded_file($_FILES['file']['tmp_name'])) {
        @move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir.'/'.$file_name);
    }
    else 
       echo 'error';


?>
