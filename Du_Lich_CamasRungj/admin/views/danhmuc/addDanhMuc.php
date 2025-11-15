<h2>Thêm danh mục</h2>
<form action="?controller=danhmuc&action=postadd" method="POST">
    <label for="">Tên danh mục: </label>
    <input type="text" name ="ten" required>
    <label for="">trạng thái: </label>
    <select name="trang_thai">
        <option value="1">Hiển thị</option>
        <option value="0">Ẩn</option>
    </select>
    <button type = "submit" name="submit">Thêm</button>
</form>
