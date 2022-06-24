<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Approval Perbaikan Aset</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form</a></li>
              <li class="breadcrumb-item">Perbaikan Aset</li>
              <li class="breadcrumb-item active">Penjadwalan</li>
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
                    <form role="form" action="<?php echo base_url().'Aset/accApp'?>" method="POST" enctype="multipart/form-data">  
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Detail Approval Perbaikan Aset | Repair ID : <?= $nama['RP_ID']?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ID Repair</label>
                                            <input type="text" name='idReim' class="form-control" value="<?= $nama['RP_ID']?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Applicant</label>
                                            <input type="text" name='namaReim' class="form-control" value="<?= $nama['nama']?>" readonly>
                                            <input type="hidden" name='idApp' class="form-control" value="<?= $this->uri->segment(3)?>">
                                            <input type="hidden" name='idKB' class="form-control" value="<?= $nama['RP_ID']?>">
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                $wheredp = array(
                                    'DEPART_ID' => $nama['DEPART_ID'],
                                );
                                $depart = $this->Model_online->findSingleDataWhere($wheredp, 'm_department');
                                $wherebr = array(
                                    'BRANCH_ID' => $depart['BRANCH_ID'],
                                );
                                $branch = $this->Model_online->findSingleDataWhere($wherebr, 'm_branch'); 
                                ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Branch</label>
                                            <input type="text" name='idReim' class="form-control" value="<?= $depart['DEPART_NAME']?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Department</label>
                                            <input type="text" name='namaReim' class="form-control" value="<?= $branch['BRANCH_NAME']?>" readonly>
                                            <input type="hidden" name='idApp' class="form-control" value="<?= $this->uri->segment(3)?>">
                                            <input type="hidden" name='idKB' class="form-control" value="<?= $nama['RP_ID']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jumlah Item</label>
                                            <input type="text" name='namaReim' class="form-control" value="<?= count($det);?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example3" class="table table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Nama Aset</th>
                                                <th>Keterangan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($det as $detail) :
                                                $whereAset = array(
                                                    'ASSET_CODE' => $detail['ASSET_CODE'],
                                                );
                                                $aset = $this->Model_online->findSingleDataWhere($whereAset, 'm_asset');
                                                ?>
                                                <tr>
                                                    <td><?= $detail['ASSET_CODE'].' - '.$aset['ASSET_NAME']; ?></td>
                                                    <td><?= $detail['DET_RP_REASON']; ?></td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jadwal Mulai Visit</label>
                                            <input type="text" name='idReim' class="form-control" value="<?= $nama['RP_STR_DATE']?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jadwal Selesai Visit</label>
                                            <input type="text" name='idReim' class="form-control" value="<?= $nama['RP_END_DATE']?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <form role="form" action="<?php echo base_url().'Aset/insEmp'?>" method="POST" enctype="multipart/form-data">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label for="delnama">Pilih Karyawan</label>
                                                <div class="form-group karyawan">
                                                    <input type="hidden" name="repairid" value="<?= $nama['RP_ID']?>">
                                                    <select class="form-control select2bs4" id="karyawan" name="insEmp">
                                                        <option selected="selected" value="">Silahkan Pilih Karyawan</option>
                                                        <?php foreach($daftar as $daftar) :?>
                                                        <option value="<?= $daftar['EMP_ID']?>"><?= $daftar['EMP_FULL_NAME']?></option>
                                                        <?php endforeach?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Tambahkan Data</label>
                                                <button class="btn btn-block btn-info" type="submit" formaction="<?php echo base_url().'Aset/insEmp'?>">Tambah Data</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                $whererp = array(
                                    'RP_ID' => $nama['RP_ID'],
                                );
                                $hitungsch = $this->Model_online->countRowWhere('tr_repair_sch',$whererp);
                                $dataemp = $this->Model_online->findAllDataWhere($whererp, 'tr_repair_sch');
                                if($hitungsch>0){
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example2" class="table table table-bordered table-hover text-center">
                                            <thead>
                                            <tr>
                                                <th>ID Karyawan</th>
                                                <th>Nama Karyawan</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($dataemp as $dataemp) :
                                                $whereEmp = array(
                                                    'EMP_ID' => $dataemp['EMP_ID'],
                                                );
                                                $namaemp = $this->Model_online->findSingleDataWhere($whereEmp, 'm_employee');
                                                ?>
                                                <tr>
                                                    <td><?= $dataemp['EMP_ID']; ?></td>
                                                    <td><?= $namaemp['EMP_FULL_NAME']; ?></td>
                                                    <td>
                                                        <div class="btn-group">                                        
                                                            <span data-toggle="tooltip" data-placement="top" title="Hapus Pengajuan">
                                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-delete-<?= str_replace('/','',$dataemp['RP_SCH_ID']); ?>">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button> 
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Modal Deny -->
                                                <div class="modal fade" id="modal-delete-<?= str_replace('/','',$dataemp['RP_SCH_ID']); ?>">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                            <div class="modal-header text-center" style="background-color:#d9534f;color:white;">
                                                                <h5 class="modal-title text-center">Konfirmasi Hapus</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <p>Apakah Anda Yakin Untuk Menghapus <b><?= $namaemp['EMP_FULL_NAME']; ?> ?</b></p>
                                                                <hr>
                                                                <p>Silahkan Klik Tombol Lanjutkan Untuk <strong>Menghapus </strong></p>
                                                                <input type="hidden" name="repairid" value="<?= $nama['RP_ID']?>">
                                                                <input type="hidden" name="delID" value="<?= $dataemp['RP_SCH_ID']; ?>">
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="submit" formaction="<?php echo base_url().'Aset/delEmp'?>" class="btn btn-danger">Lanjutkan</button>
                                                            </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" data-toggle="modal" data-target="#modal-acc" class="btn btn-block btn-success">
                                            Tugaskan Visit
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Approve dan Kirim Ke Atasan -->
                            <div class="modal fade" id="modal-acc">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <form role="form" action="<?php echo base_url().'Aset/accApp'?>" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header text-center" style="background-color:#5cb85c;color:white;">
                                            <h5 class="modal-title text-center">Summary Penjadwalan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jadwal Mulai Visit</label>
                                                        <input type="text" name='idReim' class="form-control" value="<?= $nama['RP_STR_DATE']?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jadwal Selesai Visit</label>
                                                        <input type="text" name='idReim' class="form-control" value="<?= $nama['RP_END_DATE']?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table id="tabeldata" class="table table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>ID Karyawan</th>
                                                            <th>Nama Karyawan</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $dataemp2 = $this->Model_online->findAllDataWhere($whererp, 'tr_repair_sch');
                                                            foreach($dataemp2 as $dataemp2) :
                                                            $whereEmp2 = array(
                                                                'EMP_ID' => $dataemp2['EMP_ID'],
                                                            );
                                                            $namaemp2 = $this->Model_online->findSingleDataWhere($whereEmp2, 'm_employee');
                                                            ?>
                                                            <tr>
                                                                <td><?= $dataemp2['EMP_ID']; ?></td>
                                                                <td><?= $namaemp2['EMP_FULL_NAME']; ?></td>
                                                            </tr>
                                                            <?php
                                                            endforeach
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Lanjutkan</button>
                                        </div>
                                    </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            <!-- Modal Deny -->
                            <div class="modal fade" id="modal-deny">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header text-center" style="background-color:#d9534f;color:white;">
                                            <h5 class="modal-title text-center">Konfirmasi Penolakan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p><b>Apakah Anda Yakin Untuk Menolak ?</b></p>
                                            <hr>
                                            <p>Silahkan Klik Tombol Lanjutkan Untuk <strong>Menolak</strong></p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" formaction="<?php echo base_url().'Kasbon/denyApp'?>" class="btn btn-danger">Lanjutkan</button>
                                        </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->