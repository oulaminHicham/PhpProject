<?php
$do=isset($_GET['do']) ? $_GET['do'] : 'Manage';
switch($do){
    case 'Manage':
        echo "you are in the Mmange page!";
        break;
    case 'add':
        echo "You are in add categoreie page";
        break;
    default:
        header('location:index.php');
}
?>
