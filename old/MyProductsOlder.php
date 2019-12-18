<?php
session_start();
$user=$_SESSION['username'];
require_once "SellerNotif.php";

require_once "includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function dateformatter($date){
	$date = str_replace('/', '-', $date );
	$newDate = date("Y-m-d", strtotime($date));
	return $newDate;
}
$start_price=$start_time=$duration="";
$deleteConfirmation=$stopConfirmation="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  
  $start_price = test_input($_POST["start_price"]);
  $duration = test_input($_POST["duration"]);
  $pid=$_POST["prodId"];
  
  $deleteConfirmation=$_POST["deleteConfirmation"];
  $stopConfirmation=$_POST["stopConfirmation"];
  
  if($start_price!="" && $duration!=""){
    $the_time = date('Y-m-d H:i:s');
    $duration += 3; //Timezone
    $endtime=date('Y-m-d H:i',strtotime('+'.$duration.' hours',strtotime($the_time)));
    $update="UPDATE Product SET is_Sold=0, start_time='$the_time', duration=$duration, end_time='$endtime',
                              start_price=$start_price
                          WHERE current_owner='$user'
                          AND productId=$pid ";
    $Result =$conn->exec($update) ;
    header("Location: MyProducts.php");
  }
  else if($deleteConfirmation=="yes"){
      $query="SELECT username FROM Bidding WHERE productId=$pid";
      $Result =$conn->query($query);
      if(!$Result){
        $delQuery="DELETE FROM Product WHERE productId=$pid";
        $delResult =$conn->exec($delQuery) ;
        header("Location: MyProducts.php");
      }
      else{
        echo "<script type='text/javascript'>alert('Product cant be deleted. Someone has already bidded on it');</script>";
        //cho "failed";
      }
  }
  else if($stopConfirmation=="yes"){
    $query="SELECT username FROM Bidding WHERE productId=$pid";
    $Result =$conn->query($query);
    if(!$Result){
      $update="UPDATE Product SET is_Sold=1 WHERE productId=$pid AND current_owner='$user'";
      $answer =$conn->exec($update) ;
      header("Location: MyProducts.php");
    }
    else{
      echo "<script type='text/javascript'>alert('Product cant be deleted. Someone has already bidded on it');</script>";
      //echo "failed";
    }
  }
  else{
    header("Location: MyProducts.php");
  }
  
}
?>

<html lang="en">
<head>
    <title>My Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="includes/products.css">
    <link rel="stylesheet" href="includes/myproductsTab.css">

</head>
<body>
<div class="site-wrap">
    <!--Start of header-->
    <header class="site-navbar py-2 bg-white" role="banner">
      <div class="container">
        <div class="row align-items-center"> <!--creating a row to insert the header-->
        <div class="col-0.5">
            <nav class="site-navigation position-relative text-left " style="margin-left: -100px" role="navigation">
               <ul class="site-menu js-clone-nav ">
                <li class="has-children">
                  <span><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="MyProfile.html">My Profile</a></li>
                      <li><a href="MyBiddings.php">My Biddings</a></li>
                      <li><a href="homepage.php">Logout</a></li>
                  </ul>
                </li>
                </ul>
              </nav>
        </div>
        <div class="col-2.5">
            <nav class="site-navigation position-relative text-left ">
                <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                    <li><a href="UploadProducts.php"><span>Sell a new product</span></a></li>
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

    <!--Search Bar only-->
	<div class="background-image" style="background-image: url(includes/coverproduct.png); "data-aos="fade"> 
		<div class="container">
			<p>.</p>
			<div class="row align-items-center justify-content-center text-center" style="min-height:325px;">
				<div class="col-md-10">
					<div class="row justify-content-center mb-4">
						<div class="col-md-8 text-center">
							<h1 style="color:white;" data-aos="fade-up" >My Products</h1>
						</div>
					</div>
          <div class="row justify-content-center mb-4">
						<div class="col-md-8 text-center">
            <button class="tablinks" onclick="switchTab(event, 'owned')">Items Owned</button>
            <button class="tablinks" onclick="switchTab(event, 'inauction')">Items In Auction</button>
						</div>
					</div>		
				</div>

			</div>
		</div>
	</div>


    <div class="container" style="padding-left:70px; padding-top:75px">
      
      <div id="owned" class="tabcontent row">
        <?php
          $query="SELECT  p.name, s.imageName,p.productId
                  FROM Product p,  ProductImage s
                  WHERE p.productId=s.prodID
                  AND p.current_owner='$user'
                  AND p.is_Sold=1
                  ";
          $data  =$conn->query($query) ;
          $result = $data->fetchAll(PDO::FETCH_ASSOC);
    
          foreach($result as $output) {
              $name =  $output["name"];
              $imageName = $output["imageName"];
              $pid=$output['productId'];

              echo "
                <div class=\"col-lg-4 col-md-6 mb-5\">
                <div class=\"product-item\">
                  <figure>
                  <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
                  </figure>
                  <div class=\"px-4\">
                      <h3>$name</h3>
                  </div>
                  <button  onclick=\"resell('$pid')\">Resell</button>
                  <button>Leave Feedback</button>
                  <button onclick=\"deletes('$pid')\">Delete</button>
                  <div>
                  <a href='details.php?id=".$output['productId']."' class=\"btn mr-1 rounded-3\">View</a>
                  </div>
                </div>
                </div>
              ";
            }
          
        ?>
      </div>
      <div id="inauction" class="tabcontent row">
        <?php
        $query="SELECT p.start_time, p.start_price, p.name, s.imageName,p.productId
                FROM Product p, ProductImage s
                WHERE p.current_owner='$user'
                AND p.productId=s.prodID
                AND p.is_Sold=0";
        $data  =$conn->query($query) ;
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $output) {
            $name =  $output["name"];
            $price = $output["start_price"];
            $date = $output["start_time"];
            $imageName = $output["imageName"];
            $pid=$output['productId'];
            $currentPriceQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
                                                           FROM Bidding
                                                           WHERE productId = '$pid'")->fetch();
                                                           
            $currentPrice = $currentPriceQuery['price_bidded'];
            if(empty($currentPrice)){
              $currentPrice = $price;
            }
              echo "
                <div class=\"col-lg-4 col-md-6 mb-5\">
                <div class=\"product-item\">
                  <figure>
                  <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
                  </figure>
                  <div class=\"px-4\">
                      <h3>$name</h3>
                      <p>Current Price: Rs $currentPrice</p>
                      <p>Time Left: TO BE IMPLEMENTED</p>
                  </div>
                  <button onclick=\"deletes('$pid')\">Delete</button>
                  <button onclick=\"stopAuction('$pid')\">Stop Auction</button>
                  <div>
                  <a href='details.php?id=".$output['productId']."' class=\"btn mr-1 rounded-3\">View</a>
                  </div>
                </div>
                </div>
              ";
          }
        ?>
      </div>
      
      
    </div>
    <div id="modal-wrapper" class="modal">
      <form class="modal-content animate" action="" method="post" >
        <div class="container">
          <h3>Reselling Product</h3>
          <span onclick="document.getElementById('modal-wrapper').style.display='none' " class="close" title="Close PopUp">&times;</span>
          <input type="number" class="form-control" name="start_price" value="" placeholder="Starting Price" min="1" maxlength="20">
          <input type="number" class="form-control" name="duration" value="" placeholder="Duration(hours)" min="1" maxlength="20">
          <input type="hidden" id="prodId" name="prodId">
          <input type="submit" value="Confirm Resale">
        </div>
      </form>
    </div>

    <div id="modal-delete" class="modal">
      <form class="modal-content animate" action="" method="post">
      <div class="container">
        <p>Confirm Deletion</pp>
        <span onclick="document.getElementById('modal-delete').style.display='none' " class="close" title="Close PopUp">&times;</span>
        <input type="checkbox" name="deleteConfirmation" value="yes">Yes
        <input type="checkbox" name="deleteConfirmation" value="no">No<br>
        <input type="hidden" id="prodIds" name="prodId">
        <input type="submit" value="Delete">
        </div>
      </form>
    </div>

    <div id="modal-stop" class="modal">
      <form class="modal-content animate" action="" method="post">
      <div class="container">
        <p>Confirm Stopping Auction</p>
        <span onclick="document.getElementById('modal-stop').style.display='none' " class="close" title="Close PopUp">&times;</span>
        <input type="checkbox" name="stopConfirmation" value="yes">Yes
        <input type="checkbox" name="stopConfirmation" value="no">No<br>
        <input type="hidden" id="prodIdstop" name="prodId">
        <input type="submit" value="Stop">
        </div>
      </form>
    </div>

</div>
<script>
        function switchTab(evt,choice){
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(choice).style.display = "inline";
          evt.currentTarget.className += " active";
        }
        function resell(pid){
          document.getElementById("modal-wrapper").style.display="block";
          document.getElementById("prodId").value=pid;
         // productid.innerHTML="Value= "+"'"+pid+"'";
        }
        var modal = document.getElementById('modal-wrapper');
        window.onclick = function(at) {
        if (at.target == modal) {
        modal.style.display = "none";
        }
        }
        function deletes(pid){
          document.getElementById("modal-delete").style.display="block";
          document.getElementById("prodIds").value=pid;
        }
        function stopAuction(pid){
          document.getElementById("modal-stop").style.display="block";
          document.getElementById("prodIdstop").value=pid;
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
</body>
</html>