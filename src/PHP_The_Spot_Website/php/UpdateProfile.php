<?php
  include("Connect.php");
  include("SessionStartScript.php");
  StartSession();
  $UserId = $_SESSION["UserId"];
  $conn = connectionFunc();
  try
  {
    $name = isset($_POST["name"])? $_POST["name"]:"";
    $surname = isset($_POST["surname"])?$_POST["surname"]:"";
    $contactnumber = isset($_POST["contactnumber"])?$_POST["contactnumber"]:"";
    $birthday = isset($_POST["dateofbirth"])?$_POST["dateofbirth"]:"";
    $relationship = isset($_POST["relationship"])?$_POST["relationship"]:"";
    $gender = isset($_POST["Gender"])?$_POST["Gender"]:"";
    $ethnicity = isset($_POST["Ethnicity"])?$_POST["Ethnicity"]:"";
    $location = isset($_POST["location"])?$_POST["location"]:"";
    $bio = isset($_POST["bio"])?$_POST["bio"]:"";
    $private = isset($_POST["private"])?$_POST["private"]:"";
    if($private =="on")
    {
      $private=1;
    }
    else
    {
      $private=0;
    }
    $duplicateusercheck="SELECT*FROM profile_information WHERE idprofile_user = :name";
    $res = $conn->prepare($duplicateusercheck);
    $res->bindParam(":name",$UserId);
    $registerUserQuery=
    "UPDATE profile_information 
     SET Name='$name',
     Surname='$surname',
     Phone_Number='$contactnumber',
     Birthday='$birthday',
     Relationship_Status='$relationship',
     Gender='$gender',
     Ethnicity='$ethnicity',
     Bio='$bio',
     Location='$location',
     Private='$private' 
     WHERE idprofile_user=:name";
    $something = $conn->prepare($registerUserQuery);
    $something->bindParam(":name",$UserId);
    $something->execute();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn=NULL;
    header("Location: http://localhost/php/Profile_Page.php");
    exit();
  }
  catch(PDOException $e)
  {
    echo $e;
  }
?>