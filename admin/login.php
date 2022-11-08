<?php
if (isset($_SESSION["user_name"]) && isset($_SESSION["user_uname"]) && isset($_SESSION['date_created'])){
  header("Location: /admin/dashboard");
 }  
include 'connection.php';

function checkUser($conn, $username){
  $query = "SELECT * FROM `auth_users` WHERE email = ? or username = ?";
  $check = $conn->prepare($query);
  $check->bind_param('ss', $username, $username);

  if($check->execute()){
  $data = $check->get_result();
  return $data->fetch_assoc();
  }  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <title>BOSCHMA | Login</title>
  <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
</head>
<body>

  <?php
  $message = "";
  if(isset($_POST['login'])){
    $username = $_POST['username'];
		$password = $_POST['password'];

  if(!empty($username) && !empty($password)){ 
    
    $user_data = checkUser($con, $username);

    if(!empty($user_data)){
        $name = $user_data['name'];
        $user = $user_data['username'];
        $user_image = $user_data['image_path'];
        $pswd = $user_data['passphrase'];

    if(password_verify($password, $pswd)){
        $_SESSION["user_name"] = $name;
        $_SESSION["user_uname"] = $user;
        $_SESSION["user_avatar"] = $user_image;
        $_SESSION['date_created'] = time();
        header("Location: /admin/dashboard");
    }else{
        $message = '<div class="alert alert-danger alert-dismissible" role="alert">
        Invalid Login details!
      </div>';
    }      
  }else{
    $message = '<div class="alert alert-danger alert-dismissible" role="alert">
        Invalid Login details!
      </div>';
  } 
 }
}

  ?>
  <div class="main_div">
    <div class="title">
        <img src="../img/logo2.png" alt="logo" srcset="">
    </div>
    <form action="/admin/login" method="post">
    <?php echo $message; ?>

      <div class="input_box">
        <input type="text" name="username" placeholder="Username or Email" required>
        <div class="icon"><i class="fas fa-user"></i></div>
      </div>
      <div class="input_box">
        <input type="password" name="password" placeholder="Password" required>
        <div class="icon"><i class="fas fa-lock"></i></div>
      </div>
      
      <div class="input_box button">
        <input type="submit" name="login" value="Login">
      </div>
      
    </form>
  </div>
  
  
</body>
</html>

