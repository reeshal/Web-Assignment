<?php
    require_once "../PhpFunctions/db_connect.php";
    $query="SELECT categoryName FROM Category";
    
    $result = $conn->query($query);
    $full_array =array();
	$categories_array = array();
	$products_array = array();
    while($row=$result->fetch()){
        $categoryname=$row['categoryName'];
        $categories_array['category_name']=$categoryname;
        $categories_array['products']=array();

        $innerquery="SELECT p.name, p.description,p.start_price, a.amount_paid
                    FROM Product p
                    JOIN AuctionDetail a ON a.productId=p.productId
                    WHERE p.category='$categoryname'";

        $result2 = $conn->query($innerquery);
        if($result2->rowCount()!=0){
            while($row=$result2->fetch()){
                $products_array['product_name']=$row['name'];
                $products_array['description']=$row['description'];
                $products_array['start_price']=$row['start_price'];
                $products_array['highest_bidded_price']=$row['amount_paid'];
                array_push($categories_array['products'],$products_array);
            }
            array_push($full_array ,$categories_array);
        }
        
    }
    
    //validating
    use Opis\JsonSchema\{
   		 Validator, ValidationResult, ValidationError, Schema
	};
    require 'vendor/autoload.php';
    $encoded = json_encode($full_array, JSON_NUMERIC_CHECK);  //encoding such as all digits are integers and not strings
    $decoded = json_decode($encoded);
    $schema = Schema::fromJsonString(file_get_contents('DataValidation.json'));
    $validator = new Validator();
      
	/** @var ValidationResult $result */
    $result = $validator->schemaValidation($decoded, $schema);
    if ($result->isValid()) {
        header('Content-Type: application/json'); 
        $jasondata=json_encode($decoded,JSON_PRETTY_PRINT);
        file_put_contents("AuctionHouseData.json",$jasondata);
    }
    else{
        /** @var ValidationError $error */
	    $error = $result->getErrors();
	    echo '$encoded is invalid', PHP_EOL;
	    
	    foreach ($error as $key => $value) {
	    	# code...
	    	echo "Error: ", $value->keyword(), PHP_EOL;
	    	echo json_encode($value->keywordArgs(), JSON_PRETTY_PRINT), PHP_EOL;
	    }
    }
?>