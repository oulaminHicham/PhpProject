<?php
############################################
###### comments page
###### edit | add  | delete ==> comments from  here
############################################
ob_start();
session_start();
$pageTitle='coments';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    switch ($do){
//START MANAGE PAGE ##########################################################################################################################
        case 'Manage':
            // select all comments
            $comments=$con ->prepare("SELECT c.* , i.Name , u.username FROM comments c
                                      INNER JOIN items i ON c.item_id = i.item_id 
                                      INNER JOIN users u ON c.user_id = u.userID
                                      ORDER BY c_id DESC");
            $comments ->execute();
            if($comments ->rowCount() > 0){
            ?>
            <div class="container mt-5">
            <table class="table table-dark table-hover table-responsive">
                <thead>
                <tr>
                    <th class="text-info">ID</th>
                    <th class="text-info">Comments</th>
                    <th class="text-info">Item Name</th>
                    <th class="text-info">Full Name</th>
                    <th class="text-info">Added Date</th>
                    <th class="text-info">Controle</th>
                </tr>
                </thead>
                <?php  while($commentsresults=$comments ->fetch(PDO::FETCH_ASSOC)):?>
                <tbody>
                <tr>
                    <td><?php echo $commentsresults['c_id']?></td>
                    <td><?php echo substr($commentsresults['comment'],0,20)?>...</td>
                    <td><?php echo $commentsresults['Name']?></td>
                    <td><?php echo $commentsresults['username']?></td>
                    <td><?php echo $commentsresults['comment_date']?></td>
                    <td>
                        <a href="comments.php?do=Edit&comID=<?php echo $commentsresults['c_id']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="comments.php?do=Delete&comID=<?php echo $commentsresults['c_id']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                        <?php
                        if($commentsresults['status'] == 0){
                            echo"<a href='comments.php?do=Aprove&comID=".$commentsresults['c_id']."'class='btn btn-warning text-light'>";
                                echo"<i class='fa fa-check'> </i>";
                            echo"Aprove</a>";
                        }
                        ?>
                    </td>
                </tr>
                </tbody>
                <?php endwhile ?>
            </table>
            </div>
        <?php
        }else // close of if the table of comments is empty
        {
            echo"<div class='container text-white'>";
                echo"<div class='alert alert-info text-center fs-2 p-5 m-5'> There Is No Comments To Show </div>";
            echo"</div>";
        }
        break;
//END MAAGE PAGE ##########################################################################################################################

//START EDIT PAGE ##########################################################################################################################
        case 'Edit':
            $comid=isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']) : 0;
            // check if the comment exits
            $check=checkItme('c_id','comments');
                $comment=$con ->prepare("SELECT comment , c_id FROM comments WHERE c_id =:comid");
                $comment->bindValue(":comid",$comid);
                $comment ->execute();
                $count=$comment->rowCount();
                $theComment=$comment ->fetch(PDO::FETCH_ASSOC);
            if($count > 0){
            ?>
            <h1 class="text-center mt-3 text-info">Edit Comment</h1>
            <div class="container form-general">
                <form action="?do=Update" method="post" class="Edit w-50 p-3">
                    <input type="hidden" name="id" value="<?php echo $theComment['c_id']?>">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label text-white">Comment :</label>
                                <textarea name="coment"  class="form-control" rows="5"><?php echo $theComment['comment'] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <input type="submit" value="Save Comment" class="btn btn-primary w-50">
                    </div>
                </form>
            </div>
            <?php
            }else
            {
                $err_msg="<div class='alert alert-danger'> comment not found </div>";
                redirectToHom($err_msg);
            }
            break;
//END EDIT PAGE ##########################################################################################################################

//START UPDATE PAGE ##########################################################################################################################
        case 'Update':
            if($_SERVER['REQUEST_METHOD']=='POST'){
                // get my data
                $id=$_POST['id'];
                $comment=$_POST['coment'];
                // check if comment exists
                $chekCom=checkItme("c_id","comments",$id);
                if($chekCom > 0){
                    echo"<div class='container mt-5'>";
                    echo"<h1 class='text-center text-info'>Update Comment </h1>";
                        // update comment
                        $updateCom=$con ->prepare("UPDATE comments SET comment=:com WHERE c_id=:cid");
                        $updateCom ->bindValue(':com',$comment);
                        $updateCom ->bindValue(':cid',$id);
                        $updateCom ->execute();
                        $succ_msg="<div class='alert alert-success'> Comment Updated </div>";
                        redirectToHom($succ_msg,"back");
                    echo"</div>";
                }else // close of check comment
                {
                    echo"<div class='container mt-5'>";
                    $err="<div class='alert alert-danger'> No comment found with this id </div>";
                    redirectToHom($err);
                    echo"</div>";
                }
            }else // close of if come from form
            {
                echo"<div class='container mt-5'>";
                $err="<div class='alert alert-danger'> you can not browse this page direct </div>";
                redirectToHom($err);
                echo"</div>";
            }
            break;
//END UPDATE PAGE ##########################################################################################################################

//START DELETE PAGE ##########################################################################################################################
        case 'Delete':
            echo"<div class='container mt-5'>";
                echo"<h1 class='text-center text-info'>Delete Comment </h1>";
                $comID=isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']) : 0;
                if(checkItme('c_id','comments',$comID)>0){
                    $delcom=$con ->prepare("DELETE FROM comments WHERE c_id=?");
                    $delcom -> execute([$comID]);
                    $succ_msg="<div class='alert alert-success'> Comment deleted </div>";
                    redirectToHom($succ_msg,"back");
                }else
                {
                    echo"<div class='container mt-5'>";
                    $err="<div class='alert alert-danger'> No comment found with this id </div>";
                    redirectToHom($err);
                    echo"</div>";
                }
            echo"</div>";
            break;
//END DLETE PAGE ##########################################################################################################################   
        case 'Aprove':
            echo"<div class='container mt-5'>";
            echo"<h1 class='text-center text-info'>Aprove Comment </h1>";
            $comID=isset($_GET['comID']) && is_numeric($_GET['comID']) ? intval($_GET['comID']) : 0;
            if(checkItme('c_id','comments',$comID)>0){
                $delcom=$con ->prepare("UPDATE comments SET status=1 WHERE c_id=?");
                $delcom -> execute([$comID]);
                $succ_msg="<div class='alert alert-success'> Comment Aproved </div>";
                redirectToHom($succ_msg,"back");
            }else
            {
                echo"<div class='container mt-5'>";
                $err="<div class='alert alert-danger'> No comment found with this id </div>";
                redirectToHom($err);
                echo"</div>";
            }
        echo"</div>";
            break;
    }
    include $tpl.'footer.php';
}else{
    header('location:index.php');
    exit();
    ob_end_flush();
}
?>