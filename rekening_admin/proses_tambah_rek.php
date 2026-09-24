<?php 
require_once '../database/koneksi.php';

// Mengecek apakah tombol simpan ditekan
if (isset($_POST['btn-tambah-rek'])) {
    
    // Menangkap dan membersihkan inputan untuk mencegah SQL Injection
    $nama_bank = trim(mysqli_real_escape_string($db, $_POST['nama_bank']));
    $no_rekening = trim(mysqli_real_escape_string($db, $_POST['no_rekening']));
    $atas_nama = trim(mysqli_real_escape_string($db, $_POST['atas_nama']));
    
    // Query untuk memasukkan data ke tabel rekening_admin
    $query = "INSERT INTO rekening_admin (nama_bank, no_rekening, atas_nama) 
              VALUES ('$nama_bank', '$no_rekening', '$atas_nama')";
              
    $query_simpan = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($query_simpan) {
        echo '<script>alert("Tambah Data Rekening Berhasil!")</script>';
        // Catatan: Jika nama file tabel rekeningmu bukan index.php, 
        // ubah 'index.php' di bawah ini menjadi 'rekening_admin.php' atau sesuai namamu
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data rekening!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>