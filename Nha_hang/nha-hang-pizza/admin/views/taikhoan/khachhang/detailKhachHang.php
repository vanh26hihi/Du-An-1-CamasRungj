<!-- header  -->
<?php require_once './views/layout/header.php'; ?>
<!-- Navbar -->
<?php require_once './views/layout/navbar.php'; ?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php require_once './views/layout/sidebar.php'; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Quản lý Tài Khoản Khách Hàng</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <img src="<?= BASE_URL . $khachhang['anh_dai_dien'] ?>" class="img-thumbnail " width="70%" alt=""
                        onerror="this.onerror = null , this.src='https://www.transparentpng.com/thumb/user/gray-user-profile-icon-png-fP8Q1P.png'">
                </div>

                <div class="col-8">
                    <div class="container">
                        <table class="table table-borderless">
                            <tbody style="font-size:large;">
                                <tr>
                                    <th>Họ Tên:</th>
                                    <td><?= $khachHang['ho_ten'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Ngày Sinh</th>
                                    <td><?= formatDate($khachHang['ngay_sinh']) ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $khachHang['email'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Số Điện Thoại</th>
                                    <td><?= $khachHang['so_dien_thoai'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Giới Tính</th>
                                    <td><?= $khachHang['gioi_tinh'] == 1 ? 'Nam' : 'Nữ' ?></td>
                                </tr>
                                <tr>
                                    <th>Địa Chỉ</th>
                                    <td><?= $khachHang['dia_chi'] ?? '' ?></td>
                                </tr>
                                <tr>
                                    <th>Trang Thai</th>
                                    <?php foreach ($trangThai as $key => $listTrangThai): ?>
                                        <td><?= $listTrangThai['id'] == $khachHang['trang_thai'] ? $listTrangThai['ten_trang_thai'] : '' ?></td>
                                    <?php endforeach  ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <!-- /.col -->
                </div>
                <div class="col-12">
                    <h2>Lịch Sử Mua Hàng</h2>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Đơn Hàng</th>
                                <th>Tên Người Nhận</th>
                                <th>Số Điện Thoại </th>
                                <th>Ngày Đặt</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listDonHang as $key => $donhang): ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= $donhang['ma_don_hang'] ?></td>
                                    <td><?= $donhang['ten_nguoi_nhan'] ?></td>
                                    <td><?= $donhang['sdt_nguoi_nhan'] ?></td>
                                    <td><?= formatDate($donhang['ngay_dat']) ?></td>
                                    <td><?= number_format($donhang['tong_tien'], 0, '.', ',') . ' vnđ' ?></td>
                                    <td><?= $donhang['ten_trang_thai'] ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?= BASE_URL_ADMIN . "?act=chi-tiet-don-hang&id=" . $donhang['id']; ?>">
                                                <button class="btn btn-primary"><i class="far fa-eye"></i></button>
                                            </a>
                                            <a href="<?= BASE_URL_ADMIN . "?act=form-sua-don-hang&id=" . $donhang['id']; ?>">
                                                <button class="btn btn-warning"><i class="fas fa-cogs"></i></button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-12">
                    <h2>Lịch Sử Bình Luận</h2>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản Phẩm</th>
                                <th>Nội Dung</th>
                                <th>Ngày Bình Luậnh/th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listBinhLuan as $key => $binhluan): ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><a target="_blank" href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id=' . $binhluan['san_pham_id'] ?>"><?= $binhluan['ten_san_pham'] ?></a></td>
                                    <td><?= $binhluan['noi_dung'] ?></td>
                                    <td><?= formatDate($binhluan['ngay_dang']) ?></td>
                                    <td><?= $binhluan['trang_thai'] == 1 ? 'Hiển thị' : 'Bị Ẩn' ?></td>
                                    <td class="text-center">
                                        <form action="<?= BASE_URL_ADMIN . "?act=update-trang-thai-binh-luan" ?>" method="post">
                                            <input type="hidden" name="id_binh_luan" value="<?= $binhluan['id'] ?>">
                                            <input type="hidden" name="name_view" value="detail_khach">
                                            <button type="submit" onclick="return confirm('Bạn Có Muốn Đồng Ý Ẩn Bình Luận Này Hay Không')" class="btn btn-danger">
                                                <?= $binhluan['trang_thai'] == 1 ? '<i class="far fa-eye-slash"></i>' : '<i class="far fa-eye"></i>' ?>

                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>




                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Footer -->
<?php require_once './views/layout/footer.php'; ?>
<!-- End Footer  -->
</body>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });
    });
</script>

</html>