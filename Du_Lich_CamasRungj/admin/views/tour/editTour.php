<h2>Sửa tour</h2>
<form action="?controller=tour&action=post-sua-tour" method = "post">

<!-- ID ẩn -->

    <input type="hidden" name = "id" value="<?= $tour['tour_id'] ?>">
    <label for="">Tên Tour</label><br>
    <input type="text" name = "ten" value="<?= $tour['ten'] ?>" required><br><br>
    <label for="">Mô tả</label>
    <input type="text" name="mo_ta" >
    <label for="">Trạng thái</label>
    <select name="trang_thai" id="">
        <option value="1" <?= $tour['trang_thai'] == 1? 'selected' : ''?>>Hiển thị</option>
        <option value="0" <?= $tour['trang_thai'] == 0? 'selected' : ''?>>Ẩn</option>
    </select><br><br>
    <button type = "submit" name = "submit">Lưu thay đổi</button>
</form>