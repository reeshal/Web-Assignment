<?php
$url='http://localhost/Web-Assignment/Webservice/AuctionHouseData.xml';
require_once "XMLErrorFunctions.php";

$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;
@$dom->load($url);
libxml_use_internal_errors(true);
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
            if(!$dom->schemaValidate('DataValidation.xsd')){
                print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
                libxml_display_errors();
            }
            else{ 
                $xmlstr = file_get_contents($url);
                $categories = new SimpleXMLElement($xmlstr);
                foreach($categories->category as $cat_node){
                    echo "<div class=\"row\">";
                    echo "<h2>$cat_node->category_name</h2>"; ?>
                    <div class="container table100 ver1 m-b-110">
                        <table>
                            <tr class="row100 head">
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Start Price</th>
                                <th>Highest Price</th>
                            </tr>
                            <?php
                                foreach ($cat_node->products->product as $product_node){    
                                    echo "<tr>";
                                    echo "<td>".$product_node->product_name."</td>";
                                    echo "<td>".$product_node->description."</td>";
                                    echo "<td>".$product_node->start_price."</td>";
                                    echo "<td>".$product_node->highest_bidded_price."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <?php          
                    echo "</div>";
                    echo "</br>";
                }
            }
        ?>
    </div>
</div>
</body>
</html>