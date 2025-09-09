<?php
include "koneksi.php";

// Ambil data dari form
$tanggal    = $_POST['tanggal'];
$jenis      = $_POST['jenis'];
$keterangan = $_POST['keterangan'];
$jumlah     = $_POST['jumlah'];

// Ambil saldo terakhir
$cek = mysqli_query($koneksi, "SELECT saldo FROM transaksi ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($cek);
$saldo_terakhir = $row['saldo'] ?? 0;

// Hitung saldo baru
if($jenis == "Pemasukan"){
    $saldo_baru = $saldo_terakhir + $jumlah;
} else {
    $saldo_baru = $saldo_terakhir - $jumlah;
}

// Simpan ke database
mysqli_query($koneksi, "INSERT INTO transaksi (tanggal, jenis, keterangan, jumlah, saldo) 
VALUES ('$tanggal','$jenis','$keterangan','$jumlah','$saldo_baru')");

// Kembali ke halaman utama
header("location:index.php");
?>
