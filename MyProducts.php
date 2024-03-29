<?php
session_start();
$user=$_SESSION['username'];
require_once "PhpFunctions/SellerNotif.php";
require_once "PhpFunctions/feedback.php";
require_once "PhpFunctions/phpFunctions.php";
require_once "PhpFunctions/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$start_price=$start_time=$duration="";
$deleteConfirmation=$stopConfirmation="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $pid=$_POST["prodId"];

  if(isset($_POST['resell'])){
    $start_price = test_input($_POST["start_price"]);
    $duration = test_input($_POST["duration"]);

    if($start_price!="" && $duration!=""){
      $the_time = date('Y-m-d H:i:s');
      $duration += 3; //Timezone
      $endtime=date('Y-m-d H:i',strtotime('+'.$duration.' hours',strtotime($the_time)));

      //Converting starting price of product to USD
		$rateQuery = $conn->query("SELECT c.conversion_rate as rate
                               FROM Users u, Currency c
                               WHERE u.username = '$user'
                               AND u.currency = c.currency")->fetch();
                            
    $rate = $rateQuery['rate'];
    $start_price *= $rate; 

      $update="UPDATE Product SET is_Sold=0, start_time='$the_time', duration=$duration, end_time='$endtime',
                                start_price=$start_price
                            WHERE current_owner='$user'
                            AND productId=$pid ";
      $Result =$conn->exec($update) ;
      header("Location: MyProducts.php");
    }
  }
  else if (isset($_POST['delete'])){
    $deleteConfirmation=$_POST["deleteConfirmation"];
    if($deleteConfirmation=="yes"){
      $query="SELECT username FROM Bidding WHERE productId=$pid";
      $Result =$conn->query($query);
      $row = $Result->fetch();
      if(!$row){
        $delQuery="DELETE FROM Product WHERE productId=$pid";
        $delResult =$conn->exec($delQuery) ;
        header("Location: MyProducts.php");
      }
      else{
        echo "<script type='text/javascript'>alert('Product cant be deleted. Someone has already bidded on it');</script>";
        //echo "failed";
      }
    }
  }
  else if(isset($_POST['leavefeedback'])){
    //Getting feedback value
    $feedback = test_input($_POST["feedback"]);

    //Updating feedback value of product
    $update = "UPDATE Product
               SET feedback = '$feedback'
               WHERE productId = '$pid'";

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $Result =$conn->exec($update);

    //Getting current owner of product
    $auctionDetailQuery = $conn->query("SELECT * 
                                        FROM AuctionDetail
                                        WHERE productId = '$pid'
                                        ORDER BY date DESC
                                        LIMIT 1")->fetch();
    $previous_owner = $auctionDetailQuery['previous_owner'];

    //Getting current value of feedbackNotif of User
    $feedbackNotifQuery = $conn->query("SELECT feedbackNotif FROM Users WHERE username = '$previous_owner'")->fetch();
    $feedbackNotif = $feedbackNotifQuery['feedbackNotif'];

    //Setting value of feedbackNotifQuery
    if(empty($feedbackNotif)){
      $feedbackNotif = $pid;
    }
    else{
      $feedbackNotif = $feedbackNotif . ',' . $pid;
    }

    //Adding id of product to feedbackNotif field in current_owner to notify current_owner of feedback received
    $update = "UPDATE Users
               SET feedbackNotif = '$feedbackNotif'
               WHERE username = '$previous_owner'";
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $Result =$conn->exec($update) ;

    //storing the feedback in Notification table so that user can view all later
    $notiffdetail="Feedback of product $pid: $feedback";
    $insertStmt= "INSERT INTO Notifications(notiffDetails,username)
                  VALUES('$notiffdetail','$previous_owner')";
    $resultnotiff=$conn->exec($insertStmt);
    
    header("Location: MyProducts.php");
  }

  else if (isset($_POST['stop'])){
    $stopConfirmation=$_POST["stopConfirmation"];
    if($stopConfirmation=="yes"){
      $query="SELECT username FROM Bidding WHERE productId=$pid";
      $Result =$conn->query($query);
      $row = $Result->fetch();
      if(!$row){
        $update="UPDATE Product SET is_Sold=1 WHERE productId=$pid AND current_owner='$user'";
        $answer =$conn->exec($update) ;
        header("Location: MyProducts.php");
      }
      else{
        echo "<script type='text/javascript'>alert('Product cant be stopped. Someone has already bidded on it');</script>";
        //echo "failed";
      }
    }
  }
  else{
    header("Location: MyProducts.php");
  }
  
}

//Getting ToCurrency of user
if($user != ""){
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
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/myproductsTab.css">
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
        <div class="col-0.5">
            <nav class="site-navigation position-relative text-left " style="margin-left: -100px" role="navigation">
               <ul class="site-menu js-clone-nav ">
                <li class="has-children">
                  <span id="user"><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="MyProfile.php">My Profile</a></li>
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
                <li><a href="ProductsNew.php?referer=login"><span>Products</span></a></li>
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

    <!--Search Bar only-->
	<div class="background-image" style="background-image: url(images/coverproduct.png); "data-aos="fade"> 
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
						<div class="col-md-3 ">
            <ul class="tab">
              <li><a href="#" class="tablinks" data-aos="fade-up" onclick="switchTab(event, 'owned')">Owned</a></li>
              <li><a href="#" class="tablinks" data-aos="fade-up" onclick="switchTab(event, 'inauction')">In Auction</a></li>
            </ul>
            </div>
					</div>		
				</div>

			</div>
		</div>
	</div>

  <div style="padding-left:25px; padding-top:25px">
    <div class="container">    
    <div id="owned" class="tabcontent">

        <?php
          $query="SELECT  p.name, s.imageName,p.productId
                  FROM Product p,  ProductImage s
                  WHERE p.productId=s.prodID
                  AND p.current_owner='$user'
                  AND p.is_Sold=1
                  ";
          $data  =$conn->query($query) ;
          $result = $data->fetchAll(PDO::FETCH_ASSOC);
          echo "<div class=\"row\">";
          if(!$result){
            echo "
            <div class=\"col-lg-4 col-md-6 mb-5\">
            None
            </div>
            ";
          }
          else{
            foreach($result as $output) {
                $name =  $output["name"];
                $imageName = $output["imageName"];
                $pid=$output['productId'];

                $auctionDetailQuery = $conn->query("SELECT * FROM AuctionDetail WHERE productId = '$pid' LIMIT 1")->fetch();
                $auctionDetail = $auctionDetailQuery['productId'];

                echo "
                  <div class=\"col-lg-4 col-md-6 mb-5\">
                  <div class=\"product-item\">
                    <figure>
                    <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
                    </figure>
                    <div class=\"px-4\">
                        <h3>$name</h3>
                    </div>
                    <div>
                    <p class=\"btn mr-1 rounded-3\" onclick=\"resell('$pid')\">Resell</p>
                    <p class=\"btn mr-1 rounded-3\" onclick=\"deletes('$pid')\">Delete</p>";
                    if($auctionDetail){
                     echo "<p class=\"btn mr-1 rounded-3\" onclick=\"leaveFeedback('$pid')\">Leave Feedback</p>";
                    }
                    
                echo"    </div>
                  </div>
                  </div>
                ";
              }
          } 
        ?>
    </div>
    </div>

    <div class="container">   
    <div id="inauction" class="tabcontent">

    <?php
        $query="SELECT p.start_price, p.name, s.imageName,p.productId, p.end_time
        FROM Product p, ProductImage s
        WHERE p.current_owner='$user'
        AND p.productId=s.prodID
        AND p.is_Sold=0";
        $data  =$conn->query($query) ;
        $result = $data->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class=\"row\">";
        if(!$result){
          echo "
          <div class=\"col-lg-4 col-md-6 mb-5\">
          None
          </div>
          ";
        }
        else{
          foreach($result as $output) {
              $name =  $output["name"];
              $price = $output["start_price"];
              $date = $output["end_time"];
              $imageName = $output["imageName"];
              $pid=$output['productId'];
              $currentPriceQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
                                                            FROM Bidding
                                                            WHERE productId = '$pid'")->fetch();
                                                            
              $currentPrice = $currentPriceQuery['price_bidded'];
              if(empty($currentPrice)){
                $currentPrice = $price;
              }

              $currentPrice /= $rate;
              $currentPrice = round($currentPrice, 2);
                echo "
                  <div class=\"col-lg-4 col-md-6 mb-5\">
                  <div class=\"product-item\">
                    <figure>
                    <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
                    </figure>
                    <div class=\"px-4\">
                        <h3>$name</h3>
                        <p>Current Price: $symbol $currentPrice</p>
                        <center id=\"demo\" class=\"timer\"></center> 
                        <p>End Time: $date</p>
                    </div>
                    <div>
                    <p class=\"btn mr-1 rounded-3\" onclick=\"deletes('$pid')\">Delete</p>
                    <p class=\"btn mr-1 rounded-3\" onclick=\"stopAuction('$pid')\">Stop Auction</p>
                    </div>
                  </div>
                  </div>
                ";
            }
          }
        ?>
    </div>
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
          <input type="submit" value="Confirm Resale" name="resell">
        </div>
      </form>
    </div>

    <div id="modal-delete" class="modal">
      <form class="modal-content animate" action="" method="post">
      <div class="container">
        <p>Confirm Deletion</p>
        <span onclick="document.getElementById('modal-delete').style.display='none' " class="close" title="Close PopUp">&times;</span>
        <input type="checkbox" name="deleteConfirmation" value="yes">Yes
        <input type="checkbox" name="deleteConfirmation" value="no">No<br>
        <input type="hidden" id="prodIds" name="prodId">
        <input type="submit" value="Delete" name="delete">
        </div>
      </form>
    </div>

    <div id="modal-feedback" class="modal">
      <form class="modal-content animate" action="" method="post" >
        <div class="container">
          <h3>Leave Feedback</h3>
          <span onclick="document.getElementById('modal-feedback').style.display='none' " class="close" title="Close PopUp">&times;</span>
          <input type="text" class="form-control" name="feedback" value="" placeholder="Feedback">
          <input type="hidden" id="prodIdFeedback" name="prodId">
          <input type="submit" value="Leave Feedback" name="leavefeedback">
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
        <input type="submit" value="Stop" name="stop">
        </div>
      </form>
    </div>

</div>
<script>
       document.getElementsByClassName('tablinks')[0].click(); //to set default page first
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

        

        var modal = document.getElementById('modal-wrapper');
        window.onclick = function(at) {
        if (at.target == modal) {
        modal.style.display = "none";
        }
        }

        function resell(pid){
          $("#modal-wrapper").css("display","block");
          $("#prodId").val(pid);
        }

        function deletes(pid){
          $("#modal-delete").css("display","block");
          $("#prodIds").val(pid);
        }

        function leaveFeedback(pid){
          $("#modal-feedback").css("display","block");
          $("#prodIdFeedback").val(pid);
        }

        function stopAuction(pid){
          $("#modal-stop").css("display","block");
          $("#prodIdstop").val(pid);
        }
        
      </script>
      <script src="js/jquery-3.3.1.min.js"></script>
      <script src="js/jquery-ui.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/aos.js"></script>
      <script src="js/main.js"></script>
</body>
</html>