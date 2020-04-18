<?php 
session_start();
$username=$_SESSION['username'];

require_once "db_connect.php";
//$productId = $_REQUEST['id'];
$productId = $_POST['id'];//Get product id
$FromCurrency = $_POST['fromCurrency'];//Get fromCurrency
$ToCurrency = $_POST['toCurrency'];//Get toCurrency

$biddingQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
                              FROM Bidding 
                              WHERE productId = '$productId'")->fetch();

$price_bidded = $biddingQuery['price_bidded'];

if(empty($price_bidded)){
  $productQuery = $conn->query("SELECT start_price FROM Product WHERE productId = '$productId'")->fetch();
  $price_bidded = $productQuery['start_price'];
}

//Currency conversion if necessary
if($FromCurrency != $ToCurrency) {
  $FromCurrency = urlencode($FromCurrency);
  $ToCurrency = urlencode($ToCurrency);	
  $encode_amount = 1;
  $url  = "https://www.google.com/search?q=".$FromCurrency."+to+".$ToCurrency;
  $get = file_get_contents($url);
  $data = preg_split('/\D\s(.*?)\s=\s/',$get);
  $exhangeRate = (float) substr($data[1],0,7);
  $price_bidded = $price_bidded*$exhangeRate;
}


echo json_encode($price_bidded);
?>
