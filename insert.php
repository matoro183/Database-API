<?php
error_reporting(0);
$user = filter_var($_GET["user"]);
$secret_key = filter_var($_GET["secretkey"]);
$table = filter_var($_GET["table"]);
$valu = filter_var($_GET["values"]);
$values = explode(",", $valu);
$columns = filter_var($_GET["columns"]);
$values_statement = "'";
$values_statement .= implode("', '", $values);
$values_statement .= "'";

if ($user == NULL || $secret_key == NULL || $table == NULL || $columns == NULL || $values == NULL)
{
  echo "Some of the required information is missing. Fill out the required information and try again.";
}
else {

  $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API');
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }

  $sql = "INSERT INTO " . $_GET["table"] . " (" . $columns . ") VALUES (" . $valu . ");";
  //echo $sql . "\n";
  if (!$result = $mysqli->query($sql)) {
  //    echo mysqli_error($mysqli);
      echo "Query failed\n";
      exit;
  }
}
?>
