<?php
session_start();
$user=$_SESSION['username'];
require_once "../includes/db_connect.php";
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
        header("Location: admin.php");
    }
    else{
        header("Location: admin.php");
    }
}
?>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../includes/table.css">
    <meta name="robots" content="noindex">
    <script>
         $(document).ready(function () {
             $("#viewproduct").click(function(){
                $("#viewproduct").addClass("active");
                $("div#details").load("viewproducts.php");
                $("div#details").fadeIn();
                $("div#viewfaqs").fadeOut(); 
                $("div#viewusers").fadeOut(); 
                $("div#viewreports").fadeOut(); 
             })

             $("#viewchart").click(function(){
                $("#viewchart").addClass("active");
                $("div#details").load("viewcharts.php");
                $("div#details").fadeIn();
                $("div#viewfaqs").fadeOut(); 
                $("div#viewusers").fadeOut(); 
                $("div#viewreports").fadeOut();
             })

             $("#viewuser").click(function(){
                $("div#details").html("");
                $("div#viewfaqs").fadeOut();
                $("div#viewreports").fadeOut();
                $("#viewuser").addClass("active");
                $("div#viewusers").css("display","block");
             })

             $("#viewfaq").click(function(){
                $("div#details").html("");
                $("div#viewusers").fadeOut();
                $("div#viewreports").fadeOut();
                $("#viewfaq").addClass("active");
                $("div#viewfaqs").css("display","block");
             })

             $("#viewreport").click(function(){
                $("div#details").html("");
                $("div#viewusers").fadeOut();
                $("div#viewfaqs").fadeOut();
                $("#viewreport").addClass("active");
                $("div#viewreports").css("display","block");
             })
         });
    </script>
</head>
<body>
<div class="viewport">
<!-- Sidebar Holder -->
    <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Dashboard</h3>   
            </div>
            
            <ul class="list-unstyled components">
                <p>Management</p>
                <li id="viewproduct"><a>All Products</a></li>
                <li id="viewuser"><a>Users</a></li>
                <li id="viewfaq"><a>FAQ</a></li>
                <p>Other Tools</p>
                <li id="viewreport"><a>View Reports</a></li>
                <li id="viewchart"><a>View Charts</a></li> 
                <li><a href="adminlogout.php">Logout</a></li>
            </ul>
    </nav>            


            <div id="details" style="display:none"></div>
            <!--View User-->
            <div id="viewusers" style="display:none">
                <div class="container table100 ver1 m-b-110">
                    <table >
                    <tr class="row100 head">
                        <th>Username</th>
                        <th>firstname</th>
                        <th>lastname</th>
                        <th>Date of Birth</th>
                        <th></th>
                    </tr>
                    <?php
                    $queryuser="SELECT username,firstname,lastname,dob,email 
                                FROM Users
                                WHERE accountType='normal'";
                    $Resultuser = $conn->query($queryuser);         
                    while ($rows = $Resultuser->fetch()) {
                        $username=$rows['username'];
                        $emailuser=$rows['email'];
                        echo "<tr>";	
                        echo "<td>".$username."</td>";
                        echo "<td>".$rows['firstname']."</td>";
                        echo "<td>".$rows['lastname']."</td>";
                        echo "<td>".$rows['dob']."</td>";
                        echo "<td><button class=\"btn\" onclick=\"deleteUser('$username','$emailuser')\">Remove User</button></td>";
                        echo "</tr>";
                    }
                    ?>
                    </table>
                </div>
            </div>
            
            <!--View FAQ-->
            <div id="viewfaqs" style="display:none" >
                <div class="container table100 ver1 m-b-110">
                    <table >
                    <tr class="row100 head">
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                    <?php
                    $queryfaq="SELECT faqId, question, answer, category 
                                FROM FAQ";
                    $Resultfaq = $conn->query($queryfaq);         
                    while ($rows = $Resultfaq->fetch()) {
                        $faqid=$rows['faqId'];
                        echo "<tr>";	
                        echo "<td>".$rows['question']."</td>";
                        echo "<td>".$rows['answer']."</td>";
                        echo "<td>".$rows['category']."</td>";
                        echo "<td><button class=\"btn\" onclick=\"deleteCategory('$faqid')\">Delete Question</button></td>";
                        echo "</tr>";
                    }
                    ?>
                    </table>
                </div>
                </br></br>
                <div class="container">    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["HTTP_REFERER"]);?>" class="bg-light p-5 contact-form">
                    <h3 class="text-center">Insert a new Frequently Asked Question</h3></br>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Question" name="question">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Category" name="category">
                    </div>
                    <div class="form-group">
                        <textarea cols="30" rows="7" class="form-control" placeholder="Solution" name="solution" ></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Insert Question" class="btn btn-primary py-2 px-4" >
                    </div>
                </form>
                </div>
            </div>

            <!--View Reports-->
            <div id="viewreports" style="display:none">
            <div class="container table100 ver1 m-b-110">
                <table >
                <tr class="row100 head">
                    <th>Subject</th>
                    <th>User</th>
                    <th>Description</th>
                </tr>
                <?php
                $probquery="SELECT description,subject,username FROM Problem";
                $Result = $conn->query($probquery);         
                while ($row = $Result->fetch()) {
                    echo "<tr >";	
                    echo "<td style=\"line-height:3.0;\">".$row['subject']."</td>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>".$row['description']."</td>";
                    echo "</tr>";
                }
                ?>
                </table>
            </div>
            </div>
                    

</div>
</body>
</html>