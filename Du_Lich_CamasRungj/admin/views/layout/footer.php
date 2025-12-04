 <footer class="main-footer">
   <div class="float-right d-none d-sm-block">
     <b><i class="fas fa-globe-asia"></i> CamasRungj</b>
   </div>
   <strong><i class="fas fa-briefcase"></i> Website Quản Lý Du Lịch CamasRungj</strong>
   <span class="ml-2" style="opacity: 0.8;">- Nền tảng quản lý tour du lịch chuyên nghiệp</span>
 </footer>

 <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-dark">
   <!-- Control sidebar content goes here -->
 </aside>
 <!-- /.control-sidebar -->
 </div>
 <!-- ./wrapper -->

 <!-- jQuery -->
 <script src="./assets/plugins/jquery/jquery.min.js"></script>
 <!-- Bootstrap 4 -->
 <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- DataTables  & Plugins -->
 <script src="./assets/plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="./assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="./assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
 <script src="./assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
 <script src="./assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
 <script src="./assets/plugins/jszip/jszip.min.js"></script>
 <script src="./assets/plugins/pdfmake/pdfmake.min.js"></script>
 <script src="./assets/plugins/pdfmake/vfs_fonts.js"></script>
 <script src="./assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
 <script src="./assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
 <script src="./assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
 <!-- AdminLTE App -->
 <script src="./assets/dist/js/adminlte.min.js"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="./assets/dist/js/demo.js"></script>

 <!-- Custom Sidebar Hover Script -->
 <script>
 $(document).ready(function() {
   let hoverTimeout;
   const $body = $('body');
   const $sidebar = $('.main-sidebar');
   
   // Hover vào sidebar - mở rộng
   $sidebar.on('mouseenter', function() {
     clearTimeout(hoverTimeout);
     if ($body.hasClass('sidebar-collapse')) {
       $body.removeClass('sidebar-collapse');
       $body.addClass('sidebar-hover-active');
     }
   });
   
   // Rời khỏi sidebar - thu gọn
   $sidebar.on('mouseleave', function() {
     clearTimeout(hoverTimeout);
     hoverTimeout = setTimeout(function() {
       if ($body.hasClass('sidebar-hover-active')) {
         $body.addClass('sidebar-collapse');
         $body.removeClass('sidebar-hover-active');
       }
     }, 300); // Delay 300ms trước khi thu gọn
   });
   
   // Click nút toggle - chuyển đổi chế độ cố định
   $('[data-widget="pushmenu"]').on('click', function() {
     // Xóa class hover-active khi click toggle
     $body.removeClass('sidebar-hover-active');
   });
 });
 </script>


