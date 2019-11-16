<?php
session_start();
?>

<html>
<head>
    <title>Logout</title>
</head>
<body>
<?php
if(isset($_GET['referer'])){
    if($_GET['referer'] == 'login'){
   	 echo "Welcome " . $_SESSION['username'];
      }//end if
      /*
  	if($_GET['referer'] == 'review'){  //inserted in review.php{
   	 echo "Please <a href='login.php'>login</a> first to complete a review";
  	}//end if*/
  }//end if(isset($_GET['referer']))
?>    
    <a href="logout.php">Click here to logout</a><br>
    <a href="signup.php">Sign Up</a>
</body>    
</html>