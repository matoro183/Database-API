<?php
error_reporting(0);
$user = filter_var($_GET["user"]);
$secret_key = filter_var($_GET["secretkey"]);
$table = filter_var($_GET["table"]);
if (isset($_GET["conditions"])) {
  $conditions = filter_var($_GET["conditions"]);
}
if (isset($_GET["order"])) {
  $order = filter_var($_GET["order"]);
}
if (isset($_GET["limit"])) {
  $limit = filter_var($_GET["limit"]);
}
if (!isset($user) || !isset($secret_key) || !isset($table))
{
  echo "Some of the required information is missing. Fill out the required information and try again.";
}
else {

  $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API');
	echo $mysqli->error . "\n";
  if ($mysqli->connect_errno) {
      echo "You do not have access to the database." . "\n";
      exit;
  }
  if (isset($conditions) && !isset($limit) && !isset($order)) {
  $sql = "SELECT * FROM " . $_GET["table"] . " WHERE " . $conditions . ";";
  }
  else if (isset($conditions) && isset($limit) && !isset($order))
  {
    $sql = "SELECT * FROM " . $_GET["table"] . " WHERE " . $conditions . " LIMIT " . $limit . ";";
  }
  else if (isset($conditions) && isset($limit) && isset($order))
  {
    $sql = "SELECT * FROM " . $_GET["table"] . " WHERE " . $conditions . " ORDER BY " . $order . " LIMIT " . $limit . ";";
  }
  else if (isset($conditions) && !isset($limit) && isset($order))
  {
    $sql = "SELECT * FROM " . $_GET["table"] . " WHERE " . $conditions . " ORDER BY " . $order . ";";
  }
  else if (!isset($conditions) && isset($limit) && isset($order))
  {
    $sql = "SELECT * FROM " . $_GET["table"] . " ORDER BY " . $order . " LIMIT " . $limit . ";";
  }
  else if (!isset($conditions) && !isset($limit) && isset($order))
  {
    $sql = "SELECT * FROM " . $_GET["table"] . " ORDER BY " . $order . ";";
  }
  else if (!isset($conditions) && isset($limit) && !isset($order))
  {
    $sql = "SELECT * FROM " . $_GET["table"] . " LIMIT " . $limit . ";";
  }
  else {
    $sql = "SELECT * FROM " . $_GET["table"] . ";";
  }

  $result=mysqli_query($mysqli,$sql);
  while($row = mysqli_fetch_assoc($result)){
    $test[] = $row;
  }
  $JSON = json_encode($test);
  header("Content-Type: application/json; charset=UTF-8");
  echo $JSON;
  mysqli_free_result($result);
  mysqli_close($mysqli);
}
?>
