<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Approval Reimbursement</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form </a></li>
              <li class="breadcrumb-item">Reimbusement</li>
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
                <h3 class="card-title">Data Pengajuan Approval</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                <?php
                //mengecek apakah ada data pengajuan approval ?
                $empID = $this->session->userdata('EMP_ID');
                $whereAda = array(
                  'EMP_ID' => $empID,
                  'TR_APP_STATUS' => '0',
                );
                $cekAdaData = $this->Model_online->countRowWhere('tr_approval',$whereAda);
                if($cekAdaData>0){
                ?>
                <table id="example3" class="table table-bordered table-hover text-center" style="width:100% ">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>ID Reimbursement</th>
                      <th>Total Reimbursement</th>
                      <th>Divisi</th>
                      <th>Yang Mengajukan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($app as $app):?>
                    <tr>
                      <td><?= $app['TR_SUB_DATE']?></td>
                      <td><?= $app['RB_ID']?></td>
                      <td><?= 'Rp. '.number_format($app['RB_TOTAL'])?></td>
                      <td><?= $app['DEPART_NAME']?></td>
                      <td><?= $app['EMP_FULL_NAME']?></td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Ke Helaman Detail">
                      <a href="<?php echo base_url().'Reimbursement/DetailApproval/'.str_replace('/','', $app['TR_APP_ID'])?>" class="btn btn-default">
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
                </div>
              </div>
              <div class="card-footer">

              </div>
            </div>
          </div>
        </div>
        <?php
        //mengecek apakah ada data pengajuan approval ?
        
        $whereAdaNo = array(
          'EMP_ID' => $empID,
          'TR_APP_STATUS !=' => '0',
          'TR_APP_STATUS !=' => '2',
        );
        $cekAdaDataNo = $this->Model_online->countRowWhere('tr_approval',$whereAdaNo);
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
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Data Approval</h3>
              </div>
              <div class="card-body">
                
                <table id="example2" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>ID Reimbursement</th>
                      <th>Total Reimbursement</th>
                      <th>Divisi</th>
                      <th>Yang Mengajukan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($appNo as $appNo):?>
                    <tr>
                      <td><?= $appNo['TR_SUB_DATE']?></td>
                      <td><?= $appNo['RB_ID']?></td>
                      <td><?= 'Rp. '.number_format($appNo['RB_TOTAL'])?></td>
                      <td><?= $appNo['DEPART_NAME']?></td>
                      <td><?= $appNo['EMP_FULL_NAME']?></td>
                      <?php 
                       $where4 = array(
                        'RB_ID' => $appNo['RB_ID'],
                        'TR_APP_STATUS' => '4',
                      );
                      $cek4= $this->Model_online->countRowWhere('tr_approval',$where4);
                      if($cek4>0){
                      ?>
                      <td>
                      <form role="form" action="<?php echo base_url().'Laporanpdf'?>" method="POST" enctype="multipart/form-data" target="_blank">
                      <input type="hidden" name="cetakIDreim" class="form-control" value="<?= $appNo['RB_ID']; ?>" readonly>
                      <input type="hidden" name="cetakIDemp" value="<?= $appNo['EMP_ID']; ?>"/>
                      <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan PDF">
                      <button type="submit" class="btn btn-default"><i class="fas fa-print"></i></button> 
                      </span>
                      </form>
                      </td>
                      <?php
                      }else{
                      ?>
                      <td>
                      <span class="badge badge-warning">Menunggu Persetujuan Final</span><br>
                      </td>
                      <?php
                      }
                      ?>
                    </tr>

                    <!-- modal Cetak -->
                    <div class="modal fade" id="modal-cetak-<?= str_replace('/','',$appNo['RB_ID']); ?>">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <form role="form" action="<?php echo base_url().'Laporanpdf'?>" method="POST" enctype="multipart/form-data" target="_blank">
                          <div class="modal-header" style="background-color:#5bc0de;color:white;">
                              <h5 class="modal-title ">Cetak Reimbursement - <?= $appNo['RB_ID'] ?></h5>
                              
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-lg-12">
                                      <div class="form-group">
                                          <label>ID Reimburse</label>
                                          <input type="text" name="cetakIDreim" class="form-control" value="<?= $appNo['RB_ID']; ?>" readonly>
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
                      <th>ID Reimbursement</th>
                      <th>Total Reimbursement</th>
                      <th>Divisi</th>
                      <th>Yang Mengajukan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($appFA as $appFA):?>
                    <tr>
                      <td><?= $appFA['TR_SUB_DATE']?></td>
                      <td><?= $appFA['RB_ID']?></td>
                      <td><?= 'Rp. '.number_format($appFA['RB_TOTAL'])?></td>
                      <td><?= $appFA['DEPART_NAME']?></td>
                      <td><?= $appFA['EMP_FULL_NAME']?></td>
                      <?php 
                       $where4 = array(
                        'RB_ID' => $appFA['RB_ID'],
                        'TR_APP_STATUS' => '4',
                      );
                      $cek4= $this->Model_online->countRowWhere('tr_approval',$where4);
                      if($cek4>0){
                      ?>
                      <td>
                      
                      <form role="form" action="<?php echo base_url().'Laporanpdf'?>" method="POST" enctype="multipart/form-data" target="_blank">
                      <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Detail">
                      <a href="<?php echo base_url().'Reimbursement/detail/'.str_replace('/','',$appFA['RB_ID'])?>" class="btn btn-default">
                      <i class="fas fa-clipboard-list"></i>
                      </a>
                      </span>
                      <input type="hidden" name="cetakIDreim" class="form-control" value="<?= $appFA['RB_ID']; ?>" readonly>
                      <input type="hidden" name="cetakIDemp" value="<?= $appFA['EMP_ID']; ?>"/>
                      <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan PDF">
                      <button type="submit" class="btn btn-default"><i class="fas fa-print"></i></button> 
                      </span>
                      </form>
                      </td>
                      <?php
                      }else{
                      ?>
                      <td>
                      <span class="badge badge-warning">Menunggu Persetujuan Final</span><br>
                      </td>
                      <?php
                      }
                      ?>
                    </tr>

                    <!-- modal Cetak -->
                    <div class="modal fade" id="modal-cetak-<?= str_replace('/','',$appFA['RB_ID']); ?>">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <form role="form" action="<?php echo base_url().'Laporanpdf'?>" method="POST" enctype="multipart/form-data" target="_blank">
                          <div class="modal-header" style="background-color:#5bc0de;color:white;">
                              <h5 class="modal-title ">Cetak Reimbursement - <?= $appFA['RB_ID'] ?></h5>
                              
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-lg-12">
                                      <div class="form-group">
                                          <label>ID Reimburse</label>
                                          <input type="text" name="cetakIDreim" class="form-control" value="<?= $appFA['RB_ID']; ?>" readonly>
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