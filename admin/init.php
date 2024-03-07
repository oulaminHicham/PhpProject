<?php
// includes connect.php file to connect database
include 'connect.php';
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
    // includes navbar
    if(!isset($noNavbar)){ include $tpl.'navbar.php';}
   

 









?>