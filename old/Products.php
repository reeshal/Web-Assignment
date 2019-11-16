<html>
 <head>
    <title>Products</title>
    <!--link href="includes/sign_in.css" type="text/css" rel="stylesheet" /-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <style>
	li a.active {
	    background-color: #4CAF50;
	    color: white;
	}

	li a:hover:not(.active) {
	    background-color: #555;
	    color: white;
	}

	.grid-container {
	  display: grid;
	  grid-template-columns: auto auto auto;
	  grid-column-gap: 100px;
	}

	.grid-item {
	  font-size: 15px;
	}

	div.auctionBox{
		width:  250px;
  		border: 1px solid black;
		height: 300px;
 		margin: 20px;
	}

	.btn{
		width : 60%;
	}

   </style>

   <script> 
	var deadline = new Date("Jan 5, 2020 15:37:25").getTime(); 
	var x = setInterval(function() { 
	var now = new Date().getTime(); 
	var t = deadline - now; 
	var days = Math.floor(t / (1000 * 60 * 60 * 24)); 
	var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
	var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)); 
	var seconds = Math.floor((t % (1000 * 60)) / 1000); 
	document.getElementById("demo").innerHTML = days + "d "  
	+ hours + "h " + minutes + "m " + seconds + "s "; 
	    if (t < 0) { 
		clearInterval(x); 
		document.getElementById("demo").innerHTML = "EXPIRED"; 
	    } 
	}, 1000); 
</script> 

 </head>
    <body>
	<?php
		$category="";
	 ?>
          <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
		  <ul class="navbar-nav">
		    <li class="nav-item">
		      <a class="nav-link" href="Home.php">Home</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link active" href="Products.php">Products</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" href="MyBiddings.php">My Biddings</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" href="MyProducts.php">My Products</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" href="Help.php">Help</a>
		    </li>
	 	 </ul>
	</nav>
	<div class="grid-container">
		<div class="grid-item">
			Browse Categories:
		<select name="category" class="browser-default custom-select">
		 <option value="" selected="selected" <?php if($category == "") {echo "selected"; }?>>--None--</option>
		 <option value="Vehicles"  <?php if($category == "Vehicles") {echo "selected";}?>>Vehicles</option>
		 <option value="Technologies" <?php if($category == "Technologies") {echo "selected";}?>>Technologies</option>
		 <option value="Fashion" <?php if($category == "Fashion") {echo "selected";}?>>Fashion</option>
		 <option value="Household" <?php if($category == "Household") {echo "selected";}?>>Household</option>
		</select>
		</div>
		
		<div class="search-container grid-item">
		    Search for a particular product:
		    <form action="">
		      <input type="text" placeholder="Search Product" name="search">
		      <button type="submit"><i class="fa fa-search"></i></button>
		    </form>
	  	</div>
	</div>
	<?php
		require_once "includes/db_connect.php";
		
		$query = "SELECT p.productId, p.name, p.start_price, i.imageName, p.is_sold, p.category FROM Product p, ProductImage i 			where p.productId = i.prodId";
		
		
		$data  =$conn->query($query) ;
		$result = $data->fetchAll(PDO::FETCH_ASSOC);

		echo "<div class=\"grid-container\">";
		foreach($result as $output) {
		  $name =  $output["name"];
		  $start_price = $output["start_price"];
		 // $imagePath = $output["imagePath"];
		  $imageName = $output["imageName"];

		  echo "
		<div class=\"auctionBox grid-item\">
		  <center>$name</center>
		  <img src=\"http://localhost/test/images/$imageName\" width=\"248px\" height=\"150px\"/>
		  <center>Rs $start_price</center>
		  <center id=\"demo\"></center> 
		  <center><button type=\"button\" class=\"btn btn-success\">Bid</button></center>
	        </div>";
		}
		echo "</div>";
		
	 ?>

		
    </body>
</html>
