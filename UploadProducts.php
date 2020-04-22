<?php
session_start();
require_once "PhpFunctions/phpFunctions.php";
require_once "PhpFunctions/db_connect.php";
//$user="Username"; //to display the name of the user for the dropdown box
$user=$_SESSION['username'];
require_once "PhpFunctions/SellerNotif.php";
require_once "PhpFunctions/feedback.php";

?>
<?php
//defining variables
$product_name=$description=$tags=$start_price=$category=$start_time=$duration="";
$errorproduct_name=$errordescription=$errorstart_price=$errorcategory=$errorstart_time=$errorduration="";
   
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["product_name"])) {
		$errorproduct_name = "Product name is required";
	} else {
		$product_name = test_input($_POST["product_name"]);
	} 
	$category = test_input($_POST["category"]);			
	if (empty($_POST["start_price"])) {
		$errorstart_price = "Starting price is required";
	} else {
		$start_price = test_input($_POST["start_price"]);
	}
	if (empty($_POST["duration"])) {
			  $errorduration = "Duration of auction is required";
	} else {
			  $duration = test_input($_POST["duration"]);
	}
	
	//Inserting Product record
	if($errorproduct_name == ""  && $errorstart_price == "" &&  $errorduration == ""){
	    $username = $user;
		$the_time = date('Y-m-d H:i:s');
		$duration += 3; //Timezone
		$endtime=date('Y-m-d H:i',strtotime('+'.$duration.' hours',strtotime($the_time)));

		//Converting starting price of product to USD
		$rateQuery = $conn->query("SELECT c.conversion_rate as rate
                                   FROM Users u, Currency c
                                   WHERE u.username = '$username'
                                   AND u.currency = c.currency")->fetch();
                                                           
		$rate = $rateQuery['rate'];
		$start_price *= $rate; 

	    $insert = "INSERT INTO Product(name, description, start_price, category, start_time, duration, current_owner, end_time)
			 VALUES(" . $conn->quote($product_name) .", " . $conn->quote($description) .", " . $conn->quote($start_price) .", " . $conn->quote($category) .", " . $conn->quote($the_time) .", " . $conn->quote($duration) .", " . $conn->quote($username) .", " . $conn->quote($endtime) .")";
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$conn->beginTransaction() ;
		$Result =$conn->exec($insert) ;

		$query = "SELECT MAX(productId) AS prodId FROM Product";
		$data  =$conn->query($query) ;
		$userResults = $data->fetch(PDO::FETCH_ASSOC);
		
		$productid =  $userResults['prodId'];
		//Inserting Product tags
		if(!empty($_POST["product_tags"])){
			$tags = test_input($_POST["product_tags"]);
			$tags = explode(" ",$tags);
			foreach ($tags as $str) {
				$insert = "INSERT INTO ProductTag(productId, product_tags)
						VALUES($productid," . $conn->quote($str) .")";
				$Result =$conn->exec($insert) ;
				/*
				if(!$Result){
					$conn->rollBack();	
					die();
				}*/
			}
		}
	
		//Inserting image of product in database
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		$imagename = $_FILES["image"]["name"]; 
		$insert = "INSERT INTO ProductImage(prodId, imageName)
					VALUES($productid, " . $conn->quote($imagename) .")";
		$Result =$conn->exec($insert) ;/*
		if(!$Result){
			$conn->rollBack();	
			die();
		}
		$conn->commit();*/
	}
	header("Location: MyProducts.php");
  }
?>
<html lang="en">
<head>
<title>Sell Products</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/signIn.css">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/dataValidation.js"></script>

	<script>
    function validateForm(){
        if(!checkTextBlankById('product_name','Product Name'))
            return false;
        if(!checkTextBlankById('startprice','Start Price'))
            return false;
        if(!checkTextBlankById('duration','Duration'))
            return false;
		if(!checkDropDownListById('category', '' , 'Please select a category '))
 			return false;
    }
    </script>

</head>
<body>
	<!--Start of header-->
    <header class="site-navbar py-2 bg-white" role="banner">
      <div class="container">
        <div class="row align-items-center"> <!--creating a row to insert the header-->
        <div class="col-3">
            <nav class="site-navigation position-relative text-left " style="margin-left: -100px" role="navigation">
               <ul class="site-menu js-clone-nav ">
                <li class="has-children">
                  <span><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="MyProfile.php">My Profile</a></li>
                      <li><a href="MyBiddings.php">My Biddings</a></li>
                      <li><a href="homepage.php">Logout</a></li>
                  </ul>
                </li>
                </ul>
              </nav>
        </div>
          <div class="col-9">
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
                  <li class="btn" id="clearbtn">Clear</li>
                  </ul>                  
                </li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>
    </header>
	<!--End of header-->
	<div>
		edede
</div>
	<div class="containers" style="background:url('images/hero_1.jpg'); background-size: cover;">
	<div class="signupBox">
		<h3>Create product to sell</h3>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" onsubmit="return validateForm()">
	        <input type="text" name="product_name" value="<?php echo $product_name;?>" placeholder="Product Name" maxlength="20" id="product_name">
		     <span class="error"> <?php echo $errorproduct_name;?></span>

	        <input type="text" name="description" value="<?php echo $description;?>" placeholder="Description" maxlength="50"><br>
			 <span class="error"> <?php echo $errordescription;?></span><br>
			 Category
			<select name="category" class="browser-default custom-select" id="category">
			<?php
                          $categoryQuery="SELECT categoryName FROM Category";
                          $dataa  =$conn->query($categoryQuery) ;
                          $results = $dataa->fetchAll(PDO::FETCH_ASSOC);
                          foreach($results as $outputs) {
                            $categoryOutput=$outputs["categoryName"];
                            echo "<option value=\"$categoryOutput\">$categoryOutput</option>";
                          }
            ?>
			</select><br>
			<span class="error"> <?php echo $errorcategory;?></span><br>

			<input type="text" name="product_tags" value="<?php echo $tags;?>" placeholder="Tags(Seperate tags by space)" maxlength="100"><br><br>

		     Upload picture of product<!--onChange="validateAndUpload(this);" -->
        	<input type="file" name="image" id="image" accept="image/*" required="true"><br><br>

		     <input type="number" class="form-control" name="start_price" value="<?php echo $start_price;?>" placeholder="Starting Price" min="1" maxlength="20" id="startprice">
		     <span class="error"> <?php echo $errorstart_price;?></span><br>

       		<input type="number" class="form-control" name="duration" value="<?php echo $duration;?>" placeholder="Duration(hours)" min="1" maxlength="20" id="duration">
			<span class="error"> <?php echo $errorduration;?></span>

			<input type="submit" value="Upload Product" class="btn">
            <input type="reset" value="Clear form" style="width:100px;">
		</form>
	</div>
	</div>

	

<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>