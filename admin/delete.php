<?php
session_start();
$user=$_SESSION['username'];
require_once "../includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["faqId"])){
        $faqId=$_POST["faqId"];
        $delStm="DELETE FROM FAQ WHERE faqId=$faqId";
        $delresult=$conn->query($delStm);
        if($delresult){
            echo 1;
            exit();
        }
        
    }
}

?>