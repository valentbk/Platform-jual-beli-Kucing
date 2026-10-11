<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-edit'])) {
    
    // Menangkap data perubahan
    $id_kucing = trim(mysqli_real_escape_string($db, $_POST['id_kucing']));
    $id_ras = trim(mysqli_real_escape_string($db, $_POST['id_ras']));
    $jenis_kelamin = trim(mysqli_real_escape_string($db, $_POST['jenis_kelamin']));
    $umur_bulan = trim(mysqli_real_escape_string($db, $_POST['umur_bulan']));
    $harga = trim(mysqli_real_escape_string($db, $_POST['harga']));
    $deskripsi = trim(mysqli_real_escape_string($db, $_POST['deskripsi']));
    
    // Menangkap data file & foto lama
    $file_lama = trim(mysqli_real_escape_string($db, $_POST['file_kesehatan_lama']));
    $foto_lama = trim(mysqli_real_escape_string($db, $_POST['foto_kucing_lama']));
    
    // Set default nama file dan foto dengan yang lama (berlaku jika user tidak mengupload yang baru)
    $nama_file_kesehatan = $file_lama; 
    $nama_foto_kucing = $foto_lama;

    // 1. Proses Upload Foto Baru (Jika ada)
    if (isset($_FILES['foto_kucing']) && $_FILES['foto_kucing']['error'] === 0) {
        $fotoName = $_FILES['foto_kucing']['name'];
        $fotoTmp  = $_FILES['foto_kucing']['tmp_name'];
        
        $targetDirFoto = "../asset_adminlte/img/"; 
        $fotoExtension = strtolower(pathinfo($fotoName, PATHINFO_EXTENSION));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fotoExtension, $allowedExtensions)) {
            $nama_foto_kucing = time() . '_foto_' . preg_replace("/[^a-zA-Z0-9.]/", "", $fotoName);
            $targetFileFoto = $targetDirFoto . $nama_foto_kucing;
            
            if (move_uploaded_file($fotoTmp, $targetFileFoto)) {
                // Hapus foto lama di direktori jika upload foto baru sukses
                if (!empty($foto_lama) && file_exists($targetDirFoto . $foto_lama)) {
                    unlink($targetDirFoto . $foto_lama);
                }
            } else {
                echo "<script>alert('Gagal mengupload foto kucing!'); window.history.back();</script>";
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
        
        // Disamakan dengan proses tambah kucing agar tidak nyasar
        $targetDir = "../data_master_admin/pdf/"; 
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($fileExtension == 'pdf') {
            $nama_file_kesehatan = time() . '_pdf_' . preg_replace("/[^a-zA-Z0-9.]/", "", $fileName);
            $targetFile = $targetDir . $nama_file_kesehatan;
            
            if (move_uploaded_file($fileTmp, $targetFile)) {
                // Hapus file pdf lama jika upload file baru sukses
                if (!empty($file_lama) && file_exists($targetDir . $file_lama)) {
                    unlink($targetDir . $file_lama);
                }
            } else {
                echo "<script>alert('Gagal mengupload file PDF!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('File sertifikat harus berformat PDF!'); window.history.back();</script>";
            exit;
        }
    }
    
    // 3. Query Update Data (Ditambahkan pembaruan foto_kucing)
    // Catatan: status_validasi direset menjadi 'P' setiap kali penjual melakukan edit data
    $query = "UPDATE kucing SET 
                id_ras = '$id_ras',
                jenis_kelamin = '$jenis_kelamin',
                umur_bulan = '$umur_bulan',
                harga = '$harga',
                deskripsi = '$deskripsi',
                file_kesehatan = '$nama_file_kesehatan',
                foto_kucing = '$nama_foto_kucing',
                status_validasi = 'P' 
              WHERE id_kucing = '$id_kucing'";
              
    $query_update = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($query_update) {
        echo '<script>alert("Data berhasil diubah! Status kembali Pending untuk divalidasi ulang oleh Admin.")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal mengubah data!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>