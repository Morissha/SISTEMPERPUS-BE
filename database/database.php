<?php 
$username = "root";
$password = "";
$host = "localhost";
$database = "aplikasi_perpus";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


?>