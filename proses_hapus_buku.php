<?php 

include '../database/database.php';
session_start();
      if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ../login.php');
          exit();
      } 

    if ($_SESSION['role'] === 'anggota') {
      echo "<script>
            alert('Akses ditolak! Halaman ini hanya untuk admin.');
            window.history.back();
          </script>";
      exit;
      };

// Cek apakah id_buku ada di URL
if(isset($_GET['id'])) {
    $id_buku = $_GET['id'];
    
    // Ambil data foto buku terlebih dahulu
    $sql_get = "SELECT foto FROM buku WHERE id_buku = $id_buku";
    $result = mysqli_query($conn, $sql_get);
    $row = mysqli_fetch_assoc($result);
    
    // Hapus foto jika ada
    if($row['foto']) {
        $foto_path = '../img/' . $row['foto'];
        if(file_exists($foto_path)) {
            unlink($foto_path);
        }
    }
    
    // Hapus data buku dari database
    $sql_delete = "DELETE FROM buku WHERE id_buku = $id_buku";
    
    if(mysqli_query($conn, $sql_delete)) {
        // Redirect ke data_buku.php dengan pesan sukses
        header("Location: data_buku.php?pesan=sukses");
        exit();
    } else {
        // Redirect dengan pesan error
        header("Location: data_buku.php?pesan=error");
        exit();
    }
} else {
    // Jika id tidak ada, redirect ke data_buku.php
    header("Location: data_buku.php");
    exit();
}

?>
