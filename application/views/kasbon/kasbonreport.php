<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Laporan Kasbon - ID : <?= $kasbon['KB_ID'];?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item">Kasbon</li>
              <li class="breadcrumb-item active">Report</li>
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
        <?php if($hitDKasbon > 0){
        ?>
            <div class="row">
                <!-- Data Kasbon Baru column -->
                <div class="col-lg-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Keterangan Yang Harus Dilengkapi</h3>
                        </div>
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
                                <tbody>
                                <?php
                                $i = 1;
                                foreach($dkasbon as $dkasbon) :
                                ?>
                                <tr>
                                    <td><?= $dkasbon['DET_KB_ID']; ?></td>
                                    <td><?= $dkasbon['DET_KB_ITEM']; ?></td>
                                    <td><?= number_format($dkasbon['DET_KB_VALUE']); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                        <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Detail Realisasi">
                                        <a href="<?php echo base_url().'Kasbon/dtreport/'.str_replace('/','',$dkasbon['DET_KB_ID'])?>" class="btn btn-default">
                                        <i class="fas fa-lg fa-file-invoice-dollar"></i>
                                        </a>
                                        </span>
                                        </div>
                                    </td>
                                </tr>
                                

                                <!-- modal insert -->
                                <div class="modal fade" id="modal-ins-<?= str_replace('/','',$dkasbon['DET_KB_ID']); ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <form role="form" action="<?php echo base_url().'Kasbon/insReport'?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#5bc0de;">
                                            <h5 class="modal-title" style="color:white"> <strong>Laporan <?= $dkasbon['DET_KB_ITEM'];?></strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" name="insIDDet" class="form-control" value="<?= $dkasbon['DET_KB_ID']; ?>" readonly>
                                                        <input type="hidden" name="insIDKB" class="form-control" value="<?= $dkasbon['KB_ID']; ?>">
                                                        <input type="hidden" name="insTotalAwal" class="form-control" value="<?= $kasbon['KB_TOTAL_AWAL'];?>">
                                                        <input type="hidden" name="insTotalAkhir" class="form-control" value="<?= $kasbon['KB_TOTAL_AKHIR'];?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Nominal</label>
                                                        <input type="text" name="insValueAwal" class="form-control money" value="<?= $dkasbon['DET_KB_VALUE']; ?>" readonly>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Foto Nota / Lampiran Pendukung</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                            <input type="file" name="insNota" class="custom-file-input" id="exampleInputFile" required>
                                                            <label class="custom-file-label" for="exampleInputFile">Klik Untuk Pilih File</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Nominal Laporan</label>
                                                        <input type="text" name="insValueAkhir" class="form-control money" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-info">Kirim</button>
                                        </div>
                                        </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal Update-->
                                <?php
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        <?php } if($hitDKasbonIsi > 0) { 
        ?>
            <div class="row">
                <!-- Data Kasbon Baru column -->
                <div class="col-lg-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Keterangan Yang Sudah Dilengkapi </h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Detail</th>
                                        <th>Keterangan</th>
                                        <th>Nominal Awal</th>
                                        <th>Nominal Akhir</th>
                                        <th style="width: 12%;">Selisih</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                foreach($dkasbon2 as $dkasbon2) :
                                ?>
                                <tr>
                                    <td><?= $dkasbon2['DET_KB_ID']; ?></td>
                                    <td><?= $dkasbon2['DET_KB_ITEM']; ?></td>
                                    <td><?= 'Rp. '.number_format($dkasbon2['DET_KB_VALUE']); ?></td>
                                    <td><?= 'Rp. '.number_format($dkasbon2['DET_KB_END_VALUE']); ?></td>
                                    <td><?= 'Rp. '.number_format($dkasbon2['DET_KB_DIFF']); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                        <span data-toggle="tooltip" data-placement="top" title="Ke Halaman Detail Realisasi">
                                        <a href="<?php echo base_url().'Kasbon/dtreport/'.str_replace('/','',$dkasbon2['DET_KB_ID'])?>" class="btn btn-default">
                                        <i class="fas fa-lg fa-file-invoice-dollar"></i>
                                        </a>
                                        </span>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-summary">
                                Kirim Laporan 
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <!-- Modal -->
                    <!-- modal atasan -->
                    <div class="modal fade" id="modal-summary">
                        <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form role="form" action="<?php echo base_url().'Kasbon/sendReport'?>" method="POST" enctype="multipart/form-data">
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
                                                    <input type="text" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_FULL_NAME');?>" readonly>
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
                                                    $panjangreal = count($real);
                                                    ?>
                                                    <?php foreach($real as $real) :?>
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
                                        <button type="submit" class="btn btn-success">Kirim</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        <?php }?>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->