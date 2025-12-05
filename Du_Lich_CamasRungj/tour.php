<?php
require_once __DIR__ . '/commons/env.php';
require_once __DIR__ . '/commons/function.php';
require_once __DIR__ . '/admin/models/AdminTour.php';
require_once __DIR__ . '/admin/models/AdminDanhMuc.php';

$tourId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$tourId) {
    http_response_code(404);
    echo "<h1>Tour không tồn tại</h1>";
    exit;
}

$tModel = new AdminTour();
$dModel = new AdminDanhMuc();

$tour = $tModel->getTourDetailById($tourId);
$diaDiemList = $tModel->getDiaDiemTourByTour($tourId);
$lichTrinhList = $dModel->getLichTrinhByTour($tourId);

if (!$tour) {
    http_response_code(404);
    echo "<h1>Tour không tìm thấy</h1>";
    exit;
}

// Group itinerary by day
$days = [];
foreach ($lichTrinhList as $lt) {
    $d = intval($lt['ngay_thu'] ?? 0);
    if (!isset($days[$d])) $days[$d] = [];
    $days[$d][] = $lt;
}
ksort($days);

?><!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($tour['ten']) ?> — Chi tiết tour</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css" />
  <style>
    /* Page-specific beautiful itinerary styles */
    body { background:#f5f7fb; color:#222; }
    .container { max-width:1100px; margin:28px auto; padding:0 16px; }
    .tour-header { display:flex; gap:20px; align-items:flex-start; margin-bottom:18px; }
    .tour-title { font-size:28px; font-weight:700; color:#0d47a1; margin:0 0 6px 0; }
    .tour-sub { color:#6b7280; font-size:14px; }

    .layout { display:flex; gap:24px; }
    .main { flex:1; }
    .aside { width:320px; }

    .card { background:#fff; border-radius:10px; padding:16px; box-shadow:0 6px 18px rgba(13,71,161,0.06); }

    /* Itinerary */
    .itinerary { margin-top:18px; }
    .day { display:block; margin-bottom:18px; }
    .day-head { display:flex; gap:12px; align-items:center; }
    .day-badge { min-width:72px; background:linear-gradient(135deg,#0d47a1,#1976d2); color:#fff; padding:12px 14px; border-radius:10px; font-weight:700; font-size:16px; box-shadow:0 6px 14px rgba(25,118,210,0.12); }
    .day-info { flex:1; }
    .day-info .title { font-weight:700; color:#0f1724; }
    .day-items { margin-top:10px; display:flex; flex-direction:column; gap:10px; }

    .it-item { display:flex; gap:12px; align-items:flex-start; background:linear-gradient(180deg,#fff,#fbfdff); border:1px solid #e6eefc; padding:12px; border-radius:10px; }
    .it-item .time { min-width:96px; color:#0d47a1; font-weight:600; }
    .it-item .meta { flex:1; }
    .it-item .meta .place { font-weight:700; color:#0f1724; }
    .it-item .meta .desc { margin-top:6px; color:#374151; }

    /* For days with multiple items emphasize separation */
    .day.multi .day-items { border-left:3px dashed rgba(25,118,210,0.12); padding-left:12px; }

    /* Aside */
    .price { font-size:22px; font-weight:800; color:#10b981; }
    .places li { margin-bottom:8px; }

    /* Responsive */
    @media (max-width:900px) { .layout { flex-direction:column; } .aside { width:100%; } }
  </style>
</head>
<body>
  <div class="container">
    <a href="<?= BASE_URL ?>" style="text-decoration:none; color:#1976d2; font-weight:600;">&larr; Về trang chủ</a>

    <div class="tour-header">
      <div style="flex:1">
        <h1 class="tour-title"><?= htmlspecialchars($tour['ten']) ?></h1>
        <div class="tour-sub">Danh mục: <?= htmlspecialchars($tour['ten_danh_muc'] ?? '-') ?> • Thời lượng: <?= htmlspecialchars($tour['thoi_luong_mac_dinh'] ?? '-') ?> ngày</div>
      </div>
      <div style="text-align:right">
        <div class="price"><?= isset($tour['gia_co_ban']) ? number_format($tour['gia_co_ban'],0,',','.') . ' VND' : '-' ?></div>
        <div class="tour-sub" style="margin-top:6px">Điểm khởi hành: <?= htmlspecialchars($tour['diem_khoi_hanh'] ?? '-') ?></div>
      </div>
    </div>

    <div class="layout">
      <main class="main">
        <div class="card">
          <h3 style="margin-top:0;">Mô tả</h3>
          <div><?= nl2br(htmlspecialchars($tour['mo_ta'] ?? '-')) ?></div>

          <div class="itinerary">
            <h3 style="margin-bottom:8px;">Lịch trình chi tiết</h3>
            <?php if (empty($days)): ?>
              <div class="text-muted">Chưa có lịch trình.</div>
            <?php else: ?>
              <?php foreach ($days as $dayNum => $items): ?>
                <?php $isMulti = count($items) > 1; ?>
                <div class="day <?php if($isMulti) echo 'multi'; ?>">
                  <div class="day-head">
                    <div class="day-badge">Ngày <?= $dayNum ?></div>
                    <div class="day-info">
                      <div class="title">Ngày <?= $dayNum ?> — <?= count($items) ?> hoạt động</div>
                      <div class="day-summary text-muted" style="margin-top:6px;">
                        <?php
                          // short summary: list places
                          $places = [];
                          foreach ($items as $it) if (!empty($it['ten_dia_diem'])) $places[] = $it['ten_dia_diem'];
                          echo htmlspecialchars(implode(' • ', array_unique($places)));
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="day-items">
                    <?php foreach ($items as $it): ?>
                      <div class="it-item">
                        <div class="time"><?= htmlspecialchars(($it['gio_bat_dau'] ? $it['gio_bat_dau'] : '-') . ' → ' . ($it['gio_ket_thuc'] ? $it['gio_ket_thuc'] : '-')) ?></div>
                        <div class="meta">
                          <div class="place"><?= htmlspecialchars($it['ten_dia_diem'] ?? '(Không rõ địa điểm)') ?></div>
                          <div class="desc"><?= nl2br(htmlspecialchars(mb_strimwidth($it['noi_dung'] ?? '', 0, 800, '...'))) ?></div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

      </main>

      <aside class="aside">
        <div class="card">
          <h4>Giá & Thông tin</h4>
          <div style="margin-top:6px;"><span class="price"><?= isset($tour['gia_co_ban']) ? number_format($tour['gia_co_ban'],0,',','.') . ' VND' : '-' ?></span></div>
          <hr/>
          <h5>Địa điểm trong tour</h5>
          <?php if (!empty($diaDiemList)): ?>
            <ul class="places">
              <?php foreach ($diaDiemList as $d): ?>
                <li><strong><?= htmlspecialchars($d['ten_dia_diem'] ?? '') ?></strong><br/><small class="text-muted"><?= htmlspecialchars($d['mo_ta_dia_diem'] ?? '') ?></small></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <div class="text-muted">Chưa có địa điểm.</div>
          <?php endif; ?>
        </div>

        <div class="card" style="margin-top:12px; text-align:center;">
          <h5>Đặt tour</h5>
          <p class="text-muted">Liên hệ để đặt tour hoặc thêm chức năng booking sau.</p>
          <a href="#" class="btn" style="background:#1976d2; color:#fff; border-radius:8px; padding:10px 16px;">Liên hệ</a>
        </div>
      </aside>
    </div>
  </div>
</body>
</html>
