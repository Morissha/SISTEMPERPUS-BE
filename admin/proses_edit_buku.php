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
    $id_buku = $_POST['id_buku'];
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $foto_lama = $_POST['foto_lama'];
    $foto = $foto_lama;

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
            // Hapus foto lama jika ada
            if($foto_lama && file_exists($target_dir . $foto_lama)) {
                unlink($target_dir . $foto_lama);
            }
            $foto = $new_file_name;
        }
    }

    $query = "UPDATE buku SET judul_buku = '$judul_buku', pengarang = '$pengarang', penerbit = '$penerbit', tahun = '$tahun', id_kategori = '$kategori', stok = '$stok', foto = '$foto' WHERE id_buku = $id_buku";
    
    if(mysqli_query($conn, $query)) {
        header("Location: data_buku.php?pesan=sukses_edit");
        exit();
    } else {
        header("Location: edit_buku.php?id=$id_buku&pesan=error");
        exit();
    }
}
?>
