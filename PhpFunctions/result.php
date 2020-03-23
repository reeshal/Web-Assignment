<?php 
session_start();
$user=$_SESSION['username'];

    require_once "db_connect.php";
    //Insert into auction detail
   // $productId = $_GET['id'];
   $productId = $_POST['id'];//Get product id

    //Get previous owner of product
    $previousOwnerQuery = $conn->query("SELECT current_owner FROM Product WHERE productId = '$productId'")->fetch();
    $previousOwner = $previousOwnerQuery['current_owner'];

    //Getting current value of soldNotif
    $soldNotifQuery = $conn->query("SELECT soldNotif FROM Users WHERE username = '$previousOwner'")->fetch();
    $soldNotif = $soldNotifQuery['soldNotif'];

    //Setting value of soldNotif
    if(empty($soldNotif)){
      $soldNotif = $productId;
    }
    else{
      $soldNotif = $soldNotif . ',' . $productId;
    }

    //Adding id of product to sold notif field in seller to notify seller that bidding of product is over
    $update = "UPDATE Users
               SET soldNotif = '$soldNotif'
               WHERE username = '$previousOwner'";

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $Result =$conn->exec($update) ;

    //Get new owner of product
    $currentOwnerQuery = $conn->query("SELECT username, MAX(price_bidded) as price_bidded
                                       FROM Bidding 
                                       WHERE productId = '$productId'")->fetch();

    $currentOwner = $currentOwnerQuery['username'];
    $amountPaid = $currentOwnerQuery['price_bidded'];

    if($currentOwnerQuery){ //Checking if anyone has bidded on product first

      //Insert into auction detail
      $insert = "INSERT INTO AuctionDetail (current_owner, previous_owner, productId, amount_paid, date) 
      VALUES (". $conn->quote($currentOwner) .", ". $conn->quote($previousOwner) .",
      ". $conn->quote($productId) .", ". $conn->quote($amountPaid) .", current_timestamp()) ";

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      $Result =$conn->exec($insert) ;

      //Update owner of product
      $update = "UPDATE Product
          SET is_sold = 1, current_owner = ". $conn->quote($currentOwner) ."
          WHERE productId = '$productId'";

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      $Result =$conn->exec($update) ;

      //Delete bidding records of product
      $delete = "DELETE FROM Bidding WHERE productId = '$productId'";
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      $Result =$conn->exec($delete) ;
      
    }
    else{
      //Product is not sold and is removed from auction
      $update = "UPDATE Product
      SET is_sold = 1
      WHERE productId = '$productId'";

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      $Result =$conn->exec($update) ;

    }

?>
