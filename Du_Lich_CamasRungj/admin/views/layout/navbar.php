<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= BASE_URL_ADMIN ?>" class="nav-link">
          <i class="fas fa-home"></i> Trang Chủ
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Fullscreen -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Toàn màn hình">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
      <!-- Logout -->
      <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL_ADMIN . '?act=logout-admin' ?>" 
           onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')" 
           role="button" 
           title="Đăng xuất">
          <i class="fas fa-sign-out-alt"></i> Đăng Xuất
        </a>
      </li>
    </ul>
  </nav>


