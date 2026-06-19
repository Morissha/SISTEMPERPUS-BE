<?php
// File untuk mengecek apakah user sudah login
// Gunakan di awal setiap file yang memerlukan autentikasi

session_start();

// Cek apakah user sudah login
if(!isset($_SESSION['nim']) || empty($_SESSION['nim'])) {
    header('Location: ' . (strpos($_SERVER['PHP_SELF'], '/admin/') !== false ? '../' : '') . 'login.php');
    exit();
}
?>
