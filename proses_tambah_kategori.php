<?php 
if(isset($_POST['simpan'])) {
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
    $kategori = $_POST['nama_kategori'];
    $keterangan = $_POST['deskripsi'];

    $query = "INSERT INTO kategori (nama_kategori, deskripsi) VALUES ('$kategori', '$keterangan')";
    if(mysqli_query($conn, $query)) {
        header("Location: kategori.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}



?>
