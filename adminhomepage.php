<?php
session_start();
require_once "includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reason=$deleteConfirmation=$pid="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $deleteConfirmation=$_POST["deleteConfirmation"];
    $reason=$_POST["reason"];
    $pid=$_POST['prodId'];
    $email=$_POST['email'];
    
    if($deleteConfirmation=="yes"){
        mail($email, "Why we deleted your product", $reason, "From: reeshalnew@gmail.com");

        $delQuery="DELETE FROM Product WHERE productId=$pid";
        $delResult =$conn->exec($delQuery) ;
        header("Location: adminhomepage.php");
    }
    else{
        header("Location: adminhomepage.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/aos.css">   
    <link rel="stylesheet" href="css/rangeslider.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="includes/myproductsTab.css">
<meta name="robots" content="noindex">
</head>
<body>
<table>
    <tr>
        <th></th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Category</th>
        <th>End time of bid</th>
        <th>Seller</th>
        <th></th>
    </tr>
<?php
$query="SELECT p.productId, p.name, p.description, p.category, i.imageName, p.end_time, p.current_owner, u.email
         FROM Product p, ProductImage i, Users u 
         WHERE p.productId=prodId
         AND u.username=p.current_owner";
$Result = $conn->query($query);         
while ($row = $Result->fetch()) {
    $pid=$row['productId'];
    $currentowner=$row['current_owner'];
    $email=$row['email'];
    echo "<tr>";	
    echo "<td><img src='http://localhost/Web-Assignment/images/".$row['imageName']."' width=150px height=100px></td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['description']."</td>";
    echo "<td>".$row['category']."</td>";
    echo "<td>".$row['end_time']."</td>";
    echo "<td>".$currentowner."</td>";
    echo "<td><button onclick=\"deletes('$pid','$email')\">Delete</button></td>";
}
?>
</table>

<div id="modal-delete" class="modal">
      <form class="modal-content animate" action="" method="post">
      <div class="container">
        <p>Confirm Deletion</p>
        <span onclick="document.getElementById('modal-delete').style.display='none' " class="close" title="Close PopUp">&times;</span>
        <input type="checkbox" name="deleteConfirmation" value="yes">Yes
        <input type="checkbox" name="deleteConfirmation" value="no">No
        <p>Give a reason why you are deleting this product</p>
        <textarea  rows="5" cols="45" name="reason"></textarea><br/>
        <input type="hidden" id="prodIds" name="prodId">
        <input type="hidden" id="email" name="email">
        <input type="submit" value="Delete">
        </div>
      </form>
    </div>
</body>
<script>
    function deletes(pid,email){
          document.getElementById("modal-delete").style.display="block";
          document.getElementById("prodIds").value=pid;
          document.getElementById("email").value=email;

        }
</script>
</html>