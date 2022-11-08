<?php
$recent_post =  "SELECT * FROM posts ORDER BY createdAt DESC LIMIT 5 OFFSET 4";

$getRecent = $con->prepare($recent_post);
$getRecent->execute();
$r = $getRecent->get_result();
while($res = $r->fetch_assoc()){ 
?>
<div class="d-flex rounded overflow-hidden mb-3">
    <img class="img-fluid" src="../img/post/<?php echo $res['imagePath']; ?>" style="width: 100px; height: 100px; object-fit: cover;" alt="recent-image">
    <a href="/post/<?php echo $res['id']; ?>" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0"><?php echo $res['post_title']; ?>
    </a>
</div>
<?php
}
?>