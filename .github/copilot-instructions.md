# Copilot Instructions for Du-An-1-CamasRungj

PHP travel booking system using **procedural MVC** with Laragon + MySQL. All operations use raw PDO queries returning arrays (no ORM). No class inheritance - models are plain PHP classes with PDO connections.

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
│       └── tour_du_lich.sql # Database schema (import this for setup)
├── commons/
│   ├── env.php              # DB constants, BASE_URL_ADMIN, PATH_ROOT
│   └── function.php         # connectDB(), formatDate(), uploadFile(), session helpers
└── assets/                  # Public CSS, JS, images
```

### Router Pattern (`admin/index.php`)

**Single entry point** using PHP 8 match() statement with query parameter routing:

```php
$act = $_GET['act'] ?? '/';

// Authentication check (all routes except public)
$publicRoutes = ['login-admin', 'check-login-admin'];
if (!in_array($act, $publicRoutes) && empty($_SESSION['user_admin'])) {
    header('Location: ' . BASE_URL_ADMIN . '?act=login-admin');
    exit();
}

match ($act) {
    '/' => (new AdminBaoCaoThongKeController())->home(),
    'booking' => (new AdminBookingController())->danhSachBooking(),
    'form-them-booking' => (new AdminBookingController())->formAddBooking(),
    'them-booking' => (new AdminBookingController())->postAddBooking(),
    'hdv-quan-ly' => HDVController::quanLyHDV($_GET['hdv_id'] ?? 'all'),
    'hdv-get-tours' => HDVController::getToursByHDVAjax($_GET['hdv_id'] ?? null), // AJAX endpoint
    'get-tour-info' => (new AdminTourController())->getTourInfo(), // AJAX endpoint
};
```

**Route conventions**:

- URL pattern: `?act=form-them-booking` → `AdminBookingController::formAddBooking()`
- Naming: `form-` (show form), `them-` (add), `sua-` (edit), `xoa-` (delete), `post-` (POST handler)
- **Mixed patterns**: Most controllers use instance methods `(new Class())->method()`, but `HDVController` uses **static methods only** `HDVController::method()`
- **AJAX endpoints**: Named with `-get-` or return JSON directly (see HDVController::getToursByHDVAjax)

### Database Connection

**Two patterns coexist** - no inheritance, just composition:

```php
// commons/function.php - Core connection factory
function connectDB() {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Always returns arrays
    return $conn;
}

// Helper for static models
function db_query($sql, $params = []) {
    $conn = connectDB();
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    return $stmt; // Return PDOStatement for chaining ->fetch() or ->fetchAll()
}
```

**Instance models** (most common):

```php
class AdminBooking {
    public $conn;
    public function __construct() {
        $this->conn = connectDB(); // Fresh connection per instance
    }

    public function getAllBooking() {
        $sql = 'SELECT dat_tour.*, lich_khoi_hanh.ngay_bat_dau FROM dat_tour
                JOIN lich_khoi_hanh ON dat_tour.lich_id = lich_khoi_hanh.lich_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(); // Always returns array of arrays
    }
}
```

**Static models** (HDVModel, DiemDanhModel, NhatKyTourModel):

```php
class HDVModel {
    public static function getLichLamViecByHDV($hdv_id) {
        $sql = 'SELECT * FROM phan_cong_hdv WHERE hdv_id = ?';
        return db_query($sql, [$hdv_id])->fetchAll();
    }
}
```

**Critical**: Never use ORM methods or object hydration. All queries return `array` (single row) or `array[]` (multiple rows).

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

**Step-by-step process for new functionality**:

1. **Route**: Add to `admin/index.php` match statement

   ```php
   'form-them-nhat-ky' => (new NhatKyController())->formAdd(),
   'them-nhat-ky' => (new NhatKyController())->postAdd(),
   ```

2. **Controller**: Create `controllers/NhatKyController.php`

   ```php
   class NhatKyController {
       public $model;
       public function __construct() {
           $this->model = new NhatKyModel();
       }

       public function formAdd() {
           require_once './views/nhatky/addNhatKy.php';
       }

       public function postAdd() {
           // Validation → Session errors → Model insert → Redirect
       }
   }
   ```

3. **Model**: Create `models/NhatKyModel.php`

   ```php
   class NhatKyModel {
       public $conn;
       public function __construct() {
           $this->conn = connectDB();
       }

       public function insert($data) {
           $sql = 'INSERT INTO nhat_ky (lich_id, noi_dung) VALUES (:lich_id, :noi_dung)';
           $stmt = $this->conn->prepare($sql);
           return $stmt->execute($data); // Returns boolean
       }
   }
   ```

4. **View**: Create `views/nhatky/addNhatKy.php`
   ```php
   <?php require_once './views/layout/header.php'; ?>
   <?php
   $error = $_SESSION['error'] ?? [];
   $old = $_SESSION['old'] ?? [];
   unset($_SESSION['error'], $_SESSION['old'], $_SESSION['flash']);
   ?>
   <!-- Form with error display pattern -->
   <?php require_once './views/layout/footer.php'; ?>
   ```

### Database Query Standard

**Always use prepared statements** with positional or named parameters:

```php
// Instance models - named parameters (preferred for clarity)
$sql = 'SELECT t.*, l.ngay_bat_dau FROM tour t
        JOIN lich_khoi_hanh l ON t.tour_id = l.tour_id
        WHERE t.tour_id = :id AND t.trang_thai = :status';
$stmt = $this->conn->prepare($sql);
$stmt->execute([':id' => $tour_id, ':status' => 1]);
return $stmt->fetch(); // Single row

// Static models - positional parameters (shorter)
$sql = 'SELECT * FROM phan_cong_hdv WHERE hdv_id = ? AND lich_id = ?';
return db_query($sql, [$hdv_id, $lich_id])->fetchAll(); // Multiple rows
```

**JOIN pattern** (very common in this codebase):

```php
// Example from AdminBooking::getAllBooking()
$sql = 'SELECT
    dat_tour.*,
    lich_khoi_hanh.ngay_bat_dau,
    lich_khoi_hanh.ngay_ket_thuc,
    trang_thai_booking.ten_trang_thai,
    khach_hang.ho_ten as ten_khach_hang,
    tour.ten as ten_tour
FROM dat_tour
JOIN lich_khoi_hanh ON lich_khoi_hanh.lich_id = dat_tour.lich_id
JOIN khach_hang ON khach_hang.khach_hang_id = dat_tour.khach_hang_id
JOIN tour ON lich_khoi_hanh.tour_id = tour.tour_id
JOIN trang_thai_booking ON trang_thai_booking.trang_thai_id = dat_tour.trang_thai_id
ORDER BY dat_tour.dat_tour_id DESC';
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

**Standard upload with timestamp prefix**:

```php
// commons/function.php
function uploadFile($file, $folderUpload) {
    if (!isset($file['tmp_name']) || $file['error'] !== 0) {
        return null;
    }
    $safeName = time() . '-' . basename($file['ten']);
    $pathStorage = $folderUpload . $safeName;
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($file['tmp_name'], $to)) {
        return $pathStorage; // Store relative path in DB
    }
    return null;
}

// Usage in controller
if (!empty($_FILES['hinh_anh']['tmp_name'])) {
    $hinh_anh = uploadFile($_FILES['hinh_anh'], 'uploads/tour/');
}

// For updates with existing file
if (!empty($_FILES['hinh_anh']['tmp_name'])) {
    $new_file = uploadFile($_FILES['hinh_anh'], 'uploads/tour/');
    if ($new_file) {
        deleteFile($old_hinh_anh); // Remove old file
        $hinh_anh = $new_file;
    }
}
```

**Album upload** (multiple files with indices):

```php
function uploadFileAlbum($file, $folderUpload, $key) {
    $pathStorage = $folderUpload . time() . $file['ten'][$key];
    $from = $file['tmp_name'][$key];
    $to = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($from, $to)) {
        return $pathStorage;
    }
    return null;
}
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

### Common Frontend Patterns

**DataTables initialization**:

```javascript
$("#example1")
  .DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
  })
  .buttons()
  .container()
  .appendTo("#example1_wrapper .col-md-6:eq(0)");
```

**AJAX data loading** (fetch API):

```javascript
// View fetches tour info via AJAX endpoint
fetch("<?= BASE_URL_ADMIN ?>?act=get-tour-info&tour_id=" + tourId)
  .then((response) => response.json())
  .then((data) => {
    document.getElementById("ten_tour").value = data.ten;
    document.getElementById("gia_co_ban").value = data.gia_co_ban;
  });
```

**Dynamic form fields with server errors**:

```javascript
// Reconstruct dynamic rows from session data
const oldData = <?= json_encode($_SESSION['old'] ?? []) ?>;
const serverErrors = <?= json_encode($_SESSION['error'] ?? []) ?>;

oldData.ds_khach?.forEach((khach, i) => {
    const errName = serverErrors[`ds_khach_${i}_ho_ten`] ?? "";
    // Display error for each field
});
```

## Git Workflow

**Current branch**: `test` (main development branch)  
**Naming convention**: Vietnamese feature names (e.g., "ChucNangThemBooking")  
**Commit messages**: Feature + action (e.g., "Thêm tính năng booking", "Sửa lỗi validation")  
**Pull before work**: `git pull origin main`
