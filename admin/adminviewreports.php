<?php
session_start();
$user=$_SESSION['username'];
require_once "../includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<html>
<head>
    <title>Problems Reported</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../includes/table.css">
</head>
<body>
<div class="site-wrap">
    <!--Start of header-->
    <header class="site-navbar py-2 bg-white" role="banner">
      <div class="container">
        <div class="row align-items-center"> <!--creating a row to insert the header-->
        <div class="col-3">
            <nav class="site-navigation position-relative text-left " style="margin-left: -100px" role="navigation">
               <ul class="site-menu js-clone-nav ">
                <li class="has-children">
                  <span><?php echo $user?></span>
                  <ul class="dropdown">
                      <li><a href="">My Profile</a></li>
                      <li><a href="adminlogout.php">Logout</a></li>
                  </ul>
                </li>
                </ul>
              </nav>
          </div>
          <div class="col-9 ">
          <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="adminhomepage.php"><span>Home</span></a></li>
                <li><a href="adminhomepage.php"><span>View all Products</span></a></li>
                <li><a><span>Problems</span></a></li>
                <li><a href="#charts"><span>Charts</span></a></li>
                <li><a href="#others"><span>Other Tools</span></a></li>
              </ul>
            </nav>
          </div>
        </div>  
      </div>  
      </header>
    <!--End of header-->

    <!--problems-->
    <div class="site-section ">
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
    <!-- end of problems-->
</div>
</body>
</html>