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

// Cek apakah id_anggota ada di URL
if(isset($_GET['id_anggota'])) {
    $id_anggota = $_GET['id_anggota'];
    
    // Hapus data anggota dari database
    $sql_delete = "DELETE FROM anggota WHERE id_anggota = $id_anggota";
    
    if(mysqli_query($conn, $sql_delete)) {
        // Redirect ke anggota.php dengan pesan sukses
        header("Location: anggota.php?pesan=sukses");
        exit();
    } else {
        // Redirect dengan pesan error
        header("Location: anggota.php?pesan=error");
        exit();
    }
} else {
    // Jika id tidak ada, redirect ke anggota.php
    header("Location: anggota.php");
    exit();
}

?>
