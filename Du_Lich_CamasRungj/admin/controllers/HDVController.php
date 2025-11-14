<?php
require_once './models/HDVModel.php';
require_once './models/NhatKyTourModel.php';
require_once './models/DiemDanhModel.php';

class HDVController {

    public static function lichLamViec($hdv_id) {
        $data = HDVModel::getToursByHDV($hdv_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/lichlamviec.php';
        include './views/layout/footer.php';
    }

    public static function danhSachKhach($lich_id) {
        $data = HDVModel::getPassengersByLich($lich_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/danhsachkhach.php';
        include './views/layout/footer.php';
    }

    public static function nhatKy($hdv_id) {
        $data = NhatKyTourModel::getByHDV($hdv_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/nhatky.php';
        include './views/layout/footer.php';
    }

    public static function formThemNhatKy($hdv_id) {
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-them-nhat-ky.php';
        include './views/layout/footer.php';
    }

    public static function themNhatKy($formData) {
        NhatKyTourModel::add($formData);
        header('Location: ?act=hdv-nhat-ky&hdv_id=' . $formData['hdv_id']);
    }

    public static function diemDanh($lich_trinh_id, $hdv_id) {
        $data = DiemDanhModel::getAttendance($lich_trinh_id, $hdv_id);
        $itinerary = HDVModel::getItinerary($lich_trinh_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/diemdanh.php';
        include './views/layout/footer.php';
    }

    public static function formSuaNhatKy($nhat_ky_id) {
        $data = NhatKyTourModel::getById($nhat_ky_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-sua-nhat-ky.php';
        include './views/layout/footer.php';
    }

    public static function suaNhatKy($formData) {
        NhatKyTourModel::update($formData);
        header('Location: ?act=hdv-nhat-ky&hdv_id=' . $formData['hdv_id']);
    }

    public static function yeuCauDacBiet($lich_id) {
        $data = HDVModel::getSpecialRequests($lich_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/yeu-cau-dac-biet.php';
        include './views/layout/footer.php';
    }

    public static function formSuaYeuCau($khach_hang_id) {
        $data = HDVModel::getCustomerDetails($khach_hang_id);
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-sua-yeu-cau.php';
        include './views/layout/footer.php';
    }

    public static function suaYeuCau($formData) {
        HDVModel::updateSpecialRequest($formData);
        header('Location: ?act=hdv-yeu-cau-dac-biet&lich_id=' . $formData['lich_id']);
    }

    public static function danhGiaTour($hdv_id) {
        include './views/layout/header.php';
        include './views/layout/navbar.php';
        include './views/layout/sidebar.php';
        include './views/hdv/form-danh-gia-tour.php';
        include './views/layout/footer.php';
    }

    public static function guiDanhGia($formData) {
        NhatKyTourModel::addFeedback($formData);
        header('Location: ?act=hdv-lich-lam-viec&hdv_id=' . $formData['hdv_id']);
    }
}
