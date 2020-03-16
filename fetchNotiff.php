<?php
session_start();
$user=$_SESSION['username'];


require_once "includes/db_connect.php";
$query="SELECT notiffDetails FROM Notifications WHERE username='$user'";
$data  =$conn->query($query) ;
$result = $data->fetchAll(PDO::FETCH_ASSOC);
if(!$result){
    echo "No notifications";
}
else{
    foreach($result as $output) {
        $notif = $output["notiffDetails"];
        echo "<li>$notif</li>";
    }
}

?>