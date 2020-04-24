<?php 
session_start();
$username=$_SESSION['username'];

require_once "db_connect.php";
//$productId = $_REQUEST['id'];
$productId = $_POST['id'];//Get product id
$rate = $_POST['rate'];//Get rate

$biddingQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
                              FROM Bidding 
                              WHERE productId = '$productId'")->fetch();

$price_bidded = $biddingQuery['price_bidded'];

if(empty($price_bidded)){
  $productQuery = $conn->query("SELECT start_price FROM Product WHERE productId = '$productId'")->fetch();
  $price_bidded = $productQuery['start_price'];
}

$price_bidded /= $rate;
$price_bidded = round($price_bidded, 2);


echo json_encode($price_bidded);
?>