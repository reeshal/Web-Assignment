<?php
session_start();
$user=$_SESSION['username'];

require_once "PhpFunctions/db_connect.php";
$productId = $_GET['id'];//Get product id
$username =$user; 

//Getting FromCurrency of seller
$FromCurrencyQuery = $conn->query("SELECT c.code as code
FROM Users u, Product p, Currency c
WHERE u.username = p.current_owner
AND u.currency = c.currency
AND p.productId = '$productId'")->fetch();
               
$FromCurrency = $FromCurrencyQuery['code'];

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

//Getting currency of user
$ToCurrencyQuery = $conn->query("SELECT c.code as code, c.conversion_rate as rate
                                   FROM Users u, Currency c
                                   WHERE u.currency = c.currency
                                   AND username = '$user'")->fetch();
                                                           
  $ToCurrency = $ToCurrencyQuery['code'];
  $rate = $ToCurrencyQuery['rate'];

  //Setting Currency Symbol
  $locale='en-US'; //browser or user locale
  $fmt = new NumberFormatter( $locale."@currency=$ToCurrency", NumberFormatter::CURRENCY );
  $symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);



if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (!empty($_POST["tags"]))
    $search=test_input($_POST["tags"]);

  if (!empty($_POST["category"]))
    $category=test_input($_POST["category"]);

    if($isBid){
      $isBid = false;

      //Insert bidding
      require_once "PhpFunctions/db_connect.php";
      
      //query bidded price
      $newBid  = $_POST["BiddingPrice"];

      //querying if user already bidded
      $query = $conn->query("SELECT price_bidded FROM Bidding WHERE productId = '$productId' AND username = '$username'")->fetch();
      

      $newBid *= $rate; 

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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/productsRishikesh.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
                <li><a href="ContactUs.php?referer=login"><span>Contact</span></a></li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>  
    </header>
    <!--End of header-->


	<div class="row" style="padding-left:100px; padding-top:75px;">
		<?php
		require_once "PhpFunctions/db_connect.php";
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


      $biddingPrice /= $rate;
      $biddingPrice = round($biddingPrice, 2);

			echo "  <div class=\"grid-container\">
				  <div class=\"grid-item\">
				    <h1>$name</h1><br>
				    <img src=\"http://localhost/Web-Assignment/images/$imageName\" width=\"500px\" height=\"500px\"/>
				  </div>

				  <div class=\"grid-item\" style=\"padding-top:75px;\">
				    <form method=\"post\">
                <div  style=\"padding-top:10px;\">";
                if($isBid){
                  echo "Enter Bidding Price (should be higher than the price shown) :";
                }
                else{
                  echo "<center><b>You are currently the highest bidder</b></center>";
                }

                 echo "
                </div>

                  <div class=\"grid-container\" > 
                    <div class=\"grid-item\" style=\"font-size : 30px;\">
                      $symbol
                    </div>

                    <div class=\"grid-item\" style=\"padding-top:10px;\">
                      <input id=\"price\"
                        type=\"number\"
                        step=\"0.01\"
                        class=\"form-control\"
                        name=\"BiddingPrice\"
                        value=\"$biddingPrice\"
                        min=\"$biddingPrice\"
                        onchange=\"validatePrice();\">
                    </div>
                     
                  </div>

              <div class=\"grid-container\">
                <div class=\"grid-item\" style=\"padding-top:10px;\">
                Time left :
                </div>

                <div class=\"grid-item\">
                  <center id=\"demo\" class=\"timer\" style=\"font-size : 30px;\"></center> 
                </div>
              </div>
              ";
              
              if($isBid){
                echo "<center><input id=\"bid\" type=\"submit\" class=\"gridbtn btn-success\" value=\"Bid\" style=\"display:none;\"</center>";
              }
              else{
                echo "<center><input id=\"cancelbid\" type=\"submit\"  class=\"gridbtn btn-danger\" value=\"Cancel Bid\" ></center>";
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
		else if(days == 1){
			document.getElementById("demo").innerHTML = days + " day "  
			+ hours + ":" + minutes + ":" + seconds ; 
    }
    else{
      document.getElementById("demo").innerHTML = days + " days "  
			+ hours + ":" + minutes + ":" + seconds ; 
    }

    document.getElementById("demo").style.color = "red";
    
   
   var productId = "<?php echo $id ?>";
 /*  var xhttp = new XMLHttpRequest();
  
   xhttp.onreadystatechange = function() {
    console.log("responseText : " , this.responseText);

    var currentPriceShown = document.getElementById("price").value;
    console.log("currentPriceShown : " , currentPriceShown);

    var actualBiddingPrice = JSON.parse(this.responseText);
    console.log("actualBiddingPrice : " , actualBiddingPrice);

    if(currentPriceShown != actualBiddingPrice){
      setTimeout("location.reload(true);",2000);
    }
   
  };

  xhttp.open("GET", "UpdateAuction.php?id="+productId, true);
  xhttp.send(); */


  var rate = "<?php echo $rate ?>";
  console.log("rate ; " , rate);

  $(document).ready(function(){
    $.ajax({
			url:"PhpFunctions/UpdateAuction.php", 
			data: {id: productId, rate : rate}, 
			cache: false,
			method: "POST", 
			success:function(result){
          console.log("result : " , result);
    			var currentPriceShown = document.getElementById("price").value;
          console.log("currentPriceShown : " , currentPriceShown);

          var actualBiddingPrice = JSON.parse(result);
        //  actualBiddingPrice = actualBiddingPrice.toFixed(2);
          console.log("actualBiddingPrice : " , actualBiddingPrice);

          if(currentPriceShown != actualBiddingPrice){
            setTimeout("location.reload(true);",2000);
          }
    		},
    		error: function(xhr){
      			alert("An error occured: " + xhr.status + " " + xhr.statusText);
    		}
  		
  		});
  });
   
		
		    if (t < 0) { 
          clearInterval(x); 
          document.getElementById("demo").innerHTML = "EXPIRED"; 
          
          var productId = "<?php echo $id ?>";
          console.log("productId : " , productId);

          var isBid = "<?php echo $isBid ?>";

          if(!isBid){
            document.getElementById("cancelbid").style.display = 'none';
            alert("Congratulations !! You are now the owner of this product");
            setTimeout("location.href = 'http://localhost/Web-Assignment/MyProducts.php';",1000);
          }
          else{
            document.getElementById("bid").style.display = 'none';
            alert("The auction for this product is over");
            setTimeout("location.href = 'http://localhost/Web-Assignment/ProductsNew.php?referer=login';",1000);
          }

       /*   var xhttp = new XMLHttpRequest();
          xhttp.open("GET", "result.php?id="+productId, true);
          xhttp.send(); */

          $(document).ready(function(){
            $.ajax({
              url:"PhpFunctions/result.php", 
              data: {id: productId}, 
              cache: false,
              method: "POST", 
              success:function(result){
                 
                },
                error: function(xhr){
                    alert("An error occured: " + xhr.status + " " + xhr.statusText);
                }
              
              });
  });
    

         return false;
		    } 
		}, 1000); 

    function validatePrice(){
       var currentPrice = "<?php echo $biddingPrice ?>";
       console.log("currentPrice : " , currentPrice);

       var price = document.getElementById("price").value;
       console.log("price : " , price);

       if(price > currentPrice){
          document.getElementById("bid").style.display = 'block';
          return false;
       }
       else{
          document.getElementById("bid").style.display = 'none';
          return true;
       }
    }


</script>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

<body>
</html>
