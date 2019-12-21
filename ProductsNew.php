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
require_once "SellerNotif.php";
require_once "includes/db_connect.php";

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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="includes/products.css">


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
                <li><a href="ContactUs.php"><span>Contact</span></a></li>
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
<?php
    }
?>
    </header>
    <!--End of header-->
     
    <!--Search Bar only-->
    <div class="background-image" style="background-image: url(includes/coverproduct.png); " data-aos="fade" > 
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-10 ">
              <div class="form-search-wrap p-2" style="margin-top: 100px; margin-bottom: 50px">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']);?>">
                  <div class="row ">
  
                    <div class="col-7 border-right">
                      <input type="text" name="tags"  class="form-control" placeholder="What are you looking for?" value="<?php echo $search;?>">
                    </div>
                    
                    <div class="col-3">
                      <div class="select-wrap">
                        <select class="form-control" name="category">
                          <option value="">All Categories</option>
                          <?php
                          $categoryQuery="SELECT categoryName FROM Category";
                          $dataa  =$conn->query($categoryQuery) ;
                          $results = $dataa->fetchAll(PDO::FETCH_ASSOC);
                          foreach($results as $outputs) {
                            $categoryOutput=$outputs["categoryName"];
                            echo "<option value=\"$categoryOutput\">$categoryOutput</option>";
                          }
                          ?>
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
  </div>
  <div >
    <p>.</p>

      <?php
      
      if($search=="" && $category==""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i 			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user' ";
      }
      else if($search=="" && $category!=""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category,p.start_time, p.end_time,p.description  
                  FROM Product p, ProductImage i 			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.category='$category'";
      }
      else if($search!="" && $category==""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i, ProductTag t			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.productId = t.productId
                  AND t.product_tags LIKE '%$search%'
                  
                  UNION
                  SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i		
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.name LIKE '%$search%'";
      }
      else if($search!="" && $category!=""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i, ProductTag t			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.productId = t.productId
                  AND t.product_tags LIKE '%$search%'
                  AND p.category='$category'
                  UNION
                  SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i		
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.name LIKE '%$search%'
                  AND p.category='$category'";
      }
	
      $data  =$conn->query($query) ;
      $result = $data->fetchAll(PDO::FETCH_ASSOC);
      echo "<div class=\"container\">";
      echo "<div class=\"row\">";
      foreach($result as $output) {
          $name =  $output["name"];
          $start_time = $output["start_time"];
          $end_time = $output["end_time"];
          $prodId = $output["productId"];
          $imageName = $output["imageName"];
          $desc=$output["description"];

          $currentPriceQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
                                                           FROM Bidding
                                                           WHERE productId = '$prodId'")->fetch();
                                                           
          $currentPrice = $currentPriceQuery['price_bidded'];

         if(empty($currentPrice)){
          $currentPrice = $output["start_price"];
         }

          
        if($user!=""){
          echo "
          <div class=\"col-lg-4 col-md-6 mb-5\">
          <div class=\"product-item\">
            <figure>
            <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
            </figure>
            <div class=\"px-4\">
                <h3>$name</h3>
                <p>$desc</p>
                <p>Rs $currentPrice</p>
            </div>
            <div>
            <a href='details.php?id=".$output['productId']."' class=\"btn mr-1 rounded-3\">View</a>
            </div>
          </div>
          </div>

          ";
          
        }
        else{
          echo "
          <div class=\"col-lg-4 col-md-6 mb-5\">
          <div class=\"product-item\">
            <figure>
            <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
            </figure>
            <div class=\"px-4\">
                <h3>$name</h3>
                <p>$desc</p>
                <p>Rs $currentPrice</p>
            </div>
          </div>
          </div>

          ";
        }
      }
      echo "</div>"; 
      echo "</div>";  
      ?>
      

        </div>
</div>



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