<?php
require_once('login_session.php');
require_once('connection.php');

function num_of_posts($conn)
{
    $query  = "SELECT count(id) AS posts FROM posts";
    $getTotal = $conn->prepare($query);
    $getTotal->execute();
    $result = $getTotal->get_result();
    $row = $result->fetch_assoc();
    return $row['posts'];
}

function checkIfempty($fields)
{
    if (empty($fields)) {
        return "NULL";
    }
    return $fields;
}

if (isset($_POST['delete_id']) && !empty(trim($_POST['delete_id']))) {
    $pageId = $_POST['delete_id'];
    $sql = "DELETE FROM `users` WHERE id = ?";
    $del_post = $con->prepare($sql);
    $del_post->bind_param('i', $pageId);
    if ($del_post->execute()) {
        header("Location: /admin/dashboard");
    }
}

function getContents($conn)
{
    $query = "SELECT * FROM `posts` ORDER BY createdAt DESC";
    $posts = $conn->prepare($query);
    $posts->execute();
    return $posts->get_result();
}

if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    $pageId = $_POST['id'];
    $sql = "DELETE FROM `posts` WHERE id = ?";
    $del_post = $con->prepare($sql);
    $del_post->bind_param('i', $pageId);
    if ($del_post->execute()) {
        header("Location: /admin/manage");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>BOSCHMA | Dashboard</title>

    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css" rel="stylesheet">


    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left">
                <a href="/admin/dashboard" class="logo">
                    <img src="../img/logo.png" alt="Logo">
                </a>

                <a href="/admin/dashboard" class="logo logo-small">
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
                        <span class="user-img"><img class="rounded-circle" src="../img/user/<?php echo $_SESSION["user_avatar"]; ?>" width="31" alt="Profile picture"></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <img src="../img/user/<?php echo $_SESSION["user_avatar"]; ?>" alt="Profile picture" class="avatar-img rounded-circle">
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
                        <li class="active">
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


        <div class="page-wrapper">
            <div class="content container-fluid">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card card-table flex-fill">
                                <div class="card-header">
                                    <h4 class="card-title float-start">Posts</h4>
                                    <h4 class="pull-right">(<?php echo num_of_posts($con); ?>)</h4>
                                </div>

                                <div class="card-body m-3">
                                    <div class="table-responsive">
                                        <table class="datatable table table-stripped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Content</th>
                                                    <th>Date Published</th>
                                                    <th>Acton</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php


                                                $sn = 1;
                                                $post_data = getContents($con);

                                                while ($rows = $post_data->fetch_assoc()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td><a href="../post/<?php echo $rows['id']; ?>" target="_blank"><?php echo $rows['post_title']; ?></a></td>
                                                        <td><?php echo substr($rows['post_content'], 0, 100); ?>...</td>
                                                        <td><?php echo $rows['createdAt']; ?></td>
                                                        <td><a href="/admin/edit/<?php echo $rows['id'] ?>" rel="noopener noreferrer" class="btn btn-primary btn-sm">Edit</a>

                                                            <button class='btn btn-danger btn-sm delete btn-flat' data-id='<?php echo $rows['id'] ?>'><i class='fa fa-trash'></i> Delete</button>

                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal start -->
                <div class="modal fade" id="delete">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="POST" action="/admin/manage">
                                    <input type="hidden" class="id" name="id">
                                    <div class="text-center">
                                        <p>Are you sure?</p>
                                        <h2 class="bold fullname"></h2>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-flat pull-left" data-bs-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                                <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal End! -->

            </div>
        </div>


        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

        
        <script src="assets/js/custom.js"></script>
</body>

</html>