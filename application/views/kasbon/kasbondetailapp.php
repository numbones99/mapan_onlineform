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
          <form role="form" action="<?php echo base_url().'Kasbon/upApp'?>" method="POST" enctype="multipart/form-data">  
            <div class="card card-info">
            
              <div class="card-header">
                <h3 class="card-title">Detail Kasbon | Kasbon ID : <?= $kbnama['KB_ID']?></h3>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ID Kasbon</label>
                            <input type="text" name='idReim' class="form-control" value="<?= $kbnama['KB_ID']?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Applicant</label>
                            <input type="text" name='namaReim' class="form-control" value="<?= $kbnama['nama']?>" readonly>
                            <input type="hidden" name='idApp' class="form-control" value="<?= $this->uri->segment(3)?>">
                            <input type="hidden" name='idKB' class="form-control" value="<?= $kbnama['KB_ID']?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Total Kasbon</label>
                            <input type="text" name='totalReim' class="form-control" id="dis-id" value="<?= number_format($kbnama['KB_TOTAL_AWAL']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <?php
                        $myEmpID = $this->session->userdata('EMP_ID');
                        if($myEmpID == 'EMP/003/009'){ ?>
                          <div class="form-group">
                            <label>Tanggal Realisasi Transfer</label>
                            <input type="date" name='tglRealisasi' class="form-control" min="<?= date("Y-m-d") ?>" required>
                          </div> <?php
                        }
                      ?>
                    </div>
                </div>
                <div class="row">
                    <table class="table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i=1;
                            $where = array(
                                'KB_ID' => $kbnama['KB_ID'],
                                );
                            $detail = $this->Model_online->findAllDataWhere($where,'tr_detail_kasbon');
                            foreach($detail as $detail) :?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $detail['DET_KB_ITEM']; ?></td>
                                <td><?= number_format($detail['DET_KB_VALUE']); ?></td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="card-footer">
              <div class="row">
                <?php
                //mengecek apakah user yang login memiliki leader ?
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

                //custom
                $whereCekNew = array(
                  'me.LEAD_STATUS' => '5',
                  'me.EMP_ID' => $empID,
                );
                $direksiNew = $this->Model_online->direksiNew($whereCekNew); //cek apakah empID sekarang (yg sedang login) lead_status = 5
                $whereCekNewFA = array(
                  'DEPART_ID' => 'DP/003',
                  'LEAD_STATUS' => '4',
                  'EMP_ID' => $empID,
                );
                $direksiNewFA = $this->Model_online->direksiNewFA($whereCekNewFA); // cek apakah empID sekarang (yg sedang login) adalah manager FA

                //mengecek apakah user yang login bagian dari FA ?
                $whereFA = array(
                  'DEPART_ID' => 'DP/003',
                  'EMP_ID' => $empID,
                );
                $cekFA = $this->Model_online->countRowWhere('m_employee',$whereFA);
                $whereparam = array(
                  'ID_PARAM' => 'PR/0002', 
                ); 
                $param = $this->Model_online->findSingleDataWhere($whereparam, 'm_param');
                if($kbnama['KB_TOTAL_AWAL']<=$param['VALUE_PARAM'] && $direksi>0){
                  if ($direksi > 0 && $direksiNew == 0 && $direksiNewFA == 0)
                  {
                    ?>
                      <div class="col-md-6">
                        <button type="button" data-toggle="modal" data-target="#modal-fappMngFa-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-success">
                        Persetujuan Final & Kirim Ke Manajer FA
                        </button>
                      </div>
                      <div class="col-md-6">
                      <button type="button" data-toggle="modal" data-target="#modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-danger">Tolak Pengajuan</button>
                      </div>
                    <?php 
                  }else{
                ?>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-fapp-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-success">Persetujuan Final & Kirim Ke FA</button>
                  <!-- <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-<?= str_replace('/','',$kbnama['KB_ID']); ?>">Setujui & Kirim Ke FA</button> -->
                  </div>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-danger">Tolak Pengajuan</button>
                  </div>
                <?php
                }
                }else{
                if ($direksi > 0 && $direksiNew == 0 && $direksiNewFA == 0)
                {
                  ?>
                    <div class="col-md-6">
                      <button type="button" data-toggle="modal" data-target="#modal-fappMngFa-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-success">
                      Persetujuan Final & Kirim Ke Manajer FA
                      </button>
                    </div>
                    <div class="col-md-6">
                    <button type="button" data-toggle="modal" data-target="#modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-danger">Tolak Pengajuan</button>
                    </div>
                  <?php 
                }
                elseif($cekAdaLeader>0 && $cekFA==0) // kondisi yg bersangkutan punya leader dan kary FA
                {
                ?>
                  <div class="col-md-6">
                    <button type="button" data-toggle="modal" data-target="#modal-con-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-success">
                    Minta Persetujuan Lanjutan
                    </button>
                  </div>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-danger">Tolak Pengajuan</button>
                  </div>
                <?php 
                }elseif($cekAdaLeader==0 && $cekFA==0){ // konsisi ybs tidak punya leader(top) dan dia bukan FA
                ?>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-fapp-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-success">Persetujuan Final & Kirim Ke FA</button>
                  <!-- <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modal-<?= str_replace('/','',$kbnama['KB_ID']); ?>">Setujui & Kirim Ke FA</button> -->
                  </div>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-danger">Tolak Pengajuan</button>
                  </div>
                <?php
                }elseif($cekAdaLeader>0 && $cekFA>0){ //kondisi ybs punya leader dan dia FA
                ?>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-con-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-success">Minta Persetujuan Lanjutan</button>
                  </div>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-danger">Tolak Pengajuan</button>
                  </div>
                <?php  
                }elseif($cekAdaLeader<=0 && $cekFA>0){ //kondisi ybs tidak punya leader(top) dan dia FA
                ?>

                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-fappfa-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-info">Release Pengajuan</button>
                  </div>
                  <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>" class="btn btn-block btn-danger">Cancel Pengajuan</button>
                  </div>
                <?php  
                }
              }
                ?>
              </div>  
              </div>
              <!-- Modal Approve dan Kirim Ke Atasan -->
              <div class="modal fade" id="modal-con-<?= str_replace('/','',$kbnama['KB_ID']); ?>">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header text-center" style="background-color:#5cb85c;color:white;">
                            <h5 class="modal-title text-center">Konfirmasi Approval & Kirim Ke Atasan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <p><b>Apakah Anda Yakin Untuk Menyetujui ?</b></p>
                            <hr>
                            <p>Silahkan Klik Tombol Lanjutkan Untuk <br><strong>Approval dan Pengajuan Ke Atasan</strong></p>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" formaction="<?php echo base_url().'Kasbon/conApp'?>" class="btn btn-success">Lanjutkan</button>
                          </div>
                        </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <!-- Modal Deny -->
              <div class="modal fade" id="modal-deny-<?= str_replace('/','',$kbnama['KB_ID']); ?>">
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
                            <p><textarea name="alasantolak" class="form-control" placeholder="Isi Alasan Penolakan (Wajib)" rows="3"></textarea></p>
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
              <!-- Modal Final Approve -->
              <div class="modal fade" id="modal-fapp-<?= str_replace('/','',$kbnama['KB_ID']); ?>">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header text-center" style="background-color:#5cb85c;color:white;">
                            <h5 class="modal-title text-center">Konfirmasi Final Approve</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <p><b>Apakah Anda Yakin Untuk Final Approval ?</b></p>
                            <hr>
                            <p>Silahkan Klik Tombol Lanjutkan Untuk <strong>Final Approval</strong></p>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" formaction="<?php echo base_url().'Kasbon/finalApp'?>" class="btn btn-success">Lanjutkan</button>
                          </div>
                        </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <!-- Modal Final Approve FA -->
              <div class="modal fade" id="modal-fappfa-<?= str_replace('/','',$kbnama['KB_ID']); ?>">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header text-center" style="background-color:#5bc0de;color:white;">
                            <h5 class="modal-title text-center">Konfirmasi Release Pengajuan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <p><b>Apakah Anda Yakin Untuk Release Pengajuan ?</b></p>
                            <hr>
                            <p>Silahkan Klik Tombol Lanjutkan Untuk <strong>Release Pengajuan</strong></p>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" formaction="<?php echo base_url().'Kasbon/finalAppFA'?>" class="btn btn-info">Lanjutkan</button>
                          </div>
                        </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->

              <!-- Modal Final Approve -->
              <div class="modal fade" id="modal-fappMngFa-<?= str_replace('/', '', $kbnama['KB_ID']); ?>">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header text-center" style="background-color:#5cb85c;color:white;">
                      <h5 class="modal-title text-center">Konfirmasi Final Approve</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-center">
                      <p><b>Apakah Anda Yakin Untuk Final Approval ?</b></p>
                      <hr>
                      <p>Silahkan Klik Tombol Lanjutkan Untuk <strong>Final Approval</strong></p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" formaction="<?php echo base_url() . 'Kasbon/finalApprovalMngFa' ?>" class="btn btn-success">Lanjutkan</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              
            </div>
          </form>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->