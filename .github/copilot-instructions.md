# Copilot Instructions for Du-An-1-CamasRungj

PHP travel booking system using **procedural MVC** with Laragon + MySQL. All operations use raw PDO queries returning arrays (no ORM).

## Architecture Overview

### Directory Structure

```
Du_Lich_CamasRungj/
├── admin/                    # Admin panel (all backend logic)
│   ├── index.php            # Router: match() statement maps ?act= to controllers
│   ├── controllers/         # AdminBookingController, HDVController, AdminTourController, etc.
│   ├── models/              # PDO query methods (AdminBooking, HDVModel, etc.)
│   ├── views/{feature}/     # PHP templates (booking/, hdv/, tour/, taikhoan/, etc.)
│   └── assets/              # AdminLTE, DataTables, Select2, custom CSS
├── commons/
│   ├── env.php              # DB constants, BASE_URL_ADMIN, PATH_ROOT
│   └── function.php         # connectDB(), formatDate(), uploadFile(), session helpers
└── assets/                  # Public CSS, JS, images
```

### Router Pattern (`admin/index.php`)

Single entry point with **match() statement**:

```php
match ($act) {
    'booking' => (new AdminBookingController())->danhSachBooking(),
    'form-them-booking' => (new AdminBookingController())->formAddBooking(),
    'them-booking' => (new AdminBookingController())->postAddBooking(),
    'hdv-quan-ly' => HDVController::quanLyHDV($_GET['hdv_id'] ?? 'all'), // Static methods
};
```

- URL: `?act=form-them-booking` routes to `AdminBookingController::formAddBooking()`
- Naming: `them-` (add), `sua-` (edit), `xoa-` (delete), `form-` (show form)
- **Mixed patterns**: Some controllers use instance methods `(new Class())->method()`, HDVController uses **static methods** `HDVController::method()`

### Database Connection

```php
// commons/function.php
function connectDB() {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Returns arrays, not objects
    return $conn;
}
```

**Models inherit connection**:

```php
class AdminBooking {
    public $conn;
    public function __construct() {
        $this->conn = connectDB();
    }
}
```

**Static models use helper**:

```php
class HDVModel {
    public static function getLichLamViecByHDV($hdv_id) {
        return db_query($sql, [$hdv_id])->fetchAll(); // db_query() wraps PDO prepare/execute
    }
}
```

## Form Validation & Error Handling

**Session-based error flow** (redirect-after-post pattern):

```php
// Controller validation
$error = [];
if (empty($_POST['ho_ten'])) $error['ho_ten'] = "Tên không được để trống";
if (!preg_match('/^[0-9]{9,11}$/', $_POST['so_dien_thoai'])) $error['so_dien_thoai'] = "SĐT 9-11 số";

if (!empty($error)) {
    $_SESSION['flash'] = true;             // Error flag
    $_SESSION['error'] = $error;           // Keyed error messages
    $_SESSION['old'] = $_POST;             // Preserve user input
    header("Location: ?act=form-them-booking");
    exit();
}
```

**View consumption**:

```php
// views/booking/addBooking.php
$error = $_SESSION['error'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['error'], $_SESSION['old'], $_SESSION['flash']); // Cleanup after display
?>
<input name="ho_ten" value="<?= $old['ho_ten'] ?? '' ?>">
<?php if (isset($error['ho_ten'])): ?>
    <small class="text-danger"><?= $error['ho_ten'] ?></small>
<?php endif; ?>
```

### Array Field Errors (e.g., multiple customers)

```php
// Controller: Validate ds_khach array
foreach ($ds_khach as $index => $khach) {
    if (empty($khach['ho_ten'])) {
        $error["ds_khach_{$index}_ho_ten"] = "Tên khách hàng không được để trống";
    }
}

// View: JavaScript reconstructs table rows from $_SESSION['old']['ds_khach']
const serverErrors = <?= json_encode($error) ?>;
const errName = serverErrors[`ds_khach_${i}_ho_ten`] ?? "";
```

## Critical Patterns & Rules

### CRUD Workflow (Adding a Feature)

1. **Route**: Add to `admin/index.php` match statement
2. **Controller**: Create `formAdd()`, `postAdd()`, `formEdit()`, `postEdit()`, `deleteXXX()`
3. **Model**: Add query methods using `$this->conn->prepare()` + `execute()`
4. **View**: Create form in `views/{feature}/` with session error/old pattern

### Database Query Standard

```php
// Instance models
$sql = 'SELECT t.*, l.ngay_bat_dau FROM tour t JOIN lich_khoi_hanh l ON t.tour_id = l.tour_id WHERE t.tour_id = :id';
$stmt = $this->conn->prepare($sql);
$stmt->execute([':id' => $tour_id]);
return $stmt->fetch(); // Single row or fetchAll() for multiple

// Static models
return db_query($sql, [$param1, $param2])->fetchAll();
```

### Validation Rules

- **Phone**: `/^[0-9]{9,11}$/`
- **CCCD** (ID card): `/^[0-9]{12}$/` (exactly 12 digits)
- **Email**: `filter_var($email, FILTER_VALIDATE_EMAIL)`
- **Location**: Always validate in **controller**, never in model
- **Arrays**: Loop through `$_POST['ds_khach']` and validate each element with indexed error keys

### Authentication

```php
// admin/index.php: Check before routing (except login routes)
$publicRoutes = ['login-admin', 'check-login-admin'];
if (!in_array($act, $publicRoutes) && empty($_SESSION['user_admin'])) {
    header('Location: ?act=login-admin');
    exit();
}
```

### File Upload Pattern

```php
// commons/function.php
function uploadFile($file, $folderUpload) {
    $safeName = time() . '-' . basename($file['ten']);
    $pathStorage = $folderUpload . $safeName;
    move_uploaded_file($file['tmp_name'], PATH_ROOT . $pathStorage);
    return $pathStorage; // Store relative path in DB
}

// Usage in controller
$hinh_anh = uploadFile($_FILES['hinh_anh'], 'uploads/tour/');
```

## Database Schema (Key Tables)

- **dat_tour**: `dat_tour_id`, `lich_id`, `khach_hang_id`, `nguoi_tao_id`, `loai`, `so_nguoi`, `tong_tien`, `trang_thai_id`
- **hanh_khach_list**: `hanh_khach_id`, `dat_tour_id`, `ho_ten`, `gioi_tinh`, `cccd`, `so_dien_thoai`, `email`, `ngay_sinh`
- **lich_khoi_hanh**: `lich_id`, `tour_id`, `ngay_bat_dau`, `ngay_ket_thuc`
- **phan_cong_hdv**: `phan_cong_id`, `lich_id`, `hdv_id`, `vai_tro`
- **khach_hang**: User table with `chuc_vu_id` (1=admin, 2=customer)

## Environment Setup

**Local dev**: Laragon with MySQL on port 3306  
**Access admin**: `http://localhost/CamasRungj/Du-An-1-CamasRungj/Du_Lich_CamasRungj/admin/`  
**Import schema**: `admin/assets/tour_du_lich.sql`  
**Default admin password**: `password_hash('123@123ab', PASSWORD_BCRYPT)`

**Configuration** (`commons/env.php`):

```php
BASE_URL_ADMIN = 'http://localhost/CamasRungj/Du-An-1-CamasRungj/Du_Lich_CamasRungj/admin/'
DB_HOST = 'localhost'
DB_PORT = 3306
DB_USERNAME = 'root'
DB_PASSWORD = ''
DB_NAME = 'tour_du_lich'
PATH_ROOT = __DIR__ . '/../'  // Points to Du_Lich_CamasRungj/
```

**Stack**: PHP 7.4+ | MySQL 5.7+ | AdminLTE with Bootstrap 4, jQuery, DataTables, Select2

## Helper Functions (`commons/function.php`)

- `connectDB()` - Fresh PDO connection
- `db_query($sql, $params)` - Wrapper for prepare/execute (used by static models)
- `formatDate($date)` - Returns `d-m-Y` format
- `formatPrice($price)` - Returns `number_format . ' VND'`
- `uploadFile($file, $folder)` - Uploads with timestamp prefix
- `deleteFile($file)` - Unlinks from PATH_ROOT
- `deleteSessionError()` - Unsets flash/error/old after view display
- `checkAdmin()` - Redirects to login if not authenticated

## View Layout Pattern

Views use **require_once** to assemble layout:

```php
// views/booking/listBooking.php
<?php require_once './views/layout/header.php'; ?>
<!-- Content here -->
<?php require_once './views/layout/footer.php'; ?>
```

- **AdminLTE template**: jQuery, Bootstrap 4, DataTables, Select2
- **Custom CSS**: `assets/css/style-hdv.css`, `style-header.css`, `style-footer.css`

## Git Workflow

**Current branch**: `test` (main development branch)  
**Naming convention**: Vietnamese feature names (e.g., "ChucNangThemBooking")  
**Commit messages**: Feature + action (e.g., "Thêm tính năng booking", "Sửa lỗi validation")  
**Pull before work**: `git pull origin main`
