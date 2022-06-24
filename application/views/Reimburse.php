<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reimbursement</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item active">Reimbursement</li>
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
            <div class="col-lg-12 col-12">
            <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>Reimbursement Baru</h3>
                    <p>Membuat atau memasukkan Reimbursement baru</p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-file"></i>
                    </div>
                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-single">
                    Masukkan Reimbursement <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="modal-single">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                <h4 class="modal-title text-center">Konfirmasi Pembuatan Reimbursement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body text-center">
                <p><b>Apakah Anda Yakin Untuk Membuat Reimbursement Baru?</b></p>
                <hr>
                <p>Silahkan klik tombol Lanjutkan untuk membuat<br>Reimbursement Baru</p>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="<?php echo base_url().'Reimbursement/insertReim'?>"><button type="button" class="btn btn-success">Lanjutkan</button></a>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="row">
                <!-- Data Reimbusement Baru column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <?php
                        //mengecek apakah ada data pengajuan reimbursement baru ?
                        $empID = $this->session->userdata('EMP_ID');
                        $whereAdaBaru = array(
                        'EMP_ID' => $empID,
                        'RB_SUBMIT_DATE ' => null,
                        );
                        $cekAdaDataBaru = $this->Model_online->countRowWhere('tr_reimburse',$whereAdaBaru);
                        if($cekAdaDataBaru>0){
                        ?>
                    <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Data Reimbursement Baru Karyawan : <?= $this->session->userdata('EMP_FULL_NAME')?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        
                        <table id="example2" class="table table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>ID Reimbursement</th>
                            <th>Total Reimbursement</th>
                            <th>Jumlah Item</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        <?php foreach($reimburse as $reimburse) :?>
                            <tr>
                                <td><?php
                                echo  ($reimburse->RB_SUBMIT_DATE == '') ? 'Belum Diajukan' : $reimburse->RB_SUBMIT_DATE; ?></td>
                                <td><?= $reimburse->RB_ID; ?></td>
                                <td><?= number_format(''.$reimburse->RB_TOTAL.'');?></td>
                                <?php
                                $hitung = $this->Model_online->hitungJumlahItem($reimburse->RB_ID);
                                ?>
                                <td><?= $hitung.' Item'; ?></td>
                                <?php
                                $where = array(
                                    'ta.RB_ID' => $reimburse->RB_ID,
                                );
                                $getName = $this->Model_online->findLeader($where);
                                ?>
                                
                                <td class="text-center">
                                <div class="btn-group">
                                <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Detail">
                                <a href="<?php echo base_url().'Reimbursement/detail/'.str_replace('/','',$reimburse->RB_ID)?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                                </span>
                                <?php
                                if($hitung<1)
                                {
                                ?>
                                <span data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$reimburse->RB_ID); ?>"><i class="fas fa-trash-alt"></i></button> 
                                </span>
                                <?php   
                                }
                                ?>
                                </div>
                                </td>
                            </tr>
                            <!-- modal delete -->
                                <div class="modal fade" id="modal-delete-<?= str_replace('/','',$reimburse->RB_ID); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Reimbursement/deleteReim'?>" method="POST" enctype="multipart/form-data">
                        
                                        <div class="modal-header" style="background-color:#dc3545;color:white;">
                                            <h5 class="modal-title ">Delete Reimbursement - <?= $reimburse->RB_ID; ?></h5>
                                            
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="delnama">ID Reimburse</label>
                                                        <input type="text" name="delID" class="form-control" value="<?= $reimburse->RB_ID; ?>" readonly>
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
                            <!-- /.modal -->
                        <?php endforeach?>
                        </tbody>
                        </table>
                        
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <?php
                        }
                        ?>
                </div>
                <!--/.col (left) -->
                <!-- Data Reimbusement yang sudah di ajukan-->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <?php
                        //mengecek apakah ada data pengajuan reimbursement baru ?
                        $empID = $this->session->userdata('EMP_ID');
                        $whereAda = array(
                        'EMP_ID' => $empID,
                        'RB_SUBMIT_DATE !=' => null,
                        );
                        $cekAdaData = $this->Model_online->countRowWhere('tr_reimburse',$whereAda);
                        if($cekAdaData>0){
                        ?>
                    <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Data Pengajuan Reimbursement Karyawan : <?= $this->session->userdata('EMP_FULL_NAME')?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example3" class="table table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>ID Reimbursement</th>
                            <th>Total Reimbursement</th>
                            <th>Jumlah Item</th>
                            <th>Progress</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        <?php foreach($reimburseAju as $reimburse) :?>
                            <tr>
                                <td><?php
                                echo  ($reimburse->RB_SUBMIT_DATE == '') ? 'Belum Diajukan' : $reimburse->RB_SUBMIT_DATE; ?></td>
                                <td><?= $reimburse->RB_ID; ?></td>
                                <td><?= number_format(''.$reimburse->RB_TOTAL.'');?></td>
                                <?php
                                $hitung = $this->Model_online->hitungJumlahItem($reimburse->RB_ID);
                                ?>
                                <td><?= $hitung.' Item'; ?></td>
                                <td>
                                    <?php
                                    $kondisi = array(
                                        'ta.RB_ID' => $reimburse->RB_ID,
                                    );
                                    $app = $this->Model_online->findApproval($kondisi);
                                    foreach($app as $app):
                                    if($app['TR_APP_STATUS'] == '0' && $app['EMP_ID']=='EMP/003/009'){
                                        $status = 'Menunggu Konfirmasi Pengeluaran Dana Dari Finance';
                                        $statusWarna = 'badge badge-info';
                                    }elseif($app['TR_APP_STATUS'] == '0'){
                                        $status = 'Menunggu Persetujuan '.$app['EMP_FULL_NAME'];
                                        $statusWarna = 'badge badge-warning';
                                    }elseif($app['TR_APP_STATUS'] == '1'){
                                        $status = 'Telah Disetujui '.$app['EMP_FULL_NAME'];
                                        $statusWarna = 'badge badge-success';
                                    }elseif($app['TR_APP_STATUS'] == '2'){
                                        $status = 'Permohonan Ditolak Oleh '.$app['EMP_FULL_NAME'];
                                        $statusWarna = 'badge badge-danger';
                                    }elseif($app['TR_APP_STATUS'] == '3'){
                                        $status = 'Telah Disetujui '.$app['EMP_FULL_NAME'].' & Menunggu Release FA';
                                        $statusWarna = 'badge badge-info';
                                    }else{
                                        if(!empty($reimburse->RB_TRANSFER_DATE)){
                                            if(date("Y-m-d") > $reimburse->RB_TRANSFER_DATE){
                                                $status = 'Telah Direlease FA';
                                            }else{
                                                $status = 'Telah Dijadwalkan Release FA pada '.$reimburse->RB_TRANSFER_DATE;
                                            }
                                        }else{
                                            $status = 'Telah Direlease FA';
                                        }
                                        $statusWarna = 'badge badge-primary';
                                    }
                                    ?>
                                        <span class="<?= $statusWarna;?>"><?= $status;?></span><br>
                                    <?php 
                                    endforeach
                                    ?>
                                </td>
                                <td class="text-center">
                                <div class="btn-group">
                                <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Detail">
                                <a href="<?php echo base_url().'Reimbursement/detail/'.str_replace('/','',$reimburse->RB_ID)?>" class="btn btn-default">
                                <i class="fas fa-clipboard-list"></i>
                                </a> 
                                </span>
                                <?php
                                $whereNol = array(
                                    'TR_APP_STATUS' => '0',
                                    'RB_ID' => $reimburse->RB_ID,
                                );
                                $adaNol = $this->Model_online->countRowWhere('tr_approval',$whereNol);
                                $whereTolak = array(
                                    'TR_APP_STATUS' => '2',
                                    'RB_ID' => $reimburse->RB_ID
                                );
                                $adaTolak = $this->Model_online->countRowWhere('tr_approval',$whereTolak);
                                if($adaNol<=0 && $adaTolak<=0)
                                {
                                ?>
                                <form role="form" action="<?php echo base_url().'Laporanpdf'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                <input type="hidden" name="cetakIDreim" class="form-control" value="<?= $reimburse->RB_ID; ?>" readonly>
                                <input type="hidden" name="cetakIDemp" value="<?= $this->session->userdata('EMP_ID'); ?>"/>
                                <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan PDF">
                                <button type="submit" class="btn btn-default" ><i class="fas fa-print"></i></button> 
                                </span>
                                </form>
                                <?php
                                }
                                ?>
                                <?php
                                if($hitung<1)
                                {
                                ?>
                                <span data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$reimburse->RB_ID); ?>">
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
                                <div class="modal fade" id="modal-delete-<?= str_replace('/','',$reimburse->RB_ID); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Reimbursement/deleteReim'?>" method="POST" enctype="multipart/form-data">
                        
                                        <div class="modal-header" style="background-color:#dc3545;color:white;">
                                            <h5 class="modal-title ">Delete Reimbursement - <?= $reimburse->RB_ID; ?></h5>
                                            
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="delnama">ID Reimburse</label>
                                                        <input type="text" name="delID" class="form-control" value="<?= $reimburse->RB_ID; ?>" readonly>
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
                            <!-- /.modal -->
                            <!-- modal Cetak -->
                            <div class="modal fade" id="modal-cetak-<?= str_replace('/','',$reimburse->RB_ID); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Laporanpdf'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                        <div class="modal-header" style="background-color:#5bc0de;color:white;">
                                            <h5 class="modal-title ">Cetak Reimbursement - <?= $reimburse->RB_ID; ?></h5>
                                            
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>ID Reimburse</label>
                                                        <input type="text" name="cetakIDreim" class="form-control" value="<?= $reimburse->RB_ID; ?>" readonly>
                                                        <input type="hidden" name="cetakIDemp" value="<?= $this->session->userdata('EMP_ID'); ?>"/>
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
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <?php
                        }?>
                </div>
                <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->