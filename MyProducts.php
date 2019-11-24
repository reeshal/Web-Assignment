<?php
session_start();
$user=$_SESSION['username'];

require_once "includes/db_connect.php";

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

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  $start_price = test_input($_POST["start_price"]);
  $duration = test_input($_POST["duration"]);
  $pid=$_POST["prodId"];
  $the_time = date('Y-m-d H:i:s');
  $endtime=date('Y-m-d H:i',strtotime('+'.$duration.' days',strtotime($the_time)));
  
  $update="UPDATE Product SET is_Sold=0, start_time='$the_time', duration=$duration, end_time='$endtime',
                              start_price=$start_price
                          WHERE current_owner='$user'
                          AND productId=$pid ";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$Result =$conn->exec($update) ;
header("Location: MyProducts.php");
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

    <link rel="stylesheet" href="includes/productsRishikesh.css">
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


    <div class="container" style="padding-left:70px; padding-top:75px">
      <div class="row tab">
        <button class="tablinks" onclick="switchTab(event, 'owned')">Items Owned</button>
        <button class="tablinks" onclick="switchTab(event, 'inauction')">Items In Auction</button>
      </div>
      <div id="owned" class="tabcontent row">
        <?php
          $query="SELECT a.date, MAX(a.amount_paid) AS pmax, p.name, s.imageName,p.productId
                  FROM Product p, AuctionDetail a, ProductImage s
                  WHERE a.productId=p.productId
                  AND p.productId=s.prodID
                  AND p.current_owner='$user'
                  AND p.is_Sold=1
                  GROUP BY p.name";
          $data  =$conn->query($query) ;
          $result = $data->fetchAll(PDO::FETCH_ASSOC);
    
          foreach($result as $output) {
              $name =  $output["name"];
              $price = $output["pmax"];
              $date = $output["date"];
              $imageName = $output["imageName"];
              $pid=$output['productId'];
              echo "
              <div class=\"auctionBox grid-item\">
                <center><a href='details.php?id=".$output['productId']."'>$name</a></center>
                <img src=\"http://localhost/Web-Assignment/images/$imageName\" width=\"248px\" height=\"200px\"/>
                <center>Amount Paid: Rs $price</center>
                <center>Date bought: $date</center>
                <button  onclick=\"resell('$pid')\">Resell</button>
                <button>Leave Feedback</button>
                </div>";
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

            echo "
            <div class=\"auctionBox grid-item\">
              <center><a href='details.php?id=".$output['productId']."'>$name</a></center>
              <img src=\"http://localhost/Web-Assignment/images/$imageName\" width=\"248px\" height=\"200px\"/>
              <center>Starting Price: Rs $price</center>
              <center>Current Price: TO BE IMPLEMENTED</center>
              <center>Time Left: TO BE IMPLEMENTED</center>
              </div>";
          }
        ?>
      </div>
      
      
    </div>
    <div id="modal-wrapper" class="modal">
      <form class="modal-content animate" action="" method="post">
        <div class="container">
          <h3>Reselling Product</h3>
          <span onclick="document.getElementById('modal-wrapper').style.display='none' " class="close" title="Close PopUp">&times;</span>
          <input type="number" class="form-control" name="start_price" value="" placeholder="Starting Price" maxlength="20">
          <input type="number" class="form-control" name="duration" value="" placeholder="Duration" maxlength="20">
          <input type="hidden" id="prodId" name="prodId">
          <input type="submit" value="Confirm Resale">
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
        
      </script>
</body>
</html>
