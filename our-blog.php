<?php require('admin/connection.php');

function countnews($con)
{
    $query = "SELECT COUNT(`id`) AS `page` FROM posts";
    $headline = $con->prepare($query);
    if ($headline->execute()) {
        return $headline->get_result();
    }
}

function news($firstResult, $rPerPage, $con)
{
    $query = "SELECT * FROM posts ORDER BY createdAt DESC LIMIT " . $firstResult . ',' . $rPerPage;
    $headline = $con->prepare($query);
    if ($headline->execute()) {
        return $headline->get_result();
    }
}

if (!isset($page)) {
    $page = 1;
    $pageactive = 1;
    header("Location: /blog/1");
} else {
    $page = $page;
    $pageactive = $page;
}
$results_per_page = 8;
$page_first_result = ($page - 1) * $results_per_page;
$pagecount = countnews($con);
$result = $pagecount->fetch_assoc();
$number_of_result = $result['page'];
$number_of_page = ceil($number_of_result / $results_per_page);
$res = news($page_first_result, $results_per_page, $con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Faluc - Blog</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <style>
        .full-justify {
            text-align: justify;
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <small class="me-3 text-light"><i class="fa fa-map-marker-alt me-2"></i>Suite 5B Golden Plaza, Along Kano-Jos Road, Maiduguri, Borno State.</small>

                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <small class="me-3 text-light"><i class="fa fa-phone-alt me-2"></i>+234 902 191 6421</small>
                    <small class="text-light"><i class="fa fa-envelope-open me-2"></i>info@faluc.org.ng</small>

                </div>
            </div>
        </div>
    </div>
    <!-- Navbar Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-3 px-lg-5 py-3 py-lg-0">
            <a href="index.html" class="navbar-brand p-0">
                <img class="img-fluid" src="../img/logo2.png" alt="" srcset=""> <span class="fw-bold-xl">Faluc</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="navbar-nav ms-auto py-0">
                    <a href="/home" class="nav-item nav-link">Home</a>
                    <a href="/about-us" class="nav-item nav-link">About</a>
                    <a href="/blog" class="nav-item nav-link active">Blog</a>
                    <a href="/contact-us" class="nav-item nav-link">Contact</a>
                </div>
        </nav>


        <div class="container-fluid bg-primary py-5 mb-2 bg-header">
            <div class="row py-5">
                <div class="col-12 pt-lg-5 mt-lg-5 text-center">
                    <h1 class="display-4 text-white animated zoomIn">Our Blog</h1>
                    <a href="" class="h5 text-white">Home</a>
                    <i class="far fa-circle text-white px-2"></i>
                    <a href="" class="h5 text-white">Blog</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(9, 30, 62, .7);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-transparent border-primary p-3" placeholder="Type search keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->


    <!-- Blog Start -->
    <div class="container-fluid">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Blog list Start -->
                <div class="col-lg-8">
                    <div class="row g-5">

                        <?php

                        while ($np = $res->fetch_assoc()) {
                            $post_id = $np["id"];
                            $post_heading = $np["post_title"];
                            $post_content = $np["post_content"];
                            $post_img = $np["imagePath"];
                            $post_date = $np["createdAt"];
                        ?>


                            <div class="col-md-6 wow slideInUp" data-wow-delay="0.1s">
                                <div class="blog-item bg-light rounded overflow-hidden">
                                    <div class="blog-img position-relative overflow-hidden">
                                        <img class="img-fluid" src="../img/post/<?php echo $post_img; ?>" alt="Image">
                                    </div>
                                    <div class="p-4">
                                        <div class="d-flex mb-3">
                                            <small class="me-3"><i class="far fa-user text-primary me-2"></i>Admin</small>
                                            <small><i class="far fa-calendar-alt text-primary me-2"></i><?php echo date('d F, Y', strtotime($post_date)) ?></small>
                                        </div>
                                        <h4 class="mb-3"><a href="/post/<?php echo $post_id ?>"><?php echo $post_heading ?></a></h4>
                                        <p><?php echo substr($post_content, 0, 200) ?> ...</p>
                                        <a class="text-uppercase" href="/post/<?php echo $post_id ?>">Read More <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>                
                    

        <div class="col-12 wow slideInUp" data-wow-delay="0.1s">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-lg m-0">

                    <?php
                    if ($pageactive >= $number_of_page) {
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="/blog/<?php
                            if ($pageactive - 1 < 1) {
                                echo "1";
                            } else {
                                echo $pageactive - 1;
                            }
                            ?>">Previous</a>
                        </li>
                    <?php }

                    for ($page = 1; $page <= $number_of_page; $page++) {
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="/blog/<?php echo $page ?>"><?php echo $page ?></a>
                        </li>
                    <?php

                    }
                    if ($pageactive >= $number_of_page) {
                    } else { ?>
                        <li class="page-item">
                            <a class="page-link" href="/blog/<?php echo $pageactive + 1 ?>">Next</a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
   
    <!-- Blog list End -->

    <!-- Sidebar Start -->
    <div class="col-lg-4">

        <!-- Recent Post Start -->
        <?php
        include_once("recent-post.html.php");
        ?>

        <!-- Recent Post End -->



        <!-- Plain Text Start -->
        <div class="wow slideInUp" data-wow-delay="0.1s">
            <div class="section-title section-title-sm position-relative pb-3 mb-4">
                <h3 class="mb-0">Plain Text</h3>
            </div>
            <div class="bg-light text-center" style="padding: 30px;">
                <p>We are Inspired by the belief that young people when equipped with relevant skills and quality education can change the world, Foundation for Alternative Learning in Underserved Communities (FALUC) creates a community where children and youth, especially the most vulnerable of them can have access to skills and education to thrive in a challenging world.</p>
                <a href="/about-us" class="btn btn-primary py-2 px-4">Read More</a>
            </div>
        </div>
    </div>
    <!-- Plain Text End -->
    </div>
    <!-- Sidebar End -->
    </div>
    </div>
    </div>
    <!-- Blog End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 mb-5">
            <div class="bg-white">
                <div class="owl-carousel vendor-carousel">
                    <img src="../img/partners/Rectangle 1.png" alt="">
                    <img src="../img/partners/Rectangle 2.png" alt="">
                    <img src="../img/partners/Rectangle 3.png" alt="">
                    <img src="../img/partners/Rectangle 4.png" alt="">
                    <img src="../img/partners/Rectangle 5.png" alt="">
                    <img src="../img/partners/Rectangle 6.png" alt="">
                    <img src="../img/partners/Rectangle 3.png" alt="">

                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- Footer Start -->

    <div class="container-fluid text-white" style="background: #061429;">
        <div class="container text-center">
            <div class="row justify-content-end">
                <div class="col-lg-12 col-md-12">
                    <div class="d-flex align-items-center justify-content-center" style="height: 75px;">
                        <p class="mb-0">&copy; <a class="text-white border-bottom" href="#">FALUC</a>. All Rights Reserved.

                            Powered by <a class="text-white border-bottom" href="https://maid360.com">VUETIFY SOLUTIONS</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>