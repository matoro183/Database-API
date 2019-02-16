<?php
    error_reporting(0);
    ini_set('display_errors', 0); // Do not display errors
$puppy = filter_var($_GET["puppy"]);
$pedigree[$puppy] = getPedigree($puppy);
$user = filter_var($_GET["user"]);
$secret_key = filter_var($_GET["secretkey"]); 
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

    $mysqli = new mysqli('localhost',$_GET["user"],$_GET["secretkey"],'API'); // Connect to database
  if ($mysqli->connect_errno) {
      echo $mysqli->connect_errno . "\n";
      echo "You do not have access to the database." . "\n";
      exit;
  }
  $sql = "SELECT puppy_parent_id, mother_or_father FROM parent WHERE puppy_child_id = (SELECT id FROM puppy WHERE puppy_name = '" . $parent . "');";

  $result=mysqli_query($mysqli,$sql); 
  while($row = mysqli_fetch_assoc($result)){
    $test[] = $row;
  }


  $sql_2 = "SELECT puppy_name FROM puppy WHERE id = ";
  if ($test[0]["puppy_parent_id"] != NULL)
  {
    $sql_2 .= $test[0]["puppy_parent_id"];
  }
  if ($test[0]["puppy_parent_id"] != NULL AND $test[1]["puppy_parent_id"] != NULL)
  {
    $sql_2 .= " OR id = " . $test[1]["puppy_parent_id"];
  }
  if ($test[0]["puppy_parent_id"] == NULL AND $test[1]["puppy_parent_id"] != NULL)
  {
    $sql_2 .= $test[1]["puppy_parent_id"];
  }
  $sql_2 .= ";";
  $result_2=mysqli_query($mysqli,$sql_2); 
  while($row_2 = mysqli_fetch_assoc($result_2)){
    $test_2[] = $row_2;
  }

  if ($test_2[0]["puppy_name"] != NULL)
  {
    $moth[$test_2[0]["puppy_name"]] = getPedigree($test_2[0]["puppy_name"]);
    array_push($sub, $moth);
  }
  if ($test_2[1]["puppy_name"] != NULL)
  {
    $fath[$test_2[1]["puppy_name"]] = getPedigree($test_2[1]["puppy_name"]);
    array_push($sub, $fath);
  }

  return $sub; 
}

?>