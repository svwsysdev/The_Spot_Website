<?php
    include("SessionStartScript.php");
    StartSession();
    $logout=isset($_POST["logout"])?$_POST["logout"]:"";
    if($logout=="Logout")
    {
        session_unset();
        session_destroy();
        header("Location: http://localhost/Login_Page.html?return=250");
        exit();
    }
    else
    {
        session_unset();
        session_destroy();
        header("Location: http://localhost/Login_Page.html?return=403");
        exit();
    }
?>