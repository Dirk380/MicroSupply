<?php
include("../admin/authenticate.php");

$conn_error='Could not Connect.';
$mysql_host= getenv("DB_HOST");
$mysql_user= getenv("DB_USER");
$mysql_pass= getenv("DB_PASS");
$mysql_db= getenv("DB_NAME");

$con=mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
session_start();	
decode();
session_write_close();
?>