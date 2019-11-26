<?php
session_start();
session_destroy();
?>

<html>
<head>
    <title>You have logged out</title>
</head>
<body>
    <p>You have sucessfully logged out</p><br>
    <a href="login.php">Login</a><br>
    <a href="signup.php">Signup</a>
</body>
</html>