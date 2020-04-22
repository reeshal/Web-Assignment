<?php 
session_start();
require_once "PhpFunctions/db_connect.php";
require_once "PhpFunctions/phpFunctions.php";

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
    
    //inserting in database
    if($errorfirstname == "" && $errorlastname == "" && $erroraddress == "" && $errordate == "" && $errorusername == "" && $errorpassword == "" && $errorconfirmpassword == "" && $erroremail =="" && $errorgender == "" && $errorcurrency == ""){
        $hashed_password = password_hash($confirmedpassword,PASSWORD_DEFAULT);
        
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
    <link href="css/signIn.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/dataValidation.js"></script>

    <script>
    function validateForm(){
        if(!checkTextIllegalCharactersById('first_name', 'First Name field'))
            return false;
        if(!checkTextIllegalCharactersById('last_name', 'Last Name field'))
            return false;
        if(!checkTextIllegalCharactersById('address', 'Address field'))
            return false;
        if(!checkTextBlankById('dob','Date of birth'))
            return false;
        if(!checkRadioSetClickedByName('gender', 'Gender'))
		    return false;	
        if(!checkTextBlankById('username','Username'))
            return false;
        if(!checkTextBlankById('password','Password'))
            return false;
        if(!checkTextBlankById('passwordverify','Password'))
            return false;
        if(!checkTextBlankById('email','Email'))
            return false;
        if(!setDefaultValue('currency'))  //if value is empty it is set to US dollars
            $("#currency").val("US Dollars");

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
<div class="containers" style="background:url('images/signup2.jpg'); background-size: cover;">
    <div class="signupBox">
        <h3 >Please fill in the form below to register</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()">

        <input type="text" name="first_name" value="<?php echo $firstname;?>" placeholder="Firstname" maxlength="20" id="first_name"><br>
        <span class="error"> <?php echo $errorfirstname;?></span>

        <input type="text" name="last_name" value="<?php echo $lastname;?>" placeholder="Lastname" maxlength="20" id="last_name" ><br>
        <span class="error"> <?php echo $errorlastname;?></span>

        <input type="text" name="address" value="<?php echo $address;?>" placeholder="Address" maxlength="50" id="address"><br>
        <span class="error"> <?php echo $erroraddress;?></span>
        
        <input type="date" name="dob" id="dob"><br>
        <span class="error"> <?php echo $errordate;?></span>

        <div class="containers" style="border-bottom: 1px solid ;border-bottom-color: #7971ea;">           
            Gender<br><input type="radio" name="gender" value="male">Male 
            <input type="radio" name="gender" value="female">Female
            <input type="radio" name="gender"value="others" >Others                 
        </div>
        <span class="error"> <?php echo $errorgender;?></span>

        <div class="containers" style="border-bottom: 1px solid ;border-bottom-color: #7971ea;">
            Currency
            <div class="select">
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
            </div>
        </div>
             
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
                <!--include button bck to login-->
        </form>
    </div>  
  </div>
<?php
}//end else
?>
</body>
</html>  