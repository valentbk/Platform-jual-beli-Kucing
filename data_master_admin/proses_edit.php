<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    $id_kucing = trim(mysqli_real_escape_string($db, $_POST['id_kucing']));
    $id_ras = trim(mysqli_real_escape_string($db, $_POST['id_ras']));
    $harga = trim(mysqli_real_escape_string($db, $_POST['harga']));
    $status_jual = trim(mysqli_real_escape_string($db, $_POST['status_jual']));
    $status_validasi = trim(mysqli_real_escape_string($db, $_POST['status_validasi']));
    $jenis_kelamin = trim(mysqli_real_escape_string($db, $_POST['jenis_kelamin']));
    $umur_bulan = trim(mysqli_real_escape_string($db, $_POST['umur_bulan']));
    $deskripsi = trim(mysqli_real_escape_string($db, $_POST['deskripsi']));
    
    $file_kesehatan_lama = trim(mysqli_real_escape_string($db, $_POST['file_kesehatan_lama']));
    $file_kesehatan_baru = $file_kesehatan_lama;

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
                
                if (move_uploaded_file($fileTmp, $targetFile)) {
                    $file_kesehatan_baru = $uniqueName;
                    
                    if ($file_kesehatan_lama != '' && file_exists($targetDir . $file_kesehatan_lama)) {
                        unlink($targetDir . $file_kesehatan_lama);
                    }
                } else {
                    echo "<script>alert('Gagal mengupload file PDF baru.'); window.history.back();</script>";
                    exit;
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

    $query_edit_kucing = mysqli_query($db, "UPDATE kucing SET 
        id_ras = '$id_ras',
        harga = '$harga',
        status_jual = '$status_jual',
        status_validasi = '$status_validasi',
        jenis_kelamin = '$jenis_kelamin',
        umur_bulan = '$umur_bulan',
        deskripsi = '$deskripsi',
        file_kesehatan = '$file_kesehatan_baru'
        WHERE id_kucing = '$id_kucing'") or die(mysqli_error($db));
        
    if ($query_edit_kucing) {
        echo '<script>alert ("Edit Data Kucing Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>'; 
    } else {
        echo '<script>alert ("Gagal mengedit data!")</script>';
    }
}
?>