<?php require_once __DIR__ . "/../../layout/header.php"; ?>

<h2>Quản Lý Tour</h2>
<a href="?controller=QuanLyTour&action=add" class="btn btn-primary">+ Thêm Tour</a>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>ID</th>
        <th>Tên tour</th>
        <th>Danh mục</th>
        <th>Giá cơ bản</th>
        <th>Điểm khởi hành</th>
        <th>Ngày tạo</th>
        <th>Hoạt động</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($tours as $t): ?>
        <tr>
            <td><?= $t['tour_id']; ?></td>
            <td><?= $t['ten']; ?></td>
            <td><?= $t['danh_muc_id']; ?></td>
            <td><?= number_format($t['gia_co_ban']); ?> đ</td>
            <td><?= $t['diem_khoi_hanh']; ?></td>
            <td><?= $t['ngay_tao']; ?></td>
            <td><?= $t['hoat_dong'] ? "Hoạt động" : "Không"; ?></td>
            <td>
                <a href="?controller=QuanLyTour&action=edit&id=<?= $t['tour_id']; ?>">Sửa</a> |
                <a onclick="return confirm('Xóa tour này?')" 
                   href="?controller=QuanLyTour&action=delete&id=<?= $t['tour_id']; ?>">
                    Xóa
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?php require_once __DIR__ . "/../../layout/footer.php"; ?>
