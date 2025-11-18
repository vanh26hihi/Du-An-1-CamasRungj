<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cập Nhật Yêu Cầu Đặc Biệt</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Cập Nhật Yêu Cầu</li>
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
                                <i class="fas fa-edit"></i> Cập Nhật Yêu Cầu Đặc Biệt
                            </h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=hdv-sua-yeu-cau' ?>" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tên Khách</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($data['ho_ten'] ?? '') ?>" disabled>
                                    <input type="hidden" name="khach_hang_id" value="<?= $data['hanh_khach_id'] ?? '' ?>">
                                </div>

                                <div class="form-group">
                                    <label for="yeu_cau_dac_biet">Yêu Cầu Đặc Biệt <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="yeu_cau_dac_biet" name="yeu_cau_dac_biet" rows="6" placeholder="Nhập yêu cầu đặc biệt (ăn chay, bệnh lý, dị ứng, v.v.)..." required><?php echo htmlspecialchars($data['yeu_cau_dac_biet'] ?? ''); ?></textarea>
                                    <small class="form-text text-muted">Ví dụ: Ăn chay, dị ứng hải sản, bệnh tim...</small>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Lưu Yêu Cầu
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-yeu-cau-dac-biet&lich_id=" . ($_GET['lich_id'] ?? '') ?>" class="btn btn-secondary">
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
                            <p><strong>Ghi chú yêu cầu đặc biệt:</strong></p>
                            <ul>
                                <li>Ghi rõ loại ăn (chay, halal, etc.)</li>
                                <li>Ghi rõ các bệnh lý, dị ứng</li>
                                <li>Ghi rõ khả năng vận động, nhu cầu hỗ trợ</li>
                                <li>Ghi rõ các nhu cầu khác cần chú ý</li>
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
