      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="../home_admin" class="nav-link <?php if ($halaman == 'home') {echo 'active';}?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_user_admin" class="nav-link <?php if ($halaman == 'data_user') {echo 'active';}?>">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Data User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_ras_admin" class="nav-link <?php if ($halaman == 'data_ras') {echo 'active';}?>">
              <i class="nav-icon fas fa-cat"></i>
              <p>
                Data Ras 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../data_master_admin" class="nav-link <?php if ($halaman == 'data_master') {echo 'active';}?>">
              <i class="nav-icon fas fa-cat"></i>
              <p>
                Data Master Kucing
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../validasi_pembayaran_admin" class="nav-link <?php if ($halaman == 'validasi_pembayaran') {echo 'active';}?>">
              <i class="nav-icon fas fa-exchange-alt"></i>
              <p>
                Validasi Pembayaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../riwayat_transaksi_admin" class="nav-link <?php if ($halaman == 'riwayat_transaksi') {echo 'active';}?>">
              <i class="nav-icon fas fa-history"></i>
              <p>
                Riwayat Transaksi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../rekening_admin" class="nav-link <?php if ($halaman == 'rekening_admin') {echo 'active';}?>">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Rekening Admin
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../penarikan_dana_admin" class="nav-link <?php if ($halaman == 'penarikan_dana') {echo 'active';}?>">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Penarikan Dana
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../ganti_password_admin" class="nav-link <?php if ($halaman == 'ganti_pw') {echo 'active';}?>">
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