<?php
  function connectionFunc()
  {
    try 
    {
      $servername = "localhost";
      $username = get_cfg_var("db.User");
      $password = get_cfg_var("db.Pass");
      $conn = new PDO("mysql:host=$servername;dbname=internetprogramming622"
      , $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    }
    catch(PDOException $e) 
    {
      echo "Connection failed, Oops something went wrong!";
    }
  }
?>