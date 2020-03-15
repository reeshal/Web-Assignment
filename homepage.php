<?php
session_start();
$user=""; //to display the name of the user for the dropdown box
if(isset($_GET['referer'])){
  if($_GET['referer'] == 'login')
  {
    $user=$_SESSION['username'];
  }//end if
}
require_once "SellerNotif.php";
require_once "feedback.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">   
    <link rel="stylesheet" href="css/rangeslider.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>

  <div class="site-wrap">

    <!--Start of header-->
    <header class="site-navbar py-2 bg-white" role="banner">
      <div class="container">
        <div class="row align-items-center"> <!--creating a row to insert the header-->
<?php 
if ($user ==""){
    session_destroy();
    $_SERVER['HTTP_REFERER']="ProductsNew.php";  //used to redirect the form to this page
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
                <li class="active"><a><span>Home</span></a></li>
                <li><a href="ProductsNew.php"><span>Products</span></a></li>
                <li><a href="#about-section"><span>About Us</span></a></li>
                <li><a href="faq.php"><span>FAQ</span></a></li>
                <li><a href="ContactUs.php"><span>Contact</span></a></li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>  
<?php
}else{
  $_SERVER['HTTP_REFERER']="ProductsNew.php?referer=login";  //used to redirect the form to this page
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
                <li class="active"><a><span>Home</span></a></li>
                <li><a href="ProductsNew.php?referer=login"><span>Products</span></a></li>
                <li><a href="#about-section"><span>About Us</span></a></li>
                <li><a href="faq.php?referer=login"><span>FAQ</span></a></li>
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

  
    <!--Start of Title Bar-->
    <div class="site-blocks-cover overlay" style="background-image: url(images/hero_1.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">  <!--data setaller is the scroll speed of the container-->
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">

          <div class="col-md-10">
            
            
            <div class="row justify-content-center mb-4">
              <div class="col-md-8 text-center">
                <h1 data-aos="fade-up">Auction House</h1>
                <p data-aos="fade-up" data-aos-delay="100">Explore top-rated products and bid competitively!</p>
              </div>
            </div>
            
            <!--Search Bar-->
            <div class="form-search-wrap p-2" data-aos="fade-up" data-aos-delay="200">
              <form method="post" action="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']);?>">
                <div class="row ">

                  <div class="col-7 border-right">
                    <!--met name ek echo value searched-->
                    <input type="text" name="tags" value="" class="form-control" placeholder="What are you looking for?">
                  </div>
                  
                  <div class="col-3">
                    <div class="select-wrap">
                      <select class="form-control" name="category">
                        <option value="all">All Categories</option>
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
    </div>  

    <!--TO EDIT LATER-->

    <!--About us-->
    <div class="site-section " id="about-section" >
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-8" >
            <h3>About Us</h3>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4 mx-auto">
            <h3>Who We Are</h3>
          </div>
        </div>
        <div class="row mb-5">
          <div class="col-md-4 ml-auto">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam eveniet laudantium dignissimos atque labore excepturi perspiciatis ut fugit eius itaque iste quibusdam dolore consectetur reprehenderit. Illum molestiae nemo culpa optio.</p>
          </div>
          <div class="col-md-4">
            <p>Similique neque facere cum! Et esse natus qui fugiat temporibus voluptate debitis similique eos illum pariatur suscipit placeat omnis perferendis ab enim quis eligendi minima explicabo aperiam. Eaque minus itaque?</p>
          </div>
        </div>
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
  <script src="js/dataValidation.js"></script>
    
</body>
</html>