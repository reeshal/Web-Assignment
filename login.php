<?php
// Initialize the session
session_start();
require_once "PhpFunctions/phpFunctions.php";

$username = $passwords =$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["username"])) {
        $username_err = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
    }
    if (empty($_POST["password"])) {
        $password_err = "Password is required";
    } else {
        $passwords= test_input($_POST["password"]);
    }
    if($username_err == "" && $password_err == "" ){
        require_once "PhpFunctions/db_connect.php";
        $sQuery = "SELECT username,password, accountType FROM Users WHERE username = '$username'  ";

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $Result = $conn->query($sQuery) ;
        $userResults = $Result->fetch(PDO::FETCH_ASSOC);
        if($userResults['username'])//the user exists
        {	
            //save hashed passwrd from database into this variable
            $hashed_password = $userResults['password'];

            //can only use this function if we are using default passwrd hashing in signup page
            if(password_verify($passwords,$hashed_password)){
                $_SESSION['username'] = $username;
                //echo $_SESSION['username'];

                //to save data in table loginhistory //pna timezone Maurice
                $datetime=date('Y/m/d h:i:s ', time());
                $insertLogin="INSERT INTO LoginHistory(username, login_time)
                              VALUES(".$conn->quote($username).",".$conn->quote($datetime).")";
                $a=$conn->exec($insertLogin) ;

                $type=$userResults['accountType'];
                if(strcmp($type,"normal")==0)
                    header("Location: homepage.php?referer=login");
                else
                    header("Location: admin/adminhomepage.php?referer=login");

            }
            else{
                $password_err = "Wrong password";
            }	
        }else{
            $username_err = "Wrong Username";
        }
  }
}
?>

<html>
<head>
    <title>Login Page</title>
    <link href="css/signIn.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/dataValidation.js"></script>
    <script>
    function validateForm(){
        if(!checkTextBlankById('username','Username'))
            return false;
        if(!checkTextBlankById('password','Password'))
            return false;
    }
    </script>
</head>
<body>
<div class="containers" style="background:url('images/login.jpg'); background-size: cover; height: 100%">
    <div class="signUpBox">
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()">
        <i class="fa fa-user"></i>
        <input style="width:90%" type="text" name="username" placeholder="Username"  id="username">
        <span class="error"> <?php echo $username_err;?></span><br>

        <i class="fa fa-lock"></i>
        <input style="width:90%" type="password" name="password" placeholder="Password" id="password">
        <span class="error"> <?php echo $password_err;?></span>
        <br>   
        <input type="submit" value="Sign In">
        <input type="reset" value="Clear">
        <p>Dont have an Account?<a href="signup.php">Sign Up now.</a></p>

    </form>
    </div>

</div>
</body>
</html>