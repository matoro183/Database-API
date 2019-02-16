<?php
    error_reporting(0);
    ini_set('display_errors', 0); // Do not display errors
    $user = filter_var($_GET["user"]);
    $secret_key = filter_var($_GET["secretkey"]);
    $puppy = filter_var($_GET["puppy"]);
$imm = filter_var($_GET["immunization"]);
$vet = filter_var($_GET["veterinarian"]);
    $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "
  INSERT INTO puppy_immunization (puppy_id, immunization_id, veterinarian_id)
  SELECT (
    SELECT id
    FROM puppy
    WHERE puppy_name = '" . $puppy . "'
    ) AS pup_name,
    (
    SELECT id
    FROM immunization
    WHERE immunization_name = '" . $imm . "'
    ) AS imm_name,
    (
    SELECT id
    FROM veterinarian
    WHERE veterinarian_name = '" . $vet . "'
    ) AS vet_name;";
    echo $sql;
  mysqli_query($mysqli,$sql);
?>

