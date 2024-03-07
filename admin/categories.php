<?php
/*
######################################
#### categorie page
######################################
*/
ob_start();
session_start();
$pageTitle='Categories';
if(isset($_SESSION['username'])){
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    switch ($do){
//### STATRT MANAGE PAGE ################################################################################################
        case 'Manage':
            $sort='ASC';
            $sort_array=array("ASC","DESC");
            if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
                $sort=$_GET['sort'];
            }
            $matchCatDataStmt=$con->prepare("SELECT*FROM Categories ORDER BY Ordering $sort");
            $matchCatDataStmt->execute();
            $categories=$matchCatDataStmt ->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($categories)){
            ?>

            <h2 class="titleCat">Manage Categories</h2>
            <div class="container categories">
                <div class="panel cate-manage">
                    <div class="panel-heding bg-secondary p-2 d-flex justify-content-between align-items-center">Manage Categoris
                        <div class="ordering p-3 pb-0">
                            <span class="">Ordering :</span>
                            <div class="row">
                                <div class="col">
                                    <a href="?sort=DESC" class="btn btn-info">Decriment</a>
                                    <a href="?sort=ASC" class="btn btn-warning">Increment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="panel-body bg-light">
                            <?php                           
                            foreach($categories as $cat):
                            ?>
                                <div class="cat">
                                    <div class="hidden-buttons">
                                        <a href="?do=Edit&idCat=<?php echo $cat['id']?>" class="btn btn-xs btn-primary edit-btn"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="?do=Delete&idCat=<?php echo $cat['id']?>" class="btn btn-xs btn-danger del-btn confirm"><i class="fa fa-close"></i> Delete</a>
                                    </div>
                                    <h4 class="titleCat2"><?php echo $cat['Name']?></h4>
                                    <div class="full-view">
                                        <p><?php if($cat['Descreption'] =='') {echo"No Descreption In this Categories";}else{echo $cat['Descreption'];}?></p>
                                        <!-- check if the vesibelty colon is equel to 1 that mean that is in visebel and show hidden span -->
                                        <?php if($cat['Vesibelty']==1){echo "<span class='vesibelty'><i class='fa fa-eye'></i>Hidden</span>";}?>
                                        <!-- check if the comment alow colon is equel to 1 that mean that is no alow of comments and show comments-disibeld span -->
                                        <?php if($cat['Alow_Comment']==1){echo "<span class='alaw-comments'><i class='fa fa-close'></i>Comments Disibeled</span>";}?>
                                        <!-- check if the Ads colon is equel to 1 that mean that is in no ads alowed and show ads-desibled span -->
                                        <?php if($cat['Alaw_Ads']==1){echo "<span class='alaw-ads'><i class='fa fa-close'></i>Ads Disebeled</span>";}?>
                                    </div>
                                </div>
                                <hr>
                            <?php
                            endforeach                            
                            ?>
                        </div>
                    </div>
                    <a href="categories.php?do=Add" class="btn btn-success mt-3 mb-2"><i class="fa fa-plus"></i> Add Categorie</a>
            </div>
        <?php
            }else
            {
                echo"<div class='container text-white'>";
                    echo"<div class='alert alert-info text-center fs-2 p-5 m-5'> There Is No categories To Show </div>";
                    echo'<a href="categories.php?do=Add" class="btn btn-success mt-3 mb-2"><i class="fa fa-plus"></i> Add Categorie</a>';
                echo"</div>";
            }
            break;
//### END MANAGE PAGE ################################################################################################
    
// ##### START ADD PAGE ##############################################################################################
        case 'Add':
            ?>
            <div class="container w-50 mt-3 add-cat">
                <form action="?do=Insert" method="post">
                    <h3 class="text-center mb-3">Add New Categories</h3>

                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"  for="name"> Name : </label>
                        <input class="form-control" type="text" name="nameCat" placeholder="Categorie Name">
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"  for="Descreption"> Descreption : </label>
                        <input class="form-control" type="text" name="descreption" id="Descreption" placeholder="Categorie Descreption">
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary  mb-2"  for="Ordering"> Ordering : </label>
                        <input class="form-control" type="number" name="ordering" id="Ordering" placeholder="Categorie Ordering">
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"> Vesibel : </label>
                        <div class="form-control">                           
                                <input type="radio" name="visibelity" value="0" id="visibel-yes" checked>
                                <label class="control-lable" for="visibel-yes">Yes</label>                           
                                <input type="radio" name="visibelity" value="1" id="visibel-no">
                                <label class="control-lable" for="visibel-no">No</label>                           
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"> Alow Commenting : </label>
                        <div class="form-control">                          
                                <input type="radio" name="comments" value="0" id="com-yes" checked>
                                <label class="control-lable" for="com-yes">Yes</label>                        
                                 <input type="radio" name="comments" value="1" id="com-no">
                                <label class="control-lable" for="com-no">No</label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2">Alow ads : </label>
                        <div class="form-control">                           
                                <input type="radio" name="ads" value="0" id="ad-yes" checked>
                                <label class="control-lable" for="ad-yes">Yes</label>                           
                                <input type="radio" name="ads" value="1" id="ad-no">
                                <label class="control-lable" for="ad-no">No</label>                        
                        </div>
                    </div>
                    <div>
                        <input type="submit" value="Add Categorie" class="btn btn-info mb-3">
                    </div>                      
                </form>
            </div>
            <?php
            break;
// #### END ADD PAGE ###################################################################################################
// #### START INSERT PAGE ##############################################################################################
        case 'Insert':
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo"<h3 class='text-center mt-3 mb-3'>Insert Categorie</h3>";
                echo"<div class='container'>";
                // get variable from form
                $nameCat=$_POST['nameCat'];
                $dexCat=$_POST['descreption'];
                $orderCat=$_POST['ordering'];
                $visibelCat=$_POST['visibelity'];
                $alowCommentCat=$_POST['comments'];
                $alowAdsCat=$_POST['ads'];
                // validate
                $errorForms=array();
                if(empty($nameCat)){
                    array_push($errorForms,"The Name of Categorie Is requie");
                }
                if(strlen($nameCat) < 4){
                    array_push($errorForms , 'the name of categorie can not be less than 4 chars');
                }
                if(strlen($nameCat) > 20){
                    array_push($errorForms , 'the name of categorie can not be lard than 20 chars');
                }
                foreach($errorForms as $err){
                    echo "<div class='alert alert-danger'>".$err." </div>";
                }
                if(empty($errorForms)){
                    //check if categorie in data base
                    $checkExistCat=checkItme('Name','Categories',$nameCat);
                    if($checkExistCat == 0){
                        // insert categorie info
                        $catStmt=$con ->prepare("INSERT INTO 
                            Categories (Name , Descreption , Ordering , Vesibelty , Alow_Comment , Alaw_Ads)
                            VALUES (:Znam ,:Zdex , :Zord , :Zves , :ZalCom , :ZalAds)");          
                        $catStmt -> bindValue(":Znam"  , $nameCat       );
                        $catStmt -> bindValue(":Zdex"  , $dexCat        );
                        $catStmt -> bindValue(":Zord"  , $orderCat      );
                        $catStmt -> bindValue(":Zves"  , $visibelCat    );
                        $catStmt -> bindValue(":ZalCom", $alowCommentCat);
                        $catStmt -> bindValue(":ZalAds", $alowAdsCat    );
                        $catStmt -> execute(); 
                        $msg="<div class='alert alert-success'> this Categorie has Inserted </div>";
                        redirectToHom($msg , 'back');                       
                    }else{
                        $msg="<div class='alert alert-danger'> this Categorie Exists </div>";
                        redirectToHom($msg , 'back');
                    }
                }           
            }else{
                $msg="<div class='alert alert-danger'>you can't brous this page direct</div>";
                redirectToHom($msg,'back');
            }
                echo"</div>";
            break;
// #### END INSERT PAGE ###############################################################################################

// #### START EDIT PAGE  ##############################################################################################
        case 'Edit':
            // check if get request idCat is numeric & is entiger value
            $catId=isset($_GET['idCat']) && is_numeric($_GET['idCat']) ? $_GET['idCat'] : 0;
            // select all data depend on this id
            $catStmt    = $con     -> prepare("SELECT * FROM Categories WHERE id=:idZ");
            $catStmt               -> bindValue(":idZ",$catId);
            $catStmt               -> execute();
            $categories = $catStmt -> fetch(PDO::FETCH_ASSOC);
            $countCat   = $catStmt -> rowCount();
            if($countCat >0){
            ?>
             <div class="container w-50 mt-3 add-cat">
                <form action="?do=Update" method="post">
                    <h3 class="text-center mb-3">Edit Categories</h3>
                    <!-- hidden id for sending to update page -->
                    <input type="hidden" name="idcategorie" value="<?php echo $categories['id']?>">
                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"  for="name"> Name : </label>
                        <input class="form-control" type="text" name="nameCat" placeholder="Categorie Name" value="<?php echo $categories['Name']?>">
                    </div>
                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"  for="Descreption"> Descreption : </label>
                        <input class="form-control" type="text" name="descreption" id="Descreption" placeholder="Categorie Descreption" value="<?php echo $categories['Descreption']?>">
                    </div>
                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary  mb-2"  for="Ordering"> Ordering : </label>
                        <input class="form-control" type="number" name="ordering" id="Ordering" placeholder="Categorie Ordering" value="<?php echo $categories['Ordering']?>">
                    </div>
                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"> Vesibel : </label>
                        <div class="form-control">                           
                                <input type="radio" name="visibelity" value="0" id="visibel-yes" <?php if($categories['Vesibelty'] == 0) echo "checked"?>>
                                <label class="control-lable" for="visibel-yes">Yes</label>                           
                                <input type="radio" name="visibelity" value="1" id="visibel-no"  <?php if($categories['Vesibelty'] == 1) echo "checked"?>>
                                <label class="control-lable" for="visibel-no">No</label>                           
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2"> Alow Commenting : </label>
                        <div class="form-control">                          
                                <input type="radio" name="comments" value="0" id="com-yes" <?php if($categories['Alow_Comment'] == 0) echo "checked"?>>
                                <label class="control-lable" for="com-yes">Yes</label>                        
                                 <input type="radio" name="comments" value="1" id="com-no" <?php if($categories['Alow_Comment'] == 1) echo "checked"?>>
                                <label class="control-lable" for="com-no">No</label>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="control-lable text-secondary mb-2">Alow ads : </label>
                        <div class="form-control">                           
                                <input type="radio" name="ads" value="0" id="ad-yes" <?php if($categories['Alaw_Ads'] == 0) echo "checked"?>>
                                <label class="control-lable" for="ad-yes">Yes</label>                           
                                <input type="radio" name="ads" value="1" id="ad-no" <?php if($categories['Alaw_Ads'] == 1) echo "checked"?>>
                                <label class="control-lable" for="ad-no">No</label>                        
                        </div>
                    </div>
                    <div>
                        <input type="submit" value="Edit Categorie" class="btn btn-info mb-3">
                    </div>                      
                </form>
            </div>
            <?php
            }else{
                echo "<div class='container mt-3'>";
                    $msg="<div class='alert alert-danger'> theres no such Id </div>";
                    redirectToHom($msg);
                echo "</div>";
            }
            break;
// #### END EDIT PAGE  #################################################################################################

// #### START UPDATE PAGE  ############################################################################################
        case 'Update':
            echo"<div class='container mt-5'>";
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $catId        = $_POST['idcategorie'];
                $catName      = $_POST['nameCat'];
                $catDex       = $_POST['descreption'];
                $catOrdering  = $_POST['ordering'];
                $catVesiblety = $_POST['visibelity'];
                $catComment   = $_POST['comments'];
                $catAds       = $_POST['ads'];
           // update the data in database
            $catUpdatStmt=$con ->prepare("UPDATE Categories SET Name=? , Descreption=? , Ordering=? , Vesibelty=? ,
            Alow_Comment=? ,Alaw_Ads=? WHERE id=?");
            $catUpdatStmt -> execute([$catName,$catDex,$catOrdering,$catVesiblety,$catComment,$catAds,$catId]);
            $msg="<div class='alert alert-success'>".$catUpdatStmt->rowCount()." updated </div>";
            redirectToHom($msg,'back');
            }else{
                $msg="<div class='alert alert-danger'> you can't brows this page direct </div>";
                redirectToHom($msg);
            }
            echo"</div>";
            break;
// #### END UPDATE PAGE  #############################################################################################

// #### START DELETE PAGE  ###############################################################################################
        case 'Delete':
            echo "<div class='container mt-5'>";
            $idCategorie    = isset($_GET['idCat']) && is_numeric($_GET['idCat']) ? $_GET['idCat'] : '';
            $checkExistsCat = checkItme('id','Categories',$idCategorie);
            if($checkExistsCat > 0){
                $delCatStmt = $con -> prepare("DELETE FROM Categories WHERE id=?");
                $delCatStmt ->execute([$idCategorie]);
                $msg="<div class='alert alert-success'>".$delCatStmt->rowCount() ." row Deleted</div>";
                redirectToHom($msg,'back');
            }else{
                $msg="<div class='alert alert-danger'> Now user Found Deleted</div>";
                redirectToHom($msg);
            }
            echo"</div>";
            break;
// #### END DELTE PAGE  ###############################################################################################
    }
    include $tpl.'footer.php';
}else{
    header('location:index.php');
    exit();
    ob_end_flush();
}
?>