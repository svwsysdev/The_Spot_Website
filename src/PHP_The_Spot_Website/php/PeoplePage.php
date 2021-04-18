<?php
    include("Connect.php");
    include("SessionStartScript.php");
    StartSession();
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
?>

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
            <a class="active1" href="/php/Profile_Page.php">Profile
            </a>
        </li>
        <li style="width:20%;"> 
            <a class="active2" href="/php/Timeline.php">Timeline
            </a>
        </li>
        <li style="width:20%;">
            <a class="active3" href="/php/Messaging.php">Chats
            </a>
        </li>
        <li style="width:20%;">
            <a class="activeselected"  href="/php/PeoplePage.php">People
            </a>
        </li>
        <li style="width:20%;" class="sidenavr">
            <a class="activer" href="/php/SessionKillScript.php">Logout
            </a>
        </li>
    </ul>

    <div class="wrapper flex">
        <div class="dividers" style="margin:10px; margin-top:6%;">
            <div class="peoplewindow">
                <form style="width: 100%; text-align: center; " action="/php/PeoplePage.php" method="POST">
                    <div class="wrapper flex">
                        <div style="float:left; border:none;  margin:5px;  width :50%;">
                            <label style="width:50%;">Search:
                            </label>
                            <input type="textbox" style="width:50%;" name="searchstringy" />
                        </div>
                        <div style=" margin:5px;text-align: center; border:none;  float:left; width :50%;">
                            <input type="submit" style="width:100%;" name="searchpeople" value="Search" />
                        </div>
                    </div>

                    <?php
                        $conn = connectionFunc();
                        $searchstring= 
                        isset($_POST["searchstringy"])?'%'.$_POST["searchstringy"].'%':NULL; 
                        if($searchstring !=NULL)
                        {
                            $query = 
                                "SELECT * FROM profile_information 
                                 WHERE Name 
                                 LIKE :searchy 
                                 OR Surname 
                                 LIKE :searchy2 
                                 AND idprofile_user <> :userid";
                            $res = $conn->prepare($query);
                            $res->bindParam(':searchy',$searchstring);
                            $res->bindParam(':searchy2',$searchstring);
                            $res->bindParam(':userid',$UserId);
                            $res->execute();                
                        }
                        else
                        {
                            $query = 
                                "SELECT * FROM profile_information 
                                 WHERE idprofile_user <> :userid";
                            $res = $conn->prepare($query);
                            $res->bindParam(":userid",$UserId);
                            $res->execute();
                        }
                    $row = $res->fetchAll(PDO::FETCH_ASSOC);
                    foreach($row as $rowwer)
                    {
                        if($rowwer["idprofile_user"]!=$UserId)
                        {
                            $image = $rowwer['Profile_Photo'];
                            echo "<div class=\"cardyb\">";
                            echo "<div style=font-size:14px; flaot:left; width:50%;>";
                            $othuse=isset($rowwer["Name"])?$rowwer["Name"]:"";
                            $othusesurname =isset($rowwer["Surname"])?$rowwer["Surname"]:"";
                            $iduse=$rowwer["idprofile_user"];
                            echo"<a href=\"/php/Profile_Page.php?viewprofile=$iduse\">";                 
                            echo $othuse." ".$othusesurname;
                            echo"</a>";
                            echo "</div>";
                            $bioli=isset($rowwer["Bio"])?$rowwer["Bio"]:"";
                            echo "<div style=font-size:10px; display:inline-block; width:50%;>$bioli</div>";
                            echo "<div class=\"imagetag\" style=\" display:inline-block; text-align:center;  border-radius:50%; width:100%; \">";
                            if($image !=NULL)
                            {
                                echo "<img style=\"border:4px ridge lightskyblue; width:100px; height:100px;\"src=\"data:image/png;base64,$image\" />";
                            }
                            else
                            {
                                echo "<img style=\" border:4px ridge lightskyblue; width:100px; height:100px;\" src=\"/images/Square_200x200.png\" />";   
                            }                   
                            echo "</div>";
                            echo "<div>";
                            echo"<a href=\"/php/GetUserMessages.php?user=$iduse\">";
                            echo "<img title=\"Message User Page\" style=\"border:2px ridge lightskyblue; width:20px; height:20px; margin:5px;\" src=\"/images/blog-comment-speech-bubble-symbol-svgrepo-com.svg\" />";                
                            echo"</a>";
                            echo"<a href=\"/php/Profile_Page.php?viewprofile=$iduse\">";
                            echo "<img title=\"View Users Profile Page\" style=\"border:2px ridge lightskyblue; width:20px; height:20px; margin:5px;\" src=\"/images/iconmonstr-user-6.svg\" />";
                            echo"</a>";
                            echo"<a href=\"/php/Timeline.php?user=$iduse\">";
                            echo "<img title=\"View Users Timeline Page\" style=\"border:2px ridge lightskyblue; width:20px; height:20px; margin:5px;\" src=\"/images/indexing-pages.svg\" />";
                            echo"</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "<br/>"; 
                        }
                    }
                ?>

                </form>
            </div>
        </div>
    </div>
</body>

</html>