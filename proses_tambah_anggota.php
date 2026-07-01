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

    $nama_anggota = $_POST['nama_anggota'];
    $nim = $_POST['nim'];
    $no_hp = $_POST['no_hp'];

    $query = "INSERT INTO anggota (nama_anggota, nim, no_hp) VALUES ('$nama_anggota', '$nim', '$no_hp')";
    if(mysqli_query($conn, $query)) {
        header("Location: anggota.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>