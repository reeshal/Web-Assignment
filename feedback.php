<?php
require_once "includes/db_connect.php";

//Getting value of feedbackNotif
$feedbackNotifQuery = $conn->query("SELECT feedbackNotif FROM Users WHERE username = '$user'")->fetch();
$feedbackNotif = $feedbackNotifQuery['feedbackNotif'];

if(!empty($feedbackNotif)){//Checking if a feedback is received
    $str_arr = explode(",", $feedbackNotif); //Seperate feedbackNotif string into array
    
    foreach($str_arr as $id) {
        $productQuery = $conn->query("SELECT * FROM Product WHERE productId = '$id'")->fetch();
        $name = $productQuery['name'];
        $feedback = $productQuery['feedback'];

      /*  echo "<div id=\"modal\" class=\"modal\">
          <div class=\"container\">
            <h3>You got a feedback of product $name that you sold</h3>
            <span onclick=\"document.getElementById('modal-feedback').style.display='none' \" class=\"close\" title=\"Close PopUp\">&times;</span>
            <p class=\"form-control\">$feedback</p>
            <input type=\"submit\" value=\"Ok\" name=\"ok\"/>
          </div>
      </div>";*/

      echo "<script>alert(\"You got a feedback of product $name that you sold. $feedback\");</script>";
       
    }

    //Set soldNotif to null
    $update = "UPDATE Users
               SET feedbackNotif = ''
               WHERE username = '$user'";

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $Result =$conn->exec($update) ;
}

?>