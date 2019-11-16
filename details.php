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



if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (!empty($_POST["tags"]))
    $search=test_input($_POST["tags"]);

  if (!empty($_POST["category"]))
    $category=test_input($_POST["category"]);

    if($isBid){
      $isBid = false;

      //Insert bidding
      require_once "includes/db_connect.php";
      

      //query start price
      $startPriceQuery = $conn->query("SELECT start_price FROM Product WHERE productId = '$productId' LIMIT 1")->fetch();
      $startPrice =  $startPriceQuery['start_price'];

      //query last bidded price
      $lastBidPriceQuery = $conn->query("SELECT MAX(price_bidded) AS max FROM Bidding WHERE productId = '$productId' LIMIT 1")->fetch();
      $lastBidPrice =  $lastBidPriceQuery['max'];

      //calculate new bidded price
      if(empty($lastBidPrice)){
        $lastBidPrice = $startPrice;
      }
      $newBid = (0.1 * $startPrice) + $lastBidPrice;

      //querying if user already bidded
      $query = $conn->query("SELECT price_bidded FROM Bidding WHERE productId = '$productId' AND username = '$username'")->fetch();
      

      if(empty($query['price_bidded'])){
      $insert = "INSERT INTO Bidding(username, productId, price_bidded, time_bidded) 
                VALUES (". $conn->quote($username) .",  ". $conn->quote($productId) .", ". $conn->quote($newBid) .", current_timestamp())";
      
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      $Result =$conn->exec($insert) ;
      }
      else{
          $update = "UPDATE Bidding
                    SET price_bidded = ". $conn->quote($newBid) .", time_bidded = current_timestamp()
                    WHERE username = '$username' AND productId = '$productId'";
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
          $Result =$conn->exec($update) ;
      }
    }
    else{
      $isBid = true;

      //Delete bidding record if user cancels bid
      $delete = "DELETE FROM Bidding
                 WHERE username = '$user'
                 AND productId = '$productId'";

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      $Result =$conn->exec($delete) ;
    }

   header("Location: details.php?id=$productId"); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Detail</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/rangeslider.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="includes/productsRishikesh.css">

</head>

<body>
<div class="site-wrap">
	<!--Start of header-->
    <header class="site-navbar py-2 bg-white" role="banner">
      <div class="container">
        <div class="row align-items-center"> <!--creating a row to insert the header-->
          <div class="col-3">
            <nav class="site-navigation position-relative text-left " style="margin-left: -100px" role="navigation">
               <ul class="site-menu js-clone-nav ">
                <li class="has-children">
                  <span><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="MyProfile.html">My Profile</a></li>
                      <li><a href="MyProducts.php">My Products</a></li>
                      <li><a href="MyBiddings.php">My Biddings</a></li>
                      <li><a href="homepage.php">Logout</a></li>
                  </ul>
                </li>
                </ul>
              </nav>
          </div>
          <div class="col-9 ">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="homepage.php?referer=login"><span>Home</span></a></li>
                <li class="active"><a href="ProductsNew.php?referer=login"><span>Products</span></a></li>
                <li><a href="#about-section"><span>About Us</span></a></li>
                <li><a href="blog.html"><span>FAQ</span></a></li>
                <li><a href="#contact-section"><span>Contact</span></a></li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>  
    </header>
    <!--End of header-->


	<div class="row" style="padding-left:100px; padding-top:75px;">
		<?php
		require_once "includes/db_connect.php";
		$id = $_GET['id'];
		$query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category, p.start_time, p.end_time
		          FROM Product p, ProductImage i 			
		          where p.productId = i.prodId 
			         AND p.productId = '$id'";
		$output  =$conn->query($query)->fetch();

		$queryBidding = "SELECT MAX(price_bidded) AS max FROM Bidding WHERE productId = '$id' LIMIT 1";
		$bid = $conn->query($queryBidding)->fetch();
		
			$name =  $output["name"];
			$imageName = $output["imageName"];
			$start_price = $output["start_price"];
			$end_time = $output["end_time"];
			$biddingPrice = $bid["max"];

			if(empty($biddingPrice)){
				$biddingPrice = $start_price;
			}
			echo "  <div class=\"grid-container\">
				  <div class=\"grid-item\">
				    <h1>$name</h1><br>
				    <img src=\"http://localhost/Assignment/images/$imageName\" width=\"500px\" height=\"500px\"/>
				  </div>

				  <div class=\"grid-item\" style=\"padding-top:75px;\">
				    <form method=\"post\">
              <div class=\"grid-container\">
                <div class=\"grid-item\" style=\"padding-top:10px;\">
                Final sales price :
                </div>

                <div class=\"grid-item\">
                <div style=\"font-size : 30px;\">Rs $biddingPrice</div>
                </div>
              </div>

              <div class=\"grid-container\">
                <div class=\"grid-item\" style=\"padding-top:10px;\">
                Time left :
                </div>

                <div class=\"grid-item\">
                  <center id=\"demo\" class=\"timer\" style=\"font-size : 30px;\"></center> 
                </div>
              </div>";
              
              if($isBid){
                echo "<center><input type=\"submit\" class=\"gridbtn btn-success\" value=\"Bid\"></center>";
              }
              else{
                echo "<center><input type=\"submit\" class=\"gridbtn btn-danger\" value=\"Cancel Bid\" ></center>";
              }
              


              echo "</form>
						
				 </div>
        </div>";
        
	?>
	</div>

</div>

<script type="text/javascript"> 
		var end_time = "<?php echo $end_time ?>";
    console.log("end_time : " , end_time);
		var deadline = new Date(end_time).getTime(); 
		var x = setInterval(function() { 
		var now = new Date().getTime(); 
		var t = deadline - now; 
		var days = Math.floor(t / (1000 * 60 * 60 * 24)); 
		var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
		var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)); 
		var seconds = Math.floor((t % (1000 * 60)) / 1000); 
		if(days == 0){
			document.getElementById("demo").innerHTML = hours + ":" + minutes + ":" + seconds ; 
		}
		else{
			document.getElementById("demo").innerHTML = days + " day "  
			+ hours + ":" + minutes + ":" + seconds ; 
		}
		document.getElementById("demo").style.color = "red";
		
		    if (t < 0) { 
          clearInterval(x); 
          document.getElementById("demo").innerHTML = "EXPIRED"; 
          var productId = "<?php echo $id ?>";
          console.log("productId : " , productId);
    
         var xhttp = new XMLHttpRequest();
         xhttp.open("GET", "result.php?id="+productId, true);
         xhttp.send();  
         return false;
		    } 
		}, 1000); 

    function changeButton(){

    }
</script>

   

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/rangeslider.min.js"></script>
  <script src="js/main.js"></script>

<body>
</html>
