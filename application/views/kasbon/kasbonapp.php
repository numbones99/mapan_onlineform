<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Approval Kasbon</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form </a></li>
              <li class="breadcrumb-item">Kasbon</li>
              <li class="breadcrumb-item active">Approval</li>
              
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
        <div class="row">
          <div class="col-md-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Data Pengajuan Approval Kasbon</h3>
              </div>
              <div class="card-body">
                <?php
                //mengecek apakah ada data pengajuan approval ?
                $empID = $this->session->userdata('EMP_ID');
                $whereAda = array(
                  'EMP_ID' => $empID,
                  'TR_KB_APP_STATUS' => '0',
                );
                $cekAdaData = $this->Model_online->countRowWhere('tr_kb_approval',$whereAda);
                if($cekAdaData>0){
                ?>
                <table id="example3" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>ID Kasbon</th>
                      <th>Total Kasbon</th>
                      <th>Divisi</th>
                      <th>Yang Mengajukan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($app as $app):?>
                    <tr>
                      <td><?= $app['TR_KB_SUB_DATE']?></td>
                      <td><?= $app['KB_ID']?></td>
                      <td><?= 'Rp. '.number_format($app['KB_TOTAL_AWAL'])?></td>
                      <td><?= $app['DEPART_NAME']?></td>
                      <td><?= $app['EMP_FULL_NAME']?></td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Approval">
                      <a href="<?php echo base_url().'Kasbon/detailapproval/'.str_replace('/','', $app['TR_KB_APP_ID'])?>" class="btn btn-default">
                      <i class="fas fa-clipboard-list"></i>
                      </a>
                      </span>
                      </td>
                    </tr>
                    <?php endforeach?>
                  </tbody>
                </table>
                <?php
                }else{
                  echo "Tidak Ada Pengajuan Approval Kepada Anda Saat Ini...";
                }
                ?>
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
        </div>
        <?php
        if($this->session->userdata('EMP_ID')=='EMP/003/009'){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Data Pengajuan Approval Realisasi</h3>
              </div>
              <div class="card-body">
                <?php
                //mengecek apakah ada data pengajuan approval ?
                $whereAda = array(
                  'KB_STATUS' => '5',
                );
                $cekAdaData = $this->Model_online->countRowWhere('tr_kasbon',$whereAda);
                if($cekAdaData>0){
                ?>
                <table id="example3" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>ID Kasbon</th>
                      <th>Yang Mengajukan</th>
                      <th>Total Kasbon</th>
                      <th>Total Realisasi</th>
                      <th>Selisih</th>
                      <th>Tanggal Realisasi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($appReal as $appReal):?>
                    <tr>
                      <td><?= $appReal['KB_SUBMIT_DATE']?></td>
                      <td><?= $appReal['KB_ID']?></td>
                      <td><?= $appReal['EMP_ID']?></td>
                      <td><?= number_format($appReal['KB_TOTAL_AWAL'])?></td>
                      <td><?= number_format($appReal['KB_TOTAL_AKHIR'])?></td>
                      <td><?= number_format($appReal['KB_DIFF'])?></td>
                      <td><?= $appReal['KB_REPORT_DATE']?></td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Approval">
                      <a href="<?php echo base_url().'Kasbon/detailappreal/'.str_replace('/','', $appReal['KB_ID'])?>" class="btn btn-default">
                      <i class="fas fa-clipboard-list"></i>
                      </a>
                      </span>
                      </td>
                    </tr>
                    <?php endforeach?>
                  </tbody>
                </table>
                <?php
                }else{
                  echo "Tidak Ada Pengajuan Approval Kepada Anda Saat Ini...";
                }
                ?>
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
        <?php
        //mengecek apakah ada data pengajuan approval ?
        
        $whereAdaNo = array(
          'EMP_ID' => $empID,
          'TR_KB_APP_STATUS !=' => '0',
          'TR_KB_APP_STATUS !=' => '2',
        );
        $cekAdaDataNo = $this->Model_online->countRowWhere('tr_kb_approval',$whereAdaNo);
        $whereFA = array(
          'EMP_ID' => $empID,
          'DEPART_ID' => 'DP/003',
        );
        $cekFA = $this->Model_online->countRowWhere('m_employee',$whereFA);
        $whereDirek = array(
          'EMP_ID' => $empID,
          'DEPART_ID' => 'DP/009',
        );
        $cekDirek = $this->Model_online->countRowWhere('m_employee',$whereDirek);
        if($cekAdaDataNo>0 && $cekFA<=0){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Approved Kasbon</h3>
              </div>
              <div class="card-body">
                
                <table id="example2" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>Total Kasbon</th>
                      <th>Divisi</th>
                      <th>Yang Mengajukan</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($appNo as $appNo):?>
                    <tr>
                      <td><?= $appNo['TR_KB_SUB_DATE']?></td>
                      <td><?= 'Rp. '.number_format($appNo['KB_TOTAL_AWAL'])?></td>
                      <td><?= $appNo['DEPART_NAME']?></td>
                      <td><?= $appNo['EMP_FULL_NAME']?></td>
                      <?php 
                      
                      if($appNo['KB_STATUS']=='6'){
                      ?>
                      <td>
                      <span class="badge badge-info">Realisasi Telah Disetujui</span><br>
                      </td>
                      <td>
                      <form role="form" action="<?php echo base_url().'Laporankasbon'?>" method="POST" enctype="multipart/form-data" target="_blank">
                        <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                        <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appNo['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                        </span>
                        <input type="hidden" name="cetakIDkb" class="form-control" value="<?= $appNo['KB_ID']; ?>" readonly>
                        <input type="hidden" name="cetakIDemp" value="<?= $appNo['EMP_ID']; ?>"/>
                        <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan PDF">
                          <button type="submit" class="btn btn-default"><i class="fas fa-print"></i></button> 
                        </span>
                      </form>
                      </td>
                      <?php
                      }elseif($appNo['KB_STATUS']=='5'){
                      ?>
                      <td>
                      <span class="badge badge-info">Menunggu Approval Realisasi</span><br>
                      </td>
                      <td>
                        <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                        <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appNo['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                        </span>
                      </td>
                      <?php  
                      }elseif($appNo['KB_STATUS']=='4'){
                      ?>
                      <td>
                      <span class="badge badge-info">Menunggu Kelengkapan Realisasi</span><br>
                      </td>
                      <td>
                        <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                        <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appNo['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                        </span>
                      </td>
                      <?php
                      }elseif($appNo['KB_STATUS']=='3'){
                      ?>
                      <td>
                      <span class="badge badge-info">Menunggu Release FA</span><br>
                      </td>
                      <td>
                        <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                        <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appNo['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                        </span>
                      </td>
                      <?php
                      }elseif($appNo['KB_STATUS']=='2'){
                      ?>
                      <td>
                      <span class="badge badge-danger">Pengajuan Telah Ditolak</span><br>
                      </td>
                      <td>
                        <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                        <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appNo['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                        </span>
                      </td>
                      <?php
                      }elseif($appNo['KB_STATUS']=='1'){
                      ?>
                      <td>
                      <span class="badge badge-warning">Menunggu Rangkaian Approval</span><br>
                      </td>
                      <td>
                        <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                        <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appNo['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                        </span>
                      </td>
                      <?php  
                      }elseif($appNo['KB_STATUS']=='7'){
                      ?>
                      <td>
                      <span class="badge badge-warning">Menunggu Revisi Realisasi</span><br>
                      </td>
                      <td>
                        <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                        <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appNo['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                        </span>
                      </td>
                      <?php  
                      }
                      ?>
                    </tr>

                    <!-- modal Cetak -->
                    <div class="modal fade" id="modal-cetak-<?= str_replace('/','',$appNo['KB_ID']); ?>">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <form role="form" action="<?php echo base_url().'Laporankasbon'?>" method="POST" enctype="multipart/form-data" target="_blank">
                          <div class="modal-header" style="background-color:#5bc0de;color:white;">
                              <h5 class="modal-title ">Cetak Kasbon - <?= $appNo['KB_ID'] ?></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-lg-12">
                                      <div class="form-group">
                                          <label>ID Kasbon</label>
                                          <input type="text" name="cetakIDkb" class="form-control" value="<?= $appNo['KB_ID']; ?>" readonly>
                                          <input type="hidden" name="cetakIDemp" value="<?= $appNo['EMP_ID']; ?>"/>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-info">Cetak</button>
                          </div>
                          </form>
                          </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <?php endforeach?>
                  </tbody>
                </table>
                
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
        </div>
        <?php
        }elseif($cekFA>0 || $cekDirek>0){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Data Approval</h3>
              </div>
              <div class="card-body">
                
                <table id="example2" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>Total Kasbon</th>
                      <th>Divisi</th>
                      <th>Yang Mengajukan</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($appFA as $appFA):?>
                    <tr>
                      <td><?= $appFA['TR_KB_SUB_DATE']?></td>
                      <td><?= 'Rp. '.number_format($appFA['KB_TOTAL_AWAL'])?></td>
                      <td><?= $appFA['DEPART_NAME']?></td>
                      <td><?= $appFA['EMP_FULL_NAME']?></td>
                      <?php 
                       $where4 = array(
                        'KB_ID' => $appFA['KB_ID'],
                      );
                      $cek = $this->Model_online->findSingleDataWhere($where4,'tr_kasbon');
                      //$cek4= $this->Model_online->countRowWhere('tr_kasbon',$where4);
                      if($cek['KB_STATUS']=='6'){
                      ?>
                      <td><span class="badge badge-success">Realisasi Telah Disetujui</span><br></td>
                      <td>
                      <form role="form" action="<?php echo base_url().'Laporankasbon'?>" method="POST" enctype="multipart/form-data" target="_blank">
                      <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                      <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appFA['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                      </span>
                      <input type="hidden" name="cetakIDkb" class="form-control" value="<?= $appFA['KB_ID']; ?>" readonly>
                      <input type="hidden" name="cetakIDemp" value="<?= $appFA['EMP_ID']; ?>"/>
                      <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan PDF">
                      <button type="submit" class="btn btn-default"><i class="fas fa-print"></i></button> 
                      </span>
                      </form>
                      </td>
                      <?php
                      }elseif($cek['KB_STATUS']=='7'){
                      ?>
                      <td>
                      <span class="badge badge-danger">Realisasi Ditolak & Menunggu Perbaikan</span><br>
                      </td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                      <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appFA['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                      </span>
                      </td>
                      <?php
                      }elseif($cek['KB_STATUS']=='5'){
                      ?>
                      <td>
                      <span class="badge badge-info">Realisasi Diajukan & Menunggu Approval</span><br>
                      </td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                      <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appFA['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                      </span>
                      </td>
                      <?php
                      }elseif($cek['KB_STATUS']=='4'){
                      ?>
                      <td>
                      <span class="badge badge-warning">Menunggu Kelengkapan Realisasi</span><br>
                      </td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                      <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appFA['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                      </span>
                      </td>
                      <?php 
                      }else{
                      ?>
                      <td>
                      </td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                      <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$appFA['KB_ID'])?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                      </span>
                      </td>
                      <?php
                      }
                      ?>
                    </tr>

                    <!-- modal Cetak -->
                    <div class="modal fade" id="modal-cetak-<?= str_replace('/','',$appFA['KB_ID']); ?>">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <form role="form" action="<?php echo base_url().'Laporankasbon'?>" method="POST" enctype="multipart/form-data" target="_blank">
                          <div class="modal-header" style="background-color:#5bc0de;color:white;">
                              <h5 class="modal-title ">Cetak Kasbon - <?= $appFA['KB_ID'] ?></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-lg-12">
                                      <div class="form-group">
                                          <label>ID Kasbon</label>
                                          <input type="text" name="cetakIDkb" class="form-control" value="<?= $appFA['KB_ID']; ?>" readonly>
                                          <input type="hidden" name="cetakIDemp" value="<?= $appFA['EMP_ID']; ?>"/>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-info">Cetak</button>
                          </div>
                          </form>
                          </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <?php endforeach?>
                  </tbody>
                </table>
                
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->