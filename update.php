<?php
error_reporting(0);
$user = filter_var($_GET["user"]);
$secret_key = filter_var($_GET["secretkey"]);
$table = filter_var($_GET["table"]);
$set = filter_var($_GET["set"]);
if ($_GET["conditions"] != NULL) {
  $conditions = filter_var($_GET["conditions"]);
}
if ($user == NULL || $secret_key == NULL || $table == NULL || $set == NULL)
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
  if ($conditions != NULL) {
  $sql = "UPDATE " . $_GET["table"] . " SET " . $set . " WHERE " . $conditions . ";";
}
  else {
    $sql = "UPDATE " . $_GET["table"] . " SET " . $set . ";";
  }
  if (!$result = $mysqli->query($sql)) {
      echo "Query failed\n";
      exit;
  }
}
?>
