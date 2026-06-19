<?php 

include '../database/database.php';
session_start();
$id_pengajuan = $_GET['id_pengajuan_peminjaman'];
$query = "SELECT * FROM pengajuan_peminjaman WHERE id_pengajuan_peminjaman = $id_pengajuan";
$result = mysqli_query($conn, $query);
$pengajuan = mysqli_fetch_assoc($result);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Pengajuan</title>
    <link rel="stylesheet" href="../style.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  </head>
  <body>
    <div class="container">
<?php include '../layout/sidebar.php';?>
      <main>
        <header>
          <h3>Edit Pengajuan</h3>
        </header>
        <div class="form-section">
          <form action="proses_edit_pengajuan.php" method="POST">
            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul_buku" name="judul_buku" value="<?php echo $pengajuan['judul_buku']; ?>" required />

            <label for="pengarang">kategori:</label>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo $pengajuan['kategori']; ?>" readonly />

            <label for="tgl_peminjaman">Tanggal Peminjaman:</label>
            <input type="date" id="tgl_peminjaman" name="tgl_peminjaman" value="<?php echo $pengajuan['tgl_peminjaman']; ?>" required />

            <label for="tgl_pengembalian">Tanggal Pengembalian:</label>
            <input type="date" id="tgl_pengembalian" name="tgl_pengembalian" value="<?php echo $pengajuan['tgl_pengembalian']; ?>" required />

            <label for="tgl_peminjaman"></label>
            <div class="btn-group">
              <button class="btn btn-tambah" type="submit" name="simpan">Simpan</button>
              <a href="pengajuan_saya.php"><button class="btn btn-secondary" type="button">Batal</button></a>
            </div>
            </div>
          </form>
        </div>
      </main>
    </div>
        <script src="../script.js"></script>
  </body>
</html>
