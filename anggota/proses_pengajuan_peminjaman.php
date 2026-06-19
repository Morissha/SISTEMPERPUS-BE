<?php 

include '../database/database.php';
session_start();
if(isset($_POST['simpan'])) {
    $nama_anggota = $_POST['nama_anggota'];
    $nim = $_POST['nim'];
    $judul_buku = $_POST['judul_buku'];
    $kategori = $_POST['kategori'];
    $tgl_peminjaman = $_POST['tgl_peminjaman'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];

    $insert_query = "
        INSERT INTO pengajuan_peminjaman (nama_anggota, nim, judul_buku, kategori, tgl_peminjaman, tgl_pengembalian)
        VALUES ('$nama_anggota', '$nim', '$judul_buku', '$kategori', '$tgl_peminjaman', '$tgl_pengembalian')
    ";
    mysqli_query($conn, $insert_query);
    header("Location: pengajuan_saya.php");
}



?>