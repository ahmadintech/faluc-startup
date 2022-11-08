<?php
require_once('login_session.php');
include 'connection.php';

function getContents($conn){
  $query = "SELECT * FROM `auth_users`";
  $users = $conn->prepare($query);
  $users->execute();
  return $users->get_result();
}

if(isset($_POST['update'])){
 if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
         $errors= array();
         $file_name = $_FILES['image']['name'];
         $file_size =$_FILES['image']['size'];
         $file_tmp =$_FILES['image']['tmp_name'];
         $file_type=$_FILES['image']['type'];
         $file_extension = explode(".", $_FILES['image']['name']);
         $file_ext = end($file_extension);
        
         $expensions= array("jpeg","jpg","png");
         if(file_exists($file_name)) {
           echo "Sorry, file already exists.";
           }
         if(in_array(strtolower($file_ext), $expensions)=== false){
            $errors[]="please choose a JPEG or PNG images";
         }
        
         if($file_size > 2097152){
            $errors[]='File is too large';
         }
         if(empty($errors)){
         $uploadfile = 'IMG'.time().rand(100000, 9999999).".".$file_ext;
           move_uploaded_file($file_tmp,"img/user/".$uploadfile);
           $query = "UPDATE `auth_users` SET `image_path`=?";
           $update_image = $con->prepare($query);
           $update_image->bind_param('s', $uploadfile);
           if($update_image->execute()){
             header("Location: /admin/logout");  
         }
         header("Location: /admin/logout"); 
        }   
    }
}

if (isset($_POST['submit'])) {

    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $username = htmlspecialchars(strip_tags($_POST['username']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));
    $pswd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    if(!empty(trim($name)) && !empty(trim($email)) && !empty(trim($username)) && !empty(trim($phone)) && !empty(trim($pswd))){

              $sql = "UPDATE `auth_users` SET `name`=?,`username`=?,`email`=?,`phone`=?,`passphrase`=?";
              $creat_post = $con->prepare($sql);
              $creat_post->bind_param('sssss', $name, $username, $email, $phone, $pswd);
              if($creat_post->execute()){
                header("Location: /admin/logout");  
        
    }else{
        header("Location: /admin/account");
    }
}else{
    header("Location: /admin/account");
} 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>BOSCHMA | Account</title>

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
<a href="/admin/account" class="logo">
<img src="../logo.png" alt="Logo">
</a>

<a href="/admin/account" class="logo logo-small">
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
                alt="Seema Sisty"></span>
    </a>
    <div class="dropdown-menu">
        <div class="user-header">
            <div class="avatar avatar-sm">
                <img src="../img/user/<?php echo $_SESSION["user_avatar"]; ?>" alt="User Image" class="avatar-img rounded-circle">
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
<li>
<a href="/admin/create"><i class="fa fa-plus-circle"></i> <span>Create Post</span></a>
</li>

<li>
<a href="/admin/manage"><i class="fa fa-cog"></i> <span>Manage Post</span></a>
</li>
<li class="active">
<a href="/admin/account"><i class="fe fe-lock"></i> <span>Account Settings</span></a>
</li>
<li>
 <a href="/admin/logout"><i class="fe fe-vector"></i> <span>Logout</span></a>
</li>

</div>
</div>
</div>

<?php 
$user_data = getContents($con);
$rows = $user_data->fetch_assoc();
?>
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-md-12 d-flex">

                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title float-start">Account</h4>
                    </div>
                    <div class="card-body m-3">
                        <div class="row settings-tab">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header all-center">
                                        <div class="avatar avatar-sm me-2 image-upload"><img
                                                class="avatar-img rounded-circle"
                                                src="../img/user/<?php echo $rows['image_path']?>" alt="User Image">
                                        </div>
                                        <h6><?php echo $rows['name']?></h6>
                                        <p>Administrator</p>
                                        <hr>
                                        <form action="/admin/account" enctype="multipart/form-data" method="post">
                                            <div class="p-2">
                                                <input type="file" name="image" class="form-control" required>
                                                <button type="submit" name="update" class="btn btn-primary w-100 mt-3">Change</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">General Settings</h4>
                                    </div>
                                    <div class="card-body p-3">
                                        <form  action="/admin/account" method="POST">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" value="<?php echo $rows['name']?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo $rows['email']?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="tel" name="phone" class="form-control" value="<?php echo $rows['phone']?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" name="username" class="form-control" value="<?php echo $rows['username']?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password" required>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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