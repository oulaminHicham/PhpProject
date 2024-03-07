<?php
$dsn='mysql:host=localhost;dbname=ecommerce_shop';
$user='root';
$pass='';

try{
    $con = new PDO($dsn , $user , $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo "Faild to connect" .$e -> getMessage();
}
?>


