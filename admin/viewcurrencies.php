<?php
session_start();
$user=$_SESSION['username'];
require_once "../PhpFunctions/db_connect.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>All currencies</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="../includes/myproductsTab.css">
    <link rel="stylesheet" href="../includes/table.css">

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="robots" content="noindex">

    <script>
         $(document).ready(function () {
            //Getting list of currencies
            var url = "http://localhost/CurrencyWebService/list";
		
        $.ajax({
            url: url,
            accepts: "application/json",
            headers:{Accept:"application/json"},
            method: "POST", 
            error: function(xhr){
                if(xhr.status == 404)
                {
                    $("div#showcurrencies").html("No currencies were found");
                }
                else
                {
                    alert("An error occured: " + xhr.status + " " + xhr.statusText);
                    console.log("An error occured: " + xhr.status + " " + xhr.statusText);
                }
            }
        })
        .done(function(data)
        {	
          
            var table_str = "<table><tr class=\"row100 head\"><th>Currency Name</th><th>Code</th><th>Conversion Rate</th></tr>";
           
            $.each(data.output, function(i,obj) {
                table_str = table_str + "<tr>";		
                table_str = table_str + "<td>" + obj['currency'] + "</td>" ;		
                table_str = table_str + "<td>" + obj['code'] + "</td>";
                table_str = table_str + "<td>" + obj['conversion_rate'] + "</td>";	
                table_str = table_str + "</tr>";					
            });
            table_str = table_str + "</table>";
            $("div#showcurrencies").html(table_str);
        });

        //Adding currency
        $("input#addCurrency").click(function(){
			
		var url = "http://localhost/CurrencyWebService/create";
		
		$.ajax({
			url: url,
			headers:{Accept:"application/json" },
			
			method: "POST", 
			data:{
                    currency: $("input#CurrencyName").val() , 
					rate: $("input#rate").val() ,
					code: $("input#Code").val() ,
			},
			error: function(xhr){
      			alert("An error occured: " + xhr.status + " " + xhr.statusText);
      		}
    	})
    	.done(function(data)
    	{	
			//alert("Currency added");
		});
    });

     //Deleting currency
     $("input#submitdelete").click(function(){
            console.log("submit delete");
			var code = $("input#codetodelete").val();
            var url = "http://localhost/CurrencyWebService/delete/" + code;
            
            $.ajax({
                url: url,
                headers:{Accept:"application/json" },
                
                method: "POST", 
               
                error: function(xhr){
                      alert("An error occured: " + xhr.status + " " + xhr.statusText);
                  }
            })
            .done(function(data)
            {	
                //alert("Currency deleted");
            });
        });
    
    
    //Updating conversion Rates
    $("button#LoadCR").click(function(){
        console.log("Load Conversion Rates clicked");
        $("div#spinner").css("visibility","visible");
        $.ajax({
                    type: 'POST',
                    url: '../PhpFunctions/CurrencyConversion.php',
                    success: function(data) {
                        $("div#spinner").css("visibility","hidden");
                        location.reload(true);
                    }
        });


    });

         //Displaying add currency popup
        $("button#createcurrency").click(function(){
            console.log("Create currency clicked on Jquery");
            $("div#modal-add").css("display","block");
        });

        //Displaying delete currency popup
        $("button#deletecurrency").click(function(){
            console.log("Delete currency clicked on Jquery");
            $("div#modal-delete").css("display","block");
        });



         });
    </script>
</head>
<body>
    <div>
        <button class="btn" id="createcurrency">Add Currency</button>
        <button class="btn" id="deletecurrency">Delete Currency</button>
        <button class="btn" id="LoadCR">Load Conversion Rates</button>
        <div id="spinner" class="spinner-border" style="visibility:hidden"></div>
        <div id="showcurrencies" class="container table100 ver1 m-b-110">
        
        </div>
    </div>


    <div id="modal-add" class="modal">
            <form class="modal-content animate" action="" method="post">
                <div class="container">
                    <h3>Adding new Currency</h3>
                    <span onclick="document.getElementById('modal-add').style.display='none' " class="close" title="Close PopUp">&times;</span>
                    <input id="CurrencyName" type="text" class="form-control" name="CurrencyName" value="" placeholder="Currency Name"  >
                    <input id="Code" type="text" class="form-control" name="Code" value="" placeholder="Currency Code" maxlength="3">
                    <input id="rate" type="number" placeholder="Conversion Rate(To $)" step="0.01" min="0">
                    <input id="addCurrency" type="submit" value="Add Currency" name="addCurrency">
                </div>
            </form>
    </div>

    <div id="modal-delete" class="modal">
            <form class="modal-content animate" action="" method="post">
                <div class="container">
                    <h3>Deleting Currency</h3>
                    <span onclick="document.getElementById('modal-delete').style.display='none' " class="close" title="Close PopUp">&times;</span>
                    <input id="codetodelete" type="text" class="form-control" name="codetodelete" value="" placeholder="Currency Code"  maxlength="3">
                    <input id="submitdelete" type="submit" value="Delete Currency" name="deleteCurrency">
                </div>
            </form>
    </div>


</body>
</html>
