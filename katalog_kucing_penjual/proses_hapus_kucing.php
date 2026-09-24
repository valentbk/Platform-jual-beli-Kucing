<?php 
require_once '../database/koneksi.php';

if (isset($_GET['nama_kucing'])) {
    $nama_kucing = mysqli_real_escape_string($db, $_GET['nama_kucing']);
    
    // 1. Cek keberadaan file PDF fisik
    $cek_file = mysqli_query($db, "SELECT file_kesehatan FROM kucing WHERE nama_kucing = '$nama_kucing'");
    
    if ($data = mysqli_fetch_assoc($cek_file)) {
        $file_kesehatan = $data['file_kesehatan'];
        $targetDir = "../../admin/pdf/";
        
        // 2. Hapus file PDF fisik dari folder jika ada
        if (!empty($file_kesehatan) && file_exists($targetDir . $file_kesehatan)) {
            unlink($targetDir . $file_kesehatan);
        }
    }
    
    // 3. Hapus data dari tabel
    $query = "DELETE FROM kucing WHERE nama_kucing = '$nama_kucing'";
    $query_hapus = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($query_hapus) {
        echo '<script>alert("Kucing berhasil dihapus dari Katalog Anda!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal menghapus data kucing!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>