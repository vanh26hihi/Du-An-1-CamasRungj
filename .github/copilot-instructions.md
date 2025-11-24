# Copilot Instructions for Du-An-1-CamasRungj

A PHP-based travel booking management system using procedural MVC pattern with a Laragon + MySQL stack.

## Architecture

### Project Structure

```
Du_Lich_CamasRungj/
├── admin/                 # Admin panel
│   ├── controllers/       # Request handlers (AdminBookingController, HDVController, etc.)
│   ├── models/           # Database queries (AdminBooking, HDVModel, etc.)
│   ├── views/            # PHP templates organized by feature (booking/, hdv/, tour/, etc.)
│   ├── assets/           # AdminLTE plugins, CSS, vendor libs
│   └── index.php         # Router entry point
├── commons/              # Shared utilities
│   ├── env.php          # Constants (BASE_URL_ADMIN, DB_*, PATH_ROOT)
│   └── function.php     # Database, file, session helpers
└── assets/              # Public CSS, JS, images
```

### Key Architectural Patterns

**Router Pattern** (`admin/index.php`):

- Single entry point using PHP `match()` statement
- Query parameter `?act=` maps to controller methods
- Example: `?act=form-them-booking` → `AdminBookingController::formAddBooking()`
- Routes define action names like `them-booking` (add), `sua-booking` (edit), `xoa-booking` (delete)

**MVC Flow**:

1. Controller receives request, calls Model methods
2. Model executes raw SQL queries via PDO, returns arrays
3. Controller redirects or requires view template
4. View accesses controller-passed variables directly (no ORM)

**Database Connection**:

- PDO with error mode set to EXCEPTION
- Default fetch mode: `FETCH_ASSOC` (returns arrays, not objects)
- Connection created fresh per request via `connectDB()` in `commons/function.php`

## Form Submission & Validation Pattern

**Server-Side Validation Flow**:

```php
// Controller builds error array with descriptive keys
$error = [];
if (empty($field)) $error['field_name'] = "Error message";

// On validation failure:
$_SESSION['flash'] = true;        // Flag errors exist
$_SESSION['error'] = $error;       // Keyed error array
$_SESSION['old'] = $_POST;         // Preserve user input
header("Location:" . BASE_URL_ADMIN . '?act=form-them-booking');

// View accesses via: $error = $_SESSION['error'] ?? []
// Then unsets all three after display
```

**Special Pattern for Array Fields** (e.g., customer list in booking):

- Errors keyed as `ds_khach_{$index}_field_name` for array index `$index`
- View reconstructs forms from `$_SESSION['old'][$field]` via JavaScript
- Example: `$error['ds_khach_0_ho_ten']` for first customer name error

## Critical Files & Workflows

### Adding a Feature Workflow

1. **Route**: Add `'feature-name' => (new ControllerName())->methodName()` to `admin/index.php`
2. **Controller**: Create methods: `formAdd()`, `postAdd()`, `formEdit()`, `postEdit()`, `delete()`
3. **Model**: Add query methods to model class, use `$this->conn->prepare()` + `execute()`
4. **View**: Create form template in `views/feature/` using error pattern above

### Database Query Pattern

```php
// Models always follow this structure:
$sql = 'SELECT ... JOIN ... WHERE ...';
$stmt = $this->conn->prepare($sql);
$stmt->execute([':param' => $value]);
return $stmt->fetchAll(); // or fetch() for single row
```

### Session Handling

- **Error Flow**: Controller sets `$_SESSION['error']`, `$_SESSION['old']`, `$_SESSION['flash']`
- **Cleanup**: Views call `deleteSessionError()` (from `commons/function.php`) after display
- **Important**: Always unset all three keys to prevent data leakage between requests

## Validation Rules & Patterns

**Common Regex Patterns Used**:

- Phone: `/^[0-9]{9,11}$/` (9-11 digits)
- CCCD: `/^[0-9]{9,12}$/` (9-12 digits) or `/^[0-9]{12}$/` (exactly 12)
- Email: `filter_var($email, FILTER_VALIDATE_EMAIL)`

**Validation Location**:

- All validation done in **controller** before DB insert
- No client-side validation enforced (HTML5 attributes used for UX only)
- Always validate both individual records and array records (e.g., customer lists)

## Environment & Setup

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

**Stack**:

- Laragon (local dev environment)
- PHP 7.4+ (raw PHP, no framework)
- MySQL 5.7+ (tour_du_lich database)
- AdminLTE template with Bootstrap, jQuery, Select2, DataTables plugins

## Common Helper Functions

From `commons/function.php`:

- `connectDB()` - Creates PDO connection
- `formatDate($date)` - Converts to d-m-Y format
- `formatPrice($price)` - Formats as "number.format with 'VND' suffix
- `uploadFile($file, $folderUpload)` - Handles file uploads with timestamp
- `deleteFile($file)` - Removes files from disk
- `checkAdmin()` - Redirects to login if not authenticated

## Branch & Workflow

- **Branch**: `ChucNangThemBooking` (feature branch for booking functionality)
- Always pull before starting work: `git pull origin main`
- Commit message convention: Feature name + action (e.g., "Thêm tính năng booking")
