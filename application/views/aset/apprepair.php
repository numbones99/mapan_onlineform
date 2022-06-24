<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Approval Perbaikan Aset</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form </a></li>
              <li class="breadcrumb-item">Perbaikan Aset</li>
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
                <h3 class="card-title">Data Pengajuan Approval Perbaikan Aset</h3>
              </div>
              <div class="card-body">
                <?php
                //mengecek apakah ada data pengajuan approval ?
                $empID = $this->session->userdata('EMP_ID');
                $whereAda = array(
                  'EMP_ID' => $empID,
                  'APP_RP_STAT' => '0',
                );
                $cekAdaData = $this->Model_online->countRowWhere('tr_app_repair',$whereAda);
                if($cekAdaData>0){
                ?>
                <table id="example3" class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>Tanggal Pengajuan</th>
                      <th>ID Repair</th>
                      <th>Branch</th>
                      <th>Divisi</th>
                      <th>Yang Mengajukan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($app as $app):?>
                    <tr>
                      <td><?= $app['RP_SUB_DATE']?></td>
                      <td><?= $app['RP_ID']?></td>
                      <td><?= $app['BRANCH_NAME']?></td>
                      <td><?= $app['DEPART_NAME']?></td>
                      <td><?= $app['EMP_FULL_NAME']?></td>
                      <td>
                      <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Approval">
                      <a href="<?php echo base_url().'Aset/dtapp/'.str_replace('/','', $app['APP_RP_ID'])?>" class="btn btn-default">
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
        if(count($appAcc)>0){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Approved Perbaikan Aset</h3>
              </div>
              <div class="card-body">      
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>ID Repair</th>
                        <th>Branch</th>
                        <th>Yang Mengajukan</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($appAcc as $appAcc):?>
                    <tr>
                        <td><?= $appAcc['RP_SUB_DATE']?></td>
                        <td><?= $appAcc['RP_ID']?></td>
                        <td><?= $appAcc['BRANCH_NAME']?></td>
                        <td><?= $appAcc['EMP_FULL_NAME']?></td>
                        <?php             
                        if($appAcc['RP_STAT']=='5'){
                        ?>
                        <td><span class="badge badge-info">Perbaikan & Review Telah Selesai</span><br></td>
                        <td>
                        <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                            <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                            <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$appAcc['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a>
                            </span>
                            <input type="hidden" name="cetakIDkb" class="form-control" value="<?= $appAcc['RP_ID']; ?>" readonly>
                            <input type="hidden" name="cetakIDemp" value="<?= $appAcc['EMP_ID']; ?>"/>
                        </form>
                        </td>
                        <?php
                        }elseif($appAcc['RP_STAT']=='4'){
                        ?>
                        <td>
                            <span class="badge badge-warning">Menunggu Konfirmasi Review</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$appAcc['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php  
                        }elseif($appAcc['RP_STAT']=='3'){
                        ?>
                        <td>
                            <span class="badge badge-success">Telah Disetujui & Menunggu Visit</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$appAcc['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php
                        }elseif($appAcc['RP_STAT']=='2'){
                        ?>
                        <td>
                            <span class="badge badge-danger">Permohonan Perbaikan Ditolak</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$appAcc['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php
                        }elseif($appAcc['RP_STAT']=='2'){
                        ?>
                        <td>
                            <span class="badge badge-danger">Pengajuan Telah Ditolak</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$appAcc['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php
                        }elseif($appAcc['RP_STAT']=='1'){
                        ?>
                        <td>
                            <span class="badge badge-warning">Menunggu Rangkaian Approval</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$appAcc['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php  
                        }
                        ?>
                    </tr>
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
        if(($this->session->userdata('BRANCH_ID')=='BR/0022' || $this->session->userdata('DEPART_ID')=='DP/006') && $this->session->userdata('EMP_ID')!='EMP/006/006'){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Data Approved Perbaikan Aset</h3>
              </div>
              <div class="card-body">      
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>ID Repair</th>
                        <th>Branch</th>
                        <th>Yang Mengajukan</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($direksi as $direksi):?>
                    <?php 
                    $arr_emp = array(
                      'EMP_ID' => $direksi['EMP_ID'],
                    );
                    $row_emp = $this->Model_online->findSingleDataWhere($arr_emp,'m_employee');
                    $arr_dep = array(
                      'DEPART_ID' => $row_emp['DEPART_ID'],
                    );
                    $row_dep = $this->Model_online->findSingleDataWhere($arr_dep,'m_department');
                    $arr_br = array(
                      'BRANCH_ID' => $row_dep['BRANCH_ID'],
                    );
                    $row_br = $this->Model_online->findSingleDataWhere($arr_br,'m_branch');
                    ?>
                    <tr>
                        <td><?= $direksi['RP_SUB_DATE']?></td>
                        <td><?= $direksi['RP_ID']?></td>
                        <td><?= $row_br['BRANCH_NAME']?></td>
                        <td><?= $row_emp['EMP_FULL_NAME']?></td>
                        <?php             
                        if($direksi['RP_STAT']=='5'){
                        ?>
                        <td><span class="badge badge-info">Perbaikan & Review Telah Selesai</span><br></td>
                        <td>
                        <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                            <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                            <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$direksi['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a>
                            </span>
                        </form>
                        </td>
                        <?php
                        }elseif($direksi['RP_STAT']=='4'){
                        ?>
                        <td>
                            <span class="badge badge-warning">Menunggu Konfirmasi Review</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$direksi['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php  
                        }elseif($direksi['RP_STAT']=='3'){
                        ?>
                        <td>
                            <span class="badge badge-success">Telah Disetujui & Menunggu Visit</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$direksi['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php
                        }elseif($direksi['RP_STAT']=='2'){
                        ?>
                        <td>
                            <span class="badge badge-danger">Permohonan Perbaikan Ditolak</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$direksi['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php
                        }elseif($direksi['RP_STAT']=='2'){
                        ?>
                        <td>
                            <span class="badge badge-danger">Pengajuan Telah Ditolak</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$direksi['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php
                        }elseif($direksi['RP_STAT']=='1'){
                        ?>
                        <td>
                            <span class="badge badge-warning">Menunggu Rangkaian Approval</span><br>
                        </td>
                        <td>
                            <form role="form" action="<?php echo base_url().'Laporanrepair'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                <a href="<?php echo base_url().'Aset/history/'.str_replace('/','',$direksi['RP_ID'])?>" class="btn btn-default"><i class="fas fa-history"></i></a> 
                                </span>
                            </form>
                        </td>
                        <?php  
                        }
                        ?>
                    </tr>
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