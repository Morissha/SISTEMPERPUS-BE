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
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = $_POST['judul_buku'];
    $deskripsi = $_POST['pengarang'];

    $query = "UPDATE kategori SET nama_kategori = '$nama_kategori', deskripsi = '$deskripsi' WHERE id_kategori = $id_kategori";
    
    if(mysqli_query($conn, $query)) {
        header("Location: kategori.php?pesan=sukses_edit");
        exit();
    } else {
        header("Location: edit_kategori.php?id_kategori=$id_kategori&pesan=error");
        exit();
    }
}
?>
