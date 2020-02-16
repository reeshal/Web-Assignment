<?php
session_start();
$user=$_SESSION['username'];
require_once "../includes/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$loginquery="SELECT COUNT(loginSessionNo) AS frequency, username
             FROM LoginHistory
             GROUP BY username";

$catquery="SELECT COUNT(productId) AS freqcat, category
           FROM Product
           GROUP BY category";      

$problemquery="SELECT COUNT(problemId) AS freqprob, username
               FROM Problem
               GROUP BY username";

$result= $conn->query($loginquery);
$result2= $conn->query($catquery);
$result3= $conn->query($problemquery);

$jsonUsername=[];
$jsonFrequency=[];
$jsonfreqcat=[];
$jsoncat=[];
$jsonfreqprob=[];
$jsonprobuser=[];
while ($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract ($row);
    $jsonUsername[]= $username;
    $jsonFrequency[]= (int)$frequency;
}
while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)){
    extract ($row2);
    $jsoncat[]= $category;
    $jsonfreqcat[]= (int)$freqcat;
}
while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)){
    extract ($row3);
    $jsonprobuser[]= $username;
    $jsonfreqprob[]= (int)$freqprob;
}
?>
<html>
<head>
    <title>View Charts</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <canvas id="loginhistoryChart"></canvas>
        </div>
        </br>
        <div class="row">
            <div class="col-6">
            <canvas id="popularCategoryChart"></canvas>
            </div>

            <div class="col-6">
            <canvas id="problemRateChart"></canvas>
            </div>
        </div>
        </br>
 
    </div>
<script>
        var lhc = document.getElementById("loginhistoryChart").getContext('2d');
        var pcc = document.getElementById("popularCategoryChart").getContext('2d');
        var prc = document.getElementById("problemRateChart").getContext('2d');

        var chart = new Chart(lhc, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($jsonUsername);?>,
                datasets: [{
                    label: 'Users Login Rate',
                    backgroundColor: [
                        "#75ab7d", "#becf9d", "#fff3cb", "#f0bf8a", "#e6845f","#de425b"
                    ],
                    
                    data: <?php echo json_encode($jsonFrequency);?>
                }]
            },
            options: {
                title : {
                    display : true,
                    position : "top",
                    text : "Users Login Rate",
                    fontSize : 24,
                    fontColor : "#37474F"
                },
                legend : {
                    display : false
                },
                scales: {
                    yAxes: [{ticks: {fontSize: 20}}],
                    xAxes: [{ticks: {fontSize: 20}}]
                }
            }
        });

        var chart = new Chart(pcc, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($jsonprobuser);?>,
                datasets: [{
                    label: 'Problem Rate',
                    backgroundColor: [
                         "#396AB1", "#3E9651","#de425b","#75ab7d", "#becf9d", "#fff3cb",
                    ],
                    data: <?php echo json_encode($jsonfreqprob);?>
                }]
            },
            options: {
                title : {
                    display : true,
                    position : "top",
                    text : "Users with the most problems",
                    fontSize : 24,
                    fontColor : "#37474F"
                },
                legend:{
                    display:true,
                    labels: {
                        fontSize:16
                    }
                }           
            }
        });

        var chart = new Chart(prc, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($jsoncat);?>,
                datasets: [{
                    
                    backgroundColor: [
                        "#75ab7d", "#becf9d", "#fff3cb", "#f0bf8a", "#e6845f","#de425b"
                    ],
                    data: <?php echo json_encode($jsonfreqcat);?>
                }]
            },
            options: {
                title : {
                    display : true,
                    position : "top",
                    text : "Most sold categories",
                    fontSize : 24,
                    fontColor : "#37474F"
                },
                legend:{
                    display:true,
                    labels: {
                        fontSize:16
                    }
                }           
            }
        });
</script>
    
</body>
</html>