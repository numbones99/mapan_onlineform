<?php
$page = basename($_SERVER['PHP_SELF']);
if($page == "Aset_it"){
  $divName = "IT";
  $longDivName = "Information & Technology";
}else{
  $divName = "MB";
  $longDivName = "Maintenance Building";
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Menu <?= $longDivName ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item active">Permintaan & Perbaikan Aset</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <div class="container-fluid">
    <?php
    $Ymdhis = date('Y-m-d H:i:s');
    ?>
        <div class="row">
            <div class="col-lg-12 col-12">
            <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>Permintaan / Perbaikan Aset</h3>
                    <p>Permintaan / Perbaikan Aset <?= $divName ?></p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-tools"></i>
                    </div>
                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-single">
                    Masukkan Permintaan <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="modal-single">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                <h4 class="modal-title text-center">Konfirmasi Permintaan Perbaikan Aset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body text-center">
                <p><b>Apakah Anda Yakin Untuk Membuat Permintaan Baru?</b></p>
                <hr>
                <p>Silahkan klik tombol Lanjutkan untuk membuat<br>Permintaan Baru</p>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="<?php echo base_url().'Aset/insReq'?>"><button type="button" class="btn btn-info">Lanjutkan</button></a>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <?php
        $whereEmp = array(
          'EMP_ID' => $this->session->userdata('EMP_ID'),
          'RP_STAT' => '0',
        ); 
        $cekbaru = $this->Model_online->countRowWhere('tr_repair',$whereEmp);
        if($cekbaru>0){
        ?>
        <!-- open row tampilan data -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-warning">
              <div class="card-header">
                <div class="row">
                  <div class="col-lg-6">
                    <h3 class="card-title"> <strong>Data Permintaan Perbaikan Aset (Belum Diajukan)</strong> </h3>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      
                      <th>Tanggal Pengajuan</th>
                      <th>ID Pengajuan</th>
                      <th>Jumlah Item</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="">
                    <?php
                    $i=1; 
                    foreach($repairs as $repairs) :
                    $where = array(
                      'RP_ID' => $repairs['RP_ID'],   
                    );
                    $jumlahpermin = $this->Model_online->countRowWhere('tr_detail_repair',$where);  
                    ?>          
                      <tr>
                        <td><?= ($repairs['RP_SUB_DATE'] == '') ? 'Belum Diajukan' : $repairs['RP_SUB_DATE'] ; ?></td>
                        <td><?= $repairs['RP_ID']; ?></td>
                        <td><?= $jumlahpermin; ?></td>
                        <td><?= ($repairs['RP_STAT']=='0') ? 'Belum Diajukan' : 'Sudah Diajukan' ; ?></td>
                        <td>
                          <div class="btn-group">
                              <span data-toggle="tooltip" data-placement="top" title="Edit / Isi Halaman Detail">
                              <a href="<?php echo base_url().'Aset/detail/'.str_replace('/','',$repairs['RP_ID'])?>" class="btn btn-default">
                              <i class="fas fa-clipboard-list"></i>
                              </a>
                              </span>
                              <?php
                              if($jumlahpermin<=0){
                              ?>                                    
                              <span data-toggle="tooltip" data-placement="top" title="Hapus Pengajuan">
                              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$repairs['RP_ID']); ?>">
                              <i class="fas fa-trash-alt"></i>
                              </button> 
                              </span>
                              <?php
                              }
                              ?>
                          </div>
                        </td>
                      </tr>
                      <!-- modal delete -->
                      <div class="modal fade" id="modal-delete-<?= str_replace('/','',$repairs['RP_ID']); ?>">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <form role="form" action="<?php echo base_url().'Aset/delReq'?>" method="POST" enctype="multipart/form-data">
                              <div class="modal-header" style="background-color:#dc3545;color:white;">
                                <h5 class="modal-title ">Delete Permintaan Perbaikan Aset - <?= $repairs['RP_ID']; ?></h5>                 
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="form-group">
                                      <label for="delnama">ID Kasbon</label>
                                      <input type="text" name="delID" class="form-control" value="<?= $repairs['RP_ID']; ?>" readonly>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                              </div>
                            </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal delete -->
                    <?php endforeach?>          
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">    
              </div>
            </div>
            <!-- /.card -->
          </div><!--/col-->
        </div>
        <!-- /row tampilan data-->
        <?php 
        }
        ?>
        <?php
        $whereEmpIsi = array(
          'EMP_ID' => $this->session->userdata('EMP_ID'),
          'RP_STAT !=' => '0',
        ); 
        $cekada = $this->Model_online->countRowWhere('tr_repair',$whereEmpIsi);
        if($cekada>0){
        ?>
        <!-- open row tampilan data -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-success">
              <div class="card-header">
                <div class="row">
                  <div class="col-lg-6">
                    <h3 class="card-title">Data Permintaan Perbaikan Aset <strong>( Telah Diajukan )</strong> </h3>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>ID Pengajuan</th>
                      <th>Jumlah Item</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="">
                    <?php
                    $i=1; 
                    foreach($repairsada as $repairsada) :
                    $wheretotal = array(
                      'RP_ID' => $repairsada['RP_ID'],   
                    );
                    $total = $this->Model_online->countRowWhere('tr_detail_repair',$wheretotal);  
                    ?>          
                      <tr>
                        <td><?= ($repairsada['RP_SUB_DATE'] == '') ? 'Belum Diajukan' : $repairsada['RP_SUB_DATE'] ; ?></td>
                        <td><?= $repairsada['RP_ID']; ?></td>
                        <td><?= $total; ?></td>
                        <td>
                        <?php 
                        if($repairsada['RP_STAT']=='0'){
                        ?>
                        <span class="badge badge-warning">Belum Diajukan</span><br>
                        <?php  
                        }elseif($repairsada['RP_STAT']=='1'){
                        ?>
                        <span class="badge badge-info">Menunggu Persetujuan</span><br>
                        <?php  
                        }elseif($repairsada['RP_STAT']=='2'){
                        ?>
                        <span class="badge badge-danger">Permohonan Ditolak</span><br>
                        <?php  
                        }elseif($repairsada['RP_STAT']=='3' && $repairsada['RP_STR_DATE'] < $Ymdhis){
                        ?>
                        <span class="badge badge-warning">Menunggu Kelangkapan Foto Aset Setelah Perbaikan dan Review</span><br>
                        <?php
                        }elseif($repairsada['RP_STAT']=='3'){
                        ?>
                        <span class="badge badge-success">Permohonan Diterima & Menunggu Visit</span><br>
                        <?php  
                        }elseif($repairsada['RP_STAT']=='5'){
                        ?>
                        <span class="badge badge-success">Perbaikan Telah Selesai & Review Telah Diterima</span><br>
                        <?php
                        }elseif($repairsada['RP_STAT']=='6'){
                        ?>
                        <span class="badge badge-danger">Review Ditolak, Mohon Inputkan Review Kembali</span><br>
                        <?php  
                        }
                        ?>
                        </td>
                        <td>
                          <div class="btn-group">
                              <span data-toggle="tooltip" data-placement="top" title="Lihat Detail Permintaan dan Timeline">
                              <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$repairsada['RP_ID'])?>" class="btn btn-default">
                              <i class="fas fa-history"></i>
                              </a>
                              </span>                                        
                          </div>
                        </td>
                      </tr>
                    <?php endforeach?>          
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">    
              </div>
            </div>
            <!-- /.card -->
          </div><!--/col-->
        </div>
        <!-- /row tampilan data-->
        <?php 
        }
        ?>
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->