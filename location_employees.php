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
  $sql2 = "select distinct person_name, location_name from person, location, employee_manages WHERE person.id = employee_manages.employee_id AND employee_manages.location_id = location.id;";
  $result2=mysqli_query($mysqli,$sql2);
  while($row2 = mysqli_fetch_assoc($result2)){    
    $row2["role"] = "manages";
    $test[] = $row2;
  }
  $sql = "select distinct person_name, location_name from person, location, employee_works_at WHERE person.id = employee_works_at.employee_id AND employee_works_at.location_id = location.id;";
  $result=mysqli_query($mysqli,$sql);
  while($row = mysqli_fetch_assoc($result)){    
    $row["role"] = "works at";
    $test[] = $row;
  }

  $JSON = json_encode($test);
  header("Content-Type: application/json; charset=UTF-8");
  echo $JSON;
  mysqli_free_result($result);
  mysqli_close($mysqli);

?>