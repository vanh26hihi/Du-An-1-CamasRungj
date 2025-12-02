<?php

// Kết nối CSDL qua PDO
function connectDB()
{
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}

// Hàm thực thi query (SELECT, INSERT, UPDATE, DELETE)
function db_query($sql, $params = [])
{
    $conn = connectDB();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

// Thêm File
function uploadFile($file, $folderUpload)
{
    if (!isset($file['tmp_name']) || $file['error'] !== 0) {
        return null;
    }
    $safeName = time() . '-' . basename($file['ten']);
    $pathStorage = $folderUpload . $safeName;
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($file['tmp_name'], $to)) {
        return $pathStorage;
    }
    return null;
}

// Xóa File
function deleteFile($file)
{
    if ($file == null) return;

    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete);
    }
}

//Xóa SESSION sau khi load lại trang 
function deleteSessionError()
{
    if (isset($_SESSION['flash'])) {
        unset($_SESSION['flash']);
        session_unset();
        session_destroy();
    }
}

//upload update album anh 
function uploadFileAlbum($file, $folderUpload, $key)
{
    $pathStorage = $folderUpload . time() . $file['ten'][$key];
    $from = $file['tmp_name'][$key];
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($from, $to)) {
        return $pathStorage;
    }
    return null;
}

function formatDate($date)
{
    return date("d-m-Y", strtotime($date));
}
function checkAdmin()
{
    if (empty($_SESSION['user_admin'])) {
        header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
        exit();
    }
}
function  formatPrice($price)
{
    return number_format($price, 0, ',', '.') . ' VND';
}

function tinhNgayDem($ngay_bat_dau, $ngay_ket_thuc)
{
    // Chuyển chuỗi ngày về dạng DateTime (format Y-m-d)
    $start = DateTime::createFromFormat('Y-m-d', $ngay_bat_dau);
    $end   = DateTime::createFromFormat('Y-m-d', $ngay_ket_thuc);

    // Kiểm tra lỗi format
    if (!$start || !$end) {
        return "Sai định dạng ngày (Y-m-d)!";
    }

    // Tính số ngày (bao gồm cả ngày bắt đầu và ngày kết thúc)
    $soNgay = $start->diff($end)->days + 1;

    // Số đêm = số ngày - 1
    $soDem = $soNgay - 1;

    return "{$soNgay} ngày {$soDem} đêm";
}
