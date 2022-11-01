<?php 

$server = "localhost";
$user = "p_admin";
$pass = "12345";
$database = "properties_admin";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>