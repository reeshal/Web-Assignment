<?php
session_start();
//$user="Username"; //to display the name of the user for the dropdown box
$user="";
if(isset($_GET['referer'])){
  if($_GET['referer'] == 'login')
  {
    $user=$_SESSION['username'];
  }//end if
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$search=$category=$query="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (!empty($_POST["tags"]))
    $search=test_input($_POST["tags"]);

  if (!empty($_POST["category"]))
    $category=test_input($_POST["category"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product</title>
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
<?php 
if ($user ==""){
  $_SERVER['HTTP_REFERER']="ProductsNew.php"; 
    //session_destroy();
?>
          <div class="col-5">
            <nav class="site-navigation position-relative text-left " style="margin-left: -100px" role="navigation">
              <ul class="site-menu js-clone-nav ">
                <li><a href="login.php"><span>Login</span></a></li>
                <li><a href="signup.php"><span>Sign Up</span></a></li>
              </ul>
            </nav>
          </div>
          <div class="col-7 ">
          <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="homepage.php"><span>Home</span></a></li>
                <li class="active"><a href="ProductsNew.php"><span>Products</span></a></li>
                <li><a href="#about-section"><span>About Us</span></a></li>
                <li><a href="blog.html"><span>FAQ</span></a></li>
                <li><a href="#contact-section"><span>Contact</span></a></li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>  
<?php
}else{
  $_SERVER['HTTP_REFERER']="ProductsNew.php?referer=login"; 
?>
    <div class="col-3">
            <nav class="site-navigation position-relative text-left " style="margin-left: -100px" role="navigation">
               <ul class="site-menu js-clone-nav ">
                <li class="has-children">
                  <span><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="MyProfile.html">My Profile</a></li>
                      <li><a href="MyProducts.php">My Products</a></li>
                      <li><a href="Biddings.php">My Biddings</a></li>
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
<?php
    }
?>
    </header>
    <!--End of header-->

    <!--Search Bar only-->
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10">
              <div class="form-search-wrap p-2" style="margin-top: 100px; margin-bottom: 50px">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']);?>">
                  <div class="row ">
  
                    <div class="col-7 border-right">
                      <!--met  echo value searched-->
                      <input type="text" name="tags"  class="form-control" placeholder="What are you looking for?" value="<?php echo $search;?>">
                    </div>
                    
                    <div class="col-3">
                      <div class="select-wrap">
                        <select class="form-control" name="category">
                          <option value="">All Categories</option>
                          <option value="Art">Art</option>
                          <option value="Books and magazines">Books &amp; Magazines</option>
                          <option value="Cellphones">Cellphones</option>
                          <option value="Computers">Computers</option>
                          <option value="Clothes">Clothes</option>
                          <option value="Jewellery and Watches">Jewellery &amp; Watches</option>
                          <option value="Music">Music</option>
                          <option value="Movies">Movies</option>
                          <option value="Health Care">Health Care</option>
                          <option value="Vehicles">Vehicles</option>
                        </select>
                      </div>
                    </div>
  
                    <div class="col-2 text-right">
                      <input type="submit" class="btn btn-primary" value="Search">
                    </div>
                    
                  </div>
                </form>
              </div>
  
            </div>
          </div>
        </div> 
        <!--End of Search bar only-->
      
      <div class="row" style="padding-left:100px;">
      <?php
      require_once "includes/db_connect.php";

      if($search=="" && $category==""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category,p.start_time, p.end_time 
                  FROM Product p, ProductImage i 			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user' ";
      }
      else if($search=="" && $category!=""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category,p.start_time, p.end_time 
                  FROM Product p, ProductImage i 			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.category='$category'";
      }
      else if($search!="" && $category==""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time
                  FROM Product p, ProductImage i, ProductTag t			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.productId = t.productId
                  AND t.product_tags LIKE '%$search%'
                  
                  UNION
                  SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time
                  FROM Product p, ProductImage i		
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.name LIKE '%$search%'";
      }
      else if($search!="" && $category!=""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time
                  FROM Product p, ProductImage i, ProductTag t			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.productId = t.productId
                  AND t.product_tags LIKE '%$search%'
                  AND p.category='$category'
                  UNION
                  SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time
                  FROM Product p, ProductImage i		
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.name LIKE '%$search%'
                  AND p.category='$category'";
      }

	
      $data  =$conn->query($query) ;
      $result = $data->fetchAll(PDO::FETCH_ASSOC);

      foreach($result as $output) {
          $name =  $output["name"];
          $start_price = $output["start_price"];
          $start_time = $output["start_time"];
          $end_time = $output["end_time"];
          $prodId = $output["productId"];
          $imageName = $output["imageName"];
          
        if($user!=""){
          echo "
          <div class=\"auctionBox grid-item\">
            <center><a href='details.php?id=".$output['productId']."'>$name</a></center>
            <img src=\"http://localhost/Assignment/images/$imageName\" width=\"248px\" height=\"200px\"/>
            <center>Rs $start_price</center>
            <center>Click on product name to bid</center>
            </div>";
        }
        else{
          echo "
          <div class=\"auctionBox grid-item\">
            <center>$name</center>
            <img src=\"http://localhost/Assignment/images/$imageName\" width=\"248px\" height=\"200px\"/>
            <center>Rs $start_price</center>
            </div>";
        }
          }
          echo "</div>";  
      ?>
      </div>
    
</div>
<script type="text/javascript"> 
	//function timer(prodId){
		var end_time = "<?php echo $end_time ?>";
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
		
		    if (t < 0) { 
			clearInterval(x); 
			document.getElementById("demo").innerHTML = "EXPIRED"; 
		    } 
		}, 1000); 
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

</body>
</html>