<?php
if(extension_loaded("mongodb"))
{
  $filter=["name"=>$_GET["name"]];
  $options=['projection' => ['_id' => 0],];
  $m=new MongoDb\Driver\Manager("mongodb://localhost:27017");
  $query=new MongoDB\Driver\Query($filter,$options);
  $cursor=$m->executeQuery("multi_rest.food",$query);
  $row=$cursor->toArray();
  $array = json_decode(json_encode($row), true); //Stores information about the item in an array
?>

<!DOCTYPE html>
<html>
<head>
<title>Item</title>
<link rel="stylesheet" type="text/css" href="food_style.css"/>	
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="contain">
<?php 
  $len=100/(count($array[0]["food_image"]));
	//echo $len;
  foreach ($array[0]["food_image"] as $image1)
  {
    ?>
    <div class="image" style="width:<?php echo $len ?>%">
      <img src="<?php echo $image1; ?>" style="width:100%;height:100%">
    </div>
    <?php 
  } ?>
</div>
<div class="food-contain">
	<h1 style="color:red"><?php echo $array[0]["name"]; ?></h1><!--Displays item name-->
	<p style="color:blue"><?php echo $array[0]["desc"]; ?></p>
    <div class="card-c">
	   <?php  foreach ($array[0]["Restaurants"] as $key ) //displays Restaurant details which serve the chosen item
      {
        //Retrieve restaurant details from restaurant table.If the restaurant details is no more available,no informtion in siplayed about it

        $filter1=["name"=>$key["rest_name"]];
        $options1=['projection' => ['_id' => 0],];
        $m=new MongoDb\Driver\Manager("mongodb://localhost:27017");
        $query1=new MongoDB\Driver\Query($filter1,$options1);
        $cursor1=$m->executeQuery("multi_rest.restaurant",$query1);
        $row1=$cursor1->toArray();
        $array1 = json_decode(json_encode($row1), true); 
        if(!empty($array1))
        {
           ?>
   	      <div class="card">
       	    <div class="card-body" style="position: relative; display: inline-block;">
   	         	  <div class="image_card">
   	 	             <img src="<?php echo $array1[0]["image"][0]; ?>" style="height: 100%;width: 100%">
   	             </div>
   	 	          <div class="card-text" >
   	 		           <h2><?php echo $key["rest_name"]; ?></h2>
   	 		           <p><?php echo "Price: ".$key["price"]; ?></p>
   	 		           <p><b><?php echo $array1[0]["location"]; ?></b></p>
   	 		               <div class="star">
                           <?php 
                           //displays rating
                            for ($x = 0; $x < $array1[0]["rating"]; $x++) {
                            ?><span class="fa fa-star checked"></span>
                            <?php }
                             for (; $x < 5; $x++) {
                             ?><span class="fa fa-star "></span>
                            <?php } ?>
                        </div>
   	 	          </div>
   	        </div>
            <a href="restaurants.php?rest_name=<?php echo $key["rest_name"] ?>" class=" stretched-link"></a>
   	    </div>
        <?php }  } ?>
    </div>
</div>
<?php } ?>
</body>
</html>