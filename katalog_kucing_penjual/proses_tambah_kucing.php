<?php 
require_once '../database/koneksi.php'; // Sesuaikan jumlah ../ dengan struktur folder kamu

if (isset($_POST['btn-tambah'])) {
    
    // Menangkap data inputan
    $id_penjual = trim(mysqli_real_escape_string($db, $_POST['id_penjual']));
    $nama_kucing = trim(mysqli_real_escape_string($db, $_POST['nama_kucing']));
    $id_ras = trim(mysqli_real_escape_string($db, $_POST['id_ras']));
    $jenis_kelamin = trim(mysqli_real_escape_string($db, $_POST['jenis_kelamin']));
    $umur_bulan = trim(mysqli_real_escape_string($db, $_POST['umur_bulan']));
    $harga = trim(mysqli_real_escape_string($db, $_POST['harga']));
    $deskripsi = trim(mysqli_real_escape_string($db, $_POST['deskripsi']));
    
    // Set status default secara otomatis (tanpa input dari form)
    $status_jual = 'TS'; // TS = Tersedia
    $status_validasi = 'P'; // P = Pending (Menunggu Validasi Admin)
    
    $nama_file_kesehatan = '';
    $nama_foto_kucing = '';

    // 1. Proses Upload Foto Kucing
    if (isset($_FILES['foto_kucing']) && $_FILES['foto_kucing']['error'] === 0) {
        $fotoName = $_FILES['foto_kucing']['name'];
        $fotoTmp  = $_FILES['foto_kucing']['tmp_name'];
        
        // Arahkan ke folder asset_adminlte/img/ sesuai permintaan
        $targetDirFoto = "../asset_adminlte/img/"; 
        $fotoExtension = strtolower(pathinfo($fotoName, PATHINFO_EXTENSION));
        
        // Validasi ekstensi foto
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fotoExtension, $allowedExtensions)) {
            $nama_foto_kucing = time() . '_foto_' . preg_replace("/[^a-zA-Z0-9.]/", "", $fotoName); // Hindari spasi di nama file
            $targetFileFoto = $targetDirFoto . $nama_foto_kucing;
            
            if (!move_uploaded_file($fotoTmp, $targetFileFoto)) {
                echo "<script>alert('Gagal mengupload file Foto Kucing!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format foto harus JPG, JPEG, atau PNG!'); window.history.back();</script>";
            exit;
        }
    }

    // 2. Proses Upload PDF Kesehatan
    if (isset($_FILES['file_kesehatan']) && $_FILES['file_kesehatan']['error'] === 0) {
        $fileName = $_FILES['file_kesehatan']['name'];
        $fileTmp  = $_FILES['file_kesehatan']['tmp_name'];
        
        // Arahkan ke folder admin/pdf/
        $targetDir = "../data_master_admin/pdf/"; 
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if ($fileExtension == 'pdf') {
            $nama_file_kesehatan = time() . '_pdf_' . preg_replace("/[^a-zA-Z0-9.]/", "", $fileName);
            $targetFile = $targetDir . $nama_file_kesehatan;
            
            if (!move_uploaded_file($fileTmp, $targetFile)) {
                echo "<script>alert('Gagal mengupload file PDF!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('File sertifikat harus berformat PDF!'); window.history.back();</script>";
            exit;
        }
    }
    
    // 3. Query Insert Data (Ditambahkan kolom foto_kucing)
    $query = "INSERT INTO kucing (
                id_penjual, id_ras, nama_kucing, jenis_kelamin, 
                umur_bulan, harga, status_jual, status_validasi, 
                deskripsi, file_kesehatan, foto_kucing
              ) VALUES (
                '$id_penjual', '$id_ras', '$nama_kucing', '$jenis_kelamin', 
                '$umur_bulan', '$harga', '$status_jual', '$status_validasi', 
                '$deskripsi', '$nama_file_kesehatan', '$nama_foto_kucing'
              )";
              
    $query_simpan = mysqli_query($db, $query) or die (mysqli_error($db));
    
    if ($query_simpan) {
        echo '<script>alert("Kucing dan foto berhasil ditambahkan! Menunggu validasi Admin.")</script>';
        echo '<script>window.location.href="index.php"</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data kucing!")</script>';
        echo '<script>window.history.back()</script>';
    }
}
?>