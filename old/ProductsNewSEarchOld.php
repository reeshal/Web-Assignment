<?php   
      if($search=="" && $category==""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageId, i.imageName, p.is_sold, p.category,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i 			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user' ";
      }
      else if($search=="" && $category!=""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageId, i.imageName,  p.is_sold, p.category,p.start_time, p.end_time,p.description  
                  FROM Product p, ProductImage i 			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.category='$category'";
      }
      else if($search!="" && $category==""){
        $query = "SELECT DISTINCT (p.productId), p.name, p.start_price, i.imageId, i.imageName,  p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i, ProductTag t			
                  where p.productId = i.prodId
                  AND p.productId = t.productId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND (t.product_tags LIKE '%$search%'
                  OR p.name LIKE '%$search%')";
                  /*
                  UNION
                  SELECT p.productId, p.name, p.start_price, i.imageId, i.imageName,  p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i		
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.name LIKE '%$search%'";*/
      }
      else if($search!="" && $category!=""){
        $query = "SELECT p.productId, p.name, p.start_price, i.imageId, i.imageName,  p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i, ProductTag t			
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.productId = t.productId
                  AND t.product_tags LIKE '%$search%'
                  AND p.category='$category'
                  UNION
                  SELECT p.productId, p.name, p.start_price, i.imageId, i.imageName,  p.is_sold, p.category ,p.start_time, p.end_time,p.description 
                  FROM Product p, ProductImage i		
                  where p.productId = i.prodId
                  AND  p.is_sold = 0	
                  AND p.current_owner != '$user'
                  AND p.name LIKE '%$search%'
                  AND p.category='$category'";
                       }
      ?>