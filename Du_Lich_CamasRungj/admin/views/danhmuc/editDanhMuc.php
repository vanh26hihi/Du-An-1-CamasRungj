<h2>Sửa danh mục</h2>
<form action="?controller=danhmuc&action=postedit" method = "post">
    <input type="hiden" name = "id" value="<?= $danhmuc['danh_muc_id'] ?>">
    <label for="">Tên danh mục</label><br>
    <input type="text" name = "ten_danh_muc" value="<?= $danhmuc['ten_danh_muc'] ?>" required><br><br>
    <label for="">Trạng thái</label>
    <select name="trang_thai" id="">
        <option value="1" <?= $danhmuc['trang_thai'] == 1? 'selected' : ''?>>Hiển thị</option>
        <option value="0" <?= $danhmuc['trang_thai'] == 0? 'selected' : ''?>>Ẩn</option>
    </select><br><br>
    <button type = "submit" name = "submit">Lưu thay đổi</button>
</form>