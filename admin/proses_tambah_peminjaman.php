<?php 
if(isset($_POST['simpan'])) {
    include 'database/database.php';
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
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'];

    $query = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_pengembalian) VALUES ('$id_anggota', '$id_buku', '$tanggal_pinjam', '$tanggal_pengembalian')";
    if(mysqli_query($conn, $query)) {
        header("Location: peminjaman.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>