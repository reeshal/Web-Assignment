<?php
    require_once "../PhpFunctions/db_connect.php";
    $query="SELECT categoryId, categoryName FROM Category";

    $result = $conn->query($query);    
    $dom = new DOMDocument( "1.0");
    $root=$dom->createElement("categories");
    
    while($row = $result->fetch()){
        
        
        $categoryname=$row['categoryName'];
        
        $innerquery="SELECT p.productId, p.name, p.description,p.start_price, a.amount_paid
                    FROM Product p
                    JOIN AuctionDetail a ON a.productId=p.productId
                    WHERE p.category='$categoryname'";

        $result2 = $conn->query($innerquery);
        if($result2->rowCount()!=0){
            $categorynode=$dom->createElement("category");
            $productsnode=$dom->createElement("products");
            $cat_name_node=$dom->createElement("category_name",$categoryname);
            $categorynode->appendChild($cat_name_node);

            while($row=$result2->fetch()){
                $product_node=$dom->createElement("product");
                $product_node->setAttribute("product_id",$row['productId']);
                
                $productname=$dom->createElement('product_name',$row['name']);
                $product_node->appendChild($productname);
    
                $productdesc=$dom->createElement('description',$row['description']);
                $product_node->appendChild($productdesc);
    
                $productprice=$dom->createElement('start_price',$row['start_price']);
                $product_node->appendChild($productprice);
    
                $producthighestbidded=$dom->createElement('highest_bidded_price',$row['amount_paid']);
                $product_node->appendChild($producthighestbidded);
    
                $productsnode->appendChild($product_node);
            }
    
            $categorynode->appendChild($productsnode);
            $root->appendChild($categorynode);
        }      
    }

    $dom->appendChild($root); 

    //validating
    require_once "../PhpFunctions/XMLErrorFunctions.php";
    libxml_use_internal_errors(true);
    if (!$dom->schemaValidate('DataValidation.xsd')) {
        print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
        libxml_display_errors();
    }
    else{
        header('Content-Type: application/xml');
        $dom->formatOutput = true;
        print $dom->saveXML();
        print $dom->save("AuctionHouseDataDOM.xml");
    }
?>