<?php
error_reporting(0); // Do not display errors
$puppy = filter_var($_GET["puppy"]);
$pedigree[$puppy] = getPedigree($puppy);

$JSON = json_encode($pedigree);
header("Content-Type: application/json; charset=UTF-8"); 
echo $JSON;

function getPedigree($parent)
{
    
    $pedi = array(); 
    $sub = array();
    $moth = array();
    $fath = array();
    if ($parent == NULL)
    {
        mysqli_close($mysqli);
        return $pedi;
    }

  $mysqli = new mysqli('localhost','employee','123654','API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "SELECT mother, father FROM Parents WHERE puppy_id = (SELECT puppy_ID FROM Puppies WHERE name = '" . $parent . "');";

  $result=mysqli_query($mysqli,$sql); 
  while($row = mysqli_fetch_assoc($result)){
    $test[] = $row;
  }

  $sql_2 = "SELECT name FROM Puppies WHERE puppy_id = ";
  if ($test[0]["mother"] != NULL)
  {
    $sql_2 .= $test[0]["mother"];
  }
  if ($test[0]["mother"] != NULL AND $test[0]["father"] != NULL)
  {
    $sql_2 .= " OR puppy_ID = " . $test[0]["father"];
  }
  if ($test[0]["mother"] == NULL AND $test[0]["father"] != NULL)
  {
    $sql_2 .= $test[0]["father"];
  }
  $sql_2 .= ";";
  $result_2=mysqli_query($mysqli,$sql_2); 
  while($row_2 = mysqli_fetch_assoc($result_2)){
    $test_2[] = $row_2;
  }

  if ($test_2[0]["name"] != NULL)
  {
    $moth[$test_2[0]["name"]] = getPedigree($test_2[0]["name"]);
    array_push($sub, $moth);
  }
  if ($test_2[1]["name"] != NULL)
  {
    $fath[$test_2[1]["name"]] = getPedigree($test_2[1]["name"]);
    array_push($sub, $fath);
  }

  return $sub; 
}

?>