<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // enkripsi md5

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $row = mysqli_fetch_assoc($cek);

    if ($row) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $row['username'];
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Username atau Password salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login BUMDes</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 300px;
    }
    h2 {
      text-align: center;
      color: #2c3e50;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    button:hover {
      background: #2980b9;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Login BUMDes</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</body>
</html>
