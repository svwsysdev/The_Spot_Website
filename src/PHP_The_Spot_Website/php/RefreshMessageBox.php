<?php
  include("Connect.php");
  include("SessionStartScript.php");
  $conn = connectionFunc();
  StartSession();
  $UserId = "";
  if(isset($_SESSION["UserId"]))
  {
    $UserId=$_SESSION["UserId"];
  }          
  $otheruse=isset($_SESSION['otheruser'])?$_SESSION['otheruser']:"";
  if($otheruse!="")
  {
    $query = 
    "SELECT * FROM user_messages  
     WHERE Sent_To 
     IN ($UserId,$otheruse)   
     AND  Sent_By 
     IN ($UserId,$otheruse) 
     ORDER BY iduser_messages" ;
    $res = $conn->prepare($query);
    $res->execute();
    $row = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach($row as $rowwer)
    {
      $usermes=isset($rowwer["User_Message"])?$rowwer["User_Message"]:" ";
      if($rowwer["Sent_To"]==$UserId && $usermes !=null)
      {  
          echo "<div style=\"height:auto;margin-top:20px; \"><p class=\"chatshadel\" >$usermes</p></div>";
      }
      else if($rowwer["Sent_By"]==$UserId)
      {
        echo "<div ><p class=\"chatrightlabel\">You</p><p class=\"chatshader\">$usermes</p></div>";
      }
    }
  }
?>