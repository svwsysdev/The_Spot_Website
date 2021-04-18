<?php
    include("SessionStartScript.php");
    StartSession();
    $username=isset($_POST["emailer"])? $_POST["emailer"]: "NAY";
    $_SESSION["email"]=$username;
    echo 
        "<!doctype html>
        <html lang=\"en\">
        <head>
        <meta charset=\"utf-8\">
        <link rel=\"stylesheet\" href=\"/css/Global.css\">
        <title>The Spot</title>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        </head>";
    echo
        "<body style=\"margin-top:20%;\">
        <div class=\"dividers\">
        <div calss=\"inputemail\">
        <h2>Email has been sent!!!</h2>
        <p >The email contains the instructions to reset your password.</p>
        <p >Page will automatically redirect in 10 seconds.</p>
        </div>
        </div>";
    echo
        "<script>
        setTimeout(function showreset()
        {window.location.href = \"http://localhost/php/ResetPword.php\";}
        ,10000); 
        </script>";
    echo
        "</body>";
    echo 
        "</html>";
?>