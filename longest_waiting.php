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
  $sql = "select puppy.puppy_name from puppy LEFT JOIN 
  (
  SELECT DISTINCT MIN(date_time_posted) AS time, location FROM puppy, location WHERE location.id = puppy.location GROUP BY location
  ) AS table2
  ON 
   puppy.date_time_posted=table2.time
   WHERE puppy.date_time_posted=table2.time AND puppy.location = table2.location;";
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