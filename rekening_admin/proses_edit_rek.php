<?php 
require_once '../database/koneksi.php';

// Mengecek apakah tombol simpan perubahan ditekan
if (isset($_POST['btn-edit-rek'])) {
    
    // Menangkap dan membersihkan inputan untuk mencegah SQL Injection
    $id_rek_admin = trim(mysqli_real_escape_string($db, $_POST['id_rek_admin']));
    $nama_bank = trim(mysqli_real_escape_string($db, $_POST['nama_bank']));
    $no_rekening = trim(mysqli_real_escape_string($db, $_POST['no_rekening']));
    $atas_nama = trim(mysqli_real_escape_string($db, $_POST['atas_nama']));
    
    // Query untuk mengupdate data di tabel rekening_admin berdasarkan ID
    $query = "UPDATE rekening_admin SET 
                nama_bank = '$nama_bank', 
                no_rekening = '$no_rekening', 
                atas_nama = '$atas_nama' 
              WHERE id_rek_admin = '$id_rek_admin'";
              
    $query_update = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($query_update) {
        echo '<script>alert("Ubah Data Rekening Berhasil!")</script>';
        // Catatan: Jika nama file halaman rekeningmu bukan index.php, 
        // ubah 'index.php' di bawah ini menjadi nama file yang benar (contoh: rekening_admin.php)
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengubah data rekening!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>