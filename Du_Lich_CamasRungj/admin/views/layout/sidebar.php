<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
    <a href="<?= BASE_URL_ADMIN ?>" class="brand-link">
      <img src="./assets/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CamasRungj</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= $_SESSION['user_admin']['anh_dai_dien'] ?? './assets/dist/img/user2-160x160.jpg' ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri' ?>" class="d-block">
            <?= $_SESSION['user_admin']['ho_ten'] ?? 'User' ?>
            <small class="text-muted d-block">
              <i class="fas fa-user-shield"></i> 
              <?= ($_SESSION['user_admin']['vai_tro_id'] ?? 1) == 1 ? 'Quản Trị Viên' : 'Hướng Dẫn Viên' ?>
            </small>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php if (($_SESSION['user_admin']['vai_tro_id'] ?? 0) == 1): // Admin 
          ?>
            <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN ?>" class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Thống Kê Doanh Thu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN . "?act=danh-muc-tour" ?>" class="nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>Quản Lý Danh Mục Tour</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN . "?act=quan-ly-tour" ?>" class="nav-link">
                <i class="nav-icon fas fa-map-marked-alt"></i>
                <p>Quản Lý Tour</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN . "?act=booking" ?>" class="nav-link">
                <i class="nav-icon fas fa-calendar-check"></i>
                <p>Quản Lý Booking</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN . "?act=hdv-quan-ly&hdv_id=1" ?>" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Quản Lý HDV</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>
                  Quản Lý Tài Khoản
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= BASE_URL_ADMIN . "?act=list-tai-khoan-quan-tri" ?>" class="nav-link">
                    <i class="nav-icon fas fa-user-shield"></i>
                    <p>Tài Khoản Quản Trị</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= BASE_URL_ADMIN . "?act=danh-sach-hdv" ?>" class="nav-link">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>Tài Khoản HDV</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri' ?>" class="nav-link">
                    <i class="nav-icon fas fa-user-edit"></i>
                    <p>Tài Khoản Cá Nhân</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php else: // HDV 
          ?>
            <li class="nav-item">
              <a href="<?= BASE_URL_ADMIN ?>" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Lịch Làm Việc</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>
                  Quản Lý Tài Khoản
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri' ?>" class="nav-link">
                    <i class="nav-icon far fa-user"></i>
                    <p>Tài khoản cá nhân</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>