<?php
require_once "db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_POST["username"])){
    $username=$_POST["username"];
    $stmt="DELETE FROM Notifications WHERE username='$username'";
    $result=$conn->exec($stmt);
    if($result>=1){
        echo "Notifications Cleared";
    }
    else{
        echo "Nothing to clear";
    }
}

?>