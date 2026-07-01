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
    $id_anggota = $_POST['id_anggota'];
    $nama_anggota = $_POST['nama_anggota'];
    $nim = $_POST['nim'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_hp = $_POST['tahun'];

    $query = "UPDATE anggota SET nama_anggota = '$nama_anggota', nim = '$nim', jenis_kelamin = '$jenis_kelamin', no_hp = '$no_hp' WHERE id_anggota = $id_anggota";
    
    if(mysqli_query($conn, $query)) {
        header("Location: anggota.php?pesan=sukses_edit");
        exit();
    } else {
        header("Location: edit_anggota.php?id_anggota=$id_anggota&pesan=error");
        exit();
    }
}
?>
