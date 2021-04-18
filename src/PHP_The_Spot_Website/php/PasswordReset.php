<?php
    include("Connect.php");
    include("SessionStartScript.php");
    try
    {
        StartSession();
        $conn = connectionFunc();
        $username = isset($_SESSION["email"])?$_SESSION["email"]:"";
        $passwordwopepper = isset($_POST["pword"])?$_POST["pword"]:"";
        $confirmpassword = isset($_POST["cpword"])?$_POST["cpword"]:"";
        if($passwordwopepper==$confirmpassword)
        {
            $pepper = "secret";
            $pwd_peppered = hash_hmac("sha256", $passwordwopepper, $pepper);
            $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
            $registerUserQuery="UPDATE user_logins SET Password='$pwd_hashed' WHERE Username=:name";
            $something = $conn->prepare($registerUserQuery);
            $something->bindParam(":name",$username);
            $something->execute();  
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn=NULL;
            header("Location: http://localhost/Login_Page.html?return=200");
            exit();
        }
        else
        {
            header("Location: http://localhost/php/ResetPword.php?return=406");
            exit();
        }
    }
    catch(PDOException $e) 
    {
    }
    $_SESSION["email"]=isset($row["Username"])?$row["Username"]:"";
?>