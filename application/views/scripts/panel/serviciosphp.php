<?php
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "db_gpsconstructivos"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}


if(isset($_POST['search'])){
 $search = mysqli_real_escape_string($con,$_POST['search']);

 $query = $instance->getnombreautocomplete($_POST);
 $result = mysqli_query($con,$query);

 $response = array();
 while($row = mysqli_fetch_array($result) ){
   $response[] = array("value"=>$row['id'],"label"=>$row['nombre']);
 }

 echo json_encode($response);
}
 return $response;