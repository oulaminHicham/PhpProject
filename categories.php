<?php
session_start();
include 'init.php';
$pageTitle='Categories';
// variable has the value of categorie id come from url
$catId=isset($_GET['catId']) && is_numeric($_GET['catId']) ? $_GET['catId'] : 0;
?>
<!-- affiched the categories -->
<div class="container">
    <h1 class="text-center text-black-50 mt-3 mb-5"><?php echo str_replace("-",' ',$_GET['catName'])  ?></h1>
    <div class="row">
        <?php 
        $allItems=getItems('cat_id ',$catId);
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
        }
        ?>
    </div>
</div>




















<?php include $tpl.'footer.php'?>