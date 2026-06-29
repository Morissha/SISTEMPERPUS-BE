<?php
session_start();
include 'database/database.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = md5($password);

    $query = "
        SELECT 
            user.id_user,
            user.username,
            user.password,
            user.role,
            anggota.id_anggota,
            anggota.nama_anggota,
            anggota.nim
        FROM user
        LEFT JOIN anggota ON user.id_user = anggota.id_user
        WHERE user.username = '$username'
        AND user.password = '$hashed_password'
    ";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['id_anggota'] = $row['id_anggota'];
        $_SESSION['nama_anggota'] = $row['nama_anggota'];
        $_SESSION['nim'] = $row['nim'];
        if($row['role'] == 'admin'){
            header("Location: admin/index.php");
        } elseif ($row['role'] == 'anggota') {
            header("Location: anggota/index.php");
        } else {
            echo"Role tidak dikenali!!";
        }
    } else {
        echo "Login gagal! Username atau password salah.";
    }
}
?>
