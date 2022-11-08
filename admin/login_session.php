<?php
   if(session_status() < 1){
    session_start();
   }
   if (isset($_SESSION["user_name"]) && isset($_SESSION["user_uname"]) && isset($_SESSION['date_created'])){
    
    if (time() - $_SESSION['date_created'] > 1800) {
        header("Location: /admin/logout");
     } 
   }else{
    header("Location: /admin");
   }  
   