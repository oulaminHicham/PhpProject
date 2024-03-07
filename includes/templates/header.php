<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $cssDirec;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cssDirec;?>all.min.css">
    <link rel="stylesheet" href="<?php echo $cssDirec;?>a.css">
    <title><?php getTitle() ?></title>
</head>
<body>
<?php if(!isset($_SESSION['user_id'])){?>
  <div class="upper-bar bg-success p-2 ">
      <div class="w-100 d-flex justify-content-end">
        <a href="login.php" class="text-decoration-none btn btn-primary rounded-4">
          <span class="d-block text-end text-white">login / signup</span>
        </a>
      </div>
  </div>
<?php 
  }
  else{
    echo "<div class='container p-3'>";
      echo"<div class='d-flex justify-content-end align-items-center'>";
        echo "<h4 class='d-inline-block text-black-50 mx-2'>welcome ".$sessionUser."</h4>";
        echo "<a href='profil.php' class='btn btn-success rounded-4 mx-2'>My Profile</a>";
        echo '<a class="btn btn-primary rounded-4 mx-2" href="logout.php">LogOut</a>';
      echo "</div>";
    echo "</div>";
  }
  ?>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><?php echo lang('BRAND')?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="container navbar-nav me-auto justify-content-end">
        <?php foreach(getcat() as $cat):?>
        <li class="nav-item">
          <a class="nav-link" href="categories.php?catId=<?php echo $cat['id'].'&catName='.str_replace(' ','-',$cat['Name'])?>">
            <?php echo $cat['Name']?>
          </a>
        </li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>
</nav>







