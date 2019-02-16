<?php
error_reporting(0);
$user = filter_var($_GET["user"]);
$secret_key = filter_var($_GET["secretkey"]);
$table = filter_var($_GET["table"]);
$columns = filter_var($_GET["columns"]);
$values = filter_var($_GET["values"]);
$fktables = filter_var($_GET["fktables"]);
$fkcolumns = filter_var($_GET["fkcolumns"]);
$table_array = explode(",", $table);
$columns_array = explode(",", $columns);
$values_array = explode(",", $values);
$fktables_array = explode(",", $fktables);
$fkcolumns_array = explode(",", $fkcolumns);


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

  $sql = "SELECT id FROM " . $fktables_array[0] . " WHERE " . $fkcolumns_array[0] . " = " . $values_array[0] . ";";
  echo $sql . "\n";
  $result=mysqli_query($mysqli,$sql); 
  $row = mysqli_fetch_assoc($result);
  
  $sql2 = "SELECT id FROM " . $fktables_array[1] . " WHERE " . $fkcolumns_array[1] . " = " . $values_array[1] . ";";
  echo $sql2 . "\n";
  $result2=mysqli_query($mysqli,$sql2); 
  $row2 = mysqli_fetch_assoc($result2);

  if (sizeof($columns_array) == 3) 
  {

    $sql4 = "INSERT INTO " . $table . " (" . $columns_array[0] . ", " . $columns_array[1] . ", " . $columns_array[2] . ") VALUES ('" . $row["id"] . "', '" . $row2["id"] . "', " . $values_array[2] . ");";
    echo $sql4 . "\n";
    if (!$result4 = $mysqli->query($sql4)) {
      //    echo mysqli_error($mysqli);
          echo "Query failed\n";
          exit;
      }
  }
  else {

  $sql3 = "INSERT INTO " . $table . " (" . $columns_array[0] . ", " . $columns_array[1] . ") VALUES ('" . $row["id"] . "', '" . $row2["id"] . "');";
  echo $sql3 . "\n";
  if (!$result3 = $mysqli->query($sql3)) {
    //    echo mysqli_error($mysqli);
        echo "Query failed\n";
        exit;
    }
  }
}
?>
