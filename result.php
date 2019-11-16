<?php 
    require_once "includes/db_connect.php";
    //Insert into auction detail
    $productId = $_GET['id'];

    //Get previous owner of product
    $previousOwnerQuery = $conn->query("SELECT current_owner FROM Product WHERE productId = '$productId'")->fetch();
    $previousOwner = $previousOwnerQuery['current_owner'];

    //Get new owner of product
    $currentOwnerQuery = $conn->query("SELECT username, price_bidded
                                       FROM Bidding 
                                       WHERE productId = '$productId'
                                       AND price_bidded = (SELECT MAX(price_bidded)
                                                           FROM Bidding
                                                           WHERE productId = '$productId')")->fetch();
    $currentOwner = $currentOwnerQuery['username'];
    $amountPaid = $currentOwnerQuery['price_bidded'];

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

    header("Location: ProductsNew.php"); 
?>