<?php
    error_reporting(1);
    ini_set('display_errors', 1); // Do not display errors
    $user = filter_var($_GET["user"]);
    $secret_key = filter_var($_GET["secretkey"]);
    $query = filter_var($_GET["query"]);
    $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "SELECT MATCH(description) AGAINST ('" . $query . "' IN BOOLEAN MODE) AS score FROM puppy ORDER BY score DESC;";
  $result=mysqli_query($mysqli,$sql);
  $row = mysqli_fetch_assoc($result);
  $test = $row["score"];
  $JSON = json_encode($test);
  header("Content-Type: application/json; charset=UTF-8");
  echo $JSON;
  mysqli_free_result($result);
  mysqli_close($mysqli);

?>