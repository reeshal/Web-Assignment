<?php
session_start();

require_once "PhpFunctions/phpFunctions.php";
//$user="Username"; //to display the name of the user for the dropdown box
$user="";
if(isset($_GET['referer'])){
  if($_GET['referer'] == 'login')
  {
    $user=$_SESSION['username'];
  }//end if
}
require_once "PhpFunctions/SellerNotif.php";
require_once "PhpFunctions/db_connect.php";
$min = 0;
$max = 10000;
$search=$category=$query="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if (!empty($_POST["tags"]))
    $search=test_input($_POST["tags"]);
  if (!empty($_POST["category"]))
    $category=test_input($_POST["category"]);
  if (! empty($_POST['min_price']))
      $min = $_POST['min_price'];
  if (! empty($_POST['max_price'])) 
      $max = $_POST['max_price'];
}

require_once "PhpFunctions/feedback.php";

//Getting ToCurrency of user
if($user != ""){
  $ToCurrencyQuery = $conn->query("SELECT c.code as code
                                   FROM Users u, Currency c
                                   WHERE u.currency = c.currency
                                   AND username = '$user'")->fetch();
                                                           
  $ToCurrency = $ToCurrencyQuery['code'];

  //Setting Currency Symbol
  $locale='en-US'; //browser or user locale
  $fmt = new NumberFormatter( $locale."@currency=$ToCurrency", NumberFormatter::CURRENCY );
  $symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  

<script type="text/javascript">
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 10000,
      values: [ <?php echo $min; ?>, <?php echo $max; ?> ],
      slide: function( event, ui ) {
        $( "#amount" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		$( "#min" ).val(ui.values[ 0 ]);
		$( "#max" ).val(ui.values[ 1 ]);
      }
      });
    $( "#amount" ).html( "$" + $( "#slider-range" ).slider( "values", 0 ) +
     " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  });
  </script>

  <style>
  .form-price-range-filter {
      text-align: center;
  }

  #min {
    float: left;
    width: 65px;
    height:35px;
    padding: 5px 10px;
    margin-right: 14px;
    border-radius:10px;
  }

  #slider-range {
    width: 75%;
    float: left;
    margin: 5px 0px 5px 0px;
  }

  #max {
    float: right;
    width: 65px;
    height:35px;
    padding: 5px 10px;
    margin-right: 14px;
    border-radius:10px;
  }
  </style>

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
                <li><a href="faq.php"><span>FAQ</span></a></li>
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
            <nav class="site-navigation position-relative text-sleft " style="margin-left: -100px" role="navigation">
               <ul class="site-menu js-clone-nav ">
                <li class="has-children">
                  <span><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="MyProfile.php">My Profile</a></li>
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
                <li><a href="faq.php?referer=login"><span>FAQ</span></a></li>
                <li><a href="ContactUs.php?referer=login"><span>Contact</span></a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/notification.png"></a>
                  <ul class="dropdown-menu" >
                  <?php
                  $query="SELECT notiffDetails FROM Notifications WHERE username='$user'";
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
                  <li class="btn" id="clearbtn">Clear</li>
                  </ul>                  
                </li>
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
    <div class="background-image" style="background-image: url(images/coverproduct.png); " data-aos="fade" > 
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
                  <div class="row">
                  <div class="col-1"></div>
                  <div class="col-10">
                    <div class="form-price-range-filter">
                        <input type="" id="min" name="min_price" value="<?php echo $min; ?>">
                        <div id="slider-range"></div>
                        <input type="" id="max" name="max_price" value="<?php echo $max; ?>">
                    </div>
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
      $query = "SELECT DISTINCT(p.productId), p.name, p.start_price, i.imageId, i.imageName,  p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                FROM Product p, ProductImage i, ProductTag t			
                where p.productId = i.prodId
                AND  p.is_sold = 0	
                AND p.current_owner != '$user'
                AND p.productId = t.productId
                AND p.start_price BETWEEN $min AND $max
                AND p.category LIKE  '%$category%'
                AND (t.product_tags LIKE '%$search%'
                OR p.name LIKE '%$search%')";

      $data  =$conn->query($query) ;
      $result = $data->fetchAll(PDO::FETCH_ASSOC);

      if(!$result)
        echo "<h2 style=text-align:center>Sorry. No results found</h2>";
      else{
      echo "<div class=\"container\">";
      echo "<div class=\"row\">";
      foreach($result as $output) {
          $name =  $output["name"];
          $start_time = $output["start_time"];
          $end_time = $output["end_time"];
          $prodId = $output["productId"];
          $imageId = $output["imageId"];
          $imageName = $output["imageName"];
          $desc=$output["description"];

          $currentPriceQuery = $conn->query("SELECT MAX(price_bidded) as price_bidded
                                                           FROM Bidding
                                                           WHERE productId = '$prodId'")->fetch();
                                                           
          $currentPrice = $currentPriceQuery['price_bidded'];

         if(empty($currentPrice)){
          $currentPrice = $output["start_price"];
         }

         //Getting FromCurrency of seller
         $FromCurrencyQuery = $conn->query("SELECT c.code as code
                                            FROM Users u, Product p, Currency c
                                            WHERE u.username = p.current_owner
                                            AND u.currency = c.currency
                                            AND p.productId = '$prodId'")->fetch();
                                                           
          $FromCurrency = $FromCurrencyQuery['code'];

        if($user!=""){
          //Currency conversion if necessary
          if($FromCurrency != $ToCurrency) {
            $FromCurrency = urlencode($FromCurrency);
            $ToCurrency = urlencode($ToCurrency);	
            $encode_amount = 1;
            $url  = "https://www.google.com/search?q=".$FromCurrency."+to+".$ToCurrency;

           /* $curl_handle=curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Auction House');
            $get = curl_exec($curl_handle);
            curl_close($curl_handle);*/

            $get = file_get_contents($url);
            $data = preg_split('/\D\s(.*?)\s=\s/',$get);
           // if (!empty($data[1]))
            $exhangeRate = (float) substr($data[1],0,7);
            $currentPrice = $currentPrice*$exhangeRate;
            $currentPrice = round($currentPrice, 2);
          }

          echo "
          <div class=\"col-lg-4 col-md-6 mb-5\">
          <div class=\"product-item\">
            <figure>
            <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
            </figure>
            <div class=\"px-4\">
                <h3>$name</h3>
                <p>$desc</p>
                <p>$symbol $currentPrice</p>
            </div>
            <div>
            <a href='details.php?id=".$output['productId']."' class=\"btn mr-1 rounded-3\">View</a>
            </div>
          </div>
          </div>

          ";
          
        }
        else{
          //Setting Currency Symbol of seller
          $locale='en-US'; //browser or user locale
          $fmt = new NumberFormatter( $locale."@currency=$FromCurrency", NumberFormatter::CURRENCY );
          $symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

          echo "
          <div class=\"col-lg-4 col-md-6 mb-5\">
          <div class=\"product-item\">
            <figure>
            <img src=\"http://localhost/Web-Assignment/images/$imageName\" alt=\"Image\" class=\"image-size\">
            </figure>
            <div class=\"px-4\">
                <h3>$name</h3>
                <p>$desc</p>
                <p>$symbol $currentPrice</p>
            </div>
          </div>
          </div>

          ";
        }
      }
      echo "</div>"; 
      echo "</div>";  
    }
      ?>
      

        </div>
</div>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/rangeslider.min.js"></script>
  <script src="js/main.js"></script>

</body>
</html>