<?php
require_once '../database/koneksi.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../asset_login/fonts/icomoon/style.css">

    <link rel="stylesheet" href="../asset_login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../asset_login/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="../asset_login/css/style.css">

    <title>MeowMart</title>
  </head>
  <body>
  

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('../asset_login/images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3><strong>MeowMart</strong></h3>
            
            <form action="" method="post">
              <div class="form-group first">
                <label for="">Masukan pin anda</label>
                <input type="text" class="form-control" placeholder="masukan pin" id="username" name="pin" required>
              </div>
              
              <input type="submit" value="Log In" class="btn btn-block btn-primary" name="btn-2fa">

            </form>
            <?php
              if (isset($_POST['btn-2fa'])) {
                $input_pin = trim(mysqli_real_escape_string($db, $_POST['pin']));

                $role = @$_SESSION['role'];
                $pin = @$_SESSION['pin'];

                if ($input_pin == $pin ) {
                 if ($role == 'A') {
                  echo '<script>window.location.href="../home_admin"</script>';
                    }elseif ($role == 'PB') {
                    echo '<script>window.location.href="../home_pembeli"</script>';
                    }elseif ($role == 'PJ') {
                        echo '<script>window.location.href="../home_penjual"</script>';
                    }else{
                        echo '<script>alert("Gagal masuk. Role tidak ditemukan.");</script>';
                    }
                } else {
                  echo '<script>alert ("Pin yang anda masukan salah")</script>';
                  echo '<script>window.location.href="../../MeowMart"</script>'; 
                }
               }
            
             ?>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

    <script src="../asset_login/js/jquery-3.3.1.min.js"></script>
    <script src="../asset_login/js/popper.min.js"></script>
    <script src="../asset_login/js/bootstrap.min.js"></script>
    <script src="../asset_login/js/main.js"></script>
  </body>
</html>