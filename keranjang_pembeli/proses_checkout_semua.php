<?php
require_once '../database/koneksi.php';

// Proteksi: Pastikan hanya pembeli yang bisa mengakses
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'PB') {
    echo '<script>alert("Akses ditolak!"); window.location.href="../login.php";</script>';
    exit;
}

// Cek apakah tombol checkout benar-benar ditekan
if (isset($_POST['btn-checkout'])) {
    $id_user = $_SESSION['id_user'];
    $tanggal_sekarang = date('Y-m-d H:i:s');
    
    // --- 1. PROSES UPLOAD BUKTI TRANSFER ---
    $nama_file = $_FILES['bukti_transfer']['name'];
    $ukuran_file = $_FILES['bukti_transfer']['size'];
    $error = $_FILES['bukti_transfer']['error'];
    $tmp_name = $_FILES['bukti_transfer']['tmp_name'];

    // Cek apakah ada file yang diunggah
    if ($error === 4) {
        echo '<script>alert("Silakan unggah bukti transfer terlebih dahulu!"); window.location.href="../keranjang_pembeli/index.php";</script>';
        exit;
    }

    // Cek ekstensi file (Hanya boleh gambar)
    $ekstensi_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi_file = explode('.', $nama_file);
    $ekstensi_file = strtolower(end($ekstensi_file));

    if (!in_array($ekstensi_file, $ekstensi_valid)) {
        echo '<script>alert("Format file tidak valid! Harap unggah JPG atau PNG."); window.location.href="../keranjang_pembeli/index.php";</script>';
        exit;
    }

    // Buat nama file baru yang unik (agar tidak tertimpa jika ada nama file yang sama)
    $nama_file_baru = uniqid() . '-' . $id_user . '.' . $ekstensi_file;
    
    // Tentukan folder tujuan (Misalnya kita simpan di folder asset_adminlte/img/bukti_transfer/)
    $folder_tujuan = '../bukti_transfer/';
    
    // Pindahkan file dari memori sementara ke folder tujuan
    if (move_uploaded_file($tmp_name, $folder_tujuan . $nama_file_baru)) {
        
        // --- 2. JIKA UPLOAD SUKSES, PINDAHKAN KERANJANG KE TRANSAKSI ---
        $query_keranjang = mysqli_query($db, "SELECT * FROM keranjang WHERE id_user = '$id_user'");
        
        if (mysqli_num_rows($query_keranjang) > 0) {
            
            // Lakukan perulangan untuk setiap kucing
            while ($data_keranjang = mysqli_fetch_array($query_keranjang)) {
                $id_kucing = $data_keranjang['id_kucing'];
                
                // Ambil harga kucing
                $q_kucing = mysqli_query($db, "SELECT harga FROM kucing WHERE id_kucing = '$id_kucing'");
                $d_kucing = mysqli_fetch_assoc($q_kucing);
                $harga_kucing = $d_kucing['harga'];
                
                // Masukkan ke tabel transaksi (Status diubah jadi 'Verifikasi Pembayaran' karena sudah upload bukti)
                $query_transaksi = "INSERT INTO transaksi (id_pembeli, id_kucing, tanggal_transaksi, harga_kucing, total_bayar, bukti_transfer, status_transaksi) 
                                    VALUES ('$id_user', '$id_kucing', '$tanggal_sekarang', '$harga_kucing', '$harga_kucing', '$nama_file_baru', 'Verifikasi Pembayaran')";
                mysqli_query($db, $query_transaksi);
                
                // Ubah status kucing jadi 'TJ' (Terjual) agar hilang dari katalog
                mysqli_query($db, "UPDATE kucing SET status_jual = 'TJ' WHERE id_kucing = '$id_kucing'");
            }
            
            // --- 3. KOSONGKAN KERANJANG & REDIRECT ---
            mysqli_query($db, "DELETE FROM keranjang WHERE id_user = '$id_user'");
            
            echo '<script>alert("Pesanan berhasil dibuat! Silakan tunggu Admin memverifikasi pembayaran Anda.");</script>';
            echo '<script>window.location.href="../pesanan_saya_pembeli/index.php";</script>';
            
        } else {
            echo '<script>alert("Keranjang kosong!"); window.location.href="../keranjang_pembeli/index.php";</script>';
        }
        
    } else {
        // Jika file gagal dipindahkan ke folder
        echo '<script>alert("Gagal mengunggah bukti transfer! Pastikan folder penyimpanan sudah ada."); window.location.href="../keranjang_pembeli/index.php";</script>';
    }
} else {
    echo '<script>window.location.href="../keranjang_pembeli/index.php";</script>';
}
?>