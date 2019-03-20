<?php
$employeeName = $_GET["user"];
$secretKey = $_GET["secretkey"];
$table = $_GET["table"];
$columns = $_GET["columns"];
$values = $_GET["values"];
$fktables = $_GET["fktables"];
$fkcolumns = $_GET["fkcolumns"];

$expectedEmployeeKey = '123654';
$expectedAdminKey = '321456';

$servername = "localhost";
$usernameEmployee = "employee";
$usernameAdmin = "employeeadmin";
$databasename = "API"; //db name

//check to make sure the data needed is set in the URL string
if(!isset($_GET["user"]) || !isset($_GET["secretkey"]) || !isset($_GET["table"]) || !isset($_GET["columns"]) ||
   !isset($_GET["values"]) || !isset($_GET["fktables"]) || !isset($_GET["fkcolumns"])){
  exit("Incomplete information entered.");
}

if((($employeeName == $usernameEmployee) && ($secretKey == $expectedEmployeeKey)) ||
  (($employeeName == $usernameAdmin) && ($secretKey == $expectedAdminKey))) {
  //you are an employee so you can insert

  $conn = new mysqli($servername, $employeeName, $secretKey, $databasename);
  //Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  //clean the tables, columns and values
  $cleanTable = filter_var($table, FILTER_SANITIZE_STRING);
  $cleanColumns = filter_var($columns, FILTER_SANITIZE_STRING);
  $cleanValues = filter_var($values, FILTER_SANITIZE_STRING);
  $clean_fktables = filter_var($fktables, FILTER_SANITIZE_STRING);
  $clean_fkcolumns = filter_var($fkcolumns, FILTER_SANITIZE_STRING);

  //Justins code to change things to question marks
  $revisedValues = str_replace("%20"," ",$cleanValues);
  $revisedValues = preg_replace("!&#39;%?[a-zA-Z0-9 \.\-@]+%?&#39;!","*",$revisedValues);
  $conditions_array = preg_match_all("!&#39;(%?[a-zA-Z0-9 \.\-@]+%?)&#39;!", $cleanValues, $condition_matches, PREG_PATTERN_ORDER);


$subqueries = array();
if ($clean_fktables != False) {
    $fktables_array = explode(",",$clean_fktables);
    $fkcolumns_array = explode(",",$clean_fkcolumns);
    for ($i = 0; $i < count($fktables_array); $i++) {
      $fktable = $fktables_array[$i];
      $fkcolumn = $fkcolumns_array[$i];
      $subquery = "(SELECT id FROM $fktable WHERE $fkcolumn = ?)";
      $subqueries[] = $subquery;
    }
}
//print_r($subqueries);

for ($i = 0; $i < count($subqueries); $i++) {
  $subquery = $subqueries[$i];
  $revisedValues = preg_replace('#\*#',$subquery,$revisedValues,1);
}
$revisedValues = str_replace('*', '?', $revisedValues);

//run the query
$query_sql = "INSERT INTO $cleanTable (" . $cleanColumns . ") VALUES (" . $revisedValues . ")";

if ($stmt = $conn->prepare($query_sql)) {
  $types = "";
  foreach ($condition_matches[1] as $v) {
    if (preg_match("!^[0-9\.]+$!",$v)) {
      $types .= "d";
    } else {
      $types .= "s";
    }
  }
  $stmt->bind_param($types, ...$condition_matches[1]);
  }

  if (!$stmt->execute()) {
        // it didnt work!
        exit("SQL statement failed.");
    }

  $stmt->close();
  $conn->close();

  }
  else {
  exit("Incorrect user name or password entered.");
  }

?>
