<?php
  try 
  {
    include("Connect.php");
    include("SessionStartScript.php");
    $conn = connectionFunc();
    $name = isset($_POST["name"])? $_POST["name"]:"";
    $surname = isset($_POST["surname"])?$_POST["surname"]:"";
    $email = isset($_POST["email"])?$_POST["email"]:"";
    $contactnumber = isset($_POST["contactnumber"])?$_POST["contactnumber"]:"";
    $passwordwopepper = isset($_POST["password"])?$_POST["password"]:"";
    $confirmpassword = isset($_POST["cpassword"])?$_POST["cpassword"]:"";
    $duplicateusercheck="SELECT*FROM user_logins WHERE Username = :name";
    $res = $conn->prepare($duplicateusercheck);
    $res->bindParam(":name",$email);
    $res->execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    StartSession();
    if(!$row)
    {
      $pepper = "secret";
      $pwd_peppered = hash_hmac("sha256", $passwordwopepper, $pepper);
      $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
      $registerUserQuery="INSERT INTO user_logins (Username,Password) VALUES (?,?)";
      $conn->prepare($registerUserQuery)->execute([$email, $pwd_hashed]);
      $last_id = $conn->lastInsertId();
      $_SESSION["UserId"]=   $last_id ;
      $registerUserQuery="INSERT INTO profile_information (Name,Surname,Phone_Number,idprofile_user) VALUES (?,?,?,?)";
      $conn->prepare($registerUserQuery)->execute([$name, $surname,$contactnumber,$last_id]);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn=NULL;
    }
    else
    {
      header("Location: http://localhost/Login_Page.html?return=403");
      exit();
    }
  header("Location: http://localhost/php/Profile_Page.php");
  exit();
  }
  catch(PDOException $e) 
  {
  }
?>