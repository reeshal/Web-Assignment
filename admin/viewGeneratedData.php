<?php
session_start();
$user=$_SESSION['username'];
require_once "../PhpFunctions/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>All XML JSON</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="../includes/myproductsTab.css">
    <link rel="stylesheet" href="../includes/table.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="robots" content="noindex">

    <script>
    $(document).ready(function(){
        $("button#dom").click(function(){
            $("div#loadData").load("../Webservice/GenerateDataDOM.php");
        });
        $("button#2query").click(function(){
            $("div#loadData").load("../Webservice/GenerateData2XML.php");
        });
        $("button#json").click(function(){
            $("div#loadData").load("../Webservice/GenerateDataJSON.php");
        });
    });
    </script>

</head>
<body>
    <div class="container">
        <p>Generating Data into XML:</p>
        <button class="btn btn-primary" id="dom">DOM</button>
        <button class="btn btn-primary" id="2query">Query2XML</button></br></br>

        <p>Generating Data into JSON:</p>
        <button class="btn btn-primary" id="json">JSON</button>
    </div>
    </br></br>
    <div class="container" id="loadData">
     
    </div>
</body>

<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</html>