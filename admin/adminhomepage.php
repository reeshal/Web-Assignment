<?php
session_start();
$user=$_SESSION['username'];
require_once "../PhpFunctions/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$reason=$deleteConfirmation=$pid="";
$question=$category=$solution="";
$deleteConfirmationFaq="";
$deleteuser="";
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["deleteproduct"])){
        $deleteConfirmation=$_POST["deleteConfirmation"];
        $reason=$_POST["reason"];
        $pid=$_POST['prodId'];
        $email=$_POST['email'];
        if($deleteConfirmation=="yes"){
            if(mail($email, "Why we deleted your product", $reason)){
                $delQuery="DELETE FROM Product WHERE productId=$pid";
                $delResult =$conn->exec($delQuery) ;
                header("Location: adminhomepage.php?referer=login");
            }
            else{
                echo "<script>alert('Email not sent');</script>";
            }    
        }
        else{
            header("Location: adminhomepage.php?referer=login");
        }
    }

    if(isset($_POST["insertquestion"])){
        $question=$_POST["question"];
        $category=$_POST["category"];
        $solution=$_POST["solution"];
        $insertquery="INSERT INTO FAQ(question,answer,category)
                      VALUES('$question','$category','$solution')";
        $resultinsert=$conn->exec($insertquery);
        if($resultinsert){
            header("Location: adminhomepage.php?referer=login");
        }
        else{
            echo "<script>alert('failed')</script>";
        }
    }

    if(isset($_POST["deletefaq"])){
        $deleteConfirmationFaq=$_POST["deleteConfirmationfaq"];
        $faqId=$_POST["faqId"];
        if($deleteConfirmationFaq=="yes"){
            $delStm="DELETE FROM FAQ WHERE faqId=$faqId";
            $delresult=$conn->exec($delStm);
            if($delresult){
                header("Location: adminhomepage.php?referer=login");
            }
            else{
                echo "<script>alert('failed');</script>";  
            }
        }
        else{
            header("Location: adminhomepage.php?referer=login");
        }    
    }

    if(isset($_POST["deleteuser"])){
        $deleteuser=$_POST["deleteConfirmationuser"];
        $email=$_POST["emailuser"];
        $userdelete=$_POST["usernamedel"];
        if($deleteuser=="yes"){
            $delStm="DELETE FROM Users WHERE username='$userdelete'";
            $delresult=$conn->exec($delStm);
            if($delresult){
                header("Location: adminhomepage.php?referer=login");
            }
            else{
                echo "<script>alert('failed');</script>";  
            }
        }
        else{
            header("Location: adminhomepage.php?referer=login");
        } 
    }
}
?>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/myproductsTab.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
   
    <meta name="robots" content="noindex">
    <script>
         $(document).ready(function () {

             $("#viewproduct").click(function(){
                $("#viewproduct").addClass("active");
                $("div#details").load("viewproducts.php");
                $("div#details").fadeIn();
                $("div#viewfaqs,div#viewusers,div#viewreports").fadeOut(); 
                $("#viewchart,#viewuser,#viewcurrency,#viewfaq,#viewreport,#generatedata").removeClass("active");
             });

             $("#viewchart").click(function(){
                $("#viewchart").addClass("active");
                $("div#details").load("viewcharts.php");
                $("div#details").fadeIn();
                $("div#viewfaqs,div#viewusers,div#viewreports").fadeOut(); 
                $("#viewproduct,#viewuser,#viewcurrency,#viewfaq,#viewreport,#generatedata").removeClass("active");
             });

             $("#viewuser").click(function(){
                $("div#details").html("");
                $("#viewuser").addClass("active");
                $("div#viewusers").css("display","block");
                $("div#viewfaqs,div#viewreports").fadeOut(); 
                $("#viewproduct,#viewchart,#viewcurrency,#viewfaq,#viewreport,#generatedata").removeClass("active");
             });

             $("#viewcurrency").click(function(){
                $("#viewcurrency").addClass("active");
                $("div#details").load("viewcurrencies.php");
                $("div#details").fadeIn();
                $("div#viewfaqs,div#viewreports,div#viewusers").fadeOut(); 
                $("#viewproduct,#viewchart,#viewuser,#viewfaq,#viewreport,#generatedata").removeClass("active");
             });

             $("#viewfaq").click(function(){
                $("div#details").html("");
                $("#viewfaq").addClass("active");
                $("div#viewreports,div#viewusers").fadeOut(); 
                $("#viewproduct,#viewchart,#viewuser,#viewcurrency,#viewreport,#generatedata").removeClass("active");
                $("div#viewfaqs").css("display","block");
             });

             $("#viewreport").click(function(){
                $("div#details").html("");
                $("#viewreport").addClass("active");
                $("div#viewreports").css("display","block");
                $("div#viewfaqs,div#viewusers").fadeOut(); 
                $("#viewproduct,#viewchart,#viewuser,#viewcurrency,#viewfaq,#generatedata").removeClass("active");
             });

             $("#generatedata").click(function(){
                $("div#details").html("");
                $("#generatedata").addClass("active");
                $("div#details").load("viewGeneratedData.php");
                $("div#details").fadeIn();
                $("div#viewfaqs,div#viewusers,div#viewreports").fadeOut(); 
                $("#viewproduct,#viewchart,#viewuser,#viewcurrency,#viewfaq,#viewreport").removeClass("active");
             });

             $('.deletequestion').click(function(){
                 var questionId=$(this).attr('id');
                 $("#modal-delete-question").css("display","block");
                 $("#faqIdmodal").val(questionId);
             });

            $("button#createcurrency").click(function(){
                console.log("Create currency clicked on Jquery");
                $("div#modal-wrapper").css("display","block");
                console.log("Modal displayed");
            });
                            
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
                <h5 style="text-align:center">Management</h5><hr>
                <li id="viewproduct"><a>All Products</a></li>
                <li id="viewuser"><a>Users</a></li>
                <li id="viewcurrency"><a>Currencies</a></li>
                <li id="viewfaq"><a>FAQ</a></li><hr>
                <h5 style="text-align:center">Other Tools</h5><hr>
                <li id="viewreport"><a>View Reports</a></li>
                <li id="viewchart"><a>View Charts</a></li> 
                <li id="generatedata"><a>Generate XML/JSON</a></li> 
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
                        echo "<td><button class=\"btn btn-primary\" onclick=\"deleteUser('$username','$emailuser')\">Remove User</button></td>";
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
                    ?>
                        <tr>	
                        <td><?php echo $rows['question']?></td>
                        <td><?php echo $rows['answer']?></td>
                        <td><?php echo $rows['category']?></td>
                        <td><button class="btn  btn-primary deletequestion" id="<?php echo $faqid?>">Delete Question</button></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </table>
                </div>
                </br></br>
                <div class="container">    
                    <form method="post" action="" class="bg-light p-5 contact-form">
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
                        <input type="submit" value="Insert Question" class="btn btn-primary py-2 px-4" name="insertquestion">
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

        <div id="modal-delete-question" class="modal">
            <form class="modal-content animate" action="" method="post">
            <div class="container">
            <p>Confirm Deletion</p>
            <span onclick="document.getElementById('modal-delete-question').style.display='none' " class="close" title="Close PopUp">&times;</span>
            <input type="checkbox" name="deleteConfirmationfaq" value="yes">Yes
            <input type="checkbox" name="deleteConfirmationfaq" value="no">No
            <input type="hidden" id="faqIdmodal" name="faqId">
            <input type="submit" value="Delete" name="deletefaq">
            </div>
            </form>
        </div>      
        
        <div id="modal-delete-user" class="modal">
            <form class="modal-content animate" action="" method="post">
            <div class="container">
                <p>Confirm Deletion</p>
                <span onclick="document.getElementById('modal-delete-user').style.display='none' " class="close" title="Close PopUp">&times;</span>
                <input type="checkbox" name="deleteConfirmationuser" value="yes">Yes
                <input type="checkbox" name="deleteConfirmationuser" value="no">No
                <p>Give a reason why you are deleting this user</p>
                <textarea  rows="5" cols="45" name="reason"></textarea><br/>
                <input type="hidden" id="usernamedel" name="usernamedel">
                <input type="hidden" id="emailuser" name="emailuser">
                <input type="submit" value="Remove User" name="deleteuser">
                </div>
            </form>
        </div>  

        <div id="modal-wrapper" class="modal">
            <form class="modal-content animate" action="" method="post">
                <div class="container">
                    <h3>Adding new Currency</h3>
                    <span onclick="document.getElementById('modal-wrapper').style.display='none' " class="close" title="Close PopUp">&times;</span>
                    <input type="text" class="form-control" name="CurrencyName" value="" placeholder="Currency Name"  >
                    <input type="text" class="form-control" name="Code" value="" placeholder="Currency Code">
                    <input type="submit" value="Add Currency" name="addCurrency">
                </div>
            </form>
        </div>

        <!--Add currency popup-->
        <!--div id="modal-wrapper" class="modal" style="display:block;">
            <form class="modal-content animate" action="" method="post" >
                <div class="container">
                    <h3>Adding new Currency</h3>
                    <span onclick="document.getElementById('modal-wrapper').style.display='none' " class="close" title="Close PopUp">&times;</span>
                    <input type="text" class="form-control" name="CurrencyName" value="" placeholder="Currency Name"  >
                    <input type="text" class="form-control" name="Code" value="" placeholder="Currency Code" min="3" maxlength="3">
                    <input type="submit" value="Add Currency" name="addCurrency">
                </div>
            </form>
        </div-->    


        <script>
        function deleteUser(username, email){
                $("#modal-delete-user").css("display","block");
                $("#usernamedel").val(username);
                $("#emailuser").val(email);
        }

        function addCurrency(){
            console.log("Create currency clicked on JS");
            document.getElementById("modal-wrapper").style.display="block";
           // $("#modal-wrapper").css("display","block");
        }
        </script>
</div>
</body>
</html>