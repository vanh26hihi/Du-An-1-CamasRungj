<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Thêm Nhật Ký Tour</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN ?>">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="<?= BASE_URL_ADMIN . "?act=hdv-nhat-ky&hdv_id=" . $_GET['hdv_id'] ?>">Nhật Ký Tour</a></li>
                        <li class="breadcrumb-item active">Thêm Nhật Ký</li>
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
                                <i class="fas fa-plus"></i> Thêm Nhật Ký Tour Mới
                            </h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=hdv-them-nhat-ky' ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="hdv_id">HDV ID</label>
                                    <input type="hidden" name="hdv_id" value="<?= $_GET['hdv_id'] ?>">
                                    <input type="text" class="form-control" value="<?= $_GET['hdv_id'] ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="tour_id">Tour <span class="text-danger">*</span></label>
                                    <select class="form-control" id="tour_id" name="tour_id" required>
                                        <option value="">-- Chọn Tour --</option>
                                        <option value="1">Tour 1</option>
                                        <option value="2">Tour 2</option>
                                        <!-- Thay bằng dynamic data nếu có -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="lich_id">Lịch Khởi Hành <span class="text-danger">*</span></label>
                                    <select class="form-control" id="lich_id" name="lich_id" required>
                                        <option value="">-- Chọn Lịch --</option>
                                        <option value="1">Lịch 1</option>
                                        <option value="2">Lịch 2</option>
                                        <!-- Thay bằng dynamic data nếu có -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dia_diem_id">Địa Điểm <span class="text-danger">*</span></label>
                                    <select class="form-control" id="dia_diem_id" name="dia_diem_id" required>
                                        <option value="">-- Chọn Địa Điểm --</option>
                                        <option value="1">Địa Điểm 1</option>
                                        <option value="2">Địa Điểm 2</option>
                                        <!-- Thay bằng dynamic data nếu có -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="noi_dung">Nội Dung <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="noi_dung" name="noi_dung" rows="5" placeholder="Nhập nội dung nhật ký tour..." required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="anh_tour">Ảnh Tour</label>
                                    <input type="file" class="form-control-file" id="anh_tour" name="anh_tour" accept="image/*">
                                    <small class="form-text text-muted">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 5MB</small>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Lưu Nhật Ký
                                </button>
                                <a href="<?= BASE_URL_ADMIN . "?act=hdv-nhat-ky&hdv_id=" . $_GET['hdv_id'] ?>" class="btn btn-secondary">
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
                                <i class="fas fa-info-circle"></i> Hướng Dẫn
                            </h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Lưu ý khi thêm nhật ký:</strong></p>
                            <ul>
                                <li>Chọn tour và lịch khởi hành tương ứng</li>
                                <li>Chọn địa điểm trên tour</li>
                                <li>Mô tả chi tiết nội dung và sự kiện trong ngày</li>
                                <li>Tải ảnh minh họa (tùy chọn)</li>
                                <li>Nhấn "Lưu Nhật Ký" để hoàn thành</li>
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
