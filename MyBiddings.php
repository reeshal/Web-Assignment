<?php 
	session_start();
	require_once "PhpFunctions/phpFunctions.php";
	$user=$_SESSION['username'];
	  
	$search=$category=$query="";
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if (!empty($_POST["tags"]))
		  $search=test_input($_POST["tags"]);
	
		  $category=$_POST["category"];
	}

	require_once "PhpFunctions/SellerNotif.php";
	require_once "PhpFunctions/feedback.php";

?>

<html>
 <head>
    <title>My Biddings</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/products.css">
	<script>
      function clearNotif(){
        var user=$("span#user").html();
          $.ajax({
            url:"PhpFunctions/clearNotifications.php",
            data:{username:user},
            method:"POST",
            success:function(result){             
              if(result=="Notifications Cleared"){
                alert(result);
                location.reload();
              }             
            },
            error: function(a){
              alert("Failed")
            }
          });  
      }
    </script>
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
				  <span id="user"><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="MyProfile.php">My Profile</a></li>
                      <li><a href="MyProducts.php">My Products</a></li>
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
                <li><a href="faq.php?referer=login"><span>FAQ</span></a></li>
				<li><a href="ContactUs.php?referer=login"><span>Contact</span></a></li>
				<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/notification.png"></a>
                  <ul class="dropdown-menu" >
                  <?php
                  $query="SELECT notiffId,notiffDetails FROM Notifications WHERE username='$user'LIMIT 5 ";
                  $data  =$conn->query($query) ;
                  $result = $data->fetchAll(PDO::FETCH_ASSOC);
                  if(!$result){
                      echo "<li>No notification</li>";
                  }
                  else{
                      foreach($result as $output) {
                          $notif = $output["notiffDetails"];
                          echo "<li >$notif<hr></li>";
                      }
                  }
                  ?>
                  <li class="btn btn-primary" onclick="clearNotif()">Clear Notifications</li>
                  </ul>                  
                </li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>  
    </header>
	<!--End of header-->

	<!--Pic only-->
	<div class="background-image" style="background-image: url(images/hero_1.jpg); "data-aos="fade"> 
		<div class="container">
			<p>.</p>
			<div class="row align-items-center justify-content-center text-center" style="min-height:325px;">
				<div class="col-md-10">
					<div class="row justify-content-center mb-4">
						<div class="col-md-8 text-center">
							<h1 style="color:black;" data-aos="fade-up" >My Biddings</h1>
						</div>
					</div>	
				</div>

			</div>
		</div>
	</div>
	<!--End of Pic only-->
	
	
<div>
<p>.</p>
		<?php 
			require_once "PhpFunctions/db_connect.php";
			$query = "SELECT DISTINCT(p.productId), p.name, p.start_price, i.imageName,  p.is_sold, p.category ,p.start_time, p.end_time 
                FROM Product p, ProductImage i, Bidding b 			
                where p.productId = i.prodId
				AND p.productId = b.productId
                AND  p.is_sold = 0	
				AND b.username = '$user'";
						
			$data  =$conn->query($query) ;
			$result = $data->fetchAll(PDO::FETCH_ASSOC);
			
			if($data->rowCount() > 0){
				echo "<div class=\"container\">";
      			echo "<div class=\"row\">";  
				foreach($result as $output) {
					$name =  $output["name"];
					$start_time = $output["start_time"];
					$end_time = $output["end_time"];
					$prodId = $output["productId"];
					$imageName = $output["imageName"];
	
					$currentPriceQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
															   FROM Bidding
															   WHERE productId = '$prodId'")->fetch();
															   
					$currentPrice = $currentPriceQuery['price_bidded'];
	
					if(empty($currentPrice)){
						$currentPrice = $output["start_price"];
					}
	
					echo "
					<div class=\"col-lg-4 col-md-6 mb-5\">
					<div class=\"product-item\">
						<figure>
						<img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
						</figure>
						<div class=\"px-4\">
							<h3>$name</h3>
							<p>$end_time</p>
							<p>Rs $currentPrice</p>
						</div>
						<div>
						<a href='details.php?id=".$output['productId']."' class=\"btn mr-1 rounded-3\">View</a>
						</div>
					</div>
					</div>
					";
				}
				echo "</div>"; 
      			echo "</div>"; 
			}
			else{
				echo "<h2 style=\"color : red;\">You have not bidded on any products yet</h2>";
			}
		?>
	</div>
	</div>
</body>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

</html>