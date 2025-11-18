<?php require_once __DIR__ . "/../../layout/header.php"; ?>

<h2>Thêm Tour Mới</h2>
<a href="?controller=QuanLyTour&action=index">← Quay lại</a>

<form method="post">

    <p>
        <label>Tên tour:</label><br>
        <input type="text" name="ten" required>
    </p>

    <p>
        <label>ID Danh mục:</label><br>
        <input type="number" name="danh_muc_id" required>
    </p>

    <p>
        <label>Mô tả ngắn:</label><br>
        <textarea name="mo_ta_ngan"></textarea>
    </p>

    <p>
        <label>Mô tả:</label><br>
        <textarea name="mo_ta" rows="5"></textarea>
    </p>

    <p>
        <label>Giá cơ bản:</label><br>
        <input type="number" name="gia_co_ban" required>
    </p>

    <p>
        <label>Thời lượng mặc định:</label><br>
        <input type="text" name="thoi_luong_mac_dinh">
    </p>

    <p>
        <label>Chính sách:</label><br>
        <textarea name="chinh_sach" rows="4"></textarea>
    </p>

    <p>
        <label>ID người tạo:</label><br>
        <input type="number" name="nguoi_tao_id">
    </p>

    <p>
        <label>Điểm khởi hành:</label><br>
        <input type="text" name="diem_khoi_hanh">
    </p>

    <p>
        <label>Hoạt động:</label><br>
        <select name="hoat_dong">
            <option value="1">Hoạt động</option>
            <option value="0">Không</option>
        </select>
    </p>

    <button type="submit">Thêm tour</button>
</form>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>
