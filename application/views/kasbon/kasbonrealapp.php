<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Approval Realisasi Kasbon</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Online Form </a></li>
              <li class="breadcrumb-item">Kasbon</li>
              <li class="breadcrumb-item active">Approval Realisasi</li>
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
          <form role="form" action="<?php echo base_url().'Kasbon/upApp'?>" method="POST" enctype="multipart/form-data">  
            <div class="card card-info">
            
              <div class="card-header">
                <h3 class="card-title">Detail Kasbon | Kasbon ID : <?= $kasbon['KB_ID']?></h3>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ID Kasbon</label>
                            <input type="text" name='idKasbon' class="form-control" value="<?= $kasbon['KB_ID']?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Applicant</label>
                            <?php
                            $arr_emp = array(
                              'EMP_ID' => $kasbon['EMP_ID'],
                            );
                            $rowEmp = $this->Model_online->findSingleDataWhere($arr_emp,'m_employee');
                            ?>
                            <input type="hidden" name='namaKasbon' class="form-control" value="<?= $kasbon['EMP_ID']?>" readonly>
                            <input type="text" name='namalengkap' class="form-control" value="<?= $rowEmp['EMP_FULL_NAME']?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Total Kasbon</label>
                            <input type="text" name='totalKasbon' class="form-control" id="dis-id" value="<?= 'Rp. '.number_format($kasbon['KB_TOTAL_AWAL'])?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Total Realisasi</label>
                            <input type="text" name='totalReal' class="form-control" id="dis-id" value="<?= 'Rp. '.number_format($kasbon['KB_TOTAL_AKHIR'])?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Selisih</label>
                            <input type="text" name='selisih' class="form-control" id="dis-id" value="<?= 'Rp. '.number_format($kasbon['KB_DIFF'])?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Keterangan</th>
                            <th>Nominal Awal</th>
                            <th>Nominal Akhir</th>
                            <th>Nominal Selisih</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            $where = array(
                                'KB_ID' => $kasbon['KB_ID'],
                                );
                            $detail = $this->Model_online->findAllDataWhere($where,'tr_detail_kasbon');
                            foreach($detail as $detail) :?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $detail['DET_KB_ITEM']; ?></td>
                                <td><?= 'Rp. '.number_format($detail['DET_KB_VALUE']); ?></td>
                                <td><?= 'Rp. '.number_format($detail['DET_KB_END_VALUE']); ?></td>
                                <td><?= 'Rp. '.number_format($detail['DET_KB_DIFF']); ?></td>
                            </tr>
                            <?php
                            $whereReal = array(
                                'DET_KB_ID' => $detail['DET_KB_ID'],
                                );
                            $detailReal = $this->Model_online->findAllDataWhere($whereReal,'tr_detail_real');
                            foreach($detailReal as $detailReal):
                            ?>
                            <tr>
                            <td><i class="fas fa-file-export"></i></td>
                            <td colspan="2"><?= $detailReal['REAL_NAME']; ?></td>
                            <td><?= 'Rp. '.$detailReal['REAL_VALUE']; ?></td>
                            <td>
                            <a href="<?php echo base_url()?>assets/doc-kasbon/<?= $detailReal['REAL_PHOTO']; ?>" target="_blank">
                            <?= $detailReal['REAL_PHOTO'];?>
                            </a>
                            </td>
                            </tr>
                            <?php endforeach?>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                    <button type="button" data-toggle="modal" data-target="#modal-setuju-<?= str_replace('/','',$kasbon['KB_ID']); ?>" class="btn btn-block btn-success">Setujui Realisasi</button>
                    </div>
                    <div class="col-md-6">
                    <button type="button" data-toggle="modal" data-target="#modal-revisi-<?= str_replace('/','',$kasbon['KB_ID']); ?>" class="btn btn-block btn-danger">Revisi Realisasi</button>
                    </div>
                </div>
              </div>
              <!-- Modal Deny -->
              <div class="modal fade" id="modal-revisi-<?= str_replace('/','',$kasbon['KB_ID']); ?>">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header text-center" style="background-color:#d9534f;color:white;">
                            <h5 class="modal-title text-center">Konfirmasi Penolakan Realisasi</h5>
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
                              <button type="submit" formaction="<?php echo base_url().'Kasbon/denyAppReal'?>" class="btn btn-danger">Lanjutkan</button>
                          </div>
                        </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <!-- Modal Final Approve -->
              <div class="modal fade" id="modal-setuju-<?= str_replace('/','',$kasbon['KB_ID']); ?>">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header text-center" style="background-color:#5cb85c;color:white;">
                            <h5 class="modal-title text-center">Konfirmasi Persetujuan Realisasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <p><b>Apakah Anda Yakin Untuk Menyetujui Realisasi ?</b></p>
                            <hr>
                            <p>Silahkan Klik Tombol Lanjutkan Untuk <strong>Menyetujui Realisasi</strong></p>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" formaction="<?php echo base_url().'Kasbon/AccAppReal'?>" class="btn btn-success">Lanjutkan</button>
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