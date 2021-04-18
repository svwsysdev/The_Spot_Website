<?php
  include("Connect.php");
  include("SessionStartScript.php");
  $conn = connectionFunc();
  StartSession();
  $_SESSION["otheruser"]=isset( $_GET['user'])? $_GET['user']:"";
  header("Location: http://localhost/php/Messaging.php",false);
  exit;        
?>