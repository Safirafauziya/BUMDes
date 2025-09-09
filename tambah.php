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
  <title>Tambah Transaksi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
    }

    form {
      max-width: 400px;
      margin: 20px auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 10px;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 6px;
    }

    button {
      margin-top: 15px;
      padding: 10px 16px;
      background: #27ae60;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
    }

    button:hover {
      background: #1e8449;
    }

    .back {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #3498db;
    }
    .btn-back {
  display: inline-block;
  margin-top: 15px;
  padding: 10px 16px;
  background: #95a5a6;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-size: 14px;
  transition: 0.3s;
}

.btn-back:hover {
  background: #7f8c8d;
}

  </style>
</head>
<body>
  <h2>Tambah Transaksi Baru</h2>
  <form method="POST" action="">
    <label>Tanggal</label>
    <input type="date" name="tanggal" required>

    <label>Jenis Transaksi</label>
    <select name="jenis" required>
      <option value="Pemasukan">Pemasukan</option>
      <option value="Pengeluaran">Pengeluaran</option>
    </select>

    <label>Keterangan</label>
    <textarea name="keterangan" rows="3" required></textarea>

    <label>Jumlah (Rp)</label>
    <input type="number" name="jumlah" required>

    <button type="submit" name="simpan">Simpan</button>
  </form>

  <a href="index.php" class="btn-back">← Kembali</a>
</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    // Ambil saldo terakhir
    $cekSaldo = mysqli_query($koneksi, "SELECT saldo FROM transaksi ORDER BY id DESC LIMIT 1");
    $rowSaldo = mysqli_fetch_assoc($cekSaldo);
    $saldoTerakhir = $rowSaldo['saldo'] ?? 0;

    // Hitung saldo baru
    if ($jenis == "Pemasukan") {
        $saldoBaru = $saldoTerakhir + $jumlah;
    } else {
        $saldoBaru = $saldoTerakhir - $jumlah;
    }

    // Simpan ke database
    $query = "INSERT INTO transaksi (tanggal, jenis, keterangan, jumlah, saldo)
              VALUES ('$tanggal', '$jenis', '$keterangan', '$jumlah', '$saldoBaru')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Transaksi berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
