<?php
$url='AuctionHouseData.json';
$json = file_get_contents($url);
$obj = json_decode($json, false);

use Opis\JsonSchema\{
    Validator, ValidationResult, ValidationError, Schema
};
require 'vendor/autoload.php';
$schema = Schema::fromJsonString(file_get_contents('DataValidation.json'));
$validator = new Validator();

/** @var ValidationResult $result */
$result = $validator->schemaValidation($obj, $schema);

?>
<html>
<head>
    <title>Reseller</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/signIn.css">
</head>
<body>
<div style="background:url('../images/hero_1.jpg'); background-size: cover; ">
    <div class="container" style="text-align:center;" >
        <h1>Reseller Company</h1>
        <h3>We sell secondhand products at a lower and affordable price</h3>
    </div>
    <div class="container signupBox" style="max-width:85%">
        <?php
            if(!$result->isValid()){
                /** @var ValidationError $error */
                $error = $result->getErrors();
                echo '$obj is invalid', PHP_EOL;
                
                foreach ($error as $key => $value) {
                    # code...
                    echo "Error: ", $value->keyword(), PHP_EOL;
                    echo json_encode($value->keywordArgs(), JSON_PRETTY_PRINT), PHP_EOL;
                }
            }
            else{ 
                foreach($obj as $cat){
                    $totalsum=0;
                    $count=0;
                    echo "<div class=\"row\">";
                    echo "<h2>$cat->category_name</h2>"; ?>
                    <div class="container table100 ver1 m-b-110">
                        <table>
                            <tr class="row100 head">
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Start Price</th>
                                <th>Highest Price</th>
                            </tr>
                            <?php
                                foreach ($cat->products as $product){    
                                    echo "<tr>";
                                    echo "<td>".$product->product_name."</td>";
                                    echo "<td>".$product->description."</td>";
                                    echo "<td>".$product->start_price."</td>";
                                    echo "<td>".$product->highest_bidded_price."</td>";
                                    echo "</tr>";
                                    $totalsum+=$product->highest_bidded_price;
                                    $count++;
                                }
                            ?>
                        </table>
                    </div>
                    <?php          
                    echo "</div>";
                    $avgprice=$totalsum/$count;
                    echo "<p style=\"text-align:right;\">Average Price:$avgprice</p>";
                }
            }
        ?>
    </div>
</div>
</body>
</html>