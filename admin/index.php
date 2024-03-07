<?php
session_start();
$noNavbar=0;
$pageTitle='Login';
include 'init.php';
// check if  user comme from post request
if($_SERVER['REQUEST_METHOD']=='POST'){
   $userN=$_POST['username'];
   $pass=sha1($_POST['pass']);
   // check if the user exests
   $stmt = $con -> prepare("SELECT userID  , username , password FROM users  WHERE username=:userN AND password=:pass AND groupID=1 LIMIT 1");
   $stmt        -> bindValue(":userN",$userN);
   $stmt        -> bindValue(":pass",$pass);
   $stmt        -> execute();
   $count=$stmt -> rowCount();
   $adminInfo= $stmt ->fetch(PDO::FETCH_ASSOC);
   if($count > 0){
      // regestare username session
      $_SESSION['username']=$adminInfo['username'];
      // resetration session of admin id
      $_SESSION['Id']=$adminInfo['userID'];
      // redirect to dash bord page
      header('location:dashbord.php');
      exit(); 
   }
   else
   {
      echo"no admin found with this login ";
   }
}
?>
<form class="container" action="" method="post">
   <div class="login p-3">
    <h4 class="text-center">Admin Login</h4>
    <label class="form-label mt-3" for="">UserName:</label>
    <input class="form-control" type="text" name="username" placeholder="User Name" autocomplete="off">

    <label class="form-label mt-3" for="">PassWord :</label>
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="off">
    
    <input class="btn btn-primary w-100 mt-3" type="submit" value="Log">

   </div>
</form>
<?php include $tpl.'footer.php'?>