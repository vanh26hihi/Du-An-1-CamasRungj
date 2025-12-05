<?php require_once './views/layout/header.php'; ?>
<?php require_once './views/layout/navbar.php'; ?>
<?php require_once './views/layout/sidebar.php'; ?>

<div class="content-wrapper">
  <style>
    * { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body, html { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    
    /* Improve spacing and layout for tour days and items */
    .tour-day { margin-bottom:18px; }
    .tour-day .day-head { display:flex; gap:14px; align-items:flex-start; }
    .tour-day .day-badge { min-width:90px; background:linear-gradient(135deg,#0d47a1,#1976d2); color:#fff; padding:12px 16px; border-radius:10px; font-weight:700; font-size:15px; box-shadow:0 6px 16px rgba(25,118,210,0.08); }
    .tour-day .day-body { flex:1; }
    .tour-day .day-title { font-weight:700; color:#0f1724; margin-bottom:6px; }
    .tour-day .day-summary { color:#6b7280; margin-bottom:10px; }

    .tour-day .day-items { display:flex; flex-direction:column; gap:10px; }
    .tour-day .day-item { background:#fff; border:1px solid #e9eefc; padding:12px; border-radius:10px; box-shadow:0 4px 10px rgba(13,71,161,0.03); }
    .tour-day .day-item .time { font-weight:700; color:#0d47a1; margin-bottom:6px; }
    .tour-day .day-item .place { font-weight:700; color:#111827; }
    .tour-day .day-item .desc { margin-top:8px; color:#374151; line-height:1.6; }

    /* emphasize multi-activity days */
    .tour-day.multi .day-items { border-left:3px dashed rgba(25,118,210,0.08); padding-left:12px; }

    /* responsive tweaks */
    @media (max-width:768px) { .tour-day .day-head { flex-direction:column; } .tour-day .day-badge { min-width:unset; width:100%; text-align:center; } }
  </style>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1 style="font-size:28px; font-weight:700; color:#0d47a1; margin:0;"><?= htmlspecialchars($tourDetail['ten']) ?></h1>
          <p class="text-muted">Danh mục: <strong><?= htmlspecialchars($tourDetail['ten_danh_muc'] ?? '-') ?></strong> • Thời lượng: <?= htmlspecialchars($tourDetail['thoi_luong_mac_dinh'] ?? '-') ?> ngày</p>
        </div>
        <div class="col-sm-4 text-right">
          <a href="<?= BASE_URL_ADMIN . '?act=danh-muc-tour' ?>" class="btn btn-secondary">&larr; Quay lại</a>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- LEFT: Price / Intro / Description / Places -->
        <div class="col-md-4">
          <div class="card p-3">
            <h5 style="margin-top:0;">Thông tin & Giới thiệu</h5>
            <div style="font-size:20px; font-weight:700; color:#10b981;">
              <?= isset($tourDetail['gia_co_ban']) ? number_format($tourDetail['gia_co_ban'],0,',','.') . ' VND' : '-' ?>
            </div>

            <div style="margin-top:10px; color:#374151;"> <?= nl2br(htmlspecialchars($tourDetail['mo_ta_ngan'] ?? ($tourDetail['mo_ta'] ?? '-'))) ?></div>

            <hr/>
            <div class="text-muted">Thời lượng: <strong><?= htmlspecialchars($tourDetail['thoi_luong_mac_dinh'] ?? '-') ?> ngày</strong></div>
            <div class="text-muted" style="margin-top:6px;">Điểm khởi hành: <strong><?= htmlspecialchars($tourDetail['diem_khoi_hanh'] ?? '-') ?></strong></div>

            <?php if (!empty($diaDiemList)): ?>
              <hr/>
              <h6>Địa điểm trong tour</h6>
              <ul style="padding-left:18px;">
                <?php foreach ($diaDiemList as $d): ?>
                  <li style="margin-bottom:8px;"><strong><?= htmlspecialchars($d['ten_dia_diem'] ?? '') ?></strong><br/><small class="text-muted"><?= htmlspecialchars($d['mo_ta_dia_diem'] ?? '') ?></small></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>

          <!-- Description below info -->
          <div class="card p-3 mt-3">
            <h5 style="margin-top:0;">Mô tả chi tiết</h5>
            <div style="color:#374151; line-height:1.7"><?= nl2br(htmlspecialchars($tourDetail['mo_ta'] ?? '-')) ?></div>
          </div>
        </div>

        <!-- RIGHT: Itinerary (show always) -->
        <div class="col-md-8">
          <div class="card p-3">
            <h5 style="margin-top:0;">Lịch trình chi tiết</h5>

            <?php
              $days = [];
              foreach ($lichTrinhList as $lt) {
                $d = intval($lt['ngay_thu'] ?? 0);
                if (!isset($days[$d])) $days[$d] = [];
                $days[$d][] = $lt;
              }
              ksort($days);
            ?>

            <?php if (empty($days)): ?>
              <p class="text-muted" style="margin-top:12px;">Chưa có lịch trình.</p>
            <?php else: ?>
              <div id="tourItinerary" style="margin-top:12px;">
                <div class="row">
                  <?php foreach ($days as $dayNum => $items): ?>
                    <?php $isMulti = count($items) > 1; ?>
                    <div class="col-12 mb-3">
                      <div class="tour-day <?php if($isMulti) echo 'multi'; ?>">
                        <div class="day-head">
                          <div class="day-badge">Ngày <?= $dayNum ?></div>
                          <div class="day-body">
                            <div class="day-title">Ngày <?= $dayNum ?> — <?= count($items) ?> hoạt động</div>
                            <div class="day-summary">
                              <?php
                                $places = [];
                                foreach ($items as $it) if (!empty($it['ten_dia_diem'])) $places[] = $it['ten_dia_diem'];
                                echo htmlspecialchars(implode(' • ', array_unique($places)));
                              ?>
                            </div>

                            <div class="day-items">
                              <?php foreach ($items as $it): ?>
                                <div class="day-item">
                                  <div class="time"><?= htmlspecialchars(($it['gio_bat_dau'] ? $it['gio_bat_dau'] : '-') . ' → ' . ($it['gio_ket_thuc'] ? $it['gio_ket_thuc'] : '-')) ?></div>
                                  <div class="place"><?= htmlspecialchars($it['ten_dia_diem'] ?? '(Không rõ địa điểm)') ?></div>
                                  <div class="desc"><?= nl2br(htmlspecialchars(mb_strimwidth($it['noi_dung'] ?? '', 0, 800, '...'))) ?></div>
                                </div>
                              <?php endforeach; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once './views/layout/footer.php'; ?>
</body>
</html>

