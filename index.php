<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Aplikasi Keuangan BUMDes</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>💰 Aplikasi Keuangan BUMDes</h1>
    <a href="tambah.php" class="btn">+ Tambah Transaksi</a>

    <?php
    // Hitung total pemasukan, pengeluaran, saldo
    $pemasukan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM transaksi WHERE jenis='Pemasukan'"));
    $pengeluaran = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM transaksi WHERE jenis='Pengeluaran'"));

    $totalPemasukan = $pemasukan['total'] ?? 0;
    $totalPengeluaran = $pengeluaran['total'] ?? 0;
    $saldo = $totalPemasukan - $totalPengeluaran;
    ?>

    <div class="cards">
      <div class="card income">
        <h3>Pemasukan</h3>
        <p>Rp<?= number_format($totalPemasukan) ?></p>
      </div>
      <div class="card expense">
        <h3>Pengeluaran</h3>
        <p>Rp<?= number_format($totalPengeluaran) ?></p>
      </div>
      <div class="card balance">
        <h3>Saldo Akhir</h3>
        <p>Rp<?= number_format($saldo) ?></p>
      </div>
    </div>

    <h2>📑 Daftar Transaksi</h2>
    <table>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Keterangan</th>
        <th>Jumlah</th>
        <th>Saldo</th>
      </tr>
      <?php
      $no = 1;
      $data = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY id ASC");
      while($row = mysqli_fetch_array($data)){
        $jenisClass = $row['jenis'] == "Pemasukan" ? "text-green" : "text-red";
        echo "<tr>
          <td>".$no++."</td>
          <td>".$row['tanggal']."</td>
          <td class='".$jenisClass."'>".$row['jenis']."</td>
          <td>".$row['keterangan']."</td>
          <td>Rp".number_format($row['jumlah'])."</td>
          <td>Rp".number_format($row['saldo'])."</td>
        </tr>";
      }
      ?>
    </table>
    <a href="logout.php" class="btn" style="background:#e74c3c;">Logout</a>

  </div>
</body>
</html>
