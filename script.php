<!-- jQuery -->
<script src="../asset_adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../asset_adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../asset_adminlte/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../asset_adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../asset_adminlte/dist/js/pages/dashboard3.js"></script>

<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="../asset_adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script
<!-- DataTables  & Plugins -->
<script src="../asset_adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../asset_adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../asset_adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../asset_adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../asset_adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../asset_adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../asset_adminlte/plugins/jszip/jszip.min.js"></script>
<script src="../asset_adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../asset_adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../asset_adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../asset_adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../asset_adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<!-- AdminLTE for demo purposes -->
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
