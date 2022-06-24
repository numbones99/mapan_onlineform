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
              <li class="breadcrumb-item active">Kasbon</li>
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
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>Kasbon Baru</h3>
                    <p>Membuat atau memasukkan Kasbon baru</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-single">
                    Masukkan Kasbon <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- modal -->
        <div class="modal fade" id="modal-single">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                <h4 class="modal-title text-center">Konfirmasi Pembuatan Kasbon</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body text-center">
                <p><b>Apakah Anda Yakin Untuk Membuat Kasbon Baru?</b></p>
                <hr>
                <p>Silahkan klik tombol Lanjutkan untuk membuat<br>Kasbon Baru</p>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="<?php echo base_url().'Kasbon/insKasbon'?>"><button type="button" class="btn btn-warning">Lanjutkan</button></a>
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
                //mengecek apakah ada data pengajuan kasbon baru ?
                $empID = $this->session->userdata('EMP_ID');
                $whereAdaBaru = array(
                'EMP_ID' => $empID,
                'KB_SUBMIT_DATE' => null,
                );
                $cekAdaDataBaru = $this->Model_online->countRowWhere('tr_kasbon',$whereAdaBaru);
                if($cekAdaDataBaru>0){
                ?>
                    <!-- card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Kasbon Baru Karyawan : <?= $this->session->userdata('EMP_FULL_NAME')?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>ID Kasbon</th>
                                    <th>Total Kasbon</th>
                                    <th>Jumlah Item</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            <tbody class="">
                            <?php foreach($kasbon as $kasbon) :?>
                                <tr>
                                    <td><?php
                                    echo  ($kasbon->KB_SUBMIT_DATE == '') ? 'Belum Diajukan' : $kasbon->KB_SUBMIT_DATE; ?></td>
                                    <td><?= $kasbon->KB_ID; ?></td>
                                    <td><?= number_format(''.$kasbon->KB_TOTAL_AWAL.'');?></td>
                                        <?php
                                        $wherehitung = array(
                                            "KB_ID" => $kasbon->KB_ID,
                                        );
                                        $hitung = $this->Model_online->countRowWhere('tr_detail_kasbon',$wherehitung);
                                        ?>
                                    <td><?= $hitung.' Item'; ?></td>
                                    <td class="text-center">
                                    <div class="btn-group">
                                            <span data-toggle="tooltip" data-placement="top" title="Edit / Isi Halaman Detail">
                                            <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$kasbon->KB_ID)?>" class="btn btn-default">
                                            <i class="fas fa-clipboard-list"></i>
                                            </a>
                                            </span>
                                             
                                        <?php if($hitung<1) { ?>
                                            <span data-toggle="tooltip" data-placement="top" title="Hapus Pengajuan">
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$kasbon->KB_ID); ?>">
                                            <i class="fas fa-trash-alt"></i>
                                            </button> 
                                            </span>
                                        <?php } ?>
                                    </div>
                                    </td>
                                </tr>
                                <!-- modal delete -->
                                    <div class="modal fade" id="modal-delete-<?= str_replace('/','',$kasbon->KB_ID); ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                            <form role="form" action="<?php echo base_url().'Kasbon/delKasbon'?>" method="POST" enctype="multipart/form-data">
                            
                                            <div class="modal-header" style="background-color:#dc3545;color:white;">
                                                <h5 class="modal-title ">Delete Kasbon - <?= $kasbon->KB_ID; ?></h5>
                                                
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="delnama">ID Kasbon</label>
                                                            <input type="text" name="delID" class="form-control" value="<?= $kasbon->KB_ID; ?>" readonly>
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
            <!-- untuk div berisi tabel kasbon yang sudah diajukan -->
            <!-- Data Reimbusement yang sudah di ajukan-->
            <div class="col-md-12">
                <!-- general form elements -->
                <?php
                    //mengecek apakah ada data pengajuan Kasbon baru ?
                    $empID = $this->session->userdata('EMP_ID');
                    $whereAda = array(
                    'EMP_ID' => $empID,
                    'KB_SUBMIT_DATE !=' => null,
                    );
                    $cekAdaData = $this->Model_online->countRowWhere('tr_kasbon',$whereAda);
                    if($cekAdaData>0){
                    ?>
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Data Pengajuan Kasbon Karyawan : <?= $this->session->userdata('EMP_FULL_NAME')?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example3" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>ID Kasbon</th>
                                    <th>Total Kasbon</th>
                                    <th>Jumlah Item</th>
                                    <th>Progress</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="">
                            <?php foreach($kasbonAju as $kasbonAju) :?>
                                <tr>
                                    <td><?php
                                    echo  ($kasbonAju->KB_SUBMIT_DATE == '') ? 'Belum Diajukan' : $kasbonAju->KB_SUBMIT_DATE; ?></td>
                                    <td><?= $kasbonAju->KB_ID; ?></td>
                                    <td><?= number_format(''.$kasbonAju->KB_TOTAL_AWAL.'');?></td>
                                    <?php
                                    $where = array(
                                        'KB_ID' => $kasbonAju->KB_ID,
                                    );
                                    $hitung = $this->Model_online->countRowWhere('tr_detail_kasbon',$where);
                                    ?>
                                    <td><?= $hitung.' Item'; ?></td>
                                    <td>
                                        <?php
                                        $kondisi = array(
                                            'tak.KB_ID' => $kasbonAju->KB_ID,
                                        );
                                        $app = $this->Model_online->findApprovalKB($kondisi);
                                        foreach($app as $app):
                                        if($app['TR_KB_APP_STATUS'] == '0' && $app['EMP_ID']=='EMP/003/009'){
                                            $status = 'Menunggu Konfirmasi Pengeluaran Dana Dari Finance';
                                            $statusWarna = 'badge badge-info';
                                        }elseif($app['TR_KB_APP_STATUS'] == '0'){
                                            $status = 'Menunggu Persetujuan '.$app['EMP_FULL_NAME'];
                                            $statusWarna = 'badge badge-warning';
                                        }elseif($app['TR_KB_APP_STATUS'] == '1'){
                                            $status = 'Telah Disetujui '.$app['EMP_FULL_NAME'];
                                            $statusWarna = 'badge badge-success';
                                        }elseif($app['TR_KB_APP_STATUS'] == '2'){
                                            $status = 'Permohonan Ditolak Oleh '.$app['EMP_FULL_NAME'];
                                            $statusWarna = 'badge badge-danger';
                                        }elseif($app['TR_KB_APP_STATUS'] == '3'){
                                            $status = 'Telah Disetujui '.$app['EMP_FULL_NAME'].' & Menunggu Release FA';
                                            $statusWarna = 'badge badge-info';
                                        }else{
                                            if(!empty($kasbonAju->KB_TRANSFER_DATE)){
                                                if(date("Y-m-d") > $kasbonAju->KB_TRANSFER_DATE){
                                                    $status = 'Telah Direlease FA';
                                                }else{
                                                    $status = 'Telah Dijadwalkan Release FA pada '.$kasbonAju->KB_TRANSFER_DATE;
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
                                            <?php
                                            if($kasbonAju->KB_STATUS=='5')
                                            {
                                            ?>
                                            <span class="badge badge-warning">Telah Mengisi Realisasi, Menunggu Persetujuan</span><br>
                                            <?php
                                            }elseif($kasbonAju->KB_STATUS=='4' && (date("Y-m-d") >= $kasbonAju->KB_TRANSFER_DATE)){
                                            ?>
                                            <span class="badge badge-danger">Harap Mengisi Realisasi</span><br>
                                            <?php
                                            }elseif($kasbonAju->KB_STATUS=='6'){
                                            ?>
                                            <span class="badge badge-success">Realisasi Telah Disetujui</span><br>
                                            <?php 
                                            }elseif($kasbonAju->KB_STATUS=='7'){
                                            ?>
                                            <span class="badge badge-danger">Realisasi Ditolak, Harap Mengisi Realisasi Keembali</span><br>
                                            <?php
                                            }
                                            ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <span data-toggle="tooltip" data-placement="top" title="Lihat History">
                                            <a href="<?php echo base_url().'Kasbon/detail/'.str_replace('/','',$kasbonAju->KB_ID)?>" class="btn btn-default"><i class="fas fa-clipboard-list"></i></a> 
                                            </span>
                                            <?php
                                            if($kasbonAju->KB_STATUS=='6')
                                            {
                                            ?>
                                                <form role="form" action="<?php echo base_url().'Laporankasbon'?>" method="POST" enctype="multipart/form-data" target="_blank">
                                                    <input type="hidden" name="cetakIDkb" class="form-control" value="<?= $kasbonAju->KB_ID; ?>" readonly>
                                                    <input type="hidden" name="cetakIDemp" value="<?= $this->session->userdata('EMP_ID'); ?>"/>
                                                    <span data-toggle="tooltip" data-placement="top" title="Cetak Laporan PDF">
                                                    <button type="submit" class="btn btn-default" ><i class="fas fa-print"></i></button> 
                                                    </span>
                                                </form>
                                            <?php
                                            }elseif($kasbonAju->KB_STATUS=='4' || $kasbonAju->KB_STATUS=='7'){
                                            ?>
                                                <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Realisasi">
                                                <a href="<?php echo base_url().'Kasbon/report/'.str_replace('/','',$kasbonAju->KB_ID)?>" class="btn btn-default"><i class="fas fa-file-signature"></i></a> 
                                                </span>
                                            <?php    
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <!-- modal delete -->
                                <div class="modal fade" id="modal-delete-<?= str_replace('/','',$kasbonAju->KB_ID); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Kasbon/delRB'?>" method="POST" enctype="multipart/form-data">
                        
                                        <div class="modal-header" style="background-color:#dc3545;color:white;">
                                            <h5 class="modal-title ">Delete Kasbon - <?= $kasbonAju->KB_ID; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="delnama">ID Kasbon</label>
                                                        <input type="text" name="delID" class="form-control" value="<?= $kasbonAju->KB_ID; ?>" readonly>
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
            <!-- //untuk div berisi tabel kasbon yang sudah diajukan -->
        </div>
        <!-- /.row -->


    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->