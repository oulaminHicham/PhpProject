<?php
session_start();
$titlePae='login';
// if(isset($_SESSION['user_id'])){
//     header('location:index.php');
//     exit();
// }
include 'init.php';
// check if usercoe from form request
if($_SERVER['REQUEST_METHOD'] =='POST'){
    $username=$_POST['userN'];
    $passWord=sha1($_POST['Pass']);
    // check existing user
    $STMT=$con      -> prepare("SELECT userID , username , password  FROM users WHERE username=? AND password=?");
    $STMT           -> bindValue(1,$username);
    $STMT           -> bindValue(2,$passWord);
    $STMT           -> execute();
    // $count   =$STMT -> rowCount();
    $userdata=$STMT -> fetch(PDO::FETCH_ASSOC);
    if(!empty($userdata)){
        $_SESSION['user_id']=$userdata['userID'];
        $_SESSION['user']=$userdata['username'];
        header('location:index.php');
        exit();
    }
}
?>
<div class="container">
    <div class="form mx-auto mt-5">
        <h3 class="title text-center pb-3">Login | Signup</h3>
        <form id="formTovalidate" action="" method="post">
            <div class="mb-3 position-relative">
                <label for="" class="form-label text-black-50">User Name</label>
                <input type="text" class="form-control" name="userN" autocomplete="off" required>
            </div>
            <div class="mb-3 position-relative">
                <label for="" class="form-label text-black-50">Pass Word</label>
                <input type="password" class="form-control" name="Pass" required>
            </div>
            <div>
                <button type="submit" class="btn btn-primary mb-3 rounded-4 w-100">Log</button>
                <a href="signup.php" class="btn btn-success rounded-4 d-block">SignUp</a>
            </div>
        </form>
    </div>
</div>
<?php
include $tpl.'footer.php';
?>