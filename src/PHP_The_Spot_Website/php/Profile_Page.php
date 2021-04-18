<?php
    include("Connect.php");
    include("SessionStartScript.php");
    try{
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
        $conn = connectionFunc();
        $username = isset($_POST["username"])?$_POST["username"]:"";
        $password= isset($_POST["password"])? $_POST["password"]:"";    
        $viewingprofile = isset($_GET["viewprofile"])?$_GET["viewprofile"]:NULL;
        if($viewingprofile==NULL && $UserId !=NULL)
        {
            $query = "SELECT * FROM profile_information WHERE idprofile_user = :userid ";
            $res = $conn->prepare($query);
            $res->bindParam(":userid",$UserId);
            $res->execute();
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $_SESSION["Name"]=isset($row["Name"])?$row["Name"]:"";
            $_SESSION["Surname"]=isset($row["Surname"])?$row["Surname"]:"";
            $_SESSION["Phone_Number"]=isset($row["Phone_Number"])?$row["Phone_Number"]:"";
            $_SESSION["Birthday"]=isset($row["Birthday"])?$row["Birthday"]:"";
            $_SESSION["Relationship_Status"]=isset($row["Relationship_Status"])?$row["Relationship_Status"]:"";
            $_SESSION["Gender"]=isset($row["Gender"])?$row["Gender"]:"";
            $_SESSION["Ethnicity"]=isset($row["Ethnicity"])?$row["Ethnicity"]:"";
            $_SESSION["Bio"]=isset($row["Bio"])?$row["Bio"]:"";
            $_SESSION["Location"]=isset($row["Location"])?$row["Location"]:"";
            $_SESSION["Private"]=isset($row["Private"])?$row["Private"]:"";
            $_SESSION["Profile_Photo"]=isset($row["Profile_Photo"])?$row["Profile_Photo"]:"";
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn=NULL;
        }
        else if($viewingprofile!=NULL)
        {
            $query = "SELECT * FROM profile_information WHERE idprofile_user = :userid ";
            $res = $conn->prepare($query);
            $res->bindParam(":userid",$viewingprofile);
            $res->execute();
            $row = $res->fetch(PDO::FETCH_ASSOC);
            $_SESSION["Name"]=isset($row["Name"])?$row["Name"]:"";
            $_SESSION["Surname"]=isset($row["Surname"])?$row["Surname"]:"";
            $_SESSION["Phone_Number"]=isset($row["Phone_Number"])?$row["Phone_Number"]:"";
            $_SESSION["Birthday"]=isset($row["Birthday"])?$row["Birthday"]:"";
            $_SESSION["Relationship_Status"]=isset($row["Relationship_Status"])?$row["Relationship_Status"]:"";
            $_SESSION["Gender"]=isset($row["Gender"])?$row["Gender"]:"";
            $_SESSION["Ethnicity"]=isset($row["Ethnicity"])?$row["Ethnicity"]:"";
            $_SESSION["Bio"]=isset($row["Bio"])?$row["Bio"]:"";
            $_SESSION["Location"]=isset($row["Location"])?$row["Location"]:"";
            $_SESSION["Private"]=isset($row["Private"])?$row["Private"]:"";
            $_SESSION["Profile_Photo"]=isset($row["Profile_Photo"])?$row["Profile_Photo"]:"";
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn=NULL;
        }
    }
    catch(PDOException $e) 
    {
        echo $e;
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
        <li style="width:20%;"><a class="activeselected" href="/php/Profile_Page.php">Profile</a></li>
        <li style="width:20%;"><a class="active2" href="/php/Timeline.php">Timeline</a></li>
        <li style="width:20%;"><a class="active3" href="/php/Messaging.php">Chats</a></li>
        <li style="width:20%;"><a class="active4" href="/php/PeoplePage.php">People</a></li>
        <li style="width:20%;" class="sidenavr"><a class="activer" href="/php/SessionKillScript.php">Logout</a></li>
    </ul>
    <div class="wrapper flex">
        <div class="dividers" style="margin:10px; margin-top:7%; max-height:400px;">
            <div class="imagetag">
                <img style="border:ridge 10px #00bcd1; width:120px; height:120px;" src=
                        <?php 
                            isset($_SESSION["Profile_Photo"])?
                                 $profimg=$_SESSION["Profile_Photo"]
                                :$profimg=NULL;
                            $profimg!=NULL? 
                                 $imageprint="data:image/png;base64,$profimg"
                                :$imageprint="/images/Square_200x200.png"; 
                            echo $imageprint;
                        ?> 
                    />
            </div>
            <div style="margin-top:2%;">
                <form action="FileUploadScript.php" method="post" enctype="multipart/form-data">
                    <input class="loginInput" style="border:none;" name="upload" id="fileToUpload" type=
                        <?php
                            $viewingprofile!=NULL? $try = "hidden" : $try="File";
                            echo $try;
                            $viewingprofile!=NULL? $dis = " disabled " : $dis="";
                            echo $dis;
                        ?>
                    />
                    <input class="loginInput" type="submit" name="submit" value="Upload Photo" 
                        <?php 
                            if($viewingprofile!=NULL)
                            {
                                echo" style=\"display:none;\" ";
                                echo " disabled ";                        
                            }
                        ?>
                    />
                </form>
            </div>
            <div>
                <hr 
                    <?php 
                        if($viewingprofile!=NULL)
                        {
                            echo" style=\"display:none;\" ";
                            echo " disabled ";                        
                        }
                    ?>
                />
                <form action="Timeline.php" method="POST">
                    <input class="profilenav" type="submit" name="timeline" value="Timeline" 
                        <?php 
                            if($viewingprofile!=NULL)
                            {
                                echo " style=\"display:none;\" ";                       
                                echo " disabled ";                        
                            }
                        ?>
                    />
                </form>
                <form action="Messaging.php" method="POST">
                    <input class="profilenav" type="submit" name="messages" value="Messages" 
                        <?php 
                            if($viewingprofile!=NULL)
                            {
                                echo " style=\"display:none;\" ";                       
                                echo " disabled ";                        
                            }
                        ?>
                    />
                </form>
                <form action="SessionKillScript.php" method="POST">
                    <input class="profilenav" type="submit" value="Logout" name="logout" 
                        <?php 
                            if($viewingprofile!=NULL)
                            {
                                echo " style=\"display:none;\" ";
                                echo " disabled ";                        
                            }
                        ?>
                    />
                </form>
                <hr 
                    <?php 
                        if($viewingprofile!=NULL)
                        {
                            echo" style=\"display:none;\" ";
                            echo " disabled ";                        
                        }
                    ?>
                />
                <form action="ForgetPassword.php" method="POST">
                    <input class="profilenav" type="submit" value="Change Password" 
                        <?php 
                            if($viewingprofile!=NULL)
                            {
                                echo" style=\"display:none;\" ";
                                echo " disabled ";                        
                            }
                        ?>
                    />
                </form>
                <hr 
                    <?php 
                        if($viewingprofile!=NULL)
                        {
                            echo" style=\"display:none;\" ";
                            echo " disabled ";                        
                        }
                    ?>
                />
            </div>
        </div>
        <div class="wrapit" style="margin:10px; margin-top:7%; max-height:400px;">
            <form class="loginform" action="UpdateProfile.php" method="POST">
                <p style="font-size:medium; margin:0px;">Profile Information
                </p>
                <hr>
                <div class="leftaligner">
                    <label for="nameId">Name:                         
                    </label>
                </div>
                <div class="rightaligner">
                    <input class="profileinput" id="nameId" type="text" placeholder="Name" name="name" required
                        <?php 
                            $namname=$_SESSION["Name"];
                            if($viewingprofile==NULL && $UserId !=NULL)
                            {
                                echo "value='$namname'";
                            }
                            else if($viewingprofile!=NULL)
                            {
                                echo "value='$namname'";   
                                echo " disabled ";                        
                            }
                        ?>  
                    />
                </div>
                <div class="leftaligner">
                    <label for="surnameId">Surname:                       
                    </label>
                </div>
                <div class="rightaligner">
                    <input class="profileinput" id="surnameId" type="text" placeholder="Surname" name="surname" required 
                        <?php 
                            $surn=$_SESSION["Surname"];
                            if($viewingprofile==NULL && $UserId !=NULL)
                            {
                                echo "value='$surn'";
                            }
                            else if($viewingprofile!=NULL)
                            {                     
                                echo "value='$surn'";   
                                echo " disabled ";                        
                            }
                        ?> 
                    />
                </div>
                <div class="leftaligner">
                    <label for="contactnumberId">Phone No.                       
                    </label>
                </div>
                <div class="rightaligner">
                    <input class="profileinput" id="contactnumberId" type="text" placeholder="Contact Number" name="contactnumber" required 
                        <?php 
                            $pnum= $_SESSION["Phone_Number"];
                            if($viewingprofile==NULL && $UserId !=NULL)
                            {
                                echo "value='$pnum'";
                            }
                            else if($viewingprofile!=NULL)
                            {                       
                                echo "value='$pnum'";   
                                echo " disabled ";                        
                            }
                        ?>
                    />
                </div>
                <div class="leftaligner">
                    <label for="birthdayId">Birthday:                       
                    </label>
                </div>
                <div class="rightaligner">
                    <input class="profileinput" id="birthdayId" type="date" name="dateofbirth" 
                        <?php 
                            $bday= $_SESSION["Birthday"] ;
                            if($viewingprofile==NULL && $UserId !=NULL)
                            {                   
                                echo "value='$bday'";                       
                            }
                            else if($viewingprofile!=NULL)
                            {
                                echo "value='$bday'";   
                                echo " disabled ";  
                            }
                        ?> 
                    />
                </div>
                <div class="leftaligner">
                    <label for="birthdayId">Relationship:                        
                    </label>
                </div>
                <div class="rightaligner">
                    <select class="profileinput" name="relationship" 
                        <?php 
                            $bday= $_SESSION["Birthday"];
                            if($viewingprofile!=NULL)
                            {
                                echo " disabled ";                        
                            }
                        ?>
                    >
                        <option value="Select"<?php echo $_SESSION["Relationship_Status"] =="Select"?"selected":""; ?>>
                            Select
                        </option>
                        <option value="Single" <?php echo $_SESSION["Relationship_Status"]=="Single"?"selected":""; ?>>
                            Single
                        </option>
                        <option value="Married" <?php echo $_SESSION["Relationship_Status"] =="Married"?"selected":""; ?>>
                            Married
                        </option>
                        <option value="Complicated" <?php echo $_SESSION["Relationship_Status"] =="Complicated"?"selected":""; ?>>
                            It's Complicated
                        </option>
                    </select>
                </div>
                <div class="leftaligner">
                    <label for="birthdayId">Gender:                      
                    </label>
                </div>
                <div class="rightaligner">
                    <select class="profileinput" name="Gender" 
                        <?php 
                            $bday= $_SESSION["Birthday"];
                            if($viewingprofile!=NULL)
                            {
                                echo " disabled ";                        
                            }
                        ?>
                    >
                        <option value="Select" <?php echo $_SESSION["Gender"]=="Select"?"selected":""; ?>>
                            Select
                        </option>
                        <option value="Male" <?php echo $_SESSION["Gender"]=="Male"?"selected":""; ?>>
                            Male
                        </option>
                        <option value="Female" <?php echo $_SESSION["Gender"]=="Female"?"selected":""; ?>>
                            Female
                        </option>
                        <option value="Other" <?php  echo $_SESSION["Gender"]=="Other"?"selected":""; ?>>
                            Other
                        </option>
                    </select>
                </div>
                <div class="leftaligner">
                    <label for="birthdayId">Ethnicity:                        
                    </label>
                </div>
                <div class="rightaligner">
                    <select class="profileinput" name="Ethnicity" 
                        <?php 
                            $bday= $_SESSION["Birthday"];
                            if($viewingprofile!=NULL)
                            {
                                echo " disabled ";                        
                            }
                        ?>
                    >
                        <option value="Select" <?php echo $_SESSION["Ethnicity"]=="Select"?"selected":""; ?>>
                            Select
                        </option>
                        <option value="Black" <?php echo $_SESSION["Ethnicity"]=="Black"?"selected":""; ?>>
                            Black
                        </option>
                        <option value="Indian" <?php echo $_SESSION["Ethnicity"]=="Indian"?"selected":""; ?>>
                            Indian
                        </option>
                        <option value="White" <?php echo $_SESSION["Ethnicity"]=="White"?"selected":""; ?>>
                            White
                        </option>
                        <option value="Asian" <?php echo $_SESSION["Ethnicity"]=="Asian"?"selected":""; ?>>
                            Asian
                        </option>
                    </select>
                </div>
                <div class="leftaligner">
                    <label for="birthdayId">Location:                       
                    </label>
                </div>
                <div class="rightaligner">
                    <input class="profileinput" type="text" placeholder="Enter Location" name="location" id="locationId" required 
                        <?php 
                            $loc = $_SESSION["Location"] ;
                            if($viewingprofile==NULL && $UserId !=NULL)
                            {
                                echo "value='$loc'";
                            }
                            else if($viewingprofile!=NULL)
                            {
                                echo "value='$loc'";   
                                echo " disabled ";                        
                            }
                        ?> 
                    />
                </div>
                <hr style="width:100%; margin:1px;">
                <div class="leftaligner" style="text-align:left;">
                    <label for="birthdayId">Bio:       
                    </label>
                </div>
                <div class="leftaligner" style="width:100%;">
                    <textarea rows="4" style="resize:none;" class="profileinput" wrap="hard" name="bio" type="textarea" placeholder="Please enter your bio here"
                        <?php 
                            if($viewingprofile!=NULL)
                            {
                                echo "disabled";
                            }
                        ?> 
                    ><?php echo $_SESSION["Bio"]; ?>
                    </textarea>
                </div>
                <br />
                <br />
                <hr style="margin:1px;">
                <input class="loginInputBtn" type="submit" name="submit" value="Update Profile"
                    <?php 
                        if($viewingprofile!=NULL)
                        {
                            echo "disabled";
                        }
                    ?>
                >
            </form>
        </div>
    </div>
</body>

</html>