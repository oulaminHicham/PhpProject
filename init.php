<?php
// error reporthing
// ini_set('display_errors','on');
// error_reporting(E_ALL);
// includes connect.php file to connect database
include 'admin/connect.php';
// save session in var if isset
$sessionUser='';
if(isset($_SESSION['user_id'])){
    $sessionUser=$_SESSION['user'];
}
// templates directorey
$tpl='includes/templates/';
// css directorey
$cssDirec='layout/css/';
// js directorey
$jsDirec='layout/js/';
// functions directory
$funs='includes/functions/';
// language directory
$langs='includes/languages/';


// include of important files
    // include languages fle
    include $langs.'eng.php';
    // includes functions
    include $funs.'fun.php';
    // includes header file
    include $tpl.'header.php'; 
?>