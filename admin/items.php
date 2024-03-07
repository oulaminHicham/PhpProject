<?php
/*=============================================
=== Items page
===============================================
*/
ob_start();
session_start();
$pageTitle='Items';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    switch ($do){
// START MANAGE PAGE #######################################################################################################
        case 'Manage':
            // varaibale to give no aprove item if exits
            $query='';
            isset($_GET['page']) && $_GET['page']=='aprove' ?  $query ="WHERE items.Aprove=0" :$query='' ;
            $ItemsStmt=$con ->prepare("SELECT i.*,c.Name AS catName ,u.username FROM items i
                                       INNER JOIN categories c ON c.id = i.cat_id
                                       INNER JOIN users u ON u.userId = i.member_id 
                                       ORDER BY item_id DESC");
            $ItemsStmt->execute();
            $Items=$ItemsStmt->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($Items)){
            ?>
            <h2 class="text-center m-3 text-info">Manage Item</h2>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th>Descreption</th>
                                    <th>Price</th>
                                    <th>Adding Date</th>
                                    <th>Categorie</th>
                                    <th>Member</th>
                                    <th class="text-center">Control</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($Items as $item):?>   
                                <tr>
                                    <td><?php echo $item['item_id']?></td>
                                    <td><?php echo $item['Name']?></td>
                                    <td><?php echo substr($item['item_dex'],0,20)?>...</td>
                                    <td><?php echo $item['price']?></td>
                                    <td><?php echo $item['add_date']?></td>
                                    <td><?php echo $item['catName']?></td>
                                    <td><?php echo $item['username']?></td>
                                    <td class="control">
                                        <a href="Items.php?do=Edit&itemID=<?php echo $item['item_id']?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="Items.php?do=Delete&itemID=<?php echo $item['item_id']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                        <?php
                                        if($item['Aprove']==0){
                                            echo"<a href='items.php?do=Approve&itemID=".$item['item_id']."'class='btn btn-info text-light'> <i class='fa fa-check'></i>Aprove</a>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>           
                            </tbody>
                        </table>
                    </div>
                    <a href="Items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
                </div>
            <?php
            }else // close of if the table of users is empty
            {
                echo"<div class='container'>";
                    echo"<div class='alert alert-info text-center fs-2 p-5 m-5'> There Is No Items To Show </div>";
                    echo'<a href="Items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>';
                echo"</div>";
            }          
            break;
// END MANAGE PAGE #######################################################################################################

// START ADD PAGE #######################################################################################################
        case 'Add':
        ?>
        <div class="container w-50 mt-3 add-item">
                <form action="Items.php?do=Insert" method="post">
                    <h3 class="text-center mb-3">Add New item</h3>

                    <div class="form-group mb-3">
                        <label class="control-lable mb-2"  for="name"> Name : </label>
                        <input 
                            type="text" 
                            name="itemName" 
                            class="form-control" 
                            placeholder="item Name" 
                           >
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="control-lable  mb-2"  for="name"> Dexreption : </label>
                        <input 
                            type="text" 
                            name="itemDex"
                            class="form-control" 
                           >
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-lable  mb-2"  for="name"> Price : </label>
                        <input 
                            type="text" 
                            name="price"
                            class="form-control" 
                            placeholder="item price"
                            >
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-lable  mb-2"  for="name"> Coutry : </label>
                        <input 
                            type="text" 
                            name="countryMade"
                            class="form-control" 
                            placeholder="item country made">
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-lable  mb-2"  for="name"> Status : </label>
                        <select name="status" class='form-control form-select'>
                            <option value="0">.....     </option>
                            <option value="New">New       </option>
                            <option value="Like New">Like New  </option>
                            <option value="Used">Used      </option>
                            <option value="Old">Old       </option>
                        </select>
                    </div>
                    <!-- start members field -->
                    <div class="form-group mb-3">
                        <label class="control-lable  mb-2"  for="name"> Members : </label>
                        <select name="members" class='form-control form-select'>
                            <option value="0">.....</option>
                            <?php
                            // select mebers from data base
                            $membersStmt=$con->prepare("SELECT  userID,username FROM users");
                            $membersStmt->execute();
                            while($member = $membersStmt->fetch(PDO::FETCH_ASSOC)){?>
                                <option value="<?php echo $member["userID"]?>"><?php echo $member["username"]?></option>                           
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                     <!-- end members field -->

                      <!-- start cetegorie field -->
                    <div class="form-group mb-3">
                        <label class="control-lable  mb-2"  for="name"> Categorie : </label>
                        <select name="categorie" class='form-control form-select'>
                            <option value="0">.....</option>
                            <?php
                            // select categorie from data base
                            $catStmt=$con->prepare("SELECT  id, Name FROM Categories");
                            $catStmt->execute();
                            while($cat = $catStmt->fetch(PDO::FETCH_ASSOC)){?>
                                <option value="<?php echo $cat["id"]?>"><?php echo $cat["Name"]?></option>                           
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                     <!-- end categorie field -->

                    <div>              
                        <input  type="submit" value="Add item" class="btn btn-info text-white-50 mb-3 fa fa-plus">
                    </div>                      
                </form>
            </div>
        <?php
            break;
// END ADD PAGE #######################################################################################################
// START INSERT PAGE #######################################################################################################
        case 'Insert':
            echo"<div class='container mt-3'>";
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo"<h1 class='text-center'> Insert Item </h1>";
                // get Variables
                $itemName        =  $_POST['itemName']    ;
                $itemDex         =  $_POST['itemDex']     ;
                $itemPrice       =  $_POST['price']       ;
                $itemCountryMade =  $_POST['countryMade'] ;
                $Itemstatus      =  $_POST['status']      ;
                $memberId        =  $_POST['members']     ;
                $catId           =  $_POST['categorie']   ;
                // validate form 
                $itemErrors=[];
                if(empty($itemName)){
                    array_push($itemErrors,"the name of item is <strong> required </strong>");
                }
                if(empty($itemDex)){
                    array_push($itemErrors,"the descreption of item is <strong> required </strong>");
                }

                if(empty($itemPrice)){
                    array_push($itemErrors,"the price of item is <strong> required </strong>");
                }

                if(empty($itemCountryMade)){
                    array_push($itemErrors,"the country made of item is <strong> required </strong>");
                }
                if($Itemstatus == 0){
                    array_push($itemErrors,"you must chooce<strong> status </strong>");
                }

                if($memberId == 0){
                    array_push($itemErrors,"you must chooce a <strong> Member  </strong>");
                }

                if($catId == 0){
                    array_push($itemErrors,"you must chooce a <strong> categorie </strong>");
                }

                if(empty($itemErrors)){
                    // insert item in data base
                    $insertItemstmt=$con ->prepare("INSERT INTO
                        Items  (Name , item_dex , price, country_made , status ,member_id , cat_id , add_date)
                        VALUES (:nam,:dex,:price,:coutM,:stat,:memberId,:catId,now())");
                    $insertItemstmt ->execute(array(
                        'nam'      => $itemName,
                        'dex'      => $itemDex,
                        'price'    => $itemPrice,
                        'coutM'    => $itemCountryMade,
                        'stat'     => $Itemstatus,
                        'memberId' => $memberId,
                        'catId'    => $catId
                    ));
                    $msg = "<div class='alert alert-success'>".$insertItemstmt ->rowCount()."INSERTED </div>";
                    redirectToHom($msg,'back');                 
                }else{
                    foreach($itemErrors as $item){
                        echo"<div class='alert alert-danger'>".$item."</div>";
                    }
                }                
            }else{
                $msg="<div class='alert alert-danger'> you cn't brows this page directly </div>";
                redirectToHom($msg);
            }
            echo"</div>";
            break;
// END INSERT PAGE #######################################################################################################

// START EDIT PAGE #######################################################################################################
        case 'Edit':
            // check if itemID exits ad if it is number
            $itemId=isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? intval($_GET['itemID']):0;
            // select all items from data base
            $itemSTMT=$con      ->prepare("SELECT * FROM items WHERE item_id=:Zid");
            $itemSTMT           -> bindValue(':Zid',$itemId);
            $itemSTMT           ->execute();
            $item=$itemSTMT     ->fetch(PDO::FETCH_ASSOC);
            $coutItem=$itemSTMT ->rowCount();
            // select id and user name of members
            $memberSTMT=$con    ->prepare("SELECT userID , username FROM users");
            $memberSTMT         ->execute();
            // select id an name of categorie
            $categorieSTMT=$con ->prepare("SELECT id , Name  FROM categories ");
            $categorieSTMT      ->execute();

            if($coutItem > 0){
        ?>
        <div class="container">
            <div class="form-general">
                <h3 class="text-center mt-3 pb-3 text-info">Edit Item</h3>
                <form action="?do=Update" method="post" class=" Edit p-3">
                    <input type="hidden" name="itemId" value="<?php echo $item['item_id'] ?>">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label text-secondary">Name :</label>
                            <input class="form-control" type="text" name="itemName" value="<?php echo $item['Name'] ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label text-secondary">Dexcreption :</label>
                            <input class="form-control" type="text" name="itemdex" value="<?php echo $item['item_dex'] ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label text-secondary">Price :</label>
                            <input class="form-control" type="text" name="itemPrice" value="<?php echo $item['price'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label text-secondary">Adding date :</label>
                            <input class="form-control" type="date" name="add-date" value="<?php echo $item['add_date'] ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label text-secondary">Country Made :</label>
                            <input class="form-control" type="text" name="country" value="<?php echo $item['country_made'] ?>">
                        </div>
                    </div>

                    <div class="row">
                        <label class="form-label text-secondary">Status:</label>
                        <div class="mb-3">
                            <select name="status" class='form-control form-select'>
                                <option value="New"      <?php if($item['status']=='New')      echo 'selected'   ?>>New       </option>
                                <option value="Like New" <?php if($item['status']=='Like New') echo 'selected'   ?>>Like New  </option>
                                <option value="Used"     <?php if($item['status']=='Used')     echo 'selected'   ?>>Used      </option>
                                <option value="Old"      <?php if($item['status']=='Old')      echo 'selected'   ?>>Old       </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <label class="form-label text-secondary">Member :</label>
                        <div class="mb-3">
                            <select name="userId" class="form-control form-select">
                                <?php while($users=$memberSTMT->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $users['userID']?>"
                                    <?php if($item['member_id']==$users['userID']) echo 'selected'?>  ?><?php echo $users['username'] ?></option>
                                <?php endwhile  ?>
                            </select>
                        </div>
                    </div>

                <div class="row">
                    <label class="form-label text-secondary">Categorie :</label>
                    <div class="mb-3">
                        <select name="catTD" class="form-control form-select">
                            <?php while($cats=$categorieSTMT->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $cats['id']?>"
                                <?php if($item['cat_id'] == $cats['id']) echo 'selected'?>><?php echo $cats['Name'] ?></option>
                            <?php endwhile  ?>
                        </select>
                    </div>
                </div>

                <div>              
                        <input  type="submit" value="Save item" class="btn btn-info text-white-50 mb-3">
                </div> 
            </form>
            </div>
            <!-- // SHOW COMMENTS -->
            <?php
            // select all comments
            $comments=$con ->prepare("SELECT c.* , u.username FROM comments c
                                      INNER JOIN users u ON c.user_id = u.userID
                                      where c.item_id = ?");
            $comments ->execute([$item['item_id']]);
            $countItem=$comments->rowCount();
            $commentsresults=$comments ->fetch(PDO::FETCH_ASSOC);
            if($countItem > 0){
            ?>
            <h3 class="text-info text-center m-5">[<?php echo $item['Name'] ?>] Comments <i class="fa fa-comments"></i></h3>
                <table class="table table-dark table-hover table-responsive">
                    <thead>
                    <tr>
                        <th class="text-info">Comments</th>
                        <th class="text-info">Full Name</th>
                        <th class="text-info">Added Date</th>
                        <th class="text-info text-center">Controle</th>
                    </tr>
                    </thead>
                    <?php  while($commentsresults=$comments ->fetch(PDO::FETCH_ASSOC)):?>
                    <tbody>
                    <tr>
                        <td><?php echo $commentsresults['comment']?></td>
                        <td><?php echo $commentsresults['username']?></td>
                        <td><?php echo $commentsresults['comment_date']?></td>
                        <td  class="control">
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
            }else
            {
                echo"<h2 class='text-center text-info mb-5'><i class='fa fa-comment'></i> This Item Has No Comments </h2>";
            }
            }else // else of if is exists of item wuth id
            {
                echo"<div class='container'>";
                $msg="<div class='alert alert-danger'> there is no user with this id </div>";
                redirectToHom($msg);
                echo"</div>";
            }
            break;
// END EDIT PAGE #######################################################################################################

// START UPDATE PAGE #######################################################################################################
        case 'Update':
            if($_SERVER['REQUEST_METHOD']=='POST'){
                // get all data from the form
                $id=$_POST['itemId'];
                $ItemName=$_POST['itemName'];
                $itemDex=$_POST['itemdex'];
                $itemPrice=$_POST['itemPrice'];
                $itemAdddate=$_POST['add-date'];
                $itemCountryMade=$_POST['country'];
                $itemStatus=$_POST['status'];
                $userid=$_POST['userId'];
                $catid=$_POST['catTD'];
                // validate the form
                $itemErrors=[];
                if(empty($ItemName)){
                    array_push($itemErrors,"the name of item is <strong> required </strong>");
                }
                if(empty($itemDex)){
                    array_push($itemErrors,"the descreption of item is <strong> required </strong>");
                }

                if(empty($itemPrice)){
                    array_push($itemErrors,"the price of item is <strong> required </strong>");
                }

                if(empty($itemCountryMade)){
                    array_push($itemErrors,"the country made of item is <strong> required </strong>");
                }
                if($itemStatus == 0){
                    array_push($itemErrors,"you must chooce<strong> status </strong>");
                }

                if($userid == 0){
                    array_push($itemErrors,"you must chooce a <strong> Member  </strong>");
                }

                if($catid == 0){
                    array_push($itemErrors,"you must chooce a <strong> categorie </strong>");
                }
                if(empty($itemErrors)){
                    // check if item exists
                    $chek=checkItme("item_id" , 'items' , $id);
                    if($chek > 0){
                        $updateItemSTMT=$con->prepare("UPDATE items SET Name=:Zname , item_dex=:Zdex , price=:Zprice , add_date=:Zdate ,
                                            country_made=:Zcount , status=:Zstat , cat_id=:zCate , member_id=:Zmeme WHERE item_id=:Zid");
                        $updateItemSTMT->bindValue(':Zname',$ItemName);
                        $updateItemSTMT->bindValue(':Zdex',$itemDex);
                        $updateItemSTMT->bindValue(':Zprice',$itemPrice);
                        $updateItemSTMT->bindValue(':Zdate',$itemAdddate);
                        $updateItemSTMT->bindValue(':Zcount',$itemCountryMade);
                        $updateItemSTMT->bindValue(':Zstat',$itemStatus);
                        $updateItemSTMT->bindValue(':zCate',$catid);
                        $updateItemSTMT->bindValue(':Zmeme',$userid);
                        $updateItemSTMT->bindValue(':Zid',$id);
                        $updateItemSTMT->execute();
                        echo"<div class='container mt-5'>";
                        $seccMsg="<div class='alert alert-success'> 1 Row has ben Updateted</div>";
                        redirectToHom($seccMsg,'back',5);
                        echo"</div>";
                    }else
                    {
                        $ErrMsg="<div class='alert alert-danger'> No user withthis id</div>";
                        redirectToHom($ErrMsg);
                    } 
                }else
                {
                    foreach($itemErrors as $item){
                        echo"<div class='alert alert-danger'>".$item."</div>";
                    }
                }
            }else
            {
                $ErrMsg="<div class='alert alert-danger'> you cannot browse this page directly </div>";
                redirectToHom($ErrMsg);
            }
            break;
// END UPDATE PAGE #######################################################################################################  

// START DELETE PAGE #######################################################################################################
        case 'Delete':
            $Itemid=isset($_GET['itemID']) && is_numeric($_GET['itemID'])?intval($_GET['itemID']):0;
            echo "<div class='container mt-5'>";
            echo "<h1 class='text-center'> Delete Item </h1>";
            $cheke=checkItme('item_id','items' ,$Itemid);
            if($cheke > 0){
                $delItem=$con ->prepare("DELETE FROM items WHERE item_id=?");
                $delItem ->execute([$Itemid]);
                $secMsg="<div class='alert alert-success'>1 row Deleted</div>";
                redirectToHom($secMsg , 'back');
            }else
            {
                $ErrMsg="<div class='alert alert-danger'>there is no item with this id </div>";
                redirectToHom($ErrMsg);
            }
            echo"</div>";
            break;
// END DELETE PAGE ####################################################################################################### 

// START APROVE PAGE #######################################################################################################
        case 'Approve':
            echo"<div class='container m-5'>";
            echo"<h2 class='text-center'> Apreove Item</h2>";
            $itemID=isset($_GET['itemID']) && is_numeric($_GET['itemID']) ? $_GET['itemID'] : 0;
            $check=checkItme('item_id','items',$itemID);
            if($check > 0)
            {
                $aproveSTMT=$con->prepare("UPDATE items SET Aprove=1 WHERE item_id=:Zid");
                $aproveSTMT->bindValue(':Zid',$itemID);
                $aproveSTMT->execute();
                $secMSG="<div class='alert alert-success'> One Row Updated </div>";
                redirectToHom($secMSG,"back");
            }else
            {
                $errMSG="<div class='alert alert-danger'> No Item found with this id </div>";
                redirectToHom($errMSG);
            }
            echo"</div>";
            break;
        } // close of switch
// END APROVE PAGE #######################################################################################################
    
    include $tpl.'footer.php';
}else{
    header('location:index.php');
    exit();
    ob_end_flush();
}
?>