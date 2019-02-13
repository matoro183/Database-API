<?php
error_reporting(0);
$user = filter_var($_GET["user"]);
$secret_key = filter_var($_GET["secretkey"]);
$table = filter_var($_GET["table"]);
$conditions = filter_var($_GET["conditions"]);
if ($user == NULL || $secret_key == NULL || $table == NULL || $conditions == NULL)
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

  $sql = "DELETE FROM " . $_GET["table"] . " WHERE " . $conditions . ";";

  if (!$result = $mysqli->query($sql)) {
      echo "Query failed\n";
      exit;
  }
}
?>
