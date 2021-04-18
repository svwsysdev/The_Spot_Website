<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/Global.css">
    <title>The Spot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <ul class="sidenav" style="width:100%;">
        <li style="width:20%;">
            <a class="active1"  href="/php/Profile_Page.php">Profile
            </a>
        </li>
        <li style="width:20%;">
            <a class="activeselected" href="/php/Timeline.php">Timeline
            </a>
        </li>
        <li style="width:20%;">
            <a class="active3" href="/php/Messaging.php">Chats
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
    <div class="container42">
        <div class="wrapper flex">
            <div class="dividers"style="margin:10px; margin-top:4%;">
                <h2>Timeline</h2>
                <hr>
                <div>
                    <?php
                        include("Connect.php");
                        include("SessionStartScript.php");
                        $conn = connectionFunc();
                        StartSession();
                        $UserId = "";
                        if(isset($_SESSION["UserId"]) && !isset($_GET["user"]))
                        {
                            $UserId=$_SESSION["UserId"];
                        }
                        else if(isset($_GET["user"]))
                        {
                            $UserId=$_GET["user"];
                        }
                        else
                        {
                            header("Location: http://localhost/Login_Page.html?return=400");
                            exit();
                        }
                        $query = "SELECT * FROM user_timeline WHERE users_id = :userid ORDER BY iduser_timeline DESC";
                        $res = $conn->prepare($query);
                        $res->bindParam(":userid",$UserId);
                        $res->execute();
                        $row = $res->fetchAll(PDO::FETCH_ASSOC);
                        foreach($row as $rowwer)
                        {
                            $photo=$rowwer["Post_Photo"];
                            echo "<div class=\"card\" style=\"border:3px ridge lightgray; border-radius:10px;\">";
                            if($photo !=null)
                            {
                                echo  "<img style=\"border:ridge 2px #00bcd1;  margin-top: 5px; border-radius: 0%;  width:170px; height:170px;\"
                                src=\"data:image/png;base64,$photo\" />";
                            }
                            echo "<div class=\"card\">";
                            echo $rowwer['Timeline_Post'];
                            echo "</div>";
                            echo "</div>";
                            echo "<hr>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="item shark-3">
        <form action="PostScript.php" method="post" enctype="multipart/form-data" style="position:sticky;">
            <input class="postinput" id="postId" type="text" placeholder="Post" name="postinfo" <?php if(isset($_GET["user"])){echo" disabled ";}?> required />
            <br>
            <br>
            <input class="loginInput" style="border:none;" type="file" name="upload" <?php if(isset($_GET["user"])){echo" disabled ";}?> id="fileToUpload">
            <br>
            <br>
            <input class="loginInput" type="submit" name="submit" <?php if(isset($_GET["user"])){echo" disabled ";}?> value="POST">    
            <hr>
        </form>
    </div>
</body>

</html>