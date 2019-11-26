<?php 
session_start();

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

//defining variables
$firstname=$lastname=$address=$date=$username=$password=$confirmpassword=$email=$gender=$currency="";
$errorfirstname=$errorlastname=$erroraddress=$errordate=$errorusername=$errorpassword=$errorconfirmpassword=$erroremail=$errorgender=$errorcurrency="";
$confirmedpassword="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //checking emptiness
    if (empty($_POST["first_name"])) {
        $errorfirstname = "First name is required";
    } else {
        $firstname = test_input($_POST["first_name"]);
    }
    if (empty($_POST["last_name"])) {
        $errorlastname = "Lastname is required";
    } else {
        $lastname = test_input($_POST["last_name"]);
    }
    if (empty($_POST["address"])) {
        $erroraddress = "Address is required";
    } else {
        $address= test_input($_POST["address"]);
    }
    if (empty($_POST["dob"])) {
        $errordate = "Date is required";
    } else {
        $date = test_input($_POST["dob"]);
    }
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
    if (empty($_POST["gender"])) {
    $errorgender = "Gender is required";
    } else {
    $gender = test_input($_POST["gender"]);
    }

    if (empty($_POST["currency"])) {
        $errorcurrency = "Currency is required";
    } else {
        $currency = test_input($_POST["currency"]); 
    }
    
    //confirming password
    if(strcmp($password,$confirmpassword )==0){
        $confirmedpassword=$password;
    } else{
        $errorpassword="The 2 passwords do not match";
    }

    $date=dateformatter($date);

    /*Verifying variables after submission
    echo $firstname;echo $lastname;echo $address;echo $date;echo $username;echo $password;echo $confirmpassword;echo $email;echo $gender;echo $currency;
    echo "\n";
    echo $errorfirstname;echo $errorlastname;echo $erroraddress;echo $errordate;echo $errorusername;echo $errorpassword;echo $errorconfirmpassword;echo $erroremail;echo $errorgender;echo $errorcurrency;
    */      
    
    //inserting in database
    if($errorfirstname == "" && $errorlastname == "" && $erroraddress == "" && $errordate == "" && $errorusername == "" && $errorpassword == "" && $errorconfirmpassword == "" && $erroremail =="" && $errorgender == "" && $errorcurrency == ""){
        $hashed_password = password_hash($confirmedpassword,PASSWORD_DEFAULT);
        require_once "includes/db_connect.php";
        //$insertUser="INSERT INTO LoginHistory(username,login_time) VALUES(".$conn-> quote($_SESSION['username']).$conn->time().")";

        $sInsert = "INSERT INTO Users(Username,password,firstname,lastname,gender,email,address,dob,currency)
              VALUES(" . $conn->quote($username) ."," . $conn->quote($hashed_password) ."," . $conn->quote($firstname) ."," . $conn->quote($lastname) ."," . $conn->quote($gender) ."," . $conn->quote($email) ."," . $conn->quote($address) ."," . $conn->quote($date) .",". $conn->quote($currency) .")";

        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        $Result =$conn->exec($sInsert) ;
        if($Result ){	
            $Msg = "!Success";
            echo $Msg;
        }else{
            $Msg = "ERROR: Your credentials could not be saved!";
            echo $Msg;
        }
        //head to home.php after successful login
        $_SESSION['username']=$username;
        header("Location: homepage.php?referer=login");  
    }
}
?>

<html>
<head>
    <title>Signup Page</title>
    <link href="includes/sign_in.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
if(isset($_SESSION['login'])){ 
    echo "<h3 style=\"color:red\">You are already logged in</h3>";
}//end if
else{	  
?> 
    <div class="signupBox">
        <h3 >Please fill in the form below to register</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input type="text" name="first_name" value="<?php echo $firstname;?>" placeholder="Firstname" maxlength="20" ><br>
        <span class="error"> <?php echo $errorfirstname;?></span>

        <input type="text" name="last_name" value="<?php echo $lastname;?>" placeholder="Lastname" maxlength="20" ><br>
        <span class="error"> <?php echo $errorlastname;?></span>

        <input type="text" name="address" value="<?php echo $address;?>" placeholder="Address" maxlength="50" ><br>
        <span class="error"> <?php echo $erroraddress;?></span>
        
        <input type="date" name="dob"><br>
        <span class="error"> <?php echo $errordate;?></span>

        <div class="container">           
            Gender<br><input type="radio" name="gender" value="male">Male 
            <input type="radio" name="gender" value="female">Female
            <input type="radio" name="gender"value="others" >Others                 
        </div>
        <span class="error"> <?php echo $errorgender;?></span>

        <div class="containerCurrency">
            Currency<br>
            <div class="select">
                <select name="currency">
                    <option value="US Dollars" selected="selected" <?php if($currency == "US Dollars") {echo "selected";}?>>US Dollars</option>
                    <option value="Euro"<?php if($currency == "Euro") {echo "selected";}?>>Euro</option>
                    <option value="Mauritian Rupees"<?php if($currency == "Mauritian Rupees") {echo "selected";}?>>Mauritian Rupees</option>
                    <!-- 
                    <option value="Rand"<?php //if($currency == "Dollars") {echo "selected";}?>>Rand</option>
                    <option value="Yen"<?php //if($currency == "Dollars") {echo "selected";}?>>Yen</option>
                    <option value="Indian Rupee"<?php //if($currency == "Dollars") {echo "selected";}?>>Indian Rupee</option>
                    <option value="British Pound"<?php //if($currency == "Dollars") {echo "selected";}?>>British Pound</option> -->
                </select>
            </div>
        </div>
                <!--<span class="error"> <?php //echo $errorcurrency;?></span>-->
             
        <input type="text" name="user_name" value="<?php echo $username;?>" placeholder="Username" maxlength="15" ><br>
        <span class="error"> <?php echo $errorusername;?></span>

        <input type="password" name="passwords" placeholder="Password"><br>
        <span class="error"> <?php echo $errorpassword;?></span>

        <input type="password" name="confirmpassword" placeholder="Confirm your password"><br>
        <span class="error"> <?php echo $errorconfirmpassword;?></span>

        <input type="email" name="emails" value="<?php echo $email;?>" placeholder="Email"><br>
        <span class="error"> <?php echo $erroremail;?></span>

        <input type="submit" value="Register">
        <input type="reset" value="Clear form">
                <!--include button bck to login-->
        </form>
    </div>  
<?php
}//end else
?>
</body>
</html>  