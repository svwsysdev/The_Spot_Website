<?php
    include("Connect.php");
    include("SessionStartScript.php");
    $conn = connectionFunc();
    StartSession();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/Global.css">
    <title>The Spot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" type="text/javascript"></script>
</head>

<body>
    <ul class="sidenav" style="width:100%;">
        <li style="width:20%;">
            <a class="active1" href="/php/Profile_Page.php">Profile
            </a>
        </li>
        <li style="width:20%;">
            <a class="active2" href="/php/Timeline.php">Timeline
            </a>
        </li>
        <li style="width:20%;">
            <a class="activeselected" href="/php/Messaging.php">Chats
            </a>
        </li>
        <li style="width:20%;">
            <a class="active4" href="/php/PeoplePage.php">People
            </a>
        </li>
        <li style="width:20%;" class="sidenavr">
            <a class="activer" href="/php/SessionKillScript.php">Logout
            </a>
        </li>
    </ul>

    <div class="wrapper flex">
        <div class="dividers" style="margin:10px; margin-top:6%; overflow:scroll; max-height:405px">
            <h2 style="font-size:large; text-align:center">Contacts</h2>

            <?php
                $UserId = "";
                if(isset($_SESSION["UserId"]))
                {
                    $UserId=$_SESSION["UserId"];
                }          
                else
                {
                    header("Location: http://localhost/Login_Page.html?return=400");
                    exit();
                }
                $query =
                    "SELECT b.idprofile_user,b.Name,b.Surname,b.Profile_Photo 
                     FROM user_messages a 
                     INNER JOIN profile_information b 
                     ON a.Sent_To = b.idprofile_user 
                     WHERE Sent_By = $UserId
                     UNION 
                     SELECT b.idprofile_user,b.Name,b.Surname,b.Profile_Photo 
                     FROM user_messages a 
                     INNER JOIN profile_information b 
                     ON a.Sent_By = b.idprofile_user 
                     WHERE  Sent_To = $UserId ";
                $res = $conn->prepare($query);
                $res->execute();                   
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                foreach($row as $rowwer)
                {
                    $userother=$rowwer["Name"]." ".$rowwer["Surname"];                   
                    $userotherId=$rowwer["idprofile_user"];
                    $stringmage="";
                    if(isset($rowwer["Profile_Photo"]))
                    {
                        $projam= $rowwer["Profile_Photo"];
                        $stringmage="src=\"data:image/png;base64,$projam\"";
                    }
                    else
                    {
                        $stringmage= "src=\"/images/Square_200x200.png\"";
                    }
                    if($userother !=null)
                    {
                        echo "<form  action='GetUserMessages.php?user=$userotherId' method='POST'>";
                        echo "<div class=\"chatshadec\" style=\" text-align:left; \">";
                        echo "<img style=\" width:60px; height:60px;\" $stringmage />";   
                        echo  "<input type='submit' class=\"chatshadebtn\" value='$userother' name='getmessages'/>";                          
                        echo "</div>";
                        echo "</form>";
                    }
                }                  
            ?>
            
        </div>
        <div class="wrapit" style="max-width:100; margin-top:6%; color:black; max-height:405px">
            <h2 style="font-size:large; text-align:center">Chat</h2>
            <div id="screen" class="chatwindow">
            </div>
            <form action="SendMessage.php" method="POST">
                <div class="chatcontainer">
                    <p style="font-size:10px;">You are chatting to 
                    
                        <?php
                            $nooneselected=isset($_GET["return"])?$_GET["return"]:NULL;
                            if($nooneselected != NULL && $nooneselected =="404"){ echo "<p>You have not selected anyone!!!</p>"; }
                            $some=isset( $_SESSION["otheruser"])?$_SESSION["otheruser"]:"";
                            $query = "SELECT * FROM profile_information WHERE idprofile_user = :userid";
                            $res = $conn->prepare($query);
                            $res->bindParam(":userid",$some);
                            $res->execute();               
                            $row = $res->fetchAll(PDO::FETCH_ASSOC);
                            foreach($row as $rowwer)
                            {
                                $someonesname = $rowwer['Name']." ". $rowwer['Surname'];
                                echo $someonesname;
                            }
                        ?> 
                      
                    </p>
                    <input 
                        class="postinput" 
                        id="messageId" 
                        type="text" 
                        pattern=".*\S+.*" 
                        placeholder="Message" 
                        name="message" 
                        required />
                    <br>
                    <br>
                    <input class="loginInput" type="submit" name="submit" value="Send Message">
                </div>
            </form>
        </div>
    </div>

<?php
    echo 
        "<script>
            setInterval(function() { 
                $('#screen').load('RefreshMessageBox.php'); 
                var scrollDiv = document.getElementById(\"screen\");
                scrollDiv.scrollTop = scrollDiv.scrollHeight;
            },1000); 
        </script>";
?>

</body>

</html>