<?php
session_start();
require_once "includes/phpFunctions.php";
$user=""; //to display the name of the user for the dropdown box
if(isset($_GET['referer'])){
  if($_GET['referer'] == 'login')
  {
    $user=$_SESSION['username'];
  }//end if
}
require_once "SellerNotif.php";

$subject=$description=$errorsubject=$errordescription="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (empty($_POST["subject"])) {
    $errorsubject = "Subject is required";
  } else {
    $subject = test_input($_POST["subject"]);
  }
  if (empty($_POST["description"])) {
    $errordescription = "Description is required";
  } else {
    $description = test_input($_POST["description"]);
  }

  if($errordescription=="" && $errorsubject==""){
    require_once "includes/db_connect.php";
    $Insert= "INSERT INTO Problem(description,username,subject)
              VALUES('$description','$user','$subject')";
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $Result =$conn->exec($Insert) ;
    header("Location: ContactUs.php?referer=login");
    //echo "<script type='text/javascript'>alert('Your report has been sent successfully to the admins');</script>";
    
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/aos.css">   
    <link rel="stylesheet" href="css/rangeslider.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/icomoon.css">

    <link rel="stylesheet" href="includes/contactus.css">
    
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
$_SERVER['HTTP_REFERER']="ContactUs.php";  //used to redirect the form to this page
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
            <li><a href="ProductsNew.php"><span>Products</span></a></li>
            <li><a href="#about-section"><span>About Us</span></a></li>
            <li><a href="blog.html"><span>FAQ</span></a></li>
            <li class="active"><a><span>Contact</span></a></li>
          </ul>
        </nav>
      </div>
    </div>  
  </div>  
<?php
}else{
$_SERVER['HTTP_REFERER']="ContactUs.php?referer=login";  //used to redirect the form to this page
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
            <li><a href="ProductsNew.php?referer=login"><span>Products</span></a></li>
            <li><a href="#about-section"><span>About Us</span></a></li>
            <li><a href="blog.html"><span>FAQ</span></a></li>
            <li class="active"><a><span>Contact</span></a></li>
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

<!--Pic only-->
<div class="background-image" style="background-image: url(includes/contactus.jpg); "data-aos="fade-up"> 
		<div class="container">
			<p>.</p>
			<div class="row align-items-center justify-content-center text-center" style="min-height:325px;">
				<div class="col-md-10">
					<div class="row justify-content-center mb-4">
						<div class="col-md-8 text-center">
							<h1 style="color:white;" data-aos="fade-up" >Contact Us</h1>
						</div>
					</div>	
				</div>
			</div>
		</div>
</div>
<!--End of Pic only-->
<section class="ftco-section contact-section">
      <div class="container">
        <div class="row d-flex mb-5 contact-info justify-content-center">
        	<div class="col-md-8">
        		<div class="row mb-5">
		          <div class="col-md-4 text-center py-4">
		          	<div class="icon">
		          		<span class="icon-map-o"></span>
		          	</div>
		            <p><span>Address:</span> University of Mauritius</p>
		          </div>
		          <div class="col-md-4 text-center border-height py-4">
		          	<div class="icon">
		          		<span class="icon-mobile-phone"></span>
		          	</div>
		            <p><span>Phone:</span> <a>+230 5726358</a></p>
		          </div>
		          <div class="col-md-4 text-center py-4">
		          	<div class="icon">
		          		<span class="icon-envelope-o"></span>
		          	</div>
		            <p><span>Email:</span> <a>auctionhouse@gmail.com</a></p>
		          </div>
		        </div>
          </div>
        </div>
        <div class="row block-9 justify-content-center mb-5">
          <div class="col-md-8 mb-md-5">         	
<?php
if ($user ==""){
?>
          <h3 class="text-center">If you got any issues <br>please login to report them</h3>
          <br/>
<?php
}else{
?>
          <h3 class="text-center">If you got any issues <br>please do not hesitate to report them below</h3>
          <br/>
          <!--Report from-->
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["HTTP_REFERER"]);?>" class="bg-light p-5 contact-form">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Subject" name="subject" value="<?php echo $subject;?>">
                <span style="color:red;"> <?php echo $errorsubject;?></span>
              </div>
              <div class="form-group">
                <textarea cols="30" rows="7" class="form-control" placeholder="Description" name="description" ><?php echo $description;?></textarea>
                <span style="color:red;"> <?php echo $errordescription;?></span>
              </div>
              <div class="form-group">
                <input type="submit" value="Report Problem" class="btn btn-primary py-2 px-4" >
              </div>
          </form>

<?php
}
?>
</body>
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
</html>
