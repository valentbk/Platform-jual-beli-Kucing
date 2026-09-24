<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-tambah'])) {
    
    $id_penjual = trim(mysqli_real_escape_string($db,$_POST['id_penjual']));
    $id_ras = trim(mysqli_real_escape_string($db,$_POST['id_ras']));
    $nama_kucing = trim(mysqli_real_escape_string($db,$_POST['nama_kucing']));
    $jenis_kelamin = trim(mysqli_real_escape_string($db,$_POST['jenis_kelamin']));
    $umur_bulan = trim(mysqli_real_escape_string($db,$_POST['umur_bulan']));
    $harga = trim(mysqli_real_escape_string($db,$_POST['harga']));
    $deskripsi = trim(mysqli_real_escape_string($db,$_POST['deskripsi']));
    $status_validasi = trim(mysqli_real_escape_string($db,$_POST['status_validasi']));
    $status_jual = trim(mysqli_real_escape_string($db,$_POST['status_jual']));
    
    $foto_kucing = ''; 
    
    $uniqueName = '';
    
    if (isset($_FILES['file_kesehatan']) && $_FILES['file_kesehatan']['error'] === 0) {
        $fileName = $_FILES['file_kesehatan']['name'];
        $fileTmp  = $_FILES['file_kesehatan']['tmp_name'];
        $fileSize = $_FILES['file_kesehatan']['size'];
        
        $targetDir = "pdf/";
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($fileExtension === 'pdf') {
            if ($fileSize < 5000000) {
                $uniqueName = time() . '_' . $fileName;
                $targetFile = $targetDir . $uniqueName;
                
                if (!move_uploaded_file($fileTmp, $targetFile)) {
                    $uniqueName = ''; 
                    echo "<script>alert('Peringatan: Gagal memindahkan file PDF ke folder tujuan.');</script>";
                }
            } else {
                echo "<script>alert('Ukuran file PDF terlalu besar! Maksimal 5MB.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file salah! Harus berupa file PDF.'); window.history.back();</script>";
            exit;
        }
    }

    $query_cek_nama = mysqli_query($db, "SELECT nama_kucing FROM kucing WHERE nama_kucing ='$nama_kucing'") or die (mysqli_error($db));
    $rv = mysqli_num_rows($query_cek_nama);
    
    if ($rv > 0) {
        echo '<script>alert ("Data Kucing sudah ada!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        $query = "INSERT INTO kucing (id_penjual, id_ras, nama_kucing, jenis_kelamin, umur_bulan, harga, deskripsi, foto_kucing, file_kesehatan, status_validasi, status_jual) 
                  VALUES ('$id_penjual', '$id_ras', '$nama_kucing', '$jenis_kelamin', '$umur_bulan', '$harga', '$deskripsi', '$foto_kucing', '$uniqueName', '$status_validasi', '$status_jual')";
                  
        $query_simpan = mysqli_query($db, $query) or die (mysqli_error($db));
        
        echo '<script>alert ("Tambah Data Kucing Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>';
    }
}
?>