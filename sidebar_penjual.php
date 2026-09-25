      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../home_penjual" class="nav-link <?php if ($halaman == 'home') {echo 'active';}?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../katalog_kucing_penjual" class="nav-link <?php if ($halaman == 'katalog_kucing') {echo 'active';}?>">
              <i class="nav-icon fas fa-cat"></i>
              <p>
                Katalog Kucing Saya
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../pesanan_penjual" class="nav-link <?php if ($halaman == 'pesanan_masuk') {echo 'active';}?>">
              <i class="nav-icon fas fas fa-shopping-cart"></i>
              <p>
                Pesanan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_rekening_penjual" class="nav-link <?php if ($halaman == 'data_rekening') {echo 'active';}?>">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Data Rekening Saya
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../tarik_dana_penjual" class="nav-link <?php if ($halaman == 'tarik_dana') {echo 'active';}?>">
              <i class="nav-icon fas fas fa-hand-holding-usd"></i>
              <p>
                Tarik Dana
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../ganti_password_penjual" class="nav-link <?php if ($halaman == 'ganti_pw') {echo 'active';}?>">
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