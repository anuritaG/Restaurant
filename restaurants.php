<?php 
if(extension_loaded("mongodb"))
{
  $filter=["name"=>$_GET["rest_name"]];
  $options=['projection' => ['_id' => 0],];
  $m=new MongoDb\Driver\Manager("mongodb://localhost:27017");
  $query=new MongoDB\Driver\Query($filter,$options);
  $cursor=$m->executeQuery("multi_rest.restaurant",$query);
  $row=$cursor->toArray();
  $array = json_decode(json_encode($row), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restaurants</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="restaurant_style.css" />
</head>
<body>
<div class="contain">
<!--Carousel -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="width:100%;">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" style="width:100%">
        <div class="item active" >
           <img src="<?php echo $array[0]["image"][0]; ?>"alt="Los Angeles" style="width:100%;height:25rem">
        </div>
        <div class="item">
           <img src="<?php echo $array[0]["image"][1] ?>" alt="Chicago"  style="width:100%;height:25rem">
        </div>
        <div class="item">
           <img src="<?php echo $array[0]["image"][2] ?>" alt="New york" style="width:100%;height:25rem">
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</div>
<div class="centre">
   <h1 style="font-size: 4rem"><?php echo $array[0]["name"];?></h1>
   <h3 style="font-size: 2rem"><?php echo $array[0]["location"];?></h3>
   <div class="rating" style="width:10%;margin-bottom: 20px">
       <div class="star">
       <?php 
        for ($x = 0; $x < $array[0]["rating"]; $x++) 
          { 
            ?>
            <span class="fa fa-star checked"></span>
            <?php 
          }
        for (; $x < 5; $x++) 
          { 
            ?>
            <span class="fa fa-star "></span>
            <?php 
          } 
          ?>
       </div>
   </div>
   <div class="service" style="width:30%;">
      <h3 style="font-size: 2rem">Services</h3>
        <ul>
          <?php
          foreach ($array[0]["service"] as $doc) 
          {
              ?>
              <li>
                <p style="font-size:1.7rem"> <?php echo $doc;?> </p>
              </li>
              <?php  
          } 
          ?>
       </ul>
   </div>
</div>
<?php 
} 
?>
</body>
</html>