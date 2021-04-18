<?php
    include("Connect.php");
    include("SessionStartScript.php");
    $conn = connectionFunc();
    StartSession();
    $UserId = "";
    isset($_SESSION["UserId"])?$UserId=$_SESSION["UserId"]:$UserId="";
    $UserIdsentto = "";
    if(isset($_GET["user"]))
    {
        isset($_SESSION['otheruser'])?$UserIdsentto=$_GET["user"]:"";
    }
    if(isset($_SESSION['otheruser']))
    {
        isset($_SESSION['otheruser'])?$UserIdsentto=$_SESSION['otheruser']:$UserIdsentto="";
        $message=isset($_POST["message"])?$_POST["message"]:"Hello there";
    }
    if($UserIdsentto!=NULL && $UserId!=NULL)
    {
        $dater=date("Y-m-d");
        $registerUserQuery="INSERT INTO user_messages (User_Message,Date,Sent_By,Sent_To) VALUES (?,?,?,?)";
        $conn->prepare($registerUserQuery)->execute([$message, $dater , $UserId,$UserIdsentto]);
    }
    else
    {
        header("Location: http://localhost/php/Messaging.php?return=404",false);
        exit; 
    }
    header("Location: http://localhost/php/Messaging.php",false);
    exit;  
?>