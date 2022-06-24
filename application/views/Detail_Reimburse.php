<?php
//Min Transaction Date
if(date("d") <= 10){
    $minDate = date("Y-m-01", strtotime("-1 MONTH"));
}else{
    $minDate = date("Y-m-01");
}
?>
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
                        <li class="breadcrumb-item">Reimbursement</li>
                        <li class="breadcrumb-item active">Detail</li>
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
            $cek = $this->Model_online->cekPengajuan($id_re);
            if ($cek > 0) {
            ?>
                <!-- open row tampilan data -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3 class="card-title">Data Detail Reimbusement ID - <?= $id_re; ?></h3>
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
                                            <th>ID Item</th>
                                            <th>Keterangan</th>
                                            <th>Nominal</th>
                                            <th>Foto Nota</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <?php $i = 1; ?>
                                        <?php foreach ($dreim as $dreimx) : ?>
                                            <tr>
                                                <td><?= $dreimx->DET_RB_ID; ?></td>
                                                <td><?= $dreimx->DET_RB_ITEM; ?></td>
                                                <td><?= number_format($dreimx->DET_RB_VALUE); ?></td>
                                                <td><a href="<?php echo base_url() ?>assets/dokumen/<?= $dreimx->DET_RB_PHOTO; ?>" target="_blank"><img src="<?php echo base_url() ?>assets/dokumen/<?= $dreimx->DET_RB_PHOTO; ?>" width="75px"></a></td>
                                            </tr>
                                        <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-defaultx">
                                    Summary Reimburse
                                </button>
                            </div>
                        </div>
                        <!-- /.card -->
                        <!-- modal summary -->
                        <div class="modal fade" id="modal-defaultx">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" action="<?php echo base_url() . 'Reimbursement/insertApproval' ?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#28a745;color:white;">
                                            <h5 class="modal-title">Summary Reimbusement ID - <?= $id_re; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-nama">Nama Karyawan</label>
                                                        <input type="text" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_FULL_NAME'); ?>" readonly>
                                                        <input type="hidden" name="insAppIdEmp" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_ID'); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-id">ID Reimbusement</label>
                                                        <input type="text" name='insAppIdReim' class="form-control" id="dis-id" value="<?= $id_re; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-total">Total Reimbusement</label>
                                                        <input type="text" class="form-control money" id="dis-total" value="<?= $RB_TOTAL; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Realisasi Transfer</label>
                                                        <input type="date" name='tglRealisasi' class="form-control" value="<?= $RB_TRANSFER_DATE ?>" readonly>
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
                                                                <th>Foto Nota</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                            <?php
                                                            $i = 1; ?>
                                                            <?php foreach ($dreim2 as $data) : ?>
                                                                <tr>
                                                                    <td><?= $i++; ?></td>
                                                                    <td><?= $data->DET_RB_ITEM; ?></td>
                                                                    <td><?= number_format($data->DET_RB_VALUE); ?></td>
                                                                    <td><a href="<?php echo base_url() ?>assets/dokumen/<?= $data->DET_RB_PHOTO; ?>" target="_blank"><?= $data->DET_RB_PHOTO; ?></a></td>

                                                                </tr>

                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->



                    </div>
                    <!--/col-->
                </div>
                <!-- /row tampilan data-->
                <!-- open row timeline -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Timeline Pengajuan Reimbursement ID - <?= $id_re; ?></h3>
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
                                            <span class="time"><i class="fas fa-clock"></i> <?= date("d-m-Y | H:i:s", strtotime($row['RB_SUBMIT_DATE'])) ?></span>
                                            <h3 class="timeline-header"><a href="#">Pengajuan Awal Reimbursement ID : <?= $row['RB_ID']; ?> </a></h3>
                                            <?php
                                            $whereID = array(
                                                'ta.RB_ID' => $row['RB_ID'],
                                            );
                                            $getNameID = $this->Model_online->findLeader($whereID);
                                            ?>
                                            <div class="timeline-body">
                                                Diajukan Kepada <?= $getNameID; ?>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    <?php
                                    $kondisi = array(
                                        'ta.RB_ID' => $row['RB_ID'],
                                    );
                                    $app = $this->Model_online->findApproval($kondisi);
                                    foreach ($app as $app) :
                                    ?>
                                        <!-- timeline item -->
                                        <div>
                                            <?php
                                            if ($app['TR_APP_STATUS'] == '0' && $app['EMP_ID'] == 'EMP/003/009') {
                                                $status = 'Menunggu Konfirmasi Pengeluaran Dana Dari Finance';
                                                $statusWarna = 'fa-paper-plane bg-yellow';
                                            } elseif ($app['TR_APP_STATUS'] == '0') {
                                                $status = 'Menunggu Persetujuan ' . $app['EMP_FULL_NAME'];
                                                $statusWarna = 'fa-paper-plane bg-yellow';
                                            } elseif ($app['TR_APP_STATUS'] == '1') {
                                                $status = 'Telah Disetujui ' . $app['EMP_FULL_NAME'];
                                                $statusWarna = 'fa-user-check bg-green';
                                            } elseif ($app['TR_APP_STATUS'] == '2') {
                                                $status = 'Permohonan Ditolak Oleh ' . $app['EMP_FULL_NAME'] . '. <b>Alasan: ' . $app['TR_APP_COMMENT'] . '</b>';
                                                $statusWarna = 'fa-times-circle bg-red';
                                            } elseif ($app['TR_APP_STATUS'] == '3') {
                                                $status = 'Telah Disetujui ' . $app['EMP_FULL_NAME'] . ' & Menunggu Release FA';
                                                $statusWarna = 'fa-user-check bg-green';
                                            } else {
                                                if(!empty($RB_TRANSFER_DATE)){
                                                    if(date("Y-m-d") > $RB_TRANSFER_DATE){
                                                        $status = 'Telah Direlease FA';
                                                    }else{
                                                        $status = 'Telah Dijadwalkan Release FA pada '.$RB_TRANSFER_DATE;
                                                    }
                                                }else{
                                                    $status = 'Telah Direlease FA';
                                                }
                                                $statusWarna = 'fa-user-check bg-green';
                                            }
                                            ?>
                                            <i class="fas <?= $statusWarna ?>"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> <?= $app['TR_APP_DATE'] == '0000-00-00 00:00:00' ? 'Menunggu Persetujuan ' :  $app['TR_APP_DATE']; ?> </span>
                                                <h3 class="timeline-header"><a href="#">Approval ID : <?= $app['TR_APP_ID'] ?></a></h3>
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
                                <!-- kalau mau ambil 1 data array  
                            -->
                                <h3 class="card-title">Detail Reimbusement ID - <?= $id_re; ?> </h3>
                            </div>

                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="<?php echo base_url() . 'Reimbursement/insertDetReim' ?>" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Keterangan</label>
                                                <input type="hidden" name="insID" class="form-control" value="<?= $id_re; ?>" autocomplete="off">
                                                <input type="text" name="insNama" class="form-control" placeholder="Masukkan Keterangan" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <!--endcol-->
                                    </div>
                                    <!--endrow-->
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="hargaitem">Masukkan Nominal</label>
                                                <input type="text" name="insHarga" value="" class="form-control money" id="hargaitem" placeholder="Masukkan Nominal" autocomplete="off" required>
                                                <input type="hidden" name="insTotal" value="<?= $RB_TOTAL; ?>" class="form-control" placeholder="Masukkan Harga Item" autocomplete="off">
                                            </div>
                                        </div>
                                        <!--endcol-->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Foto Nota / Lampiran Pendukung</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="insNota" class="custom-file-input" id="exampleInputFile" accept="image/png, image/gif, image/jpeg, image/jpg" required>
                                                        <label class="custom-file-label" for="exampleInputFile">Klik Untuk Pilih File</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Tanggal Nota</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="date" name="trDate" class="form-control" min="<?= $minDate ?>" max="<?= date("Y-m-d") ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--endcol-->
                                        <label for="exampleInputFile"><i>NB: Transaksi hanya bisa diklaim maksimal tgl 10 bulan berikutnya</i></label>
                                    </div>
                                    <!--endrow-->
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
                                <h3 class="card-title">Data Detail Reimbusement ID - <?= $id_re; ?></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Item</th>
                                            <th>Keterangan</th>
                                            <th>Nominal</th>
                                            <th>Foto Nota</th>
                                            <th>Tgl Transaksi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <?php $i = 1; ?>
                                        <?php foreach ($dreim as $dreim) : ?>
                                            <tr>
                                                <td><?= $dreim->DET_RB_ID; ?></td>
                                                <td><?= $dreim->DET_RB_ITEM; ?></td>
                                                <td><?= number_format($dreim->DET_RB_VALUE); ?></td>
                                                <td><a href="<?php echo base_url() ?>assets/dokumen/<?= $dreim->DET_RB_PHOTO; ?>" target="_blank"><img src="<?php echo base_url() ?>assets/dokumen/<?= $dreim->DET_RB_PHOTO; ?>" width="75px"></a></td>
                                                <td><?= $dreim->DET_RB_TRANSACTION_DATE; ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <span data-toggle="tooltip" data-placement="top" title="Edit Data">
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-update-<?= str_replace('/', '', $dreim->DET_RB_ID); ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </span>
                                                        <span data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/', '', $dreim->DET_RB_ID); ?>"><i class="fas fa-trash-alt"></i></button>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- modal delete -->
                                            <div class="modal fade" id="modal-delete-<?= str_replace('/', '', $dreim->DET_RB_ID); ?>">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form role="form" action="<?php echo base_url() . 'Reimbursement/deleteDetReim' ?>" method="POST" enctype="multipart/form-data">

                                                            <div class="modal-header" style="background-color:#dc3545;color:white;">
                                                                <h5 class="modal-title ">Delete Item - <?= $dreim->DET_RB_ID; ?></h5>

                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="delnama">Keterangan</label>
                                                                            <input type="text" name="delNama" class="form-control" value="<?= $dreim->DET_RB_ITEM; ?>" readonly>
                                                                            <input type="hidden" name="delID" class="form-control" value="<?= $dreim->DET_RB_ID; ?>" readonly>
                                                                            <input type="hidden" name="delIDUtama" class="form-control" value="<?= $dreim->RB_ID; ?>" readonly>
                                                                            <input type="hidden" name="delTotal" value="<?= $RB_TOTAL; ?>" class="form-control" placeholder="Masukkan Harga Item" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="delharga">Nominal</label>
                                                                            <input type="text" name="delHarga" class="form-control money" value="<?= $dreim->DET_RB_VALUE; ?>" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label for="delfoto">Foto Nota</label>
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" class="custom-file-input" disabled>
                                                                                    <label class="custom-file-label" for="exampleInputFile">Pilih File Foto</label>
                                                                                </div>
                                                                            </div>
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
                                            <div class="modal fade" id="modal-update-<?= str_replace('/', '', $dreim->DET_RB_ID); ?>">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form role="form" action="<?php echo base_url() . 'Reimbursement/updateDetReim' ?>" method="POST" enctype="multipart/form-data">
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
                                                                            <label for="dis-nama">Keterangan</label>
                                                                            <input type="text" name="upNama" class="form-control" value="<?= $dreim->DET_RB_ITEM; ?>" required>
                                                                            <input type="hidden" name="upIDDet" class="form-control" value="<?= $dreim->DET_RB_ID; ?>">
                                                                            <input type="hidden" name="upID" class="form-control" value="<?= $dreim->RB_ID; ?>">
                                                                            <input type="hidden" name="upTotal" value="<?= $RB_TOTAL; ?>" class="form-control" placeholder="Masukkan Harga Item" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="dis-id">Nominal</label>
                                                                            <input type="text" name="upHarga" class="form-control money" value="<?= $dreim->DET_RB_VALUE; ?>" required>
                                                                            <input type="hidden" name="upHargaLama" class="form-control money" value="<?= $dreim->DET_RB_VALUE; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label for="upfoto">Update Foto Nota</label>
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" name="upNota" class="custom-file-input">
                                                                                    <label class="custom-file-label" for="exampleInputFile">Pilih File Foto</label>
                                                                                </div>
                                                                            </div>
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

                                        <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <?php
                            $whereCek = array(
                                'RB_ID' => $id_re,
                            );
                            $countCek = $this->Model_online->countRowWhere('tr_detail_reimburse', $whereCek);
                            if ($countCek > 0) {
                            ?>
                                <div class="card-footer">

                                    <?php
                                    //mengecek apakah user yang login memiliki atasan ?
                                    $empID = $this->session->userdata('EMP_ID');
                                    $whereLeader = array(
                                        'EMP_ID_MEMBER' => $empID,
                                    );
                                    $cekAdaLeader = $this->Model_online->countRowWhere('tr_supervision', $whereLeader);
                                    $whereFA = array(
                                        'EMP_ID' => $empID,
                                        'DEPART_ID' => 'DP/003',
                                    );
                                    $cekDiaFA = $this->Model_online->countRowWhere('m_employee', $whereFA);
                                    //mengecek apakah leadernya memiliki status 5
                                    $whereCek = array(
                                        'ts.EMP_ID_MEMBER' => $empID,
                                        'me.LEAD_STATUS' => '5',
                                    );
                                    $direksi = $this->Model_online->direksi($whereCek);
                                    $whereCekNew = array(
                                        'me.LEAD_STATUS' => '5',
                                        'me.EMP_ID' => $empID,
                                    );
                                    $direksiNew = $this->Model_online->direksiNew($whereCekNew);
                                    $whereCekNewFA = array(
                                        "EMP_ID" => "EMP/003/009",
                                    );
                                    $direksiNewFA = $this->Model_online->direksiNewFA($whereCekNewFA);
                                    $whereFamng = array(
                                        'DEPART_ID' => 'DP/003',
                                        'LEAD_STATUS' => '4',
                                    );
                                    $paramMng = $this->Model_online->findSingleDataWhere($whereFamng, 'm_employee');
                                    $whereparam = array(
                                        'ID_PARAM' => 'PR/0002',
                                    );
                                    $param = $this->Model_online->findSingleDataWhere($whereparam, 'm_param');
                                    if ($direksi > 0 && $direksiNew == 0) {
                                    ?>

                                        <button type="button" data-toggle="modal" data-target="#modal-fappMngFa" class="btn btn-block btn-success">Persetujuan Final & Kirim Ke Manajer FA</button>
                                    <?php
                                    } elseif ($RB_TOTAL <= $param['VALUE_PARAM'] && $direksiNew > 0 && $direksiNewFA <= 0) {
                                    ?>
                                        <div class="col-md-6">
                                            <button type="button" data-toggle="modal" data-target="#modal-fapp" class="btn btn-block btn-success">Persetujuan Final & Kirim Ke FA</button>
                                        </div>
                                        <?php
                                    } else {
                                        if ($cekAdaLeader > 0 && $cekDiaFA <= 0) { // kalau ybs punya leader dan ybs bukan FA
                                            //cari siapa leadernya
                                            $row = $this->db->where('EMP_ID_MEMBER', $empID)->get('tr_supervision')->row_array();
                                            $LEADER_ID = $row['EMP_ID_LEADER'];
                                            // cari email leadernya
                                            $row2 = $this->db->where('EMP_ID', $LEADER_ID)->get('m_employee')->row_array();
                                            $leaderName = $row2['EMP_FULL_NAME'];
                                        ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-default">
                                                        Lanjutkan Pengajuan Ke <?= $leaderName; ?>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php
                                        } elseif ($cekAdaLeader <= 0) { // kalau ybs tidak punya leader alias TOP
                                        ?>
                                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-FA">
                                                Lanjutkan Release Ke FA
                                            </button>
                                        <?php
                                        } elseif ($cekAdaLeader > 0 && $cekDiaFA > 0) { // kalau ybs punya leader dan anggota FA
                                            //cari siapa leadernya
                                            $row = $this->db->where('EMP_ID_MEMBER', $empID)->get('tr_supervision')->row_array();
                                            $LEADER_ID = $row['EMP_ID_LEADER'];
                                            // cari email leadernya
                                            $row2 = $this->db->where('EMP_ID', $LEADER_ID)->get('m_employee')->row_array();
                                            $leaderName = $row2['EMP_FULL_NAME'];
                                        ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-default">
                                                        Lanjutkan Pengajuan Ke <?= $leaderName; ?>
                                                    </button>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                </div>
                            <?php
                            } else {
                            }
                            ?>
                        </div>
                        <!-- /.card -->

                        <!-- Modal Final Approve -->
                        <div class="modal fade" id="modal-fappMngFa">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form role="form" action="<?php echo base_url() . 'Reimbursement/insertAppLeader' ?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#28a745;color:white;">
                                            <h5 class="modal-title">Summary Reimbusement ID - <?= $id_re; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-nama">Nama Karyawan</label>
                                                        <input type="text" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_FULL_NAME'); ?>" readonly>
                                                        <input type="hidden" name="insAppIdEmp" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_ID'); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-id">ID Reimbusement</label>
                                                        <input type="text" name='insAppIdReim' class="form-control" id="dis-id" value="<?= $id_re; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="dis-total">Total Reimbusement</label>
                                                        <input type="text" class="form-control money" id="dis-total" value="<?= $RB_TOTAL; ?>" disabled>
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
                                                                <th>Foto Nota</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                            <?php
                                                            $i = 1;
                                                            ?>
                                                            <?php foreach ($dreim2 as $data) : ?>
                                                                <tr>
                                                                    <td><?= $i++; ?></td>
                                                                    <td><?= $data->DET_RB_ITEM; ?></td>
                                                                    <td><?= number_format($data->DET_RB_VALUE); ?></td>
                                                                    <td><a href="<?php echo base_url() ?>assets/dokumen/<?= $data->DET_RB_PHOTO; ?>" target="_blank"><?= $data->DET_RB_PHOTO; ?></a></td>

                                                                </tr>

                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" formaction="<?php echo base_url() . 'Reimbursement/insertAppMngFA' ?>" class="btn btn-success">Lanjutkan</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <!-- modal atasan -->
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form role="form" action="<?php echo base_url() . 'Reimbursement/insertAppLeader' ?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#28a745;color:white;">
                                            <h5 class="modal-title">Summary Reimbusement ID - <?= $id_re; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-nama">Nama Karyawan</label>
                                                        <input type="text" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_FULL_NAME'); ?>" readonly>
                                                        <input type="hidden" name="insAppIdEmp" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_ID'); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-id">ID Reimbusement</label>
                                                        <input type="text" name='insAppIdReim' class="form-control" id="dis-id" value="<?= $id_re; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="dis-total">Total Reimbusement</label>
                                                        <input type="text" class="form-control money" id="dis-total" value="<?= $RB_TOTAL; ?>" disabled>
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
                                                                <th>Foto Nota</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                            <?php
                                                            $i = 1;
                                                            ?>
                                                            <?php foreach ($dreim2 as $data) : ?>
                                                                <tr>
                                                                    <td><?= $i++; ?></td>
                                                                    <td><?= $data->DET_RB_ITEM; ?></td>
                                                                    <td><?= number_format($data->DET_RB_VALUE); ?></td>
                                                                    <td><a href="<?php echo base_url() ?>assets/dokumen/<?= $data->DET_RB_PHOTO; ?>" target="_blank"><?= $data->DET_RB_PHOTO; ?></a></td>

                                                                </tr>

                                                            <?php endforeach ?>
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
                                    <form role="form" action="<?php echo base_url() . 'Reimbursement/insertAppFA' ?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header" style="background-color:#28a745;color:white;">
                                            <h5 class="modal-title">Summary Reimbusement ID - <?= $id_re; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-nama">Nama Karyawan</label>
                                                        <input type="text" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_FULL_NAME'); ?>" readonly>
                                                        <input type="hidden" name="insAppIdEmp" class="form-control" id="dis-nama" value="<?= $this->session->userdata('EMP_ID'); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="dis-id">ID Reimbusement</label>
                                                        <input type="text" name='insAppIdReim' class="form-control" id="dis-id" value="<?= $id_re; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="dis-total">Total Reimbusement</label>
                                                        <input type="text" class="form-control money" id="dis-total" value="<?= $RB_TOTAL; ?>" disabled>
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
                                                                <th>Foto Nota</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                            <?php
                                                            $i = 1;
                                                            ?>
                                                            <?php foreach ($dreim2 as $data) : ?>
                                                                <tr>
                                                                    <td><?= $i++; ?></td>
                                                                    <td><?= $data->DET_RB_ITEM; ?></td>
                                                                    <td><?= number_format($data->DET_RB_VALUE); ?></td>
                                                                    <td><a href="<?php echo base_url() ?>assets/dokumen/<?= $data->DET_RB_PHOTO; ?>" target="_blank"><?= $data->DET_RB_PHOTO; ?></a></td>

                                                                </tr>

                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Pilih Karyawan FA</label>
                                                <select name="insFA" class="form-control">
                                                    <?php
                                                    $whereFA = array(
                                                        'DEPART_ID' => 'DP/003',
                                                    );
                                                    $memberFA = $this->Model_online->findAllDataWhere($whereFA, 'm_employee');
                                                    foreach ($memberFA as $memberFA) : ?>
                                                        <option value="<?= $memberFA['EMP_ID']; ?>"><?= $memberFA['EMP_FULL_NAME']; ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div> -->
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
                    <!--/col-->
                </div>
                <!-- /row -->
            <?php
            } //end else
            ?>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->