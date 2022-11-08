<?php 
require_once('login_session.php');
require_once('connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>BOSCHMA | Create-Post</title>

<link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/feathericon.min.css">
<link rel="stylesheet" href="assets/plugins/morris/morris.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="main-wrapper">

<div class="header">

<div class="header-left">
<a href="/admin/create" class="logo">
<img src="../logo.png" alt="Logo">
</a>

<a href="/admin/create" class="logo logo-small">
<img src="../logo.png" alt="Logo" width="30" height="30">
</a>
</div>

<a href="javascript:void(0);" id="toggle_btn">
<i class="fe fe-text-align-left"></i>
</a>
<div class="top-nav-search">
<form>
<input type="text" class="form-control" placeholder="Search here">
<button class="btn" type="submit"><i class="fa fa-search"></i></button>
</form>
</div>

<a class="mobile_btn" id="mobile_btn">
<i class="fa fa-bars"></i>
</a>


<ul class="nav user-menu">

<li class="nav-item dropdown noti-dropdown">

<li class="nav-item dropdown has-arrow">
    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
        <span class="user-img"><img class="rounded-circle" src="../img/user/<?php echo $_SESSION["user_avatar"]; ?>" width="31"
                alt="Profile image"></span>
    </a>
    <div class="dropdown-menu">
        <div class="user-header">
            <div class="avatar avatar-sm">
                <img src="../img/user/<?php echo $_SESSION["user_avatar"]; ?>" alt="Profile image" class="avatar-img rounded-circle">
            </div>
            <div class="user-text">
                <h6><?php echo $_SESSION['user_name']; ?></h6>
                <p class="text-muted mb-0">Administrator</p>
            </div>
        </div>
        <a class="dropdown-item" href="/admin/account">Account Settings</a>
        <a class="dropdown-item" href="/admin/logout">Logout</a>
    </div>
</li>
</ul>
</div>


<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="menu-title">
</li>
<li>
<a href="/admin/dashboard"><i class="fe fe-home"></i> <span>Dashboard</span></a>
</li>
<li class="active">
<a href="/admin/create"><i class="fa fa-plus-circle"></i> <span>Create Post</span></a>
</li>
<li>
<a href="/admin/account"><i class="fe fe-lock"></i> <span>Account Settings</span></a>
</li>
<li>
 <a href="/admin/logout"><i class="fe fe-vector"></i> <span>Logout</span></a>
</li>

</div>

</div>
</div>


<div class="page-wrapper">
<div class="content container-fluid">



<div class="row">
<div class="col-md-12 d-flex">

<div class="card card-table flex-fill">
<div class="card-header">
<h4 class="card-title float-start">Create Post</h4>
</div>
<div class="card-body m-3">

<form action="/admin/create" method="POST" enctype="multipart/form-data">
                                <div class="row offset-lg-3 g-3">
                                    <div class="col-lg-8 col-md-6 col-sm-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="title" id="title" required>
                                            <label for="title">Post Title</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <textarea name="content" id="content" class="form-control" cols="5" rows="5" placeholder="Your content...." required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-12">
                                        <div class="form-floating">
                                            <input type="file" name="image" class="form-control" id="image" placeholder="Your Picture" required>
                                            <label for="image">Image</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-6 col-sm-12">

                                        <button class="btn btn-primary w-100 py-2 rounded-pill mt-4" name="post" type="submit">Post</button>

                                    </div>

                                </div>
                            </form>

</div>
</div>

</div>
</div>
</div>
</div>

</div>


<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>