<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CamasRungj - Quản Lý Du Lịch</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Google Font: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">
  <!-- Custom Styles -->
  <link rel="stylesheet" href="./assets/css/style-header.css?v=<?= time() ?>">
  <link rel="stylesheet" href="./assets/css/style-sidebar.css?v=<?= time() ?>">
  <link rel="stylesheet" href="./assets/css/style-footer.css?v=<?= time() ?>">
  <link rel="stylesheet" href="./assets/css/style-hdv.css?v=<?= time() ?>">
  <!-- SweetAlert2 theme -->
  <link rel="stylesheet" href="./assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css">
</head>

<style>
  /* Global Font */
  body {
    font-family: 'Poppins', 'Source Sans Pro', sans-serif !important;
  }

  /* Content Wrapper - Màu nền sáng đẹp */
  .content-wrapper {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%) !important;
    min-height: calc(100vh - 130px) !important;
  }

  /* Card Header - Gradient đẹp */
  .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    font-weight: 600;
    border-bottom: 3px solid #f39c12;
  }

  .card-header h3, .card-header h4, .card-header h5 {
    margin: 0;
    color: white !important;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
  }

  /* Card Body */
  .card-body {
    background-color: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  /* Card */
  .card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    border: none;
    margin-bottom: 20px;
  }

  /* Buttons - Màu sắc sáng hơn */
  .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.5);
  }

  .btn-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
    border: none !important;
    box-shadow: 0 3px 10px rgba(17, 153, 142, 0.3);
  }

  .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(17, 153, 142, 0.5);
  }

  .btn-warning {
    background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%) !important;
    border: none !important;
    box-shadow: 0 3px 10px rgba(243, 156, 18, 0.3);
    color: white !important;
  }

  .btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(243, 156, 18, 0.5);
  }

  .btn-danger {
    background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%) !important;
    border: none !important;
    box-shadow: 0 3px 10px rgba(235, 51, 73, 0.3);
  }

  .btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(235, 51, 73, 0.5);
  }

  .btn-info {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%) !important;
    border: none !important;
    box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
  }

  .btn-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.5);
  }

  /* Tables */
  .table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border: none;
    text-align: center;
    vertical-align: middle !important;
    padding: 15px 10px;
    font-weight: 600;
  }

  .table tbody tr {
    transition: all 0.2s ease;
  }

  .table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  th, td {
    vertical-align: middle !important;
  }

  /* Form Controls */
  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
  }

  /* Badge */
  .badge-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    box-shadow: 0 2px 5px rgba(17, 153, 142, 0.3);
  }

  .badge-warning {
    background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%);
    box-shadow: 0 2px 5px rgba(243, 156, 18, 0.3);
  }

  .badge-danger {
    background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    box-shadow: 0 2px 5px rgba(235, 51, 73, 0.3);
  }

  .badge-info {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
  }

  /* Content Header */
  .content-header h1 {
    color: #2c3e50;
    font-weight: 700;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
  }

  /* Small Box */
  .small-box {
    border-radius: 10px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
  }

  /* Alert */
  .alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  /* Chuẩn hóa buttons trong table và action buttons */
  .btn {
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-size: 14px;
  }

  .btn-sm {
    padding: 4px 10px;
    font-size: 13px;
    min-width: 70px; /* Đảm bảo nút có độ rộng tối thiểu */
  }

  .btn i {
    margin-right: 5px;
  }

  /* Buttons trong table action column */
  table .btn-sm {
    margin: 2px;
    display: inline-block;
  }

  /* Content header action buttons */
  .content-header .btn, 
  .card-header .btn {
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
  }

  /* Cho phép text trong các cột dài xuống dòng */
  .content-wrapper,
  .content,
  .content>.container-fluid {
    height: auto !important;
    min-height: auto !important;
  }

  /* Fix layout to push footer to bottom */
  html {
    height: 100%;
  }

  body {
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  .content-wrapper {
    flex: 1;
    min-height: calc(100vh - 57px - 60px) !important; /* navbar height - footer height */
  }

  /* Footer always at bottom */
  .main-footer {
    margin-top: auto !important;
  }

  /* DataTables Pagination */
  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    color: white !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    color: white !important;
  }
</style>


<body class="hold-transition sidebar-mini">
  <div class="wrapper">