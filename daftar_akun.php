<?php
session_start();
$_SESSION['nama_anggota'] = $_POST['nama_anggota'];
$_SESSION['nim'] = $_POST['nim'];
$_SESSION['jenis_kelamin'] = $_POST['jenis_kelamin'];
$_SESSION['alamat'] = $_POST['alamat'];
$_SESSION['no_hp'] = $_POST['no_hp'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Anggota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="daftar-container">
    <div class="left">
        <img src="img/logo.png" alt="logo">
        <p>Sistem Informasi Peminjaman Buku Perpustakaan</p>
    </div>
    <div class="right">
            <div class="form-daftar">   
    <form method="post" action="proses_daftar.php">
        <h3>Daftar Akun</h3>
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button class="btn btn-primary" type="submit" name="simpan">Daftar</button>
    </form>
    </div>
    </div>
</div>

</body>
</html>
