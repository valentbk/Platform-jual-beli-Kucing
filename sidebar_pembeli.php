      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../home_pembeli" class="nav-link <?php if ($halaman == 'home') {echo 'active';}?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../katalog_pembeli" class="nav-link <?php if ($halaman == 'katalog') {echo 'active';}?>">
              <i class="nav-icon fas fa-cat"></i>
              <p>
                Katalog Kucing
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../pesanan_saya_pembeli" class="nav-link <?php if ($halaman == 'pesanan_saya') {echo 'active';}?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Pesanan Saya
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../profil_pembeli" class="nav-link <?php if ($halaman == 'profil') {echo 'active';}?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Profil Saya
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../ganti_password_pembeli" class="nav-link <?php if ($halaman == 'ganti_pw') {echo 'active';}?>">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                Ganti Password
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>
          
        </ul>
      </nav>