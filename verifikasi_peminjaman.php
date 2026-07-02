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

$query = ("SELECT * FROM pengajuan_peminjaman");
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengajuan Peminjaman</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      .form-section input[readonly] {
        background-color: #f5f5f5;
        color: #666;
        cursor: not-allowed;
      }
      .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
      }
      .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
      }
      .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
      }
    </style>
  </head>
  <body>
    <div class="container">
<?php include '../layout/sidebar.php';?>  
      <main>
        <header>
          <h3>Pengajuan Peminjaman</h3>
        </header>
        <div class="table-section">
          <div class="table-header">
            <div class="tittle">
              <h3>Data Pengajuan</h3>
            </div>
            <div class="toolbar">
              <div class="right">
                <input type="text" placeholder="Cari Nama Anggota" data-search-table />
              </div>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Nim</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while($row = mysqli_fetch_assoc($result)): 
              $no++;
              ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $row['nama_anggota']; ?></td>
                <td><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['nim']; ?></td>
                <td><?php echo $row['judul_buku']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo $row['tgl_peminjaman']; ?></td>
                <td><?php echo $row['tgl_pengembalian']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <button class="btn btn-primary"><a href="proses_verifikasi_peminjaman.php?id=<?php echo $row['id_pengajuan_peminjaman']; ?>&status=disetujui">Setujui</a></button>
                    <button class="btn btn-secondary"><a href="proses_verifikasi_peminjaman.php?id=<?php echo $row['id_pengajuan_peminjaman']; ?>&status=ditolak" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?');">Tolak</a></button>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
    <script src="../script.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('message');
        
        if(message === 'success') {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Pengajuan berhasil disetujui',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
          });
        } else if(message === 'ditolak') {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Pengajuan berhasil ditolak',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
          });
        } else if(message === 'error') {
          Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat memproses pengajuan',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      });
    </script>
  </body>
</html>
