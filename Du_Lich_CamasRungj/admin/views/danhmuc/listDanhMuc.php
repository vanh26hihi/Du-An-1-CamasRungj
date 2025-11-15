
<h2>Danh sách danh mục</h2>
<a href="?controller=danhmuc&action=add" class = "btn btn-primamy">Thêm danh mục mới</a>
<table border="1" style = "margin-top: 20px;">
<tr>
<th>ID</th>
<th>Tên danh mục</th>
<th>Trạng thái</th>
<th>Ngày tạo</th>
<th>Hành động</th>
</tr>
<?php
forEach($danhmuc as $row):
?>

<tr>
    <td><?= $row['danh_muc_id'] ?></td>
    <td><?= $row['ten']?></td>
    <td><?= $row['trang_thai'] == 1? 'Hiển thị': 'Ẩn'?></td>
    <td><?= $dm['ngày_tao']?></td>
    <td>
    <a href="?controller=danhmuc&action=edit&id=<?=$row['danh_muc_id'] ?>">Sửa</a>
    <a href="?controller=danhmuc&action=delete&id=<?=$row['danh_muc_id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không ?')">Xóa</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
