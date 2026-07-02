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
$id = $_GET['id'];
$status = isset($_GET['status']) ? $_GET['status'] : 'disetujui';

// Ambil data pengajuan
$query_data = "SELECT * FROM pengajuan_peminjaman WHERE id_pengajuan_peminjaman='$id'";
$result_data = mysqli_query($conn, $query_data);
$data = mysqli_fetch_assoc($result_data);

// Ambil id_anggota dan id_buku berdasarkan data pengajuan
$anggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_anggota FROM anggota WHERE nim = '".$data['nim']."'"));
$buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_buku FROM buku WHERE judul_buku = '".$data['judul_buku']."'"));

$id_anggota = $anggota['id_anggota'];
$id_buku = $buku['id_buku'];

if($status == 'ditolak') {
    // Insert ke peminjaman dengan status Ditolak, sama seperti disetujui
    $insert_query = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_pengembalian, status) 
                     VALUES ('$id_anggota', '$id_buku', '".$data['tgl_peminjaman']."', '".$data['tgl_pengembalian']."', 'Ditolak')";
    
    if(mysqli_query($conn, $insert_query)) {
        // Hapus dari pengajuan_peminjaman setelah berhasil insert
        $delete_query = "DELETE FROM pengajuan_peminjaman WHERE id_pengajuan_peminjaman='$id'";
        mysqli_query($conn, $delete_query);
        header("Location: verifikasi_peminjaman.php?message=ditolak");
    } else {
        header("Location: verifikasi_peminjaman.php?message=error");
    }
} else if($data['kategori'] == 'Perpanjangan') {
    // Jika perpanjangan, update tgl_pengembalian di tabel peminjaman yang existing
    $update_query = "UPDATE peminjaman SET status = 'Diperpanjang', tanggal_pengembalian = '".$data['tgl_pengembalian']."' 
                     WHERE id_anggota = '$id_anggota' 
                     AND id_buku = '$id_buku'
                     AND status = 'Dipinjam'";
    if(mysqli_query($conn, $update_query)) {
        // Update status pengajuan perpanjangan menjadi Disetujui sebelum dihapus
        $update_status_query = "UPDATE pengajuan_peminjaman SET status = 'Disetujui' WHERE id_pengajuan_peminjaman='$id'";
        mysqli_query($conn, $update_status_query);
        
        // Hapus dari pengajuan_peminjaman setelah berhasil update (sebagai penanda sudah diproses)
        $delete_query = "DELETE FROM pengajuan_peminjaman WHERE id_pengajuan_peminjaman='$id'";
        mysqli_query($conn, $delete_query);
        header("Location: verifikasi_peminjaman.php?message=success");
    } else {
        header("Location: verifikasi_peminjaman.php?message=error");
    }
} else {
    // Jika peminjaman baru, insert ke tabel peminjaman
    $insert_query = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_pengembalian, status) 
                     VALUES ('$id_anggota', '$id_buku', '".$data['tgl_peminjaman']."', '".$data['tgl_pengembalian']."', 'Dipinjam')";
    
    if(mysqli_query($conn, $insert_query)) {
        // Kurangi stok buku sebanyak 1
        $stok_query = "UPDATE buku SET stok = stok - 1 WHERE id_buku = '$id_buku'";
        mysqli_query($conn, $stok_query);
        
        // Hapus dari pengajuan_peminjaman setelah berhasil insert
        $delete_query = "DELETE FROM pengajuan_peminjaman WHERE id_pengajuan_peminjaman='$id'";
        mysqli_query($conn, $delete_query);
        header("Location: verifikasi_peminjaman.php?message=success");
    } else {
        header("Location: verifikasi_peminjaman.php?message=error");
    }
}

?>

?>