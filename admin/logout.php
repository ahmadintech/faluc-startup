<?php
   session_start();
   unset($_SESSION["user_name"]);
   unset($_SESSION["user_uname"]);
   unset($_SESSION["date_created"]);
   unset($_SESSION["user_avatar"]);
   header('Location: /admin');
?>