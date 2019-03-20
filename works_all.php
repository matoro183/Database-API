<?php
    error_reporting(1);
    ini_set('display_errors', 1); // Do not display errors
    $user = filter_var($_GET["user"]);
    $secret_key = filter_var($_GET["secretkey"]);
    $manager = filter_var($_GET["manager"]);
    $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "SELECT person_name
  FROM person, location, employee_works_at
  WHERE employee_works_at.location_id IN (select location.id from person, location, employee_manages WHERE person.id = employee_manages.employee_id AND employee_manages.location_id = location.id AND person_name = '" . $manager . "') AND person.id = employee_works_at.employee_id AND employee_works_at.location_id = location.id
  GROUP BY person_name
  HAVING COUNT(employee_works_at.location_id) = (select COUNT(location.id) from person, location, employee_manages WHERE person.id = employee_manages.employee_id AND employee_manages.location_id = location.id AND person_name = '" . $manager . "');";
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