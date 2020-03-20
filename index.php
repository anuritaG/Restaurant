<?php
if(extension_loaded("mongodb"))
{
  $options=['projection' => ['_id' => 0],];
  $m=new MongoDb\Driver\Manager("mongodb://localhost:27017");
//Search by food name
  if(isset($_GET["search"]))
  {
    $var=$_GET["foodname"];
    $filter=["name"=>$var];
    $query=new MongoDB\Driver\Query($filter,$options);
    $cursor=$m->executeQuery("multi_rest.food",$query);
    $row=$cursor->toArray();
//If search by foodname fails,the tags are searched
    if(empty($row))
    {
      $var=$_GET["foodname"];
      $filter=["tags"=>$var];
      $query=new MongoDB\Driver\Query($filter,$options);
      $cursor=$m->executeQuery("multi_rest.food",$query);
      $row=$cursor->toArray();
      if(empty($row))
      {
         ?>
        <h2 style="position: relative;margin-top: 8%;">Search Results Not Found</h2>
        <?php 
       } 
    }
  }
  else
  {
//All items are displayed    
  $filter=[];
  $query=new MongoDB\Driver\Query($filter,$options);
  $cursor=$m->executeQuery("multi_rest.food",$query);
  $row=$cursor->toArray();
  }
	?>
<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 <link rel="stylesheet" type="text/css" href="index_style.css" />
</head>
<body>
   <nav class="navbar navbar-expand-sm bg-dark fixed-top " >
	   <div class="col-xl-11">
	     <ul class="navbar-nav">
          <li class="nav-item">
            <form class="form-inline" action="" method="GET">
      	       <div class="col-xs-10">
            	   <input class="form-control mr-sm-2"  name="foodname" type="text" placeholder="search" style="font-size: 1rem;">
               </div>
      	       <div class="input-group-prepend">
      	          <button type="submit" name="search"><i class="fa fa-search"></i></button>
               </div>
            </form>
           </li>
       </ul>
     </div>
   </nav>
   <div class="content" >
     <div class="card-columns">
      	<?php foreach ($row as $doc) 
        {
            $array = json_decode(json_encode($doc), true);	?>
			      <div class="card" >
    	             <img class="card-img-top" src="<?php echo $array["food_image"][0] ?>" alt="card image cap" style="height: 70%">  
  			           <div class="card-body" style="height:30%;padding: 1%">
  				 		         <p class="card-text" style="font-size: 2rem;"><b><?php echo $array["name"] ?></b></p>
  				 		         <div class="desc-card" >
  				 		               <p class="card-desc text-truncate" style="font-size: 1rem;">
  				 		               <?php echo $array["desc"]?></p>
                       </div>
  				 		         <a href="food.php?name=<?php echo $array["name"] ?>" class=" stretched-link"></a>
  			           </div>
  		      </div>
  	        <?php 
        } 
        ?>
    	</div>
   </div>
   <?php  
 }
 ?>
</body>
</html>