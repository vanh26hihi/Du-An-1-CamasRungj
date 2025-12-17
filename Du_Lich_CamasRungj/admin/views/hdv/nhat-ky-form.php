<!-- Form thêm nhật ký -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">
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
                      action="<?= BASE_URL_ADMIN ?>?act=hdv-them-nhat-ky" 
                      enctype="multipart/form-data">
                    <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                    <input type="hidden" name="hdv_id" value="<?= $hdv_id ?>">
                    <input type="hidden" name="tour_id" value="<?= $lichInfo['tour_id'] ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Địa Điểm <span class="text-danger">*</span></label>
                                <select name="dia_diem_id" 
                                        class="form-control <?= isset($error['dia_diem_id']) ? 'is-invalid' : '' ?>" 
                                        required>
                                    <option value="">-- Chọn địa điểm --</option>
                                    <?php
                                    // Lấy danh sách địa điểm của tour
                                    $sqlDiaDiem = "SELECT dd.dia_diem_id, dd.ten 
                                                  FROM dia_diem dd
                                                  INNER JOIN dia_diem_tour ddt ON dd.dia_diem_id = ddt.dia_diem_id
                                                  WHERE ddt.tour_id = ?
                                                  ORDER BY dd.ten";
                                    $diaDiemList = db_query($sqlDiaDiem, [$lichInfo['tour_id']])->fetchAll();
                                    foreach ($diaDiemList as $dd):
                                    ?>
                                        <option value="<?= $dd['dia_diem_id'] ?>" 
                                                <?= (isset($old['dia_diem_id']) && $old['dia_diem_id'] == $dd['dia_diem_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($dd['ten']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($error['dia_diem_id'])): ?>
                                    <small class="text-danger"><?= $error['dia_diem_id'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày Thực Hiện <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       name="ngay_thuc_hien" 
                                       class="form-control <?= isset($error['ngay_thuc_hien']) ? 'is-invalid' : '' ?>" 
                                       value="<?= $old['ngay_thuc_hien'] ?? date('Y-m-d\TH:i') ?>"
                                       required>
                                <?php if (isset($error['ngay_thuc_hien'])): ?>
                                    <small class="text-danger"><?= $error['ngay_thuc_hien'] ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Ảnh Tour</label>
                        <div class="custom-file">
                            <input type="file" 
                                   name="anh_tour" 
                                   class="custom-file-input" 
                                   id="anhTourInput"
                                   accept="image/*">
                            <label class="custom-file-label" for="anhTourInput">Chọn ảnh...</label>
                        </div>
                        <small class="text-muted">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 5MB</small>
                        <div id="previewAnh" class="mt-2" style="display:none;">
                            <img src="" id="imgPreview" class="img-thumbnail" style="max-width: 300px;">
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
            <div class="card-header">
                <h3 class="card-title">
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
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">STT</th>
                                    <th width="15%">Địa Điểm</th>
                                    <th width="15%">Ngày Thực Hiện</th>
                                    <th width="12%" class="text-center">Ảnh</th>
                                    <th width="43%">Nội Dung</th>
                                    <th width="10%" class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $stt = 1; 
                                foreach ($nhatKy as $nk): 
                                    $ngayHienThi = $nk['ngay_thuc_hien'] ?? date('Y-m-d H:i:s');
                                    $noiDungHienThi = $nk['noi_dung'] ?? '';
                                    $diaDiemHienThi = $nk['dia_diem'] ?? 'Chưa xác định';
                                    $anhTour = $nk['anh_tour'] ?? '';
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $stt++ ?></td>
                                        <td>
                                            <strong><i class="fas fa-map-marker-alt text-danger"></i> <?= htmlspecialchars($diaDiemHienThi) ?></strong>
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
                                                <a href="<?= BASE_URL . $anhTour ?>" 
                                                   data-toggle="lightbox" 
                                                   data-title="<?= htmlspecialchars($diaDiemHienThi) ?>">
                                                    <img src="<?= BASE_URL . $anhTour ?>" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 80px; max-height: 80px; object-fit: cover;"
                                                         alt="<?= htmlspecialchars($diaDiemHienThi) ?>">
                                                </a>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-image"></i> Không có ảnh
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
                <form method="POST" action="<?= BASE_URL_ADMIN ?>?act=hdv-xoa-nhat-ky" id="formXoaNhatKy">
                    <input type="hidden" name="nhat_ky_id" id="nhatKyIdXoa">
                    <input type="hidden" name="lich_id" value="<?= $lich_id ?>">
                    <input type="hidden" name="hdv_id" value="<?= $hdv_id ?>">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview ảnh khi chọn file
    const anhTourInput = document.getElementById('anhTourInput');
    const previewAnh = document.getElementById('previewAnh');
    const imgPreview = document.getElementById('imgPreview');
    const fileLabel = document.querySelector('.custom-file-label');
    
    if (anhTourInput) {
        anhTourInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileLabel.textContent = file.name;
                
                // Hiển thị preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    previewAnh.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                fileLabel.textContent = 'Chọn ảnh...';
                previewAnh.style.display = 'none';
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