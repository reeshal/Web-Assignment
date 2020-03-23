<?php
/*session_start();
$username=$_SESSION['username'];*/
require_once "includes/db_connect.php";

if($user !=""){
//Getting value of soldNotif
$soldNotifQuery = $conn->query("SELECT soldNotif FROM Users WHERE username = '$user'")->fetch();
$soldNotif = $soldNotifQuery['soldNotif'];

if(!empty($soldNotif)){//Checking if the bidding of a product is over
    $str_arr = explode(",", $soldNotif); //Seperate soldNotif string into array
    
    foreach($str_arr as $id) {
        $productQuery = $conn->query("SELECT name, current_owner FROM Product WHERE productId = '$id'")->fetch();
        $name = $productQuery['name'];
        $current_owner = $productQuery['current_owner'];
        
        if($current_owner == $user){ //Product not sold
            echo "<script>alert(\"The product $name has not been sold\");</script>";
        }
        else{ //Product sold

            //storing the selling notiff in Notification table so that user can view all later
            $notiffdetail="The product $name has been sold";
            $insertStmt= "INSERT INTO Notifications(notiffDetails,username)
                        VALUES('$notiffdetail','$user')";
            $resultnotiff=$conn->exec($insertStmt);

            echo "<script>alert(\"The product $name has been sold\");</script>";
        }
    }

    //Set soldNotif to null
    $update = "UPDATE Users
               SET soldNotif = ''
               WHERE username = '$user'";

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $Result =$conn->exec($update) ;
}
}
?>