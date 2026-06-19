<?php 
// Script untuk generate denda otomatis saat pengembalian buku
// File ini bisa dipanggil saat admin memproses pengembalian buku

include '../database/database.php';

// Function untuk hitung dan generate denda
function generateDenda($conn, $id_peminjaman) {
    // Ambil data peminjaman
    $pinjam_data = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT p.*, a.id_anggota FROM peminjaman p 
         JOIN anggota a ON p.id_anggota = a.id_anggota 
         WHERE p.id_peminjaman = '$id_peminjaman'"));
    
    if (!$pinjam_data) {
        return ['success' => false, 'message' => 'Peminjaman tidak ditemukan'];
    }
    
    $tanggal_pengembalian = $pinjam_data['tanggal_pengembalian'];
    $id_anggota = $pinjam_data['id_anggota'];
    $hari_ini = date('Y-m-d');
    
    // Hitung hari terlambat
    $tanggal_kembali = new DateTime($tanggal_pengembalian);
    $tanggal_sekarang = new DateTime($hari_ini);
    $hari_terlambat = $tanggal_sekarang->diff($tanggal_kembali)->days;
    
    // Jika tidak terlambat, tidak ada denda
    if ($hari_terlambat <= 0) {
        return ['success' => true, 'message' => 'Tidak ada keterlambatan', 'denda' => 0];
    }
    
    // Hitung jumlah denda: 50.000 per hari
    $jumlah_denda = $hari_terlambat * 50000;
    
    // Cek apakah denda sudah ada untuk peminjaman ini
    $cek_denda = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT * FROM denda WHERE id_peminjaman = '$id_peminjaman'"));
    
    if ($cek_denda) {
        return ['success' => false, 'message' => 'Denda sudah dibuat untuk peminjaman ini'];
    }
    
    // Insert denda baru
    $insert_denda = "INSERT INTO denda (id_peminjaman, id_anggota, jumlah_denda, tanggal_denda, keterangan) 
                     VALUES ('$id_peminjaman', '$id_anggota', '$jumlah_denda', '$hari_ini', 'Terlambat $hari_terlambat hari x Rp 50.000')";
    
    if (mysqli_query($conn, $insert_denda)) {
        return ['success' => true, 'message' => "Denda berhasil dibuat: Rp " . number_format($jumlah_denda, 0, ',', '.'), 'denda' => $jumlah_denda];
    } else {
        return ['success' => false, 'message' => 'Gagal membuat denda: ' . mysqli_error($conn)];
    }
}

// Function untuk mark denda sebagai sudah dibayar
function bayarDenda($conn, $id_denda) {
    $tanggal_bayar = date('Y-m-d');
    $update_query = "UPDATE denda SET status_pembayaran = 'Sudah Dibayar', tanggal_pembayaran = '$tanggal_bayar' 
                     WHERE id_denda = '$id_denda'";
    
    if (mysqli_query($conn, $update_query)) {
        return ['success' => true, 'message' => 'Denda berhasil dibayarkan'];
    } else {
        return ['success' => false, 'message' => 'Gagal membayarkan denda'];
    }
}

// Function untuk get denda anggota
function getDendaAnggota($conn, $id_anggota) {
    return mysqli_query($conn, 
        "SELECT d.*, p.judul_buku, b.judul_buku as buku_nama FROM denda d 
         JOIN peminjaman p ON d.id_peminjaman = p.id_peminjaman 
         JOIN buku b ON p.id_buku = b.id_buku
         WHERE d.id_anggota = '$id_anggota' 
         ORDER BY d.tanggal_denda DESC");
}

// Function untuk get total denda belum dibayar
function getTotalDendaBelumBayar($conn, $id_anggota) {
    $result = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT COALESCE(SUM(jumlah_denda), 0) as total FROM denda 
         WHERE id_anggota = '$id_anggota' AND status_pembayaran = 'Belum Dibayar'"));
    return $result['total'];
}

?>
