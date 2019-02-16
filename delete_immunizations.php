<?php
    error_reporting(0);
    ini_set('display_errors', 0); // Do not display errors
    $user = filter_var($_GET["user"]);
    $secret_key = filter_var($_GET["secretkey"]);
    $imm = filter_var($_GET["immunization"]);

    $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
    $sql = "SELECT id FROM immunization WHERE immunization_name = '" . $imm . "';";
    echo $sql;
    $result=mysqli_query($mysqli,$sql); 
    while($row = mysqli_fetch_assoc($result)){
 
      $test[] = $row;
    }

    $sql2 = "DELETE FROM puppy_immunization WHERE immunization_id = " . $test[0]["id"] . ";";
    echo $sql2;
    mysqli_query($mysqli,$sql2);

    $sql3 = "DELETE FROM immunization WHERE immunization_name = '" . $imm . "';";
    echo $sql3;
    mysqli_query($mysqli,$sql3);
?>
