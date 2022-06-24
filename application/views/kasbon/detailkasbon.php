<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Kasbon</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item">Kasbon</li>
              <li class="breadcrumb-item active">Detail Kasbon</li>
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
        <!-- Bagian If | untuk data yang belum diajukan -->
        <?php
        $cek = $kasbon['KB_SUBMIT_DATE'];
        if ($cek !== null) {
        ?>
            <!-- open row tampilan data -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="row">
                            <div class="col-lg-6">
                            <h3 class="card-title">Data Detail Kasbon ID - <?= $kasbon['KB_ID'];?></h3>
                            </div>
                            <div class="col-lg-6">
                            <h3 class="card-title" style="color:black;float:right">Status : Telah Diajukan</h3>
                            </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                            <thead>
                            <tr>
                                <th>ID Detail</th>
                                <th>Keterangan</th>
                                <th>Nominal Awal</th>
                                <th>Nominal Laporan</th>
                                <th>Selisih</th>
                            </tr>
                            </thead>
                            <tbody class="">
                            <?php $i=1;?>
                            <?php foreach($dkasbon as $dkasbon) :?>
                            <tr>
                                <td><?= $dkasbon->DET_KB_ID; ?></td>
                                <td><?= $dkasbon->DET_KB_ITEM; ?></td>
                                <td><?= number_format($dkasbon->DET_KB_VALUE); ?></td>
                                <td><?= number_format($dkasbon->DET_KB_END_VALUE); ?></td>
                                <td><?= number_format($dkasbon->DET_KB_DIFF); ?></td>
                            </tr>
                            <?php endforeach?>
                            
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-summary">
                            Summary Kasbon
                            </button>    
                        </div>
                        </div>
                        <!-- /.card -->
                       <!-- modal atasan -->
                        <div class="modal fade" id="modal-summary">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:#28a745;color:white;">
                                        <h5 class="modal-title">Summary Laporan Kasbon ID - <?= $kasbon['KB_ID'];?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="dis-nama">Nama Karyawan</label>
                                                    <?php
                                                    $arr_emp3 = array(
                                                        'EMP_ID' => $kasbon['EMP_ID'],
                                                    );
                                                    $em3 = $this->Model_online->findSingleDataWhere($arr_emp3, 'm_employee');
                                                    ?>
                                                    <input type="text" class="form-control" id="dis-nama" value="<?= $em3['EMP_FULL_NAME'];?>" readonly>
                                                    <input type="hidden" name="insAppIdEmp" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_ID');?>" readonly>
                                                    <input type="hidden" name="sendID" value="<?= $kasbon['KB_ID'];?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="dis-id">ID Kasbon</label>
                                                    <input type="text" name='insAppIdReim' class="form-control" id="dis-id" value="<?= $kasbon['KB_ID'];?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="dis-total">Total Kasbon</label>
                                                    <input type="text" class="form-control money" id="dis-total" value="<?= $kasbon['KB_TOTAL_AWAL'];?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="dis-total">Total Kasbon Akhir</label>
                                                    <input type="text" class="form-control money" id="dis-total" value="<?= $kasbon['KB_TOTAL_AKHIR'];?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="dis-total">Selisih</label>
                                                    <input type="text" class="form-control money" id="dis-total" value="<?= $kasbon['KB_DIFF'];?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Keterangan</th>
                                                        <th>Nominal Awal</th>
                                                        <th>Nominal Akhir</th>
                                                        <th>Selisih</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="">
                                                    <?php
                                                    $i=1;
                                                    ?>
                                                    <?php foreach($dkasbon3 as $data) :?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $data['DET_KB_ITEM']; ?></td>
                                                        <td><?= number_format($data['DET_KB_VALUE']); ?></td>
                                                        <td><?= number_format($data['DET_KB_END_VALUE']); ?></td>
                                                        <td><?= number_format($data['DET_KB_DIFF']); ?></td>
                                                    </tr>
                                                    <?php
                                                    $where = array(
                                                        'DET_KB_ID' => $data['DET_KB_ID'],
                                                        );
                                                    $real = $this->Model_online->findAllDataWhere($where,'tr_detail_real');
                                                    foreach($real as $real) :
                                                    ?>
                                                    <tr>
                                                    <td><i class="fas fa-file-export"></i></td>
                                                    <td colspan="2"><?= $real['REAL_NAME'];?></td>
                                                    <td><?= number_format($real['REAL_VALUE']);?></td>
                                                    <td>
                                                    <a href="<?php echo base_url()?>assets/doc-kasbon/<?= $real['REAL_PHOTO']; ?>" target="_blank">
                                                    <?= $real['REAL_PHOTO'];?>
                                                    </a>
                                                    </td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                    <?php endforeach?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->                        
                </div><!--/col-->
            </div>
            <!-- /row tampilan data-->
            <!-- open row timeline -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Timeline Pengajuan Kasbon ID - <?= $kasbon['KB_ID'];?></h3> 
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="timeline">
                                
                                <!-- timeline time label -->
                                
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div>
                                    <i class="fas fa-envelope bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> <?= date("d-m-Y | H:i:s",strtotime($kasbon['KB_SUBMIT_DATE'])) ?></span>
                                        <h3 class="timeline-header"><a href="#">Pengajuan Awal Kasbon ID : <?= $kasbon['KB_ID'];?> </a></h3>
                                        <?php
                                        $whereID = array(
                                            'tak.KB_ID' => $kasbon['KB_ID'],
                                        );
                                        $getNameID = $this->Model_online->findLeaderKB($whereID);
                                        ?>
                                        <div class="timeline-body">
                                           Diajukan Kepada  <?= $getNameID; ?>
                                        </div>
                                    
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <?php
                                $kondisi = array(
                                    'tak.KB_ID' => $kasbon['KB_ID'],
                                );
                                $app = $this->Model_online->findApprovalKB($kondisi);
                                foreach($app as $app):
                                ?>
                                <!-- timeline item -->
                                <div>
                                    <?php
                                    if($app['TR_KB_APP_STATUS'] == '0' && $app['EMP_ID']=='EMP/003/009'){
                                        $status = 'Menunggu Konfirmasi Pengeluaran Dana Dari Finance';
                                        $statusWarna = 'fa-paper-plane bg-yellow';
                                    }elseif($app['TR_KB_APP_STATUS'] == '0'){
                                        $status = 'Menunggu Persetujuan '.$app['EMP_FULL_NAME'];
                                        $statusWarna = 'fa-paper-plane bg-yellow';
                                    }elseif($app['TR_KB_APP_STATUS'] == '1'){
                                        $status = 'Telah Disetujui '.$app['EMP_FULL_NAME'];
                                        $statusWarna = 'fa-user-check bg-green';
                                    }elseif($app['TR_KB_APP_STATUS'] == '2'){
                                        $status = 'Permohonan Ditolak Oleh '.$app['EMP_FULL_NAME'] . '. <b>Alasan: ' . $app['TR_APP_COMMENT'] . '</b>';
                                        $statusWarna = 'fa-times-circle bg-red';
                                    }elseif($app['TR_KB_APP_STATUS'] == '3'){
                                        $status = 'Telah Disetujui '.$app['EMP_FULL_NAME'].' & Menunggu Release FA';
                                        $statusWarna = 'fa-user-check bg-green';
                                    }else{
                                        if(!empty($kasbon['KB_TRANSFER_DATE'])){
                                            if(date("Y-m-d") > $kasbon['KB_TRANSFER_DATE']){
                                                $status = 'Telah Direlease FA';
                                            }else{
                                                $status = 'Telah Dijadwalkan Release FA pada '.$kasbon['KB_TRANSFER_DATE'];
                                            }
                                        }else{
                                            $status = 'Telah Direlease FA';
                                        }
                                        $statusWarna = 'fa-user-check bg-green';
                                    }
                                    ?>
                                    <i class="fas <?= $statusWarna?>"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> <?= $app['TR_KB_APP_DATE'] == '' ? 'Menunggu Persetujuan ' :  $app['TR_KB_APP_DATE'];?> </span>
                                        <h3 class="timeline-header"><a href="#">Approval ID :  <?= $app['TR_KB_APP_ID'] ?></a></h3>
                                        <?php
                                        $getNameID = $app['EMP_FULL_NAME'];
                                        ?>
                                        <div class="timeline-body">
                                           <?php 
                                           echo $status;
                                           ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- END timeline item -->
                                <?php endforeach ?>
                                <?php
                                if($kasbon['KB_STATUS'] == '6'){
                                ?>
                                <div>
                                <i class="far fa-thumbs-up bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> <?= date("d-m-Y | H:i:s",strtotime($kasbon['KB_REPORT_DATE'])) ?></span>
                                        <h3 class="timeline-header"><a href="#">Kelengkapan Laporan Kasbon ID : <?= $kasbon['KB_ID'];?> </a></h3>
                                        <?php
                                        $whereID = array(
                                            'tak.KB_ID' => $kasbon['KB_ID'],
                                        );
                                        $getNameID = $this->Model_online->findLeaderKB($whereID);
                                        ?>
                                        <div class="timeline-body">
                                           Laporan Telah Dilengkapi Dengan Selisih Rp. <?= $kasbon['KB_DIFF'];?>
                                        </div>
                                    
                                    </div>
                                </div>
                                <?php
                                }elseif($kasbon['KB_STATUS'] == '4' && (date("Y-m-d") >= $kasbon['KB_TRANSFER_DATE'])){
                                ?>
                                <div>
                                <i class="fas fa-question bg-yellow"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> Menunggu Kelengkapan Laporan</span>
                                        <h3 class="timeline-header"><a href="#">Laporan Kasbon ID : <?= $kasbon['KB_ID'];?> </a></h3>
                                        <div class="timeline-body">
                                           Menunggu Kelengkapan Laporan
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                                <div>
                                    <i class="fas fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row timeline -->
        
        <!-- Bagian Else | untuk data yang sudah diajukan -->
        <?php
        } else {
        ?>
            <!-- open row edit -->
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Detail Kasbon ID - <?= $kasbon['KB_ID'];?> </h3>
                        </div>                           
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="<?php echo base_url().'Kasbon/insDetKB'?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Keterangan</label>
                                            <input type="hidden" name="insID" class="form-control" value="<?= $kasbon['KB_ID'];?>" autocomplete="off">
                                            <input type="text" name="insNama" class="form-control" placeholder="Masukkan Keterangan" autocomplete="off" required>
                                        </div>
                                    </div><!--endcol-->
                                </div><!--endrow-->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="hargaitem">Masukkan Nominal</label>
                                            <input type="text" name="insHarga" value="" class="form-control money" id="hargaitem" placeholder="Masukkan Nominal" autocomplete="off" required>
                                            <input type="hidden" name="insTotal" value="<?= $kasbon['KB_TOTAL_AWAL'];?>" class="form-control" placeholder="Masukkan Harga Item" autocomplete="off">
                                        </div>
                                    </div><!--endcol-->
                                </div><!--endrow-->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info" style="float:right">Masukkan Data</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
            <!-- open row tampilan data -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Detail Reimbusement ID - <?= $kasbon['KB_ID'];?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID Detail</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="">
                                <?php $i=1; 
                                foreach($dkasbon as $dkasbon) :
                                ?>
                                    <tr>
                                        <td><?= $dkasbon->DET_KB_ID; ?></td>
                                        <td><?= $dkasbon->DET_KB_ITEM; ?></td>
                                        <td><?= number_format($dkasbon->DET_KB_VALUE); ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <span data-toggle="tooltip" data-placement="top" title="Edit">
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-update-<?= str_replace('/','',$dkasbon->DET_KB_ID); ?>"><i class="fas fa-edit"></i></button>
                                                </span>
                                                <span data-toggle="tooltip" data-placement="top" title="Hapus">
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$dkasbon->DET_KB_ID); ?>"><i class="fas fa-trash-alt"></i></button> 
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- modal delete -->
                                    <div class="modal fade" id="modal-delete-<?= str_replace('/','',$dkasbon->DET_KB_ID); ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <form role="form" action="<?php echo base_url().'Kasbon/delDetKB'?>" method="POST" enctype="multipart/form-data">
                            
                                            <div class="modal-header" style="background-color:#dc3545;color:white;">
                                                <h5 class="modal-title ">Delete Item - <?= $dkasbon->DET_KB_ID; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="delnama">Keterangan</label>
                                                            <input type="text" name="delNama" class="form-control" value="<?= $dkasbon->DET_KB_ITEM; ?>" readonly>
                                                            <input type="hidden" name="delID" class="form-control" value="<?= $dkasbon->DET_KB_ID; ?>" readonly>
                                                            <input type="hidden" name="delIDUtama" class="form-control" value="<?= $dkasbon->KB_ID; ?>" readonly>
                                                            <input type="hidden" name="delTotal" value="<?= $kasbon['KB_TOTAL_AWAL'];?>" class="form-control" placeholder="Masukkan Harga Item" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="delharga">Nominal</label>
                                                            <input type="text" name="delHarga" class="form-control money" value="<?= $dkasbon->DET_KB_VALUE; ?>" readonly>
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
                                    <!-- modal update -->
                                    <div class="modal fade" id="modal-update-<?= str_replace('/','',$dkasbon->DET_KB_ID); ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <form role="form" action="<?php echo base_url().'Kasbon/upDetKB'?>" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header" style="background-color:#FFC107;">
                                                <h5 class="modal-title">Update Item</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="text" name="upNama" class="form-control" value="<?= $dkasbon->DET_KB_ITEM; ?>" required>
                                                            <input type="hidden" name="upIDDet" class="form-control" value="<?= $dkasbon->DET_KB_ID; ?>">
                                                            <input type="hidden" name="upID" class="form-control" value="<?= $dkasbon->KB_ID; ?>">
                                                            <input type="hidden" name="upTotal" value="<?= $kasbon['KB_TOTAL_AWAL'];?>" class="form-control" placeholder="Masukkan Harga Item" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Nominal</label>
                                                            <input type="text" name="upHarga" class="form-control money" value="<?= $dkasbon->DET_KB_VALUE; ?>" required>
                                                            <input type="hidden" name="upHargaLama" class="form-control money" value="<?= $dkasbon->DET_KB_VALUE; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                            </div>
                                            </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal Update-->                       
                                <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <?php
                        $whereCek = array(
                            'KB_ID' => $kasbon['KB_ID'],
                        ); 
                        $countCek = $this->Model_online->countRowWhere('tr_detail_kasbon',$whereCek);
                        if($countCek>0){
                        ?>
                        <div class="card-footer">
                            <?php
                            //mengecek apakah user yang login memiliki atasan ?
                            $empID = $this->session->userdata('EMP_ID');
                            $whereLeader = array(
                                'EMP_ID_MEMBER' => $empID,
                            );
                            $cekAdaLeader = $this->Model_online->countRowWhere('tr_supervision',$whereLeader);
                            //mengecek apakah leadernya memiliki status 5
                            $whereCek = array(
                            'ts.EMP_ID_MEMBER' => $empID,
                            'me.LEAD_STATUS' => '5',
                            );
                            $direksi = $this->Model_online->direksi($whereCek);
                            $whereparam = array(
                            'ID_PARAM' => 'PR/0002', 
                            ); 
                            $param = $this->Model_online->findSingleDataWhere($whereparam, 'm_param');
                            if($kasbon['KB_TOTAL_AWAL']<=$param['VALUE_PARAM'] && $direksi>0){
                            ?>
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-FA">
                                Lanjutkan Release Ke FA
                                </button>
                            <?php    
                            }else{
                            if($cekAdaLeader>0){ // kalau ybs punya leader dan ybs bukan FA
                                //cari siapa leadernya
                                $row = $this->db->where('EMP_ID_MEMBER',$empID)->get('tr_supervision')->row_array();
                                $LEADER_ID = $row['EMP_ID_LEADER'];
                                // cari email leadernya
                                $row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
                                $leaderName = $row2['EMP_FULL_NAME'];
                            ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-default">
                                    Lanjutkan Pengajuan Ke <?= $leaderName;?>
                                    </button>
                                    </div>
                                </div>
                            <?php
                            }elseif($cekAdaLeader<=0){ // kalau ybs tidak punya leader alias TOP
                            ?>
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-FA">
                                Lanjutkan Release Ke FA
                                </button>
                            <?php
                            }
                            }
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                        </div>
                        <!-- /.card -->
                        <!-- modal atasan -->
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form role="form" action="<?php echo base_url().'Kasbon/insAppLeader'?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header" style="background-color:#28a745;color:white;">
                                        <h5 class="modal-title">Summary Kasbon ID - <?= $kasbon['KB_ID'];?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Nama Karyawan</label>
                                                    <?php
                                                    $arr_emp2 = array(
                                                        'EMP_ID' => $kasbon['EMP_ID'],
                                                    );
                                                    $em2 = $this->Model_online->findSingleDataWhere($arr_emp2, 'm_employee');
                                                    ?>
                                                    <input type="text" class="form-control"  value="<?= $em2['EMP_FULL_NAME'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>ID Kasbon</label>
                                                    <input type="text" name='insAppIdReim' class="form-control" value="<?= $kasbon['KB_ID'];?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Total Kasbon</label>
                                                    <input type="text" class="form-control money" value="<?= $kasbon['KB_TOTAL_AWAL'];?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Keterangan</th>
                                                        <th>Nominal</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="">
                                                    <?php
                                                    $i=1;
                                                    ?>
                                                    <?php foreach($dkasbon2 as $dkasbon2) :?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $dkasbon2['DET_KB_ITEM']; ?></td>
                                                        <td><?= number_format($dkasbon2['DET_KB_VALUE']); ?></td>
                                                    </tr>
                                                    
                                                    <?php endforeach?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Kirim</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- Modal FA -->
                        <div class="modal fade" id="modal-FA">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form role="form" action="<?php echo base_url().'Kasbon/insAppFA'?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header" style="background-color:#28a745;color:white;">
                                        <h5 class="modal-title">Summary Kasbon ID - <?= $kasbon['KB_ID'];?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Nama Karyawan</label>
                                                    <?php
                                                    $arr_emp1 = array(
                                                        'EMP_ID' => $kasbon['EMP_ID'],
                                                    );
                                                    $em1 = $this->Model_online->findSingleDataWhere($arr_emp1, 'm_employee');
                                                    ?>
                                                    <input type="text" class="form-control"  value="<?= $em1['EMP_FULL_NAME'];?>" readonly>
                                                    <input type="text" class="form-control"  value="<?= $this->session->userdata('EMP_FULL_NAME');?>" readonly>
                                                    <input type="hidden" name="insAppIdEmp" class="form-control"  value="<?= $this->session->userdata('EMP_ID');?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>ID Kasbon</label>
                                                    <input type="text" name='insAppIdReim' class="form-control" value="<?= $kasbon['KB_ID'];?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Total Kasbon</label>
                                                <input type="text" class="form-control money" value="<?= $kasbon['KB_TOTAL_AWAL'];?>" disabled>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table id="example2" class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Keterangan</th>
                                                        <th>Nominal</th>
                                                        
                                                    </tr>
                                                    </thead>
                                                    <tbody class="">
                                                    <?php
                                                    $i=1;
                                                    ?>
                                                    <?php foreach($dkasbon3 as $dkasbon2x) :?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $dkasbon2x['DET_KB_ITEM']; ?></td>
                                                        <td><?= number_format($dkasbon2x['DET_KB_VALUE']); ?></td>
                                                    </tr>
                                                    <?php endforeach?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Kirim</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    
                        
                        
                </div><!--/col-->
            </div>
            <!-- /row -->
        <?php
        } //end else
        ?>
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->