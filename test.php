<?php 
session_start();
$user=$_SESSION['username'];

require_once "includes/db_connect.php";
$productId = $_GET['id'];//Get product id
$username =$user; 

$biddingQuery = $conn->query("SELECT username
                              FROM Bidding
                              WHERE productId = '$productId'
                              AND price_bidded = (SELECT MAX(price_bidded)
                                                  FROM Bidding
                                                  WHERE productId = '$productId') ")->fetch();

$currentWinner = $biddingQuery['username'];

//Deciding which button Bid or Cancel bid to display
if(empty($biddingQuery) || $currentWinner != $username){
  $isBid = true;
}
else if($currentWinner == $username){
  $isBid = false; //to delete
}
?>