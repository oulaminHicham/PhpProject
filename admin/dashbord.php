<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
    $pageTitle='Dashbord';
    include 'init.php';
    // the variable to inisialisate the number of users we want to afiche them
    $numUsres=6; 
    // letest user array
    $letestUsers=getLatestItmes('*','users','userID',$numUsres);
    // letest of items
    $numItems=6;
    $letestItems=getLatestItmes('*','Items','item_id',$numItems);
    // letest commets
    $numCom=6;
    $comments=$con -> prepare("SELECT c.* , u.username , u.userID , i.Name FROM comments c
                                INNER JOIN users u ON c.user_id = u.userID
                                INNER JOIN items i ON c.item_id = i.item_id
                                ORDER BY c_id DESC
                                LIMIT $numCom");
    $comments -> execute();
    $commentsResults=$comments ->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container hom-stat">
    <h3 class="">Dashbord</h3>
    <div class="row">
        <div class="col-md-3">
            <div class="stat text-light st-members">
                <i class="fa fa-users"></i>
                <div class="info">
                    Total Members
                    <span>
                        <a class="text-light" href="members.php"><?php echo countItms('userID','users') ?></a> 
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat text-light st-pending">
            <i class="fa fa-user-plus"></i>
                <div>
                    Pending Members 
                    <span>
                        <a class="text-light" href="members.php?do=Manage&page=pending"><?php echo checkItme('regStatus','users',0)?></a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat text-light st-items">
            <i class="fa fa-tag"></i>
                <div>
                    Total Items 
                    <span>
                        <a class="text-light" href="items.php?do=Manage"><?php echo countItms('item_id','Items')?></a>
                    </span> 
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat text-light st-comment">
            <i class="fa fa-comments"></i>
                <div>
                    Total Comments 
                    <span>
                        <a href="comments.php?do=Manage" class="text-light"><?php echo checkItme('c_id','comments')?></a>
                    </span>
                </div> 
            </div>
        </div>
    </div>
</div>

<div class="container latest">
    <div class="row ">
        <div class="col-sm-6">
            <div class="panel panel-default mb-3">
                <div class="panel-heading p-3">
                    <i class="fa fa-users"></i> <span class="text-light">latest <?php echo $numUsres;?> Reagestred Users</span>
                </div>

                <div class="panel-body bg-light">

                    <ul class="list-group letestContent">
                        <?php
                        if(!empty($letestUsers)){
                            foreach($letestUsers as $user){
                                echo "<li>";
                                    echo  $user['username'];
                                    echo  "<div>";
                                        // accept button
                                        if($user['regStatus'] == 0){
                                            echo "<a class='text-light edit btn btn-info' href='members.php?do=Activate&userID=".$user['userID']."'>";
                                            echo "<i class='fa fa-check'></i>";                                                        
                                            echo "Activate</a>";
                                        }                                
                                        // edit button
                                        echo "<a class='text-light edit btn btn-success' href='members.php?do=Edit&userID=".$user['userID']."'>";
                                        echo "<i class='fa fa-edit'></i>";                                                        
                                        echo "Edit</a>";
                                    echo  "</div>";
                                echo "</li>";                      
                            }
                        }
                        else
                        {
                            echo"<div class='p-3 m-3 alert alert-info'> There Is No Users To Show </div>";
                        }
                        ?>
                    </ul>                   
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default mb-3">
                <div class="panel-heading p-3">
                    <i class="fa fa-tag"></i> <span class="text-light">latest <?php echo $numItems?> Items</span>
                </div>
                <div class="panel-body bg-light">
                <ul class="list-group letestContent">
                    <?php
                    if(!empty($letestItems)){
                        foreach($letestItems as $item){
                            echo "<li>";
                                echo $item['Name'];
                                echo"<div>";
                                    // aprove button
                                    if($item['Aprove']==0){
                                        echo "<a href='items.php?do=Approve&itemID=".$item['item_id']."'class='btn btn-info text-light'>";
                                            echo"<i class='fa fa-check'></i>";
                                        echo"Aprove</a>";
                                    }
                                    // edit button
                                    echo "<a href='items.php?do=Edit&itemID=".$item['item_id']."'class='btn btn-success'>";
                                        echo"<i class='fa fa-edit'></i>";
                                    echo"Edit </a>";
                                    // delete button
                                    echo "<a href='items.php?do=Delete&itemID=".$item['item_id']."'class='btn btn-danger confirm'>";
                                        echo"<i class='fa fa-close'></i>";
                                    echo"Delete </a>";
                                echo"</div>";
                            echo"</li>";
                        }
                    }else
                    {
                        echo"<div class='p-3 m-3 alert alert-info'> There Is No Items To Show </div>";
                    }
                    ?>
                </ul>
                </div>
            </div>
        </div>
    </div>
        <!-- START LETEST COMMENTS -->
        <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default mb-3">
                <div class="panel-heading p-3">
                    <i class="fa fa-comments"></i> <span class="text-light">latest <?php echo $numCom ?> Comments</span>
                </div>

                <div class="panel-body bg-light ">
                    <div class="letestContent">
                        <?php
                        ?>                
                        <?php
                        if(!empty($commentsResults)){
                        foreach($commentsResults as $comment):
                        ?>
                            <div class="container">
                                <div class="comment-box">
                                    <?php 
                                        echo "<span class='user-n'><a href='members.php?do=Edit&userID=".$comment['userID']."'>". $comment['username']."</a></span>";
                                        echo "<p class='user-com'>". $comment['comment']."</p>";
                                    ?>
                                </div>
                            </div>         
                        <?php endforeach  ?>
                        <?php } else
                        {
                        echo"<div class='p-3 m-3 alert alert-info'> There Is No Comments To Show </div>";
                        }  
                        ?>
                    </div>                               
                </div>
            </div>
        </div>
    </div>
        <!-- END LETEST COMMENTS -->
</div>
<?php
include $tpl.'footer.php';
}
else
{
header("location:index.php");
exit();
ob_end_flush();
}
?>
