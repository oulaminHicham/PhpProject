<?php
session_start();
$pageTitle="Profile";
include 'init.php';
if(isset($_SESSION['user_id'])){
    // $USERS=getUser($_SESSION['user_id']);
    $USERS=getUser($_SESSION['user_id']);
    ?>
    <h1 class="text-center mt-3 title">My Profile</h1>
    <!-- profile information -->
    <div class="information mb-4 mt-4">
        <div class="container">
            <div class="panel">
                <div class="panel-heading p-2">My Information</div>
                <div class="panel-body p-4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <h5 class="text-center"><i class="fa fa-unlock-alt fa-fw"></i> User Name</h5>
                            <hr class="w-50 mx-auto text-danger">
                            <p class="text-center text-success"><?php echo $USERS['username']?></p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <h5 class="text-center"><i class="fa fa-user fa-fw"></i>Full Nmae</h5>
                            <hr class="w-50 mx-auto text-danger">
                            <p class="text-center text-success"><?php echo $USERS['fullname']?></p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <h5 class="text-center"><i class="fas fa-envelope fa-fw"></i>Eamil</h5>
                            <hr class="w-50 mx-auto text-danger">
                            <p class="text-center text-success"><?php echo $USERS['email']?></p>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <h5 class="text-center"><i class="fas fa-calendar-alt"></i>Date Insecreption</h5>
                            <hr class="w-50 mx-auto text-danger">
                            <p class="text-center text-success"><?php echo $USERS['dateE']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- profile ads -->
    <div class="information mb-4">
        <div class="container">
            <div class="panel">
                <div class="panel-heading p-2">My Ads</div>
                <div class="panel-body p-4">
                    <div class="row">
                        <?php 
                            $allItems=getItems('member_id',$USERS['userID']);
                            if(!empty($allItems)) {
                                foreach($allItems as $item){
                                        echo"<div class='col-sm-6 col-md-3'>";
                                            echo"<div class='item-box mb-5'>";
                                                echo"<span>".$item['price']."</span>";
                                                echo"<img class='' src='layout/images/tech_phone.jpg' alt='pecture'>";
                                                echo"<div class='caption'>";
                                                    echo"<h3 class=''>".$item['Name']."</h3>";
                                                    echo"<p class='text-center p-2'>".$item['item_dex']."</p>";
                                                echo"</div>";
                                            echo"</div>";
                                        echo"</div>";
                                }
                            }else{
                                echo"<div class='alert alert-info p-2 w-75 mx-auto'>Sorray there is no ads to show</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="information mb-4 ">
        <div class="container">
            <div class="panel">
                <div class="panel-heading p-2">Letest Comments</div>
                <div class="panel-body p-4">
                    <?php
                    $strm=$con ->prepare("SELECT Comments.* , Items.Name AS itemName FROM Comments
                                          INNER JOIN Items ON Comments.item_id  = Items.item_id
                                          WHERE Comments.user_id = ? LIMIT 6");
                    $strm ->bindValue(1,$USERS['userID']);
                    $strm ->execute();
                    $count=$strm ->rowCount();
                    ?>
                    <div class="row">
                        <?php 
                            if($count > 0){
                                while($comments=$strm ->fetch(PDO::FETCH_ASSOC)):
                        ?>

                            <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                                <h4 class="text-center"><?php echo $comments['itemName']?></h4>
                                <p class="text-center text-white bg-secondary p-3 rounded-4"><?php echo $comments['comment']?></p>
                            </div>
                            
                        <?php endwhile;
                        }else{
                            echo"<div class='alert alert-info p-2 w-75 mx-auto'>there is no comments to show </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
include $tpl.'footer.php';
}
else
{
    header('location:login.php');
    exit();
}
?>
