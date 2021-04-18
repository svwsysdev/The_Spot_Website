<?php
  try 
  {
    include("Connect.php");
    include("SessionStartScript.php");
    $conn = connectionFunc();
    StartSession();
    $UserId = "";
    isset($_SESSION["UserId"])?$UserId=$_SESSION["UserId"]:$UserId="";
    echo "This is the results for postinfo";
    echo "<br />";
    echo  $postinfo=isset($_POST["postinfo"])?$_POST["postinfo"]:"";
    echo "<br />";
    echo "This is the results for postupload";
    echo "<br />";
    if($_FILES['upload']['name']==NULL)
    {
      echo "not uploaded";
      $dater=date("Y-m-d");
      $registerUserQuery="INSERT INTO user_timeline (Timeline_Post,Post_Date,users_id) VALUES (?,?,?)";
      $conn->prepare($registerUserQuery)->execute([$postinfo, $dater , $UserId]);
    }
    else
    {
      echo "uploaded:    ";
      echo isset($_FILES['upload']['name'])?$_FILES['upload']['tmp_name']:NULL;
      $something = base64_encode(file_get_contents(isset($_FILES['upload']['tmp_name'])?$_FILES['upload']['tmp_name']:""));
      $dater=date("Y-m-d");
      $registerUserQuery="INSERT INTO user_timeline (Timeline_Post,Post_Date,Post_Photo,users_id) VALUES (?,?,?,?)";
      $conn->prepare($registerUserQuery)->execute([$postinfo, $dater, isset($something)?$something:null , $UserId]);
    }
  header("Location: http://localhost/php/Timeline.php");
  exit();
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn=NULL;
  }
  catch(PDOException $e) 
  {
    echo $e;
  }
?>