<?php 
session_start();
$username=$_SESSION['username'];

require_once "db_connect.php";
//$productId = $_REQUEST['id'];
$productId = $_POST['id'];//Get product id

$biddingQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
                              FROM Bidding 
                              WHERE productId = '$productId'")->fetch();

$price_bidded = $biddingQuery['price_bidded'];

if(empty($price_bidded)){
  $productQuery = $conn->query("SELECT start_price FROM Product WHERE productId = '$productId'")->fetch();
  $price_bidded = $productQuery['start_price'];
}


echo json_encode($price_bidded);
?>