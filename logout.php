<?php
session_start();  
session_unset();
session_destroy();

echo '<script>alert("Anda berhasil logout.");</script>';
echo '<script>window.location.href="index.php"</script>';
?>