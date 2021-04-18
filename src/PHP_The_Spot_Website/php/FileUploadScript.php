<?php 
  include("Connect.php");
  include("SessionStartScript.php");
  StartSession();
  $UserId = $_SESSION["UserId"];
  $conn = connectionFunc();
  if(isset($_REQUEST['submit'])&& !empty($_FILES['upload']['tmp_name']))
  {
    try
    {
      $something = base64_encode(
        file_get_contents(
          isset($_FILES['upload']['tmp_name'])?$_FILES['upload']['tmp_name']:""));
      $registerUserQuery="UPDATE profile_information SET Profile_Photo='$something' WHERE idprofile_user=:name";
      $something = $conn->prepare($registerUserQuery);
      $something->bindParam(":name",$UserId);
      $something->execute();
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conn=NULL;
      header("Location: http://localhost/php/Profile_Page.php");
      exit();
    }
    catch(Exception $e)
    {
    }
  }
  else
  {
    header("Location: http://localhost/php/Profile_Page.php");
    exit();
  }
?>