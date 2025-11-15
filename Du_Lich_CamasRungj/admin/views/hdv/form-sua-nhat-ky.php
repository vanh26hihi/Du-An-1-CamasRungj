<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cập Nhật Nhật Ký Tour</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Cập Nhật Nhật Ký</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i> Cập Nhật Nhật Ký Tour
                            </h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=hdv-sua-nhat-ky' ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <input type="hidden" name="nhat_ky_id" value="<?= $data['nhat_ky_tour_id'] ?? '' ?>">
                                <input type="hidden" name="hdv_id" value="<?= $data['hdv_id'] ?? '' ?>">

                                <div class="form-group">
                                    <label for="noi_dung">Nội Dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="noi_dung" name="noi_dung" rows="6" placeholder="Nhập nội dung nhật ký tour..." required><?php echo htmlspecialchars($data['noi_dung'] ?? ''); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="anh_tour">Cập Nhật Ảnh</label>
                                    <?php if (!empty($data['anh_tour'])): ?>
                                    <div class="mb-2">
                                        <p><strong>Ảnh hiện tại:</strong></p>
                                        <img src="<?php echo $data['anh_tour']; ?>" width="200" alt="Tour" class="img-thumbnail">
                                    </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control-file" id="anh_tour" name="anh_tour" accept="image/*">
                                    <small class="form-text text-muted">Để trống nếu không muốn thay ảnh. Định dạng: JPG, PNG, GIF. Kích thước tối đa: 5MB</small>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Lưu Cập Nhật
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-nhat-ky&hdv_id=" . ($data['hdv_id'] ?? '') ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Lưu Ý
                            </h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Cập nhật nhật ký:</strong></p>
                            <ul>
                                <li>Mô tả chi tiết sự kiện, hoạt động</li>
                                <li>Ghi lại sự cố và cách xử lý</li>
                                <li>Ghi phản hồi của khách hàng</li>
                                <li>Thêm ảnh minh họa (tùy chọn)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-danger {
        color: #dc3545;
    }

    .card-footer {
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    .card-footer .btn {
        margin-right: 5px;
    }
</style>
