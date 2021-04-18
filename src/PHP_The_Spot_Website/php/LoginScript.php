<?php
    try
    {
        include("Connect.php");
        include("SessionStartScript.php");
        StartSession();
        $conn = connectionFunc();
        $username = isset($_POST["username"])?$_POST["username"]:"";
        $password= isset($_POST["password"])? $_POST["password"]:"";
        $query = "SELECT * FROM user_logins WHERE Username = :name ";
        $res = $conn->prepare($query);
        $res->bindParam(":name",$username);
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $_SESSION["UserId"]= isset($row["idUser_Logins"])?$row["idUser_Logins"]:"";
        $pepper = "secret";
        if(isset($row["Password"])?true:false)
        {
            $pwd_hashed= $row["Password"];
            $pwd_peppered = hash_hmac("sha256", $password, $pepper);
            if (password_verify($pwd_peppered, $pwd_hashed)) 
            {
                header("Location: http://localhost/php/Profile_Page.php");
                exit();
            }
            else 
            {
                header("Location: http://localhost/Login_Page.html?return=401");
                exit();
            }
        }
        else
        {
            header("Location: http://localhost/Login_Page.html?return=401");
            exit();
        }
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
    }
?>