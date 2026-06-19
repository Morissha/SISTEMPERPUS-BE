<?php 
include '../database/database.php';
session_start();


$sql = "
    SELECT 
        p.id_peminjaman,
        p.tanggal_pengembalian,
        p.status,
        a.nama_anggota,
        b.judul_buku
    FROM peminjaman p
    JOIN anggota a ON p.id_anggota = a.id_anggota
    JOIN buku b ON p.id_buku = b.id_buku
    WHERE p.status = 'Dikembalikan'
";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pengembalian Buku</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="container">
<?php include '../layout/sidebar.php'; ?>

<main>
<header>
    <h3>Pengembalian Buku</h3>
</header>

<div class="table-section">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

      
          <tbody>
<?php
$no = 1;
while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['nama_anggota']; ?></td>
    <td><?= $row['judul_buku']; ?></td>
    <td><?= $row['tanggal_pengembalian']; ?></td>
    <td>
        <span class="<?= $row['status']; ?>">
            <?= $row['status']; ?>
        </span>
    </td>
    <td>
        <form method="POST" action="proses_kembali.php">
            <input type="hidden" name="id_peminjaman" value="<?= $row['id_peminjaman']; ?>">
            <button type="submit" name="kembalikan" 
                onclick="return confirm('Yakin buku dikembalikan?')"
                class="action-btn">
                <i class="fas fa-undo"></i> Kembalikan
            </button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
    </table>
</div>
</main>
</div>
<script src="../script.js"></script>
</body>
</html>

