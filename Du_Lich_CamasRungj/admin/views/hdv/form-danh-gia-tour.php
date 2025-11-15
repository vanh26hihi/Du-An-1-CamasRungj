<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Đánh Giá Tour</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Đánh Giá Tour</li>
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
                                <i class="fas fa-star"></i> Gửi Đánh Giá Về Tour
                            </h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=hdv-gui-danh-gia' ?>" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tour_id">Chọn Tour <span class="text-danger">*</span></label>
                                    <select class="form-control" id="tour_id" name="tour_id" required>
                                        <option value="">-- Chọn Tour --</option>
                                        <option value="1">Tour 1</option>
                                        <option value="2">Tour 2</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="lich_id">Lịch Khởi Hành <span class="text-danger">*</span></label>
                                    <select class="form-control" id="lich_id" name="lich_id" required>
                                        <option value="">-- Chọn Lịch --</option>
                                        <option value="1">Lịch 1</option>
                                        <option value="2">Lịch 2</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="diem_danh_gia">Đánh Giá Chung (1-5 sao) <span class="text-danger">*</span></label>
                                    <select class="form-control" id="diem_danh_gia" name="diem_danh_gia" required>
                                        <option value="">-- Chọn Điểm --</option>
                                        <option value="5">⭐⭐⭐⭐⭐ 5 Sao - Xuất Sắc</option>
                                        <option value="4">⭐⭐⭐⭐ 4 Sao - Tốt</option>
                                        <option value="3">⭐⭐⭐ 3 Sao - Bình Thường</option>
                                        <option value="2">⭐⭐ 2 Sao - Cần Cải Thiện</option>
                                        <option value="1">⭐ 1 Sao - Kém</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="phan_hoi">Phản Hồi Chi Tiết <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="phan_hoi" name="phan_hoi" rows="6" placeholder="Ghi lại ý kiến về:&#10;- Chất lượng dịch vụ&#10;- Khách sạn, nhà hàng&#10;- Xe vận chuyển&#10;- Hướng dẫn&#10;- Các vấn đề phát sinh..." required></textarea>
                                </div>

                                <input type="hidden" name="hdv_id" value="<?= $_GET['hdv_id'] ?>">
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Gửi Đánh Giá
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-lich-lam-viec&hdv_id=" . $_GET['hdv_id'] ?>" class="btn btn-secondary">
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
                                <i class="fas fa-comment"></i> Hướng Dẫn Đánh Giá
                            </h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Vui lòng đánh giá về:</strong></p>
                            <ul>
                                <li><strong>Dịch vụ:</strong> Chất lượng hướng dẫn, phục vụ</li>
                                <li><strong>Khách sạn:</strong> Sạch sẽ, tiện nghi, phục vụ</li>
                                <li><strong>Ăn uống:</strong> Chất lượng, vệ sinh, phong cách</li>
                                <li><strong>Xe:</strong> Điều kiện, hành xử tài xế</li>
                                <li><strong>Sự cố:</strong> Ghi rõ vấn đề để cải thiện</li>
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
