<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashbord.php"><?php echo lang('BRAND')?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="container navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><?php echo lang('CATEGORIES')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items.php"><?php echo lang('ITEMS')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php?do=Manage"><?php echo lang('MEMBERS')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php"><?php echo lang('COMMENTS')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php?do=Edit&userID=<?php echo $_SESSION['Id']?>"><?php echo lang('EDIT_PROFILE')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang('SETTING')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><?php echo lang('LOG_OUT')?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php"><?php echo lang('VISIT_SHOW')?></a>
        </li>
      </ul>
    </div>
  </div>
</nav>
