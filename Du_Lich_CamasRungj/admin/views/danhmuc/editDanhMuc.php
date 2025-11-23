<h2>Sửa danh mục</h2>
<form action="?controller=danhmuc&action=post-sua-danh-muc" method = "post">

<!-- ID ẩn -->

    <input type="hidden" name = "id" value="<?= $danhmuc['danh_muc_id'] ?>">
    <label for="">Tên danh mục</label><br>
    <input type="text" name = "ten" value="<?= $danhmuc['ten'] ?>" required><br><br>
    <label for="">Mô tả</label>
    <input type="text" name="mo_ta" >
    <label for="">Trạng thái</label>
    <select name="trang_thai" id="">
        <option value="1" <?= $danhmuc['trang_thai'] == 1? 'selected' : ''?>>Hiển thị</option>
        <option value="0" <?= $danhmuc['trang_thai'] == 0? 'selected' : ''?>>Ẩn</option>
    </select><br><br>
    <button type = "submit" name = "submit">Lưu thay đổi</button>
</form>