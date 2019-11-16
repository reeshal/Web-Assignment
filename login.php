<?php
// Initialize the session
session_start();

// Define variables and initialize with empty values
$username = $passwords = "";
$username_err = $password_err = "";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
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
        require_once "includes/db_connect.php";
        $sQuery = "SELECT username,password FROM Users WHERE username = '$username'  ";

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $Result = $conn->query($sQuery) ;
        $userResults = $Result->fetch(PDO::FETCH_ASSOC);
        //echo $userResults['username'];
        //echo $userResults['password'];
        //echo $passwords;
        if($userResults['username'])//the user exists
        {	
            //save hashed passwrd from database into this variable
            $hashed_password = $userResults['password'];
            /*
            echo $hashed_password;
            echo "<br>";
            echo $passwords;*/
            //can only use this function if we are using default passwrd hashing in signup page
            if(password_verify($passwords,$hashed_password)){
                $_SESSION['username'] = $username;
                //echo $_SESSION['username'];

                //to save data in table loginhistory //pna timezone Maurice
                $datetime=date('Y/m/d h:i:s ', time());
                $insertLogin="INSERT INTO LoginHistory(username, login_time)
                              VALUES(".$conn->quote($username).",".$conn->quote($datetime).")";
                $a=$conn->exec($insertLogin) ;
                

                header("Location: homepage.php?referer=login");
            }
            else{
                $password_err = "Wrong password";
                //echo $Msg;
            }	
        }else{
            $username_err = "Wrong Username";
        //echo $Msg;
        }
  }
}
?>

<html>
<head>
    <title>Login Page</title>
    <link href="includes/sign_in.css" type="text/css" rel="stylesheet" />
</head>
<body>
    
<?php
if(isset($_SESSION['username'])){ 
    //echo "<h3 style=\"color:red\">You are already logged in</h3>";
    header("Location: homepage.php?referer=login");  //upon trying to login , you go directly to home
}//end if
else{	  
?>
    
    <div class="signUpBox">
    <h2>Login</h2>
    <form action="" method="post">
        <i class="fa fa-user"></i>
        <input style="width:90%" type="text" name="username" placeholder="Username" value="<?php echo $username;?>">
        <span class="error"> <?php echo $username_err;?></span><br>

        <i class="fa fa-lock"></i>
        <input style="width:90%" type="password" name="password" placeholder="Password">
        <span class="error"> <?php echo $password_err;?></span>
        <br>   
        <input type="submit" value="Sign In">
        <input type="checkbox">Remember Me 
        <input type="reset" value="Clear">
        <p>Dont have an Account?<a href="signup.php">Sign Up now.</a></p>

    </form>
    </div>
<?php
  }//end else
?>    
  
</body>
</html>