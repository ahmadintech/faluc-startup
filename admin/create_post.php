<?php
require_once('login_session.php');
require_once('connection.php');

if (isset($_POST['post'])) {

    $title = htmlspecialchars(strip_tags($_POST['title']));
    $content = $_POST['content'];

    if(!empty(trim($title)) && !empty(trim($content))){
      
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
            if(in_array(strtolower($file_ext),$expensions)=== false){
               $errors[]="extension not allowed, please choose a JPEG or PNG file";
            }
        
            if($file_size > 2097152){
               $errors[]='File is too large';
            }
            if(empty($errors)==true){
            $uploadfile = 'IMG'.time().rand(100000, 9999999).".".$file_ext;
              move_uploaded_file($file_tmp,"img/post/".$uploadfile);

              

              $sql = "INSERT INTO `posts`(`post_title`, `post_content`, `imagePath`) VALUES (?,?,?)";
              $creat_post = $con->prepare($sql);
              $creat_post->bind_param('sss', $title, $content, $uploadfile);
              if($creat_post->execute()){
                header("Location: /admin/manage");  
              }
            }
            else{
               header("Location: /admin/create");
            }
         }else{
            header("Location: /admin/create"); 
         }

         
    }else{
        header("Location: /admin/create");
    }
}else{
   // header("Location: post.php");  
}
?>