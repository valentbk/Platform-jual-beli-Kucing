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
    
    // Menangkap file kesehatan lama
    $file_kesehatan_lama = trim(mysqli_real_escape_string($db, $_POST['file_kesehatan_lama']));
    $file_kesehatan_baru = $file_kesehatan_lama;

    // Menangkap foto kucing lama
    $foto_kucing_lama = trim(mysqli_real_escape_string($db, $_POST['foto_kucing_lama']));
    $foto_kucing_baru = $foto_kucing_lama;

    // 1. Proses Upload Foto Kucing Baru (Jika ada)
    if (isset($_FILES['foto_kucing']) && $_FILES['foto_kucing']['error'] === 0) {
        $fotoName = $_FILES['foto_kucing']['name'];
        $fotoTmp  = $_FILES['foto_kucing']['tmp_name'];
        
        $targetDirFoto = "../asset_adminlte/img/"; 
        $fotoExtension = strtolower(pathinfo($fotoName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fotoExtension, $allowedExtensions)) {
            $uniqueFotoName = time() . '_foto_' . preg_replace("/[^a-zA-Z0-9.]/", "", $fotoName);
            $targetFileFoto = $targetDirFoto . $uniqueFotoName;
            
            if (move_uploaded_file($fotoTmp, $targetFileFoto)) {
                $foto_kucing_baru = $uniqueFotoName;
                
                // Hapus foto lama di direktori jika upload foto baru sukses dan foto lama ada
                if ($foto_kucing_lama != '' && file_exists($targetDirFoto . $foto_kucing_lama)) {
                    unlink($targetDirFoto . $foto_kucing_lama);
                }
            } else {
                echo "<script>alert('Gagal mengupload foto kucing baru.'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format foto harus JPG, JPEG, atau PNG!'); window.history.back();</script>";
            exit;
        }
    }

    // 2. Proses Upload PDF Baru (Jika ada)
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

    // 3. Query Update Data (Ditambahkan pembaruan foto_kucing)
    $query_edit_kucing = mysqli_query($db, "UPDATE kucing SET 
        id_ras = '$id_ras',
        harga = '$harga',
        status_jual = '$status_jual',
        status_validasi = '$status_validasi',
        jenis_kelamin = '$jenis_kelamin',
        umur_bulan = '$umur_bulan',
        deskripsi = '$deskripsi',
        file_kesehatan = '$file_kesehatan_baru',
        foto_kucing = '$foto_kucing_baru'
        WHERE id_kucing = '$id_kucing'") or die(mysqli_error($db));
        
    if ($query_edit_kucing) {
        echo '<script>alert ("Edit Data Kucing Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>'; 
    } else {
        echo '<script>alert ("Gagal mengedit data!")</script>';
    }
}
?>