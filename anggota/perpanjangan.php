<?php 
include '../database/database.php';
session_start();

// Cek apakah user sudah login
if(!isset($_SESSION['nim']) || empty($_SESSION['nim'])) {
    header('Location: ../login.php');
    exit();
}


$sql = "SELECT p.id_peminjaman, a.nama_anggota, b.judul_buku, p.tanggal_pinjam, p.tanggal_pengembalian, p.status
FROM peminjaman p
JOIN anggota a ON p.id_anggota = a.id_anggota
JOIN buku b ON p.id_buku = b.id_buku";
$result = mysqli_query($conn, $sql);
// Debug: Tampilkan error jika ada
if (!$result) {
    echo "Error: " . mysqli_error($conn);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpanjangan Buku</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<div class="container">
    <?php include '../layout/sidebar.php';?>    
    <main>
        <header>
          <h3>Perpanjangan Buku</h3>
        </header>
        <div class="table-section">
          <div class="table-header">
            <div class="tittle">
              <h3>Data Buku </h3>
            </div>
            <div class="toolbar">
              <div class="right">
                <input type="text" placeholder="Cari Buku..." data-search-table />
              </div>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              
              // Debug: Cek apakah ada data
              if (mysqli_num_rows($result) == 0) {
                  echo "<tr><td colspan='6'>Tidak ada peminjaman aktif. Cek status di database: ";
                  $debug_sql = "SELECT DISTINCT p.status FROM peminjaman p WHERE p.id_anggota = (SELECT id_anggota FROM anggota WHERE nim = '".$_SESSION['nim']."')";
                  $debug_result = mysqli_query($conn, $debug_sql);
                  while($debug_row = mysqli_fetch_assoc($debug_result)) {
                      echo "'" . $debug_row['status'] . "' ";
                  }
                  echo "</td></tr>";
              }
              
               while($row = mysqli_fetch_assoc($result)): 
                $no++;
              ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['tanggal_pinjam']; ?></td>
                <td><?php echo $row['tanggal_pengembalian']; ?></td>
                <td>
                  <a href="pengajuan_perpanjangan.php?id=<?php echo $row['id_peminjaman']; ?>"><button class="btn btn-edit">Ajukan Perpanjangan</button></a>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
  </main>
</div>
</body>
</html>