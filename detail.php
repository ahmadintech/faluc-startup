<?php include('admin/connection.php'); 

if(isset($page)){
//$page = $_GET['page'];
$query =  "SELECT * FROM posts WHERE id = $page";

$getPost = $con->prepare($query);
$getPost->execute();
$result = $getPost->get_result();
}else{
    header('Location: /bo/news');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<title>Faluc - Home</title>
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
.full-justify{
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
        <img class="img-fluid" src="img/logo2.png" alt="" srcset=""> <span class="fw-bold-xl">Faluc</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="/home" class="nav-item nav-link">Home</a>
            <a href="/about-us" class="nav-item nav-link">About</a>
            <a href="/blog" class="nav-item nav-link active">Blog</a>
            <a href="/contact-us" class="nav-item nav-link">Contact</a>
        </div>
    </div>
</nav>

<div class="container-fluid bg-primary py-5 bg-header2 d-sm-block d-none">
 
</div>
<!-- Navbar End -->

    <!-- Blog Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-8">
                <?php
                            while($row = $result->fetch_assoc()){ ?>
                    <!-- Blog Detail Start -->
                    <div class="mb-5">
                        <h1 class="mb-4"><?php echo $row['post_title'] ?></h1>
                        <img class="img-fluid w-100 rounded mb-5" src="../img/post/<?php echo $row['imagePath']; ?>" alt="image">
                        <div class="g2 mb-2">
                            <span class="text-danger"><i class="fa fa-calendar-alt me-2"></i><?php echo date('d F, Y', strtotime( $row['createdAt'])) ?></span> | <small>By Admin</small>
                        </div>

                        <p><?php echo $row['post_content'] ?></p>
                    </div>
                    <?php
                    };
                    ?>

                    <!-- Blog Detail End -->
    
                   
                    <!-- Comment Form Start -->
                    <div class="bg-light rounded p-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Leave A Comment</h3>
                        </div>
                        <form>
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <input type="text" class="form-control bg-white border-0" placeholder="Your Name" style="height: 55px;">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <input type="email" class="form-control bg-white border-0" placeholder="Your Email" style="height: 55px;">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control bg-white border-0" placeholder="Website" style="height: 55px;">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control bg-white border-0" rows="5" placeholder="Comment"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Leave Your Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Comment Form End -->
                </div>

                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Recent Post Start -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Recent Post</h3>
                        </div>
                        <?php
                        include_once("recent-post.html.php");
                        ?>
                    </div>
                    <!-- Recent Post End -->
    
                    <!-- Image Start -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <img src="img/blog-1.jpg" alt="" class="img-fluid rounded">
                    </div>
                    <!-- Image End -->
    
                    <!-- Tags Start -->

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