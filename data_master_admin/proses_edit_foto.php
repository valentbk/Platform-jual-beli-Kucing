<?php 
require_once '../database/koneksi.php';

if (isset($_POST['btn-editfoto'])) { 
    $id_kucing = trim(mysqli_real_escape_string($db,$_POST['id_kucing']));
    
    $file = $_FILES['foto_kucing']['name'];
    $ekstensi = explode('.',$file);
    $nama_file = 'foto-kucing'.round(microtime(true)).'.'.end($ekstensi);
    
    $alamat_sumber = $_FILES['foto_kucing']['tmp_name'];
    $alamat_tujuan = '../asset_adminlte/img/'.$nama_file;
    
    if(move_uploaded_file($alamat_sumber, $alamat_tujuan)) {
        
        $query_update_foto = mysqli_query($db,"UPDATE kucing SET
        foto_kucing = '$alamat_tujuan'
        WHERE id_kucing = '$id_kucing'") or die(mysqli_error($db));
        
        echo '<script>alert ("Edit Foto Berhasil!")</script>';
        echo '<script>window.location.href="index.php"</script>'; 
        
    } else {
        echo '<script>alert ("Gagal mengupload foto ke folder tujuan.")</script>';
        echo '<script>window.history.back();</script>';
    }
}
?>