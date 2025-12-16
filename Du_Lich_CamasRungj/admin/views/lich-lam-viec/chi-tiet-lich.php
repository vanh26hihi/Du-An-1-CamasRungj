<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chi Tiết Lịch Làm Việc</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . "?act=hdv-lich-lam-viec" ?>">Lịch Làm Việc</a></li>
                        <li class="breadcrumb-item active">Chi Tiết Lịch</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tour: <?= htmlspecialchars($lichInfo['ten_tour']) ?></h3>
                    <p class="mb-0">Từ <?= date('d/m/Y', strtotime($lichInfo['ngay_bat_dau'])) ?> đến <?= date('d/m/Y', strtotime($lichInfo['ngay_ket_thuc'])) ?></p>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="lichTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'khach-hang' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich-lam-viec&lich_id=" . $lich_id . "&tab=khach-hang" ?>">
                                <i class="fas fa-users"></i> Thông Tin Khách Hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'diem-danh' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich-lam-viec&lich_id=" . $lich_id . "&tab=diem-danh" ?>">
                                <i class="fas fa-check-circle"></i> Điểm Danh
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $tab == 'nhat-ky' ? 'active' : '' ?>" 
                               href="<?= BASE_URL_ADMIN . "?act=hdv-chi-tiet-lich-lam-viec&lich_id=" . $lich_id . "&tab=nhat-ky" ?>">
                                <i class="fas fa-book"></i> Nhật Ký Tour
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <!-- Tab 1: Thông Tin Khách Hàng -->
                        <?php if ($tab == 'khach-hang'): ?>
                            <div class="card">
                                <div class="card-body">
                                    <?php if (!empty($danhSachKhach)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Họ Tên</th>
                                                        <th>CCCD</th>
                                                        <th>Số Điện Thoại</th>
                                                        <th>Ghi Chú</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $stt = 1; foreach ($danhSachKhach as $khach): ?>
                                                        <tr>
                                                            <td class="text-center"><?= $stt++ ?></td>
                                                            <td><?= htmlspecialchars($khach['ho_ten']) ?></td>
                                                            <td><?= htmlspecialchars($khach['cccd'] ?? '') ?></td>
                                                            <td><?= htmlspecialchars($khach['so_dien_thoai'] ?? '') ?></td>
                                                            <td><?= htmlspecialchars($khach['ghi_chu'] ?? '') ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Chưa có khách hàng nào trong tour này
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tab 2: Điểm Danh -->
                        <?php if ($tab == 'diem-danh'): ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3"><i class="fas fa-check-circle"></i> Điểm Danh Khách Hàng</h5>
                                    
                                    <?php if (!empty($diemDanh)): ?>
                                        <form method="POST" action="<?= BASE_URL_ADMIN ?>?act=hdv-xu-ly-diem-danh">
                                            <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th width="60">STT</th>
                                                            <th>Họ Tên Khách Hàng</th>
                                                            <th width="150" class="text-center">Đã Đến</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $stt = 1; foreach ($diemDanh as $khach): ?>
                                                            <tr>
                                                                <td class="text-center"><?= $stt++ ?></td>
                                                                <td>
                                                                    <strong><?= htmlspecialchars($khach['ho_ten']) ?></strong>
                                                                    <?php if (!empty($khach['so_dien_thoai'])): ?>
                                                                        <br><small class="text-muted"><i class="fas fa-phone"></i> <?= htmlspecialchars($khach['so_dien_thoai']) ?></small>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" 
                                                                               class="custom-control-input" 
                                                                               id="diem_danh_<?= $khach['booking_id'] ?>"
                                                                               name="diem_danh[<?= $khach['booking_id'] ?>]" 
                                                                               value="1"
                                                                               <?= (isset($khach['da_den']) && $khach['da_den'] == 1) ? 'checked' : '' ?>>
                                                                        <label class="custom-control-label" for="diem_danh_<?= $khach['booking_id'] ?>"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="text-right mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Lưu Điểm Danh
                                                </button>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Chưa có dữ liệu điểm danh
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tab 3: Nhật Ký Tour -->
                        <?php if ($tab == 'nhat-ky'): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-book"></i> Nhật Ký Tour</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Form thêm nhật ký -->
                                    <div class="card border-primary mb-4">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="fas fa-plus-circle"></i> Thêm Nhật Ký Mới</h6>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="<?= BASE_URL_ADMIN ?>?act=hdv-them-nhat-ky-tour" enctype="multipart/form-data">
                                                <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                                                <input type="hidden" name="hdv_id" value="<?= $hdv_id ?>">
                                                <input type="hidden" name="tour_id" value="<?= $lichInfo['tour_id'] ?>">
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="dia_diem_id">Địa Điểm <span class="text-danger">*</span></label>
                                                            <select class="form-control <?= isset($_SESSION['error']['dia_diem_id']) ? 'is-invalid' : '' ?>" 
                                                                    id="dia_diem_id" name="dia_diem_id" required>
                                                                <option value="">-- Chọn địa điểm --</option>
                                                                <?php if (!empty($diaDiemTour)): ?>
                                                                    <?php foreach ($diaDiemTour as $dd): ?>
                                                                        <option value="<?= $dd['dia_diem_id'] ?>" 
                                                                                <?= (isset($_SESSION['old']['dia_diem_id']) && $_SESSION['old']['dia_diem_id'] == $dd['dia_diem_id']) ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($dd['ten_dia_diem']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                            <?php if (isset($_SESSION['error']['dia_diem_id'])): ?>
                                                                <div class="invalid-feedback"><?= $_SESSION['error']['dia_diem_id'] ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ngay_thuc_hien">Ngày Thực Hiện <span class="text-danger">*</span></label>
                                                            <input type="datetime-local" 
                                                                   class="form-control" 
                                                                   id="ngay_thuc_hien" 
                                                                   name="ngay_thuc_hien"
                                                                   value="<?= isset($_SESSION['old']['ngay_thuc_hien']) ? $_SESSION['old']['ngay_thuc_hien'] : date('Y-m-d\TH:i') ?>" 
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="anh_tour">Ảnh Tour</label>
                                                    <div class="custom-file">
                                                        <input type="file" 
                                                               class="custom-file-input" 
                                                               id="anh_tour" 
                                                               name="anh_tour" 
                                                               accept="image/*"
                                                               onchange="previewImage(this)">
                                                        <label class="custom-file-label" for="anh_tour">Chọn ảnh...</label>
                                                    </div>
                                                    <small class="form-text text-muted">Chấp nhận: JPG, JPEG, PNG, GIF. Tối đa 5MB</small>
                                                    <div id="imagePreview" class="mt-2" style="display:none;">
                                                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="noi_dung">Nội Dung <span class="text-danger">*</span></label>
                                                    <textarea class="form-control <?= isset($_SESSION['error']['noi_dung']) ? 'is-invalid' : '' ?>" 
                                                              id="noi_dung" 
                                                              name="noi_dung" 
                                                              rows="4" 
                                                              placeholder="Nhập nội dung nhật ký..." 
                                                              required><?= isset($_SESSION['old']['noi_dung']) ? htmlspecialchars($_SESSION['old']['noi_dung']) : '' ?></textarea>
                                                    <?php if (isset($_SESSION['error']['noi_dung'])): ?>
                                                        <div class="invalid-feedback"><?= $_SESSION['error']['noi_dung'] ?></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Lưu Nhật Ký
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Danh sách nhật ký -->
                                    <h6 class="mb-3"><i class="fas fa-list"></i> Danh Sách Nhật Ký</h6>
                                    <?php if (!empty($nhatKy)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th width="60" class="text-center">STT</th>
                                                        <th>Địa Điểm</th>
                                                        <th width="180">Ngày Thực Hiện</th>
                                                        <th width="150" class="text-center">Ảnh</th>
                                                        <th>Nội Dung</th>
                                                        <th width="100" class="text-center">Thao Tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $stt = 1; foreach ($nhatKy as $nk): ?>
                                                        <tr>
                                                            <td class="text-center"><?= $stt++ ?></td>
                                                            <td>
                                                                <strong><?= htmlspecialchars($nk['ten_dia_diem']) ?></strong>
                                                            </td>
                                                            <td>
                                                                <i class="far fa-calendar-alt"></i> 
                                                                <?= date('d/m/Y H:i', strtotime($nk['ngay_thuc_hien'])) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if (!empty($nk['anh_tour'])): ?>
                                                                    <img src="<?= BASE_URL . $nk['anh_tour'] ?>" 
                                                                         alt="Ảnh tour" 
                                                                         class="img-thumbnail"
                                                                         style="max-width: 100px; max-height: 100px; cursor: pointer;"
                                                                         onclick="window.open('<?= BASE_URL . $nk['anh_tour'] ?>', '_blank')">
                                                                <?php else: ?>
                                                                    <span class="text-muted"><i class="far fa-image"></i> Không có ảnh</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= nl2br(htmlspecialchars($nk['noi_dung'])) ?></td>
                                                            <td class="text-center">
                                                                <form method="POST" 
                                                                      action="<?= BASE_URL_ADMIN ?>?act=hdv-xoa-nhat-ky-tour" 
                                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?');"
                                                                      style="display: inline;">
                                                                    <input type="hidden" name="nhat_ky_id" value="<?= $nk['nhat_ky_tour_id'] ?>">
                                                                    <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                                                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Chưa có nhật ký nào được thêm
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const label = input.nextElementSibling;
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
        label.textContent = input.files[0].name;
    } else {
        previewDiv.style.display = 'none';
        label.textContent = 'Chọn ảnh...';
    }
}
</script>

<?php
// Xóa session errors và old data sau khi hiển thị
unset($_SESSION['error']);
unset($_SESSION['old']);
?>
