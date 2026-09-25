<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-beli'])) {
    
    $id_pembeli = $_SESSION['id_user'];
    $id_kucing = trim(mysqli_real_escape_string($db, $_POST['id_kucing']));
    $total_bayar = trim(mysqli_real_escape_string($db, $_POST['total_bayar']));
    
    // Status awal transaksi adalah Verifikasi Pembayaran oleh Admin
    $status_transaksi = 'Verifikasi Pembayaran';
    $nama_file_bukti = '';

    // Proses Upload Bukti Transfer (Gambar)
    if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] === 0) {
        $fileName = $_FILES['bukti_transfer']['name'];
        $fileTmp  = $_FILES['bukti_transfer']['tmp_name'];
        
        // PENTING: Arahkan ke folder admin/bukti_pembayaran/
        // Pastikan kamu membuat folder kosong bernama "bukti_pembayaran" di dalam folder admin
        $targetDir = "../bukti_transfer/"; 
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $nama_file_bukti = time() . '_pembeli_' . $fileName;
            $targetFile = $targetDir . $nama_file_bukti;
            
            if (!move_uploaded_file($fileTmp, $targetFile)) {
                echo "<script>alert('Gagal mengupload bukti transfer!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file salah! Harus JPG/PNG.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Bukti transfer wajib diunggah!'); window.history.back();</script>";
        exit;
    }
    
    // 1. Simpan data ke tabel transaksi
    $query_transaksi = "INSERT INTO transaksi (
                            id_kucing, id_pembeli, harga_kucing, total_bayar, status_transaksi, bukti_transfer
                        ) VALUES (
                            '$id_kucing', '$id_pembeli', '$total_bayar', '$total_bayar', '$status_transaksi', '$nama_file_bukti'
                        )";
              
    $eksekusi_transaksi = mysqli_query($db, $query_transaksi) or die (mysqli_error($db));
    
    // 2. Jika transaksi berhasil dibuat, UBAH status kucing menjadi 'TJ' (Terjual)
    if ($eksekusi_transaksi) {
        mysqli_query($db, "UPDATE kucing SET status_jual = 'TJ' WHERE id_kucing = '$id_kucing'");
        
        echo '<script>alert("Pesanan berhasil dibuat! Silakan tunggu Admin memvalidasi pembayaran Anda.")</script>';
        // Setelah berhasil, arahkan pembeli ke halaman Pesanan Saya
        echo '<script>window.location.href="../pesanan_saya_pembeli"</script>';
    } else {
        echo '<script>alert("Gagal memproses pesanan!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>