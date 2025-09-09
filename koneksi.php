<?php
// Konfigurasi koneksi database
$host = "localhost";
$user = "root";   // default XAMPP
$pass = "";       // default XAMPP biasanya kosong
$db   = "dumdes_db"; // sesuai nama database di phpMyAdmin

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if(!$koneksi){
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
