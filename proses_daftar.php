<?php
session_start();
include 'database/database.php';

if (isset($_POST['simpan'])) {

    // data diri (diisi dulu sebelumnya)
    $nama   = $_SESSION['nama_anggota'];
    $nim    = $_SESSION['nim'];
    $jk     = $_SESSION['jenis_kelamin'];
    $alamat = $_SESSION['alamat'];
    $no_hp  = $_SESSION['no_hp'];

    // data akun (diisi belakangan)
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Enkripsi password menggunakan MD5
    $hashed_password = md5($password);

    // 1. simpan akun user dengan password terenkripsi MD5
    mysqli_query($conn, "INSERT INTO user (username, password, role)
                         VALUES ('$username', '$hashed_password', 'anggota')");

    $id_user = mysqli_insert_id($conn);

    // 2. simpan data anggota
    mysqli_query($conn, "INSERT INTO anggota
        (id_user, nama_anggota, nim, jenis_kelamin, alamat, no_hp)
        VALUES
        ('$id_user', '$nama', '$nim', '$jk', '$alamat', '$no_hp')");

    $id_anggota = mysqli_insert_id($conn);

    // 3. update user dengan id_anggota
    mysqli_query($conn, "UPDATE user
                         SET id_anggota = '$id_anggota'
                         WHERE id_user = '$id_user'");

    session_destroy();

    echo "Pendaftaran berhasil!";
}
?>
