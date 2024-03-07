<?php
/*
    =============================================================
    == Manage Members page
    == You Can Add Delte Members form here
    =============================================================
*/
session_start();
if(isset($_SESSION['username'])){
$pageTitle='Manage Members';
include 'init.php';
$do=isset($_GET['do']) ? $_GET['do'] : "Manage";
switch($do){
    //####start manage page
    case "Manage":
        // varible to now if the request is lok for pending members
        $query='';
        // check exesting of page get and if it is pending
        if(isset($_GET['page']) && $_GET['page']=='pending'){
            $query='AND regStatus=0';
        }
        $stmt=$con -> prepare("SELECT * FROM users WHERE groupID !=1  $query ORDER BY userID DESC");
        $stmt -> execute();
        if($stmt->rowCount() > 0){
    ?> 
    <h1 class="text-center mt-3 mb-3 manag-member">Manage Members</h1>
    <div class="container">
        <div class="table-responsive">
            <table class="main-table text-center table table-bordered table-active mt-3">
                <tr>
                    <th>#id</th>
                    <th>username</th>
                    <th>Email</th>
                    <th>FullName</th>
                    <th>Regestred Date</th>
                    <th>Control</th>
                </tr>
                <?php while($members=$stmt -> fetch(PDO::FETCH_ASSOC)):?>
                <tr>
                    <td><?php echo $members  ['userID']  ?></td>
                    <td><?php echo $members['username']  ?></td>
                    <td><?php echo $members   ['email']  ?></td>
                    <td><?php echo $members['fullname']  ?></td>
                    <td><?php echo $members   ['dateE']  ?></td>
                    <td>
                        <a href="members.php?do=Edit&userID=<?php echo $members['userID'];?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                        <a href="members.php?do=Delete&userID=<?php echo $members['userID'];?>" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                        <?php
                            if( $members['regStatus'] == 0){
                                echo'<a href="members.php?do=Activate&userID='.$members["userID"].'"class="btn btn-info text-light">
                                <i class="fa fa-check"></i> Activate</a>';
                            }
                        ?>
                    </td>
                </tr>
                <?php endwhile ?>
            </table>
        </div>
        <a class='daelBTN btn btn-dark mb-3 mt-3' href='members.php?do=Add'><i class="fa fa-plus"></i> New Member </a>
    </div>
    <?php
        }else // close of if the table of users is empty
        {
            echo"<div class='container text-white'>";
                echo"<div class='alert alert-info text-center fs-2 p-5 m-5'> There Is No Members To Show </div>";
                echo"<a class='daelBTN btn btn-dark mb-3 mt-3' href='members.php?do=Add'><i class='fa fa-plus'></i> New Member </a>";
            echo"</div>";
        }
        break;
    //#### end manage page
    //#### start Add page
    case "Add":
?>
    <form action="?do=insert" method="post">
        <div class="container mt-3 Edit-member">
            <h3 class="text-center mb-3">Add New Member</h3>
            <div class="mb-3 row">
                <label for="username" class="col-sm-2 col-form-label">username</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" autocomplete="off"  placeholder="user name to login into shop">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="pass" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                <input type="password" class="form-control" id="pass" name="pass"  placeholder="pass word must be hard an complex">
                <!-- <i class="show-pass fa fa-eye fa-1x"></i> -->
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email"  placeholder="email must be valid">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="fullN" class="col-sm-2 col-form-label">Full Nmae</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="fullN" name="fullN" autocomplete="off"  placeholder="full name apeare for your profile page">
                <input type="submit" class="mb-3 mt-3 btn btn-primary" value="Add Member" name="add">
                <input type="reset" class="mb-3 mt-3 btn btn-primary" value="Reset" name="">
                
                </div>
            </div>
        </div>
    </form>
<?php       
        break;
    //#### end Add page

    //@@@@@@ start insert page
    case "insert":
        if($_SERVER['REQUEST_METHOD']=="POST"){
            echo "<div class='container insert'>";
            echo "<h1 class='text-center mt-3 mb-3'> Add New Memeber </h1>";
            // get variables
            $user     = $_POST['username'];
            $pass     = $_POST['pass'];
            $email    = $_POST['email'];
            $Name     = $_POST['fullN'];
            $hPass    =md5($_POST['pass']);
            // validate the form
            $formsError=array();
            if(strlen($user) < 4){
                array_push($formsError,"username cant be less than4 characters");
            }
            if(empty($user)){
                array_push($formsError , "username cant be Empty");
            }
            if(empty($pass)){
                array_push($formsError , "passWord cant be Empty");
            }
            if(empty($email)){
                array_push($formsError , "Email cant be Empty ");
            }
            if(empty($Name)){
                array_push($formsError , "full name cant be Empty");
            }
            // loop all errors and afiched theme 
            foreach($formsError as $err){
                echo "<div class='alert alert-danger'>".$err."</div>";
            }
            // check if there is no error procced the update operation
            if(empty($formsError)){
                // check if the user alrday exisrts in data base our
                $checkUniqueUser=checkItme('username' , 'users' , $user);
                if($checkUniqueUser == 0){
                    // insert user info in database
                    $stmt=$con -> prepare("INSERT INTO users (username , password , email , fullname , regStatus ,dateE) VALUES (:userN,:pass,:mail,:fullN ,1, NOW())");
                    $stmt      -> bindValue(':userN' , $user) ;
                    $stmt      -> bindValue(':pass'  , $hPass);
                    $stmt      -> bindValue(':mail'  , $email);
                    $stmt      -> bindValue(':fullN' , $Name) ;
                    $stmt      -> execute();
                    // echo success message
                    $themsg="<div class='alert alert-success'>".$stmt->rowCount()."Record Inserted </div>";
                    redirectToHom($themsg ,'back',4);
                }else{
                    echo "<div class='container'>";
                    $themsg="<div class='alert alert-danger'>This User Alredy Exists </div>";
                    redirectToHom($themsg ,'back',5);
                    echo"</div>";
                }
            }        
        }else
        {
            echo "<div class='container mt-3'>";
            $themsg="<div class='alert alert-danger'>This User Alredy Exists </div>";
            redirectToHom($themsg ,'back',3);
            echo"</div>";
        }
        echo "</div>";
        break;
    //@@@@@@ end insert page

    //###### start edit page
    case "Edit":
        // check if the id is exists in url and check if it is number and stoked them in   variable
        $userid= isset($_GET['userID']) && is_numeric($_GET['userID'])? intval($_GET['userID']): 0;
        // select all data depand thisid
        $stmt = $con -> prepare("SELECT * FROM users  WHERE userID=:userId LIMIT 1");
        $stmt        -> bindValue(":userId",$userid);
        $stmt        -> execute();
        $userInfo= $stmt ->fetch(PDO::FETCH_ASSOC);
        // if there is id show the form
        if($stmt-> rowCount() > 0){ 
?>
    <form action="?do=Update" method="post">
    <div class="container mt-3 Edit-member">
        <h3 class="text-center mb-3">Edit Member</h3>
        <input type="hidden" name="userid" value="<?php echo $userid?>">
        <div class="mb-3 row">
            <label for="username" class="col-sm-2 col-form-label">username</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $userInfo['username']?>" autocomplete="off" required='required'>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="pass" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
            <input type="password" class="form-control" id="pass" name="pass">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $userInfo['email']?>"  autocomplete="off" required='required'>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="fullN" class="col-sm-2 col-form-label">Full Nmae</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="fullN" name="fullN" value="<?php echo $userInfo['fullname']?>" autocomplete="off">
            <input type="submit" class="mb-3 mt-3 btn btn-primary" value="Save" name="save">
            </div>
        </div>
    </div>
    </form>
    <?php
        }else{
            echo "<div class='container mt-3'>";
            $themsg="<div class='alert alert-danger'>There Is No Such Id</div>";
            redirectToHom($themsg ,3);
            echo"</div>";        
        }
        break;
    //###### end edit page
    
    //@@@@@ start update page
        case 'Update':
            echo "<div class='container '>";
            echo "<h1 class='text-center mt-3 mb-3'> Update Users </h1>";
            if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['save'])){
                // get variables from form
                $id      = $_POST['userid']  ;
                $user    = $_POST['username'];
                $email   = $_POST['email']   ;
                $fullName= $_POST['fullN']   ;
                // pass word trick
                $stmtPassWord=$con -> prepare('SELECT password FROM users WHERE userID=? LIMIT 1;');
                $stmtPassWord      -> bindValue(1,$id);
                $stmtPassWord      -> execute();
                $passWoedResult=$stmtPassWord -> fetch(PDO::FETCH_ASSOC); 
                $pass = empty($_POST['pass']) ? $passWoedResult['password'] : md5($_POST['pass']); 
                // validate the form
                $formsError=array();
                if(strlen($user) < 4){
                    array_push($formsError,"username cant be less than4 characters  </div>");
                }
                if(empty($user)){
                    array_push($formsError , "username cant beEmpty  </div>");
                }
                if(empty($email)){
                    array_push($formsError , "Email cant beEmpty  </div>");
                }
                if(empty($fullName)){
                    array_push($formsError , "full name cant beEmpty  </div>");
                }
                // loop all errors and afiched theme 
                foreach($formsError as $err){
                    echo $err;
                }
                // check if there is no error procced the update operation
                if(count($formsError) == 0){
                        // select user wuth user name like the user comme frim form and his id is defferens 
                        // that mean double username 
                        $checkExitsUser=$con   -> prepare("SELECT * FROM users WHERE username=? AND userID != ?");
                        $checkExitsUser        -> execute(array($user , $id));
                        $count=$checkExitsUser -> rowCount();
                        if($count == 0){
                            // update database with tehs infoo
                            $stmt=$con -> prepare("UPDATE users SET username=:userN ,password=:pass , email=:mail , fullname=:fullN WHERE userID=:id");
                            $stmt      -> bindValue(':userN' , $user)    ;
                            $stmt      -> bindValue(':pass' , $pass)     ;
                            $stmt      -> bindValue(':mail'  , $email)   ;
                            $stmt      -> bindValue(':fullN' , $fullName);
                            $stmt      -> bindValue(':id'    , $id)      ;
                            $stmt      -> execute();
                            // echo success message
                            $theMsg='<div class="alert alert-success"> Record updated </div>';
                            redirectToHom($theMsg , 'back');
                        }else
                        {
                            $theExitsUserMsg="<div class='alert alert-danger'> this user olredy exits</div>'";
                            redirectToHom($theExitsUserMsg ,'back');
                        }                      
                }        
            }else{
                $theMsg="<div class='alert alert-danger'> you can't brows this page direct</div>'";
                redirectToHom($theMsg);
            }
            echo "</div>";
            break;
    //@@@@@ end update page
    //@@@@@ start dlete page
    case "Delete":
        // delete member page
        echo "<div class='container'>";
        echo '<h1 class="text-center"> Delete Page </h1>';
        // check if the id is exists in url and check if it is number and stoked them in   variable
        $userid= isset($_GET['userID']) && is_numeric($_GET['userID'])? intval($_GET['userID']): 0;
        // select all data depand thisid
        $checkExistItem=checkItme('userID','users',$userid);
        if($checkExistItem == 1){
            $stmt=$con -> prepare("DELETE FROM users WHERE userID=:id");
            $stmt      ->bindValue(':id' ,$userid);
            $stmt      ->execute();
            $theMsg='<div class="alert alert-success"> Record Deleted </div>';
            redirectToHom($theMsg , 'back');
            exit();
        }else{
            echo"<div class'container mt-3'>";
            $theMsg='<div class="alert alert-success"> There Is No User With This Id </div>';
            redirectToHom($theMsg);
            echo "</div>";
        } 
        echo"</div>";                 
        break;
        //@@@@@ end dlete page

        //@@@@@@@@@ START ACTIVATE PAGE
        case 'Activate':
            // Activate member page
        echo "<div class='container'>";
        echo '<h1 class="text-center"> Activate Page </h1>';
        // check if the id is exists in url and check if it is number and stoked them in   variable
        $userid= isset($_GET['userID']) && is_numeric($_GET['userID'])? intval($_GET['userID']): 0;
        // select all data depand thisid
        $checkExistItem=checkItme('userID','users',$userid);
        if($checkExistItem == 1){
            $stmt=$con -> prepare("UPDATE users SET regStatus=1 WHERE userID=:id");
            $stmt      ->bindValue(':id' ,$userid);
            $stmt      ->execute();
            $theMsg='<div class="alert alert-success"> The Member Is Activated </div>';
            redirectToHom($theMsg , 'back' ,4);
            exit();
        }else{
            echo"<div class'container mt-3'>";
            $theMsg='<div class="alert alert-success"> There Is No User With This Id </div>';
            redirectToHom($theMsg);
            echo "</div>";
        } 
        echo"</div>";                 
        break;
        //@@@@@@@@@ END ACTIVATE PAGE
// close of switch
}
include $tpl."footer.php";
?>
<?php
// close of session cheked
}
else{
    header('location:index.php');
}
?>
