<?php
require_once('login_session.php');
require_once('connection.php');
if (isset($page) && !empty(trim($page))) {
    $post_id = $page;

    $query = "SELECT * FROM `posts` WHERE id = ?";
    $edit = $con->prepare($query);
    $edit->bind_param('i', $post_id);
    $edit->execute();
    $result = $edit->get_result();
    if ($result->num_rows < 1) {
        header("Location: /admin/manage");
    }
} else {
    header("Location: /admin/manage");
}

if (isset($_POST['submit'])) {
    $getPage = $_POST['csrf'];
    $title = htmlspecialchars(strip_tags($_POST['title']));
    $content = $_POST['content'];

    if (!empty(trim($title)) && !empty(trim($content)) && isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_extension = explode(".", $_FILES['image']['name']);
        $file_ext = end($file_extension);

        $expensions = array("jpeg", "jpg", "png");
        if (file_exists($file_name)) {
            echo "Sorry, file already exists.";
        }
        if (in_array(strtolower($file_ext), $expensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file";
        }

        if ($file_size > 2097152) {
            $errors[] = 'File is too large';
        }
        if (empty($errors)) {
            $uploadfile = 'IMG' . time() . rand(100000, 9999999) . "." . $file_ext;
            move_uploaded_file($file_tmp, "img/post/" . $uploadfile);

            $query1 = "UPDATE `posts` SET `post_title` = ?, `post_content` = ?,`imagePath` = ? WHERE id = ?";
            $u_post = $con->prepare($query1);
            $u_post->bind_param('sssi', $title, $content, $uploadfile, $getPage);
            if ($u_post->execute()) {
                header("Location: /admin/dashboard");
            }
        } else {
            header("Location: /admin/dashboard");
        }
    } elseif (!empty(trim($title)) && !empty(trim($content))) {

        $query2 = "UPDATE `posts` SET `post_title`=?,`post_content`=? WHERE `id`=?";
        $u_post2 = $con->prepare($query2);
        $u_post2->bind_param('ssi', $title, $content, $getPage);
        if ($u_post2->execute()) {
            header("Location: /admin/dashboard");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>BOSCHMA | Edit-Post</title>

    <link rel="shortcut icon" type="image/x-icon" href="../../img/favicon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/feathericon.min.css">
    <link rel="stylesheet" href="../assets/plugins/morris/morris.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left">
                <a href="#" class="logo">
                    <img src="../../logo.png" alt="Logo">
                </a>

                <a href="#" class="logo logo-small">
                    <img src="../../logo.png" alt="Logo" width="30" height="30">
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
                        <span class="user-img"><img class="rounded-circle" src="../../img/user/<?php echo $_SESSION["user_avatar"]; ?>" width="31" alt="Profile Image"></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="../../img/user/<?php echo $_SESSION["user_avatar"]; ?>" alt="User Image" class="avatar-img rounded-circle">
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
                            <a href="/admin/account"><i class="fe fe-lock"></i> <span>Account Settings</span></a>
                        </li>
                        <li>
                            <a href="/admin/logout"><i class="fe fe-vector"></i> <span>Logout</span></a>
                        </li>
                </div>
            </div>
        </div>

        <?php
        $rows = $result->fetch_assoc();
        ?>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h4 class="card-title float-start">Edit Post</h4>
                            </div>
                            <div class="card-body m-3">
                                <form action="/admin/edit" method="POST" enctype="multipart/form-data">
                                    <div class="row offset-lg-3 g-3">
                                        <input type="hidden" name="csrf" value="<?php echo $rows['id']; ?>">
                                        <div class="col-lg-8 col-md-6 col-sm-12">
                                            <div class="form-floating">
                                                <input type="text" value="<?php echo $rows['post_title']; ?>" class="form-control" name="title" id="title" required>
                                                <label for="title">Post Title</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <textarea name="content" class="form-control" cols="5" rows="5" placeholder="Your content...." required><?php echo $rows['post_content']; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-6 col-sm-12">
                                            <div class="border rounded p-2">
                                                <img src="../../img/post/<?php echo $rows['imagePath']; ?>" class="img-fluid" id="postImage" alt="" srcset="">
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-6 col-sm-12">
                                            <div class="form-floating">
                                                <input accept="image/*" type="file" name="image" class="form-control" id="imgInp" placeholder="Your Picture">
                                                <label for="image">Change Image</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-8 col-md-6 col-sm-12">
                                            <button class="btn btn-primary w-100 py-2 rounded-pill mt-4" name="submit" type="submit">Update</button>
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
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                postImage.src = URL.createObjectURL(file)
            }
        }
    </script>

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/script.js"></script>

</body>

</html>