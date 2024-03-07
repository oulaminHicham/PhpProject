<?php
include 'init.php';
$titlePae='signup page';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $formErr=[];
    $exitsUserErr='';
    $userName=$_POST['userN'];
    $passWord=sha1($_POST['Pass']);
    $email=$_POST['email'];

    if(isset($_POST['userN'])){
        $filtered_user=filter_var($_POST['userN'] , FILTER_SANITIZE_STRING);
        if(strlen($filtered_user) < 4){
            array_push($formErr , "Username can't be <strong> less than 4 chars </strong>");
        }
        if(strlen($filtered_user) > 20){
            array_push($formErr , "Username can't be <strong> larg than 20 chars </strong>");
        }
    }
    if(isset($_POST['Pass'])){
        if(strlen($_POST['Pass'])<8){
            array_push($formErr , "Pass Word Must be <strong> larg than 8 chars </strong>");
        }
        $pass=sha1($_POST['Pass']);
    }
    if(isset($_POST['email'])){
        $filtered_email=filter_var($_POST['email'] ,FILTER_SANITIZE_EMAIL);
        if(!filter_var($filtered_email,FILTER_VALIDATE_EMAIL)){
            array_push($formErr , "Enter   <strong> Valid Email </strong>");
        }
    }
    // check if there is no err and the user is not exits in database 
    // if all is ok insert user in datbase
    if(empty($formErr)){
        $checkEx=checkExits('username' , 'users' , 'username' ,$userName);
        if($checkEx === 1){
            $exitsUserErr='Sorrey This user is Alrady Exits !!';
        }else{
            InsertUser([$userName ,$passWord, $email , $userName." ".$userName]);
        }
    }
}
?>
<div class="container">
    <div class="form w-50 mx-auto mt-5">
        <h3 class="title text-center pb-3">Signup</h3>
        <form action="" method="post">
            <div class="mb-3 position-relative">
                <label for="" class="form-label text-black-50">User Name</label>
                <input 
                    title="username must be 4 chars"
                    type="text" 
                    class="form-control" 
                    name="userN" 
                    autocomplete="off"
                >
            </div>
            <div class="mb-3 position-relative">
                <label for="" class="form-label text-black-50">Email</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="email" 
                    autocomplete="off" 
                >
            </div>
            <div class="mb-3 position-relative">
                <label for="" class="form-label text-black-50">Pass Word</label>
                <input 
                    type="password" 
                    class="form-control" 
                    name="Pass" 
                >
            </div>
            <div>
                <button type="submit" class="btn btn-primary mb-1 rounded-4 w-75 d-block mx-auto" id="Singup">Singup</button>
            </div>
        </form>
        <div class="text-center mt-2" id="the-err-msg">
            <?php
            if(!empty($formErr))
            {
                foreach($formErr as $err){
                    echo "<div class='alert alert-danger p-0 w-75 mx-auto'>";
                        echo $err;
                    echo"</div>";
                }
            }
            if(!empty($exitsUserErr)){
                echo "<div class='alert alert-danger p-0 w-75 mx-auto'>";
                    echo $exitsUserErr;
                echo "</div>";
            }
            if(empty($formErr) && empty($exitsUserErr)){
                getMsg('Gradurate You Are Regestred Member With Us Now' , false);
            }
            ?>
        </div>
    </div>
</div>
<?php include $tpl.'footer.php' ; ?>