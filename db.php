<?php
$host = "localhost";
$user = "root"; // XAMPP varsayılan
$pass = "";     // XAMPP varsayılan
$dbname = "site_uyelik";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Veritabanına bağlanılamadı: " . $conn->connect_error);
}
?>