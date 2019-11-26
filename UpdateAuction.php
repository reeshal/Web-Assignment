<?php 
session_start();
$username=$_SESSION['username'];

require_once "includes/db_connect.php";
$productId = $_REQUEST['id'];//Get product id

$biddingQuery = $conn->query("SELECT price_bidded
                              FROM Bidding 
                              WHERE productId = '$productId'
                              AND price_bidded = (SELECT MAX(price_bidded)
                                                  FROM Bidding
                                                  WHERE productId = '$productId') ")->fetch();

$price_bidded = $biddingQuery['price_bidded'];

if(empty($price_bidded)){
  $productQuery = $conn->query("SELECT start_price FROM Product WHERE productId = '$productId'")->fetch();
  $price_bidded = $productQuery['start_price'];
}


echo json_encode($price_bidded);
?>