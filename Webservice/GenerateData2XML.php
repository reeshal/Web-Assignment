<?php
    require_once 'XML/Query2XML.php';
    require_once "../PhpFunctions/db_connect.php";

    $query2xml = XML_Query2XML::factory($conn);
    $query="SELECT p.productId, p.name, p.description,p.category, p.start_price, a.amount_paid,c.categoryId
    FROM Product p 
    JOIN AuctionDetail a ON a.productId=p.productId 
    JOIN Category c on c.categoryName=p.category";

    @$dom =$query2xml->getXML(
        $query,
        array(
            'rootTag' => 'categories',
            'idColumn' => 'categoryId', //this one is not needed
            'rowTag' => 'category',
            'elements' => array(
                'category_name'=>'category',
                'products'=>array(
                    'rootTag' => 'products',
                    'idColumn' => 'productId',
                    'rowTag' => 'product',
                    'attributes' => array('product_id' => 'productId'),
                    'elements' => array(
                        'product_name'=>'name',
                        'description',
                        'start_price',
                        'highest_bidded_price'=>'amount_paid'
                    )
                )  
            )
        )
    );

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
        print $dom->save("AuctionHouseData.xml");
    }
    
?>
