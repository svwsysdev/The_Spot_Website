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
        $_SESSION["Name"]=isset($row["Name"])?$row["Name"]:"";
        $_SESSION["Surname"]=isset($row["Surname"])?$row["Surname"]:"";
        $_SESSION["Phone_Number"]=isset($row["Phone_Number"])?$row["Phone_Number"]:"";
        $_SESSION["Birthday"]=isset($row["Birthday"])?$row["Birthday"]:"";
        $_SESSION["Relationship"]=isset($row["Relationship"])?$row["Relationship"]:"";
        $_SESSION["Gender"]=isset($row["Gender"])?$row["Gender"]:"";
        $_SESSION["Ethnicity"]=isset($row["Ethnicity"])?$row["Ethnicity"]:"";
        $_SESSION["Bio"]=isset($row["Bio"])?$row["Bio"]:"";
        $_SESSION["Location"]=isset($row["Location"])?$row["Location"]:"";
        $_SESSION["Private"]=isset($row["Private"])?$row["Private"]:"";
        $_SESSION["Profile_Photo"]=isset($row["Profile_Photo"])?$row["Profile_Photo"]:"";
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
    <p style="color:black;">Please Enter Your Registered Email Address.</p>
    <div calss="inputemail">
    <form action="EmailSent.php" name="submitreset" method="POST">
            <input class="inputemail" type="text" placeholder="E-Mail" name="emailer" required>
            <hr>
            <input class="profilenav" type="submit" value="Send Reset Password Link">
            </form>
    </div>
    </div>
</body>

</html>