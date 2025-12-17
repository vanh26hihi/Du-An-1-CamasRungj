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
                            <!-- Form thêm nhật ký -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-primary">
                                            <h3 class="card-title text-white">
                                                <i class="fas fa-plus-circle"></i> Thêm Nhật Ký Tour
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            $error = $_SESSION['error'] ?? [];
                                            $old = $_SESSION['old'] ?? [];
                                            unset($_SESSION['error'], $_SESSION['old']);
                                            ?>
                                            
                                            <form method="POST" 
                                                  action="<?= BASE_URL_ADMIN ?>?act=hdv-them-nhat-ky-tour" 
                                                  enctype="multipart/form-data">
                                                <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                                                <input type="hidden" name="tour_id" value="<?= $lichInfo['tour_id'] ?>">
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Địa Điểm <span class="text-danger">*</span></label>
                                                            <select name="dia_diem_id" 
                                                                    class="form-control <?= isset($error['dia_diem_id']) ? 'is-invalid' : '' ?>" 
                                                                    required>
                                                                <option value="">-- Chọn địa điểm --</option>
                                                                <?php if (!empty($diaDiemTour)): ?>
                                                                    <?php foreach ($diaDiemTour as $dd): ?>
                                                                        <option value="<?= $dd['dia_diem_id'] ?>" 
                                                                                <?= (isset($old['dia_diem_id']) && $old['dia_diem_id'] == $dd['dia_diem_id']) ? 'selected' : '' ?>>
                                                                            <?= htmlspecialchars($dd['ten_dia_diem']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                            <?php if (isset($error['dia_diem_id'])): ?>
                                                                <small class="text-danger"><?= $error['dia_diem_id'] ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Ảnh Tour</label>
                                                            <div class="input-group">
                                                                <input type="text" 
                                                                       class="form-control" 
                                                                       id="fileNameDisplay" 
                                                                       placeholder="Chọn ảnh..." 
                                                                       readonly>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" 
                                                                            type="button" 
                                                                            onclick="document.getElementById('anhTourInput').click()">
                                                                        Browse
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="file" 
                                                                   name="anh_tour" 
                                                                   id="anhTourInput"
                                                                   accept="image/*"
                                                                   style="display: none;">
                                                            <small class="text-muted">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 5MB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Nội Dung <span class="text-danger">*</span></label>
                                                    <textarea name="noi_dung" 
                                                              rows="4" 
                                                              class="form-control <?= isset($error['noi_dung']) ? 'is-invalid' : '' ?>" 
                                                              placeholder="Ghi chú về hoạt động, tình hình khách hàng, vấn đề phát sinh..."
                                                              required><?= $old['noi_dung'] ?? '' ?></textarea>
                                                    <?php if (isset($error['noi_dung'])): ?>
                                                        <small class="text-danger"><?= $error['noi_dung'] ?></small>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i> Lưu Nhật Ký
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Danh sách nhật ký -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-primary">
                                            <h3 class="card-title text-white">
                                                <i class="fas fa-list"></i> Danh Sách Nhật Ký
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <?php if (empty($nhatKy)): ?>
                                                <div class="alert alert-info text-center">
                                                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                                                    <p class="mb-0">Chưa có nhật ký nào. Hãy thêm nhật ký đầu tiên!</p>
                                                </div>
                                            <?php else: ?>
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered">
                                                        <thead class="bg-primary text-white">
                                                            <tr>
                                                                <th width="8%" class="text-center">STT</th>
                                                                <th width="20%">Địa Điểm</th>
                                                                <th width="15%">Ngày Thực Hiện</th>
                                                                <th width="12%" class="text-center">Ảnh</th>
                                                                <th width="35%">Nội Dung</th>
                                                                <th width="10%" class="text-center">Thao Tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $stt = 1; 
                                                            foreach ($nhatKy as $nk): 
                                                                $ngayHienThi = $nk['ngay_thuc_hien'] ?? date('Y-m-d H:i:s');
                                                                $noiDungHienThi = $nk['noi_dung'] ?? '';
                                                                $diaDiemHienThi = $nk['ten_dia_diem'] ?? 'Chưa xác định';
                                                                $anhTour = $nk['anh_tour'] ?? '';
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center"><strong><?= $stt++ ?></strong></td>
                                                                    <td>
                                                                        <i class="fas fa-map-marker-alt text-danger"></i> 
                                                                        <?= htmlspecialchars($diaDiemHienThi) ?>
                                                                    </td>
                                                                    <td>
                                                                        <i class="fas fa-calendar-alt text-primary"></i>
                                                                        <?= date('d/m/Y', strtotime($ngayHienThi)) ?><br>
                                                                        <small class="text-muted">
                                                                            <i class="fas fa-clock"></i>
                                                                            <?= date('H:i', strtotime($ngayHienThi)) ?>
                                                                        </small>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php if (!empty($anhTour)): ?>
                                                                            <img src="<?= BASE_URL . $anhTour ?>" 
                                                                                 class="img-thumbnail" 
                                                                                 style="max-width: 60px; max-height: 60px; object-fit: cover; cursor: pointer;"
                                                                                 onclick="window.open('<?= BASE_URL . $anhTour ?>', '_blank')"
                                                                                 alt="<?= htmlspecialchars($diaDiemHienThi) ?>">
                                                                        <?php else: ?>
                                                                            <span class="badge badge-secondary">
                                                                                <i class="fas fa-image"></i>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td><?= nl2br(htmlspecialchars($noiDungHienThi)) ?></td>
                                                                    <td class="text-center">
                                                                        <button type="button" 
                                                                                class="btn btn-danger btn-sm btn-xoa-nhat-ky" 
                                                                                data-id="<?= $nk['nhat_ky_tour_id'] ?>"
                                                                                data-dia-diem="<?= htmlspecialchars($diaDiemHienThi) ?>"
                                                                                title="Xóa nhật ký">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal xác nhận xóa nhật ký -->
                            <div class="modal fade" id="modalXoaNhatKy" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h5 class="modal-title text-white">
                                                <i class="fas fa-exclamation-triangle"></i> Xác Nhận Xóa
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa nhật ký tại địa điểm: <strong id="tenDiaDiemXoa"></strong>?</p>
                                            <p class="text-danger"><i class="fas fa-info-circle"></i> Hành động này không thể hoàn tác!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST" action="<?= BASE_URL_ADMIN ?>?act=hdv-xoa-nhat-ky-tour" id="formXoaNhatKy">
                                                <input type="hidden" name="nhat_ky_id" id="nhatKyIdXoa">
                                                <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times"></i> Hủy
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // Browse button cho file input
    const anhTourInput = document.getElementById('anhTourInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    
    if (anhTourInput) {
        anhTourInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileNameDisplay.value = file.name;
            } else {
                fileNameDisplay.value = '';
            }
        });
    }
    
    // Xóa nhật ký
    const btnXoaList = document.querySelectorAll('.btn-xoa-nhat-ky');
    btnXoaList.forEach(btn => {
        btn.addEventListener('click', function() {
            const nhatKyId = this.dataset.id;
            const diaDiem = this.dataset.diaDiem;
            
            document.getElementById('nhatKyIdXoa').value = nhatKyId;
            document.getElementById('tenDiaDiemXoa').textContent = diaDiem;
            
            $('#modalXoaNhatKy').modal('show');
        });
    });
});
</script>
