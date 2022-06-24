<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="mapangroup.com">Mapan Group</a>.</strong>
    All rights reserved.
</footer>
<div><!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url()?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>assets/dist/js/adminlte.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo base_url()?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url()?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/dist/js/demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
<!-- DataTables -->
<script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url()?>assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo base_url()?>assets/plugins/raphael/raphael.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>assets/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<!--<script src="{{asset('assets')}}/dist/js/pages/dashboard2.js"></script>-->
<script type="text/javascript">
    // untuk format number input menjadi currency
    
    $(document).ready(function(){
        //untuk file input
        bsCustomFileInput.init();
        // Format mata uang.
        $('.money').mask('000.000.000.000.000', {reverse: true});

        $('#reservationtime').change(function(){ 
          view_table();
          var rangetgl=$(this).val();
          $.ajax({
              url : '<?php echo base_url();?>Aset/get_emp',
              method : "POST",
              data : {rangetgl: rangetgl},
              async : true,
              dataType : 'json',
              success: function(data){
                  var html = '';
                  var i;
                  for(i=0; i<data.length; i++){
                      html += '<option value='+data[i].EMP_ID+'>'+data[i].EMP_FULL_NAME+'</option>';
                  }
                  $('#karyawan').html(html);
              }
          });
          return false;
        });

        $('#selruang').change(function(){ 
          var id=$(this).val();
          $.ajax({
              url : '<?php echo base_url();?>Aset/get_asset',
              method : "POST",
              data : {id: id},
              async : true,
              dataType : 'json',
              success: function(data){
                  var html = '';
                  var i;
                  for(i=0; i<data.length; i++){
                      html += '<option value='+data[i].ASSET_CODE+'>'+data[i].ASSET_CODE+' - '+data[i].ASSET_NAME+'</option>';
                  }
                  $('#selaset').html(html);
              }
          });
          return false;
        }); 
        $('.selruang2').change(function(){ 
          var id=$(this).val();
          $.ajax({
              url : '<?php echo base_url();?>Aset/get_asset',
              method : "POST",
              data : {id: id},
              async : true,
              dataType : 'json',
              success: function(data){
                  var html = '';
                  var i;
                  for(i=0; i<data.length; i++){
                      html += '<option value='+data[i].ASSET_CODE+'>'+data[i].ASSET_CODE+' - '+data[i].ASSET_NAME+'</option>';
                  }
                  $('.selaset2').html(html);
              }
          });
          return false;
        });
        $('#tanggal').change(function(){ 
          var tanggal=$(this).val();
          console.log(tanggal);
          $.ajax({
              url : '<?php echo base_url();?>Aset/get_jadwal',
              method : "POST",
              data : {tanggal: tanggal},
              async : true,
              dataType : 'json',
              success: function(data){
                  var html = '';
                  var i;
                  var no = 1;
                  for(i=0; i<data.length; i++){
                  rpnew = data[i].RP_ID.split('/').join('');
                      html += '<tr>'
                      + '<td>'+ no +'. </td>' 
                      + '<td>'+data[i].EMP_FULL_NAME+'</td>' 
                      + '<td>'+data[i].BRANCH_NAME+'</td>' 
                      + '<td>'
                      + '<span data-toggle="tooltip" data-placement="top" title="Edit / Isi Halaman Detail">'
                      + '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-detail-'+rpnew+'">'
                      + '<i class="fas fa-clipboard-list"></i>'
                      + '</a>'
                      + '</span>'
                      + '</td>' 
                      + '</tr>';
                      no++
                  }
                  $('.jadwalteknisi').html(html);
              }
          });
          return false;
        });  
        $('#tanggalall').change(function(){ 
          var tanggal=$(this).val();
          $.ajax({
              url : '<?php echo base_url();?>Aset/get_jadwal_all',
              method : "POST",
              data : {tanggal: tanggal},
              async : true,
              dataType : 'json',
              success: function(data){
                  var html = '';
                  var i;
                  var no = 1;
                  console.log();
                  for(i=0; i<data.length; i++){
                  rpnew = data[i].RP_ID.split('/').join('');
                      html += '<tr>'
                      + '<td>'+ no +'. </td>' 
                      + '<td>'+data[i].EMP_FULL_NAME+'</td>' 
                      + '<td>'+data[i].BRANCH_NAME+'</td>' 
                      + '<td>'
                      + '<span data-toggle="tooltip" data-placement="top" title="Edit / Isi Halaman Detail">'
                      + '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-detail-'+rpnew+'">'
                      + '<i class="fas fa-clipboard-list"></i>'
                      + '</a>'
                      + '</span>'
                      + '</td>' 
                      + '</tr>';
                      no++
                  }
                  $('.jadwalteknisi').html(html);
              }
          });
          return false;
        });  
    })
    // untuk js memunculkan select foto di halaman awal jika di pilih multiple
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })
        $("[name=toggler]").click(function(){
                $('.toHide').hide();
                $("#blk-"+$(this).val()).show('slow');
        });
        //Date range picker with time picker
        var date = new Date();
        // add a day
        //date.setDate(date.getDate() + 1);
        $('#reservationtime').daterangepicker({
          minDate: date,
          minTime: '06:00',
          endDate:date,
          locale: {
              format: 'YYYY/MM/DD'
          }
        })
        $('#tanggal').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          minYear: 1901,
          maxYear: parseInt(moment().format('YYYY'),10),
          locale: {
            format: 'DD-MM-YYYY'
          }
        })
        $('#tanggalwaktu').daterangepicker({
          singleDatePicker: true,
          timePicker:true,
          timePicker24Hour: true,
          showDropdowns: true,
          timePickerIncrement: 10,
          minYear: 1901,
          maxYear: parseInt(moment().format('YYYY'),10),
          enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22],
          locale: {
            format: 'DD-MM-YYYY HH:mm:ss'
          }
        })
        $('#tanggalwaktu2').daterangepicker({
          singleDatePicker: true,
          timePicker:true,
          timePicker24Hour: true,
          showDropdowns: true,
          timePickerIncrement: 10,
          minYear: 1901,
          maxYear: parseInt(moment().format('YYYY'),10),
          enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22],
          locale: {
            format: 'DD-MM-YYYY HH:mm:ss'
          }
        })
        $('#tanggalall').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          minYear: 1901,
          maxYear: parseInt(moment().format('YYYY'),10),
          locale: {
            format: 'DD-MM-YYYY'
          }
        })

    });
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "paging": true,
      //"lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]], 
    });
    $("#example4").DataTable({
      "paging": true,
      responsive: true,
      //"lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]], 
    });
    $('#example2').DataTable({
      "paging": true,
      //"lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]]
    });
    $('#example3').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]]
    });
    $('#tabelmenu').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]]
    });
    $('#tabelmenu2').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]]
    });
    $('#projectdone').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]]
    });
    $('#projectoutletdone').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      "order": [[ 0, "desc" ]]
    });
  });
</script>
<script>
const flashdata = $('.flashdata').data('flashdata');
if (flashdata) {
    Swal.fire({
    icon: 'success',
    title: 'Selamat ...',
    text: flashdata,
    position: 'center',
    showConfirmButton: false,
    timer: 2000
    })
}
</script>
</body>
</html>
