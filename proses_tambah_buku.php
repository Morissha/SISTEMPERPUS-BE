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
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $foto = '';

    // Handle foto upload
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../img/";
        if(!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        
        $file_name = basename($_FILES['foto']['name']);
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = time() . '.' . $file_ext;
        $target_file = $target_dir . $new_file_name;
        
        if(move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $foto = $new_file_name;
        }
    }

    if($foto) {
        $query = "INSERT INTO buku (judul_buku, pengarang, penerbit, tahun, id_kategori, stok, foto) VALUES ('$judul_buku', '$pengarang', '$penerbit', '$tahun', '$kategori', '$stok', '$foto')";
    } else {
        $query = "INSERT INTO buku (judul_buku, pengarang, penerbit, tahun, id_kategori, stok) VALUES ('$judul_buku', '$pengarang', '$penerbit', '$tahun', '$kategori', '$stok')";
    }

    if(mysqli_query($conn, $query)) {
        header("Location: data_buku.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}



?>
