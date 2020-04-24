<?php
    require_once "db_connect.php";

    $CurrencyQuery = "SELECT * FROM Currency";
    $data  =$conn->query($CurrencyQuery) ;
    $result = $data->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $output) {
        $code = $output["code"];
        if($code != "USD"){
            $fromCurrency = urlencode($code);
            $encode_amount = 1;
            $url  = "https://www.google.com/search?q=".$fromCurrency."+to+USD";
            $get = file_get_contents($url);
            $data = preg_split('/\D\s(.*?)\s=\s/',$get);
            $exhangeRate = (float) substr($data[1],0,7);
    
            $update = "UPDATE Currency
                       SET conversion_rate = ". $conn->quote($exhangeRate) ."
                       WHERE code = '$code'";
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
            $Result =$conn->exec($update) ;
        }
       
    }

?> 

