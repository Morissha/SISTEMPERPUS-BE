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
// Cek apakah id_kategori ada di URL
if(isset($_GET['id_kategori'])) {
    $id_kategori = $_GET['id_kategori'];
    
    // Hapus data kategori dari database
    $sql_delete = "DELETE FROM kategori WHERE id_kategori = $id_kategori";
    
    if(mysqli_query($conn, $sql_delete)) {
        // Redirect ke kategori.php dengan pesan sukses
        header("Location: kategori.php?pesan=sukses");
        exit();
    } else {
        // Redirect dengan pesan error
        header("Location: kategori.php?pesan=error");
        exit();
    }
} else {
    // Jika id tidak ada, redirect ke kategori.php
    header("Location: kategori.php");
    exit();
}

?>
