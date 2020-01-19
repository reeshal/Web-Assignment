<?php 
session_start();
require_once "../includes/db_connect.php";
require_once "../includes/phpFunctions.php";

//defining variables
$username=$password=$confirmpassword=$email="";
$errorusername=$errorpassword=$errorconfirmpassword=$erroremail="";
$confirmedpassword="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["user_name"])) {
        $errorusername = "Username is required";
    } else {
        $username = test_input($_POST["user_name"]);
    }
    if (empty($_POST["passwords"])) {
        $errorpassword = "Password is required";
    } else {
        $password = test_input($_POST["passwords"]);
    }
    if (empty($_POST["confirmpassword"])) {
        $errorconfirmpassword = "Password is required";
    } else {
        $confirmpassword = test_input($_POST["confirmpassword"]);
    }
    if (empty($_POST["emails"])) {
        $erroremail = "Email is required";
    } else {
        $email = test_input($_POST["emails"]);
    }

    //confirming password
    if(strcmp($password,$confirmpassword )==0){
        $confirmedpassword=$password;
    } else{
        $errorpassword="The 2 passwords do not match";
    }


    
    //inserting in database
    if($errorusername == "" && $errorpassword == "" && $errorconfirmpassword == "" && $erroremail ==""){
        $hashed_password = password_hash($confirmedpassword,PASSWORD_DEFAULT);
        $datetime=date('Y/m/d h:i:s ', time());
        $sInsert = "INSERT INTO Users(Username,password,email,firstname,lastname,gender, address, dob, accountType)
              VALUES('$username','$hashed_password','$email','admin','admin','admin','admin','$datetime','admin')";
         
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        $Result =$conn->exec($sInsert) ;
        //head to adminhome.php after successful login
        $_SESSION['username']=$username;
        header("Location: adminhomepage.php?referer=login");  
    }
}
?>
<html>
<head>
    <title>Admin Login Page</title>
    <link href="../includes/sign_in.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/dataValidation.js"></script>
    <script>
    function validateForm(){
        if(!checkTextBlankById('username','Username'))
            return false;
        if(!checkTextBlankById('password','Password'))
            return false;
        if(!checkTextBlankById('passwordverify','Password'))
            return false;
        if(!checkTextBlankById('email','Email'))
            return false;
    }
    </script>
</head>
<body>
<?php
if(isset($_SESSION['login'])){ 
    echo "<h3 style=\"color:red\">You are already logged in</h3>";
}//end if
else{	  
?> 
    <div class="signupBox">
        <h3 >Please fill in the form below to register as Admin</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()">
             
        <input type="text" name="user_name" value="<?php echo $username;?>" placeholder="Username" maxlength="15" id="username"><br>
        <span class="error"> <?php echo $errorusername;?></span>

        <input type="password" name="passwords" placeholder="Password" id="password"><br>
        <span class="error"> <?php echo $errorpassword;?></span>

        <input type="password" name="confirmpassword" placeholder="Confirm your password" id="passwordverify"><br>
        <span class="error"> <?php echo $errorconfirmpassword;?></span>

        <input type="email" name="emails" value="<?php echo $email;?>" placeholder="Email" id="email"><br>
        <span class="error"> <?php echo $erroremail;?></span>

        <input type="submit" value="Register">
        <input type="reset" value="Clear form">
        </form>
    </div>  
<?php
}//end else
?>
</body>
</html>