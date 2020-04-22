<?php
session_start();
$user=$_SESSION['username'];
require_once "PhpFunctions/SellerNotif.php";
require_once "PhpFunctions/feedback.php";
require_once "PhpFunctions/phpFunctions.php";
require_once "PhpFunctions/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$detailquery="SELECT password,firstname,lastname,gender,email,address,dob,currency
              FROM Users 
              WHERE username='$user'";
$resultdata=$conn->query($detailquery);
$result=$resultdata->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $output){
    $firstname=$output['firstname'];
    $lastname=$output['lastname'];
    $gender=$output['gender'];
    $email=$output['email'];
    $address=$output['address'];
    $dob=$output['dob'];
    $currency=$output['currency'];
}
$oldusername=$user;
$password="";

//button edit pressed

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $firstname = test_input($_POST["fname"]);
    $lastname = test_input($_POST["lname"]);
    $address= test_input($_POST["address"]);
    $date = test_input($_POST["dob"]);
    $date=dateformatter($date);
    $oldusername = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $gender = test_input($_POST["gender"]);
    $currency = test_input($_POST["currency"]); 

    $date=dateformatter($date);
    
    if(empty($_POST["password"])){
        $updateStmt="UPDATE USERS
        SET firstname='$firstname',lastname='$lastname',gender='$gender',email='$email',address='$address',dob='$dob',currency='$currency'
        WHERE username='$user'";
    }
    else{
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $updateStmt="UPDATE USERS
                    SET firstname='$firstname',lastname='$lastname',gender='$gender',email='$email',address='$address',dob='$dob',currency='$currency',password='$hashed_password'
                    WHERE username='$user'";
    }   
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    $Result =$conn->exec($updateStmt);
    if($Result ){	
        $_SESSION['username']=$oldusername;
        header("Location: homepage.php?referer=login");  
    }else{
        echo "<script>alert('Failed to Update Profile');</script>";
    }   
}
?>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/myprofile.css">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/dataValidation.js"></script>
    <script>
    function validateForm(){
        if(!checkTextIllegalCharactersById('fname', 'First Name field'))
            return false;
        if(!checkTextIllegalCharactersById('lname', 'Last Name field'))
            return false;
        if(!checkTextIllegalCharactersById('address', 'Address field'))
            return false;
        if(!checkTextBlankById('dob','Date of birth'))
            return false;
        if(!checkTextBlankById('gender', 'Gender'))
            return false;
        if(!checkTextBlankById('username','Username'))
            return false;
        if(!checkTextBlankById('email','Email'))
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
                      <li><a href="MyProducts.php">My Products</a></li>
                      <li><a href="Biddings.php">My Biddings</a></li>
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
    <div class="containers" style="background:url('images/myprofile.jpg'); background-size: cover; ">
        <div class="detailsBox">
            <h3>My Profile</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" onsubmit="return validateForm()">
                  First Name<input type="text" name="fname" value="<?php echo $firstname?>" id="fname">
                </br>Last Name<input type="text" name="lname" value="<?php echo $lastname?>" id="lname">
                </br>Email<input type="email" name="email" value="<?php echo $email?>" id="email">
                </br>Address<input type="text" name="address" value="<?php echo $address?>" id="address">
                </br>Date of Birth<input type="date" name="dob" value="<?php echo $dob?>" id="dob">
                </br>Gender<input type="text" name="gender" value="<?php echo $gender?>" id="gender">
                </br>Currency</br><input type="text" value="<?php echo $currency?>" style="width:55%">
                <select name="currency" id="currency">
                    <?php
                    $currencyquery="SELECT currency FROM Currency";
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $dataa =$conn->query($currencyquery) ;
                    $results = $dataa->fetchAll(PDO::FETCH_ASSOC);
                    foreach($results as $outputs) {
                        $currencyOutput=$outputs['currency'];
                        echo "<option value=\"$currencyOutput\">$currencyOutput</option>";
                    }
                    ?>
                    </select>
                </br>Username<input type="text" name="username" value="<?php echo $oldusername?>" id="username" >   
                </br>Password<input type="text" name="password" placeholder="Insert new password" id="password" > 
                </br><input type="submit" value="Edit">
            </form> 
        </div>              
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>