<?php
    error_reporting(0);
    ini_set('display_errors', 0); // Do not display errors
    $user = filter_var($_GET["user"]);
    $secret_key = filter_var($_GET["secretkey"]);
    $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "SELECT puppy_name, age FROM puppy WHERE id NOT IN (SELECT puppy_id from puppy_immunization);";

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