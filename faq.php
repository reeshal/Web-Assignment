<?php
session_start();
$user=$_SESSION['username'];
require_once "SellerNotif.php";
require_once "includes/db_connect.php";

?>
<html lang="en">
<head>
    <title>FAQ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="includes/faq.css">
    
    
    
</head>
<body>
<div class="site-wrap">
    <!--Start of header-->
    <header class="site-navbar py-2 bg-white" role="banner">
      <div class="container">
        <div class="row align-items-center">
<?php 
if ($user ==""){
  $_SERVER['HTTP_REFERER']="faq.php"; 
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
                <li ><a href="ProductsNew.php"><span>Products</span></a></li>
                <li><a href="#about-section"><span>About Us</span></a></li>
                <li class="active"><a><span>FAQ</span></a></li>
                <li><a href="ContactUs.php"><span>Contact</span></a></li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>  
<?php
}else{
  $_SERVER['HTTP_REFERER']="faq.php?referer=login"; 
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
                <li ><a href="ProductsNew.php?referer=login"><span>Products</span></a></li>
                <li><a href="#about-section"><span>About Us</span></a></li>
                <li class="active"><a><span>FAQ</span></a></li>
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
	<div class="background-image" style="background-image: url(includes/coverproduct.png); "data-aos="fade"> 
		<div class="container">
			<p>.</p>
			<div class="row align-items-center justify-content-center text-center" style="min-height:325px;">
				<div class="col-md-10">
					<div class="row justify-content-center mb-4">
						<div class="col-md-8 text-center">
							<h1 style="color:white;" data-aos="fade-up" >Frequently Asked Questions</h1>
						</div>
					</div>
                </div>
		    </div>
        </div>
    </div>
    </br>
    <div class="container">
    <?php
    $queryfaq="SELECT faqId,question, answer FROM FAQ";
    $datafaq=$conn->query($queryfaq);
    $resultfaq = $datafaq->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultfaq as $output){
        $faqid=$output['faqId'];
        $question=$output["question"];
        $answer=$output["answer"];      
        ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default" >
            <div class="panel-heading" role="tab" id="<?php echo $faqid ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="<?php echo "#collapse".$faqid ?>" aria-expanded="true" aria-controls="<?php echo "collapse".$faqid ?>">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        <?php echo $question ?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo "collapse".$faqid ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo "collapse".$faqid ?>">
                <div class="panel-body">
                    <?php echo $answer ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

    </div>


</div>   

<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
</body>
</html>