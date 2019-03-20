<?php
    error_reporting(1);
    ini_set('display_errors', 1); // Do not display errors
    $user = filter_var($_GET["user"]);
    $secret_key = filter_var($_GET["secretkey"]);
    $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "SELECT location_name
  From location, breed, puppy, puppy_breed
  WHERE puppy_breed.breed_id IN (SELECT breed_id FROM breed) AND location.id = puppy.location AND puppy_breed.breed_id = breed.id AND puppy_breed.puppy_id = puppy.id
  GROUP BY location_name
  HAVING COUNT(breed_id) != (SELECT COUNT(id) FROM breed)
  ORDER BY location_name DESC;";
  $result=mysqli_query($mysqli,$sql);
  while($row = mysqli_fetch_assoc($result)){    
    $test[] = $row;
  }

  $JSON = json_encode($test);
  header("Content-Type: application/json; charset=UTF-8");
  echo $JSON;
  mysqli_free_result($result);
  mysqli_close($mysqli);

?>