<?php
    include("Connect.php");
    include("SessionStartScript.php");
    try
    {
        StartSession();
        $conn = connectionFunc();
        $username = isset($_POST["username"])?$_POST["username"]:"";
        $password= isset($_POST["password"])? $_POST["password"]:"";
        $query = "SELECT * FROM profile_information WHERE idprofile_user = :userid ";
        $res = $conn->prepare($query);
        $res->bindParam(":userid",$UserId);
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $error=isset($_GET["return"])?"Password must match!!!": "";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn=NULL;
    }
    catch(PDOException $e) 
    {
    }
?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/Global.css">
    <title>The Spot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/js/ForgotPassword.js"></script>
</head>

<body >
    <div class="dividers">
        <div calss="inputemail">
            <h2>Please enter a new password!</h2>
            <hr>
            <form action="PasswordReset.php" name="submitreset" method="POST">
                <?php
                    echo $echoer=isset($_GET["return"])=="406"?"<p style=\"color:black;\">$error</p>":"";
                ?>
                <input 
                    class="loginInput" 
                    type="password" 
                    name="pword" 
                    placeholder="Password"  
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,})" 
                    required/>
                <br>
                <br>
                <input 
                    class="loginInput" 
                    type="password" 
                    placeholder="Confirm Password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,})" 
                    name="cpword" id="cpwordId" 
                    required/>
                <hr>
                <input class="loginInput" type="submit" value="Change Password">
            </form>
        </div>
    </div>
</body>

</html>