<?php
ob_start();
session_start();
$pageTitle='';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    switch ($do){
        case 'Manage':

            break;
        case 'Add':

            break;

        case 'Insert':

            break;
        
        case 'Edit':

            break;

        case 'Update':

            break;
        
        case 'Delete':

            break;
        
        case 'Activate':

            break;


    }
    include $tpl.'footer.php';
}else{
    header('location:index.php');
    exit();
    ob_end_flush();
}
?>