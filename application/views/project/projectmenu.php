<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Aplikasi Proyek Outlet</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url("Dashboard")?>">Online Form</a></li>
              <li class="breadcrumb-item active">Daftar Proyek</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="flashdata" data-flashdata="<?php echo $this->session->flashdata("flashdata");?>"></div>
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <!-- Inputkan dalemannya disini ++++ -->
    <div class="container-fluid">
      <div class="row">
          <div class="col-lg-12 col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                  <h3 class="card-title">Proyek Yang Sedang Berjalan</h3>
                  <div class="card-tools">
                    <?php 
                    $allowAdd = array('DP/002','DP/006','DP/007');
                    // if(in_array($this->session->userdata('DEPART_ID'), $allowAdd) && $this->session->userdata('LEAD_STATUS') == '4')
                    if($this->session->userdata('EMP_ID') == 'EMP/003/001')
                    {
                    ?>
                    <button type="button" class="btn btn-sm btn-success mr-3" data-toggle="modal" data-target="#modal-add">Tambah Proyek Baru</button>
                    <div class="modal fade" id="modal-add">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content">
                          <form role="form" action="<?php echo base_url().'Project/AddProjectMenu'?>" method="POST" enctype="multipart/form-data">
                          <div class="modal-header" style="background-color:#0275d8;">
                              <h5 class="modal-title" style="color:white"> <strong>Proyek Baru</strong></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-6">
                                      <label>Nama Karyawan</label>
                                      <input type="text" name="insEmpName" class="form-control" value="<?= $this->session->userdata('EMP_FULL_NAME');?>" readonly>
                                      <input type="hidden" name="insEmp" class="form-control" value="<?= $this->session->userdata('EMP_ID');?>" readonly>
                                  </div>
                                  <div class="col-6">
                                      <label>Tanggal Pengajuan</label>
                                      <input type="text" name="insTgl" class="form-control" value="<?= date('Y-m-d H:i:s');?>" readonly>
                                  </div>
                              </div>
                              <div class="row mt-2">
                                  <div class="col-12">
                                      <div class="form-group">
                                        <label for="exampleInputEmail1">Outlet</label>
                                        <select class="form-control select2bs4" id="selruang" name="insBr" style="width: 100%;" required>
                                            <option disabled selected="selected" value="">Silahkan Pilih Outlet</option>
                                            <?php foreach($allbranch as $allbranch):?>
                                            <option value="<?= $allbranch->BRANCH_ID.'|'.$allbranch->BRANCH_CODE ?>"><?= $allbranch->BRANCH_NAME?></option>
                                            <?php endforeach?>
                                        </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <label>Nama Proyek</label>
                                      <input type="text" name="insProyek" class="form-control" required>
                                  </div>
                              </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary"> <strong>Tambahkan</strong> </button>
                          </div>
                          </form>
                          </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <?php
                    }
                    ?>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                      <?php 
                      $i=1;
                      foreach($branch as $branch):
                      ?>
                      <div class="col-lg-3 col-6">
                          <!-- small card -->
                          <div class="small-box <?= $i++ % 2 != 0 ? 'bg-warning' : 'bg-danger' ?>">
                              <div class="inner">
                              <h3><?= $branch->BRANCH_CODE?></h3>
                              <p><?= $branch->BRANCH_NAME?></p>
                              </div>
                              <div class="icon">
                              
                              <i class="fas fa-store"></i>
                              </div>
                              <a href="<?= base_url("Project/DetailProject/".str_replace('/','',$branch->BRANCH_ID)."")?>" class="small-box-footer">
                              More info <i class="fas fa-arrow-circle-right"></i>
                              </a>
                          </div>
                      </div>
                      <?php
                      endforeach;
                      ?>
                  </div>
                </div>
            </div>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12 col-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                  <h3 class="card-title">Data Proyek</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="allactive-tab" data-toggle="pill" href="#allactive" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Proyek Aktif</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="alldone-tab" data-toggle="pill" href="#alldone" role="tab" aria-controls="custom-content-above-messages" aria-selected="false">Proyek Selesai</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="outletactive-tab" data-toggle="pill" href="#outletactive" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Proyek Aktif Per Outlet</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="outletdone-tab" data-toggle="pill" href="#outletdone" role="tab" aria-controls="custom-content-above-settings" aria-selected="false">Proyek Selesai Per Outlet</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="custom-content-above-tabContent">
                        <div class="tab-pane fade show active" id="allactive" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                          <p class="lead mb-0 mt-3">Daftar Proyek Aktif</p>
                          <hr>
                          <div class="row">
                            <div class="col-12">
                                <table id="tabelmenu" class="table align-middle text-center table-bordered mt-2" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th>Outlet</th>
                                      <th>Nama Proyek</th>
                                      <th>Tgl Pengajuan</th>
                                      <th>Tgl Update</th>
                                      <th>Total Pengajuan</th>
                                      <th>Total Pengeluaran</th>
                                      <th class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach($all as $all):
                                    ?>
                                      <tr>
                                        <td><?= $all->BRANCH_CODE?></td>
                                        <td><?= $all->PR_NAME?></td>
                                        <td><?= $all->PR_SUB_DATE?></td>
                                        <td><?= $all->PR_LAST_UPDATE?></td>
                                        <td><?= 'Rp. '.number_format($all->PR_TOTAL)?></td>
                                        <td><?= 'Rp. '.number_format($all->PR_PAID_TOTAL)?></td>
                                        <td class="text-center">
                                          <span data-toggle="tooltip" data-placement="top" title="Lihat Detail">
                                            <a class="btn btn-default" href="<?= base_url("Project/DetailProject/".str_replace('/','',$all->BRANCH_ID).""); ?>">
                                              <i class="fas fa-clipboard-list"></i>
                                            </a>
                                          </span>
                                        </td>
                                      </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                  </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade show" id="alldone" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                          <p class="lead mb-0 mt-3">Daftar Proyek Selesai</p>
                          <hr>
                          <div class="row">
                            <div class="col-12">
                                <table id="projectdone" class="table align-middle text-center table-bordered mt-2" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th>Outlet</th>
                                      <th>Nama Proyek</th>
                                      <th>Tgl Pengajuan</th>
                                      <th>Tgl Update</th>
                                      <th>Total Pengajuan</th>
                                      <th>Total Pengeluaran</th>
                                      <th class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach($alldone as $alldone):
                                    ?>
                                      <tr>
                                        <td><?= $alldone->BRANCH_CODE?></td>
                                        <td><?= $alldone->PR_NAME?></td>
                                        <td><?= $alldone->PR_SUB_DATE?></td>
                                        <td><?= $alldone->PR_LAST_UPDATE?></td>
                                        <td><?= 'Rp. '.number_format($alldone->PR_TOTAL)?></td>
                                        <td><?= 'Rp. '.number_format($alldone->PR_PAID_TOTAL)?></td>
                                        <td class="text-center">
                                          <span data-toggle="tooltip" data-placement="top" title="Lihat Detail">
                                            <a class="btn btn-default" href="<?= base_url("Project/DetailProject/".str_replace('/','',$alldone->BRANCH_ID).""); ?>">
                                              <i class="fas fa-clipboard-list"></i>
                                            </a>
                                          </span>
                                        </td>
                                      </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                  </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="outletactive" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                          <p class="lead mb-0 mt-3">Daftar Proyek Aktif Per Outlet</p>
                          <hr>
                          <div class="row">
                            <div class="col-12">
                                <table id="tabelmenu2" class="table align-middle text-center table-bordered mt-2" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th>Kode Outlet</th>
                                      <th>Nama Outlet</th>
                                      <th>Total Pengajuan</th>
                                      <th>Total Pengeluaran</th>
                                      <th class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach($allother as $allother):
                                    ?>
                                      <tr>
                                        <td><?= $allother->BRANCH_CODE?></td>
                                        <td><?= $allother->BRANCH_NAME?></td>
                                        <td><?= 'Rp. '.number_format($allother->TOTAL_AJU)?></td>
                                        <td><?= 'Rp. '.number_format($allother->TOTAL_BAYAR)?></td>
                                        <td class="text-center">
                                          <span data-toggle="tooltip" data-placement="top" title="Lihat Detail">
                                            <a class="btn btn-default" href="<?= base_url("Project/DetailProject/".str_replace('/','',$allother->BRANCH_ID).""); ?>">
                                              <i class="fas fa-clipboard-list"></i>
                                            </a>
                                          </span>
                                        </td>
                                      </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                  </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="outletdone" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                          <p class="lead mb-0 mt-3">Daftar Proyek Selesai Per Outlet</p>
                          <hr>
                          <div class="row">
                            <div class="col-12">
                                <table id="projectoutletdone" class="table align-middle text-center table-bordered mt-2" style="width:100%">
                                  <thead>
                                    <tr>
                                      <th>Kode Outlet</th>
                                      <th>Nama Outlet</th>
                                      <th>Total Pengajuan</th>
                                      <th>Total Pengeluaran</th>
                                      <th class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    foreach($allotherdone as $allotherdone):
                                    ?>
                                      <tr>
                                        <td><?= $allotherdone->BRANCH_CODE?></td>
                                        <td><?= $allotherdone->BRANCH_NAME?></td>
                                        <td><?= 'Rp. '.number_format($allotherdone->TOTAL_AJU)?></td>
                                        <td><?= 'Rp. '.number_format($allotherdone->TOTAL_BAYAR)?></td>
                                        <td class="text-center">
                                          <span data-toggle="tooltip" data-placement="top" title="Lihat Detail">
                                            <a class="btn btn-default" href="<?= base_url("Project/DetailProject/".str_replace('/','',$allotherdone->BRANCH_ID).""); ?>">
                                              <i class="fas fa-clipboard-list"></i>
                                            </a>
                                          </span>
                                        </td>
                                      </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                  </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
            </div>
          </div>
      </div>
        
    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->