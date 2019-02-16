<?php
    error_reporting(0);
    ini_set('display_errors', 0); // Do not display errors
    $user = filter_var($_GET["user"]);
$secret_key = filter_var($_GET["secretkey"]);
$mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API');// Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "SELECT breed AS breed_name, COUNT(Puppies.puppy_ID) AS numpups FROM Puppies LEFT JOIN Purchases ON Puppies.puppy_ID = Purchases.puppy_ID WHERE Purchases.puppy_ID IS NULL GROUP BY Puppies.breed ORDER BY Puppies.breed;";

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